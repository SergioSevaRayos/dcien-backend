<?php

namespace DCIEN\Tests\Obedience\Sovereignty;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

/**
 * Scripts / CLI NO pueden mutar estado
 * sin autoridad soberana explícita.
 */
final class ScriptCannotBypassSovereignTest extends TestCase
{
    public function test_script_cannot_mutate_state_without_sovereign(): void
    {
        // Arrange
        $state = new SystemState();
        $system = new System($state);

        $initialState = $system->getOrderState();

        // Simulación de script CLI
        $script = function () use ($system): void {
            $system->forceOrderStateChange('paid');
        };

        // Act
        $script();

        // Assert
        $this->assertSame(
            $initialState,
            $system->getOrderState(),
            'Scripts must not mutate state without sovereign authority'
        );
    }
}
