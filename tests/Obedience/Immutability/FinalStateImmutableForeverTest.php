<?php

namespace DCIEN\Tests\Obedience\Immutability;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

final class FinalStateImmutableForeverTest extends TestCase
{
    public function test_final_state_never_mutates_under_any_context(): void
    {
        // Arrange
        $state = new SystemState();
        $system = new System($state);

        // Simulamos que la order alcanza un estado FINAL
        $system->forceOrderStateChange('paid');

        $finalState = $system->getOrderState();

        // Act: intentos explícitos de mutación posterior
        $system->forceOrderStateChange('cancelled');
        $system->forceOrderStateChange('refunded');
        $system->forceOrderStateChange('created');

        // Assert: el estado final NO debe cambiar jamás
        $this->assertSame(
            $finalState,
            $system->getOrderState(),
            'Final states must be immutable forever, regardless of context'
        );
    }
}
