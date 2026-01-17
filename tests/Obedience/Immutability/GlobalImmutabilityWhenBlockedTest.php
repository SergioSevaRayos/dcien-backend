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

        // Estado inicial gestionado por el sistema
        $this->assertSame('created', $system->getOrderState());

        // Act: intento de mutación A TRAVÉS DEL SISTEMA
        $system->attemptMutation(function () use ($system) {
            $system->forceOrderStateChange('paid');
        });

        // Assert: el estado NO debe mutar
        $this->assertSame(
            'created',
            $system->getOrderState(),
            'Order state must remain immutable while system is blocked'
        );
    }
}
