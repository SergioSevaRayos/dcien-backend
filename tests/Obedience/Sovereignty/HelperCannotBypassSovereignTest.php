<?php

namespace DCIEN\Tests\Obedience\Sovereignty;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

/**
 * Helpers utilitarios NO pueden mutar estado
 * sin pasar por la autoridad soberana.
 */
final class HelperCannotBypassSovereignTest extends TestCase
{
    public function test_helper_cannot_mutate_state_without_sovereign(): void
    {
        // Arrange
        $state = new SystemState();
        $system = new System($state);

        $initialState = $system->getOrderState();

        // Helper "inofensivo"
        $helper = function (System $system): void {
            // Mutación directa fuera de soberano
            $system->forceOrderStateChange('paid');
        };

        // Act
        $helper($system);

        // Assert
        $this->assertSame(
            $initialState,
            $system->getOrderState(),
            'Helpers must not mutate state without sovereign authority'
        );
    }
}
