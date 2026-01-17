<?php

namespace DCIEN\Tests\Obedience\Sovereignty;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\Persistence\DirectPersistence;

final class DirectPersistenceCannotBypassSovereignTest extends TestCase
{
    public function test_direct_persistence_can_mutate_state_without_sovereign(): void
    {
        // Arrange
        $persistence = new DirectPersistence();

        // Act
        $result = $persistence->forceWrite([
            'order_id' => 1,
            'state' => 'paid',
        ]);

        // Assert
        $this->assertFalse(
            $result,
            'Direct persistence must not be able to mutate state without sovereign authority'
        );
    }
}
