<?php
declare(strict_types=1);

namespace DCIEN\Tests\Domain\Numbering;

use DCIEN\Infrastructure\Numbering\NumberAllocatorImpl;
use DCIEN\Tests\DatabaseTestCase;
use PDO;
use Throwable;

final class ConcurrencyTest extends DatabaseTestCase
{
    public function test_two_concurrent_allocations_only_one_can_succeed(): void
    {
        // Arrange: serie con UN solo número disponible
        $this->pdo->exec("INSERT INTO series (id) VALUES (1)");
        $this->pdo->exec("
            INSERT INTO numbers (series_id, number, status)
            VALUES (1, 1, 'available')
        ");

        // Segunda conexión REAL
        $env = parse_ini_file(__DIR__ . '/../../../.env.test');

        $pdo2 = new PDO(
            sprintf(
                'pgsql:host=%s;port=%s;dbname=%s',
                $env['DB_HOST'],
                $env['DB_PORT'],
                $env['DB_NAME']
            ),
            $env['DB_USER'],
            $env['DB_PASSWORD'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        $allocator1 = new NumberAllocatorImpl();
        $allocator2 = new NumberAllocatorImpl();

        // Act: dos transacciones manuales
        $this->pdo->beginTransaction();
        $pdo2->beginTransaction();

        $result1 = null;
        $result2 = null;
        $exception2 = null;

        try {
            // Primera asignación: DEBE bloquear el número
            $result1 = $allocator1->allocateRandom(1, 9001);

            // Segunda asignación concurrente
            try {
                $result2 = $allocator2->allocateRandom(1, 9002);
            } catch (Throwable $e) {
                $exception2 = $e;
            }

            $this->pdo->commit();
            $pdo2->commit();
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            $pdo2->rollBack();
            throw $e;
        }

        // Assert: solo UNA asignación válida
        $this->assertNotNull($result1, 'First allocation must succeed');
        $this->assertTrue(
            $exception2 !== null || $result2 === null,
            'Second allocation must fail or block'
        );

        // Assert final DB state
        $stmt = $this->pdo->query("
            SELECT number, status, assigned_order_id
            FROM numbers
        ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->assertCount(1, $rows);
        $this->assertSame('reserved', $rows[0]['status']);
    }
}
