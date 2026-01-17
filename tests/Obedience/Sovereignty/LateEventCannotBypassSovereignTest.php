<?php

namespace DCIEN\Tests\Obedience\Sovereignty;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

/**
 * Un evento tardío (side effect / async / listener)
 * NO debe poder mutar estado sin pasar por el soberano.
 */
final class LateEventCannotBypassSovereignTest extends TestCase
{
    public function test_late_event_cannot_mutate_state_without_sovereign(): void
    {
        // Arrange
        $state = new SystemState();
        $system = new System($state);

        // Estado inicial
        $initialOrderState = $system->getOrderState();

        // Evento tardío simulado (fuera de flujo principal)
        $lateEvent = function () use ($system) {
            // Intento de mutación directa, fuera de soberano
            $system->forceOrderStateChange('paid');
        };

        // Act
        $lateEvent();

        // Assert
        $this->assertSame(
            $initialOrderState,
            $system->getOrderState(),
            'Late events must not mutate state without sovereign authority'
        );
    }
}
