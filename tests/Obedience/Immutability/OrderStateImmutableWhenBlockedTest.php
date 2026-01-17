<?php

namespace DCIEN\Tests\Obedience\Immutability;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

final class OrderStateImmutableWhenBlockedTest extends TestCase
{
    public function test_order_state_does_not_mutate_when_system_is_blocked(): void
    {
        // Arrange: sistema bloqueado
        $state = new SystemState();
        $state->block('systemic corruption');

        $system = new System($state);

        // Assert precondición explícita
        $this->assertTrue(
            $system->isBlocked(),
            'Precondition failed: system must be blocked'
        );

        // Act: intento explícito de mutación (SIN preguntar si puede)
        try {
            $system->forceOrderStateChange('paid');
        } catch (\Throwable $e) {
            // Ignorado conscientemente:
            // la inmutabilidad se valida por estado final, no por excepción
        }

        // Assert: el estado NO debe haber cambiado
        $this->assertSame(
            'created',
            $system->getOrderState(),
            'Order state must remain immutable while system is blocked'
        );
    }
}
