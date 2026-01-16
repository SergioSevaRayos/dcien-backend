<?php
declare(strict_types=1);

namespace DCIEN\Tests\Domain\Numbering;

use DCIEN\Infrastructure\Numbering\NumberAllocatorImpl;
use LogicException;
use DCIEN\Tests\DatabaseTestCase;


final class ExhaustionTest extends DatabaseTestCase

{
    public function test_allocation_fails_when_no_numbers_are_available(): void
    {
        $pdo = $this->pdo;

        // Arrange: crear serie SIN números
        $pdo->exec("INSERT INTO series (id) VALUES (1)");

        $allocator = new NumberAllocatorImpl();

        // Act + Assert
        try {
            $allocator->allocateRandom(1, 1001);
            $this->fail('Allocation should fail when no numbers are available');
        } catch (LogicException $e) {
            $this->assertStringContainsString(
                'no available numbers',
                strtolower($e->getMessage()),
                'Exception message must indicate DB exhaustion check'
            );

            // Y la DB sigue sin mutar
            $stmt = $pdo->query("SELECT COUNT(*) FROM numbers");
            $count = (int) $stmt->fetchColumn();
            $this->assertSame(0, $count);
        }
    }
}
