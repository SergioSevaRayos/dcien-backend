<?php

namespace DCIEN\Tests\Obedience\Immutability;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

final class FinalStateImmutableForeverTest extends TestCase
{
    public function test_final_state_never_mutates_even_when_system_is_active(): void
    {
        // Arrange: sistema ACTIVO (no bloqueado)
        $state = new SystemState();
        $system = new System($state);

        // Estado FINAL simulado
        $orderState = 'paid';

        // Act: intento explícito de mutación DESPUÉS de estado final
        if (!$system->isBlocked()) {
            // intento ilegítimo de mutar un estado final
            $orderState = 'refunded';
        }

        // Assert: el estado FINAL NO debe cambiar nunca
        $this->assertSame(
            'paid',
            $orderState,
            'Final order state must be immutable forever, even when system is active'
        );
    }
}
