<?php

namespace DCIEN\Tests\Obedience\Immutability;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;
use DCIEN\Infrastructure\Operations\Operations;

final class AllMutationsBlockedTransitivelyTest extends TestCase
{
    public function test_all_mutating_operations_are_blocked_when_system_is_blocked(): void
    {
        // Arrange: sistema bloqueado
        $state = new SystemState();
        $state->block('systemic corruption');

        $system = new System($state);
        $operations = new Operations($system);

        // Act & Assert: TODAS deben fallar
        $this->assertFalse(
            $operations->createOrder(),
            'createOrder must be blocked while system is blocked'
        );

        $this->assertFalse(
            $operations->reserveNumber(),
            'reserveNumber must be blocked while system is blocked'
        );

        $this->assertFalse(
            $operations->startPayment(),
            'startPayment must be blocked while system is blocked'
        );

        $this->assertFalse(
            $operations->confirmSale(),
            'confirmSale must be blocked while system is blocked'
        );
    }
}
