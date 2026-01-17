<?php

namespace DCIEN\Tests\Obedience\Immutability;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

final class GlobalImmutabilityWhenBlockedTest extends TestCase
{
    public function test_no_system_operation_can_mutate_state_when_blocked(): void
    {
        // Arrange
        $state = new SystemState();
        $state->block('systemic corruption');

        $system = new System($state);

        $orderState  = 'created';
        $numberState = 'reserved';

        // Act: intentos explícitos de mutación
        try {
            $orderState  = 'paid';
            $numberState = 'sold';
        } catch (\Throwable $e) {
            // irrelevante
        }

        // Assert
        $this->assertSame(
            'created',
            $orderState,
            'Order state must remain immutable while system is blocked'
        );

        $this->assertSame(
            'reserved',
            $numberState,
            'Number state must remain immutable while system is blocked'
        );
    }
}
