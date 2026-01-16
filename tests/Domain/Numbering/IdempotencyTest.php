<?php
declare(strict_types=1);

namespace DCIEN\Tests\Domain\Numbering;

use DCIEN\Infrastructure\Numbering\NumberAllocatorImpl;
use DCIEN\Tests\DatabaseTestCase;


final class IdempotencyTest extends DatabaseTestCase
{
    public function test_same_order_id_always_returns_same_number(): void
    {
        $pdo = $this->pdo;

        // Arrange: serie con números disponibles
        $pdo->exec("INSERT INTO series (id) VALUES (1)");
        $pdo->exec("
            INSERT INTO numbers (series_id, number, status)
            VALUES
                (1, 1, 'available'),
                (1, 2, 'available'),
                (1, 3, 'available')
        ");

        $allocator = new NumberAllocatorImpl();

        // Act: primera asignación
        $firstNumber = $allocator->allocateRandom(1, 5001);

        // Assert: DB refleja reserva
        $stmt = $pdo->query("
            SELECT id, number, status, assigned_order_id
            FROM numbers
            WHERE assigned_order_id = 5001
        ");
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        $this->assertNotFalse($row, 'First allocation must reserve a number');
        $this->assertSame('reserved', $row['status']);
        $this->assertSame(5001, (int) $row['assigned_order_id']);

        // Act: segunda asignación (misma order_id)
        $secondNumber = $allocator->allocateRandom(1, 5001);

        // Assert: idempotencia
        $this->assertSame(
            $firstNumber,
            $secondNumber,
            'Same order_id must always return same number'
        );

        // Assert: no mutación adicional
        $stmt = $pdo->query("SELECT COUNT(*) FROM numbers WHERE assigned_order_id = 5001");
        $count = (int) $stmt->fetchColumn();
        $this->assertSame(1, $count);

        $stmt = $pdo->query("SELECT COUNT(*) FROM numbers");
        $total = (int) $stmt->fetchColumn();
        $this->assertSame(3, $total);
    }
}
