<?php

namespace DCIEN\Tests\Obedience\Sovereignty;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

/**
 * Jobs / cron NO pueden mutar estado
 * sin autoridad soberana explícita.
 */
final class JobCannotBypassSovereignTest extends TestCase
{
    public function test_job_cannot_mutate_state_without_sovereign(): void
    {
        // Arrange
        $state = new SystemState();
        $system = new System($state);

        $initialState = $system->getOrderState();

        // Simulación de job / cron
        $job = function () use ($system): void {
            // Mutación directa fuera de soberano
            $system->forceOrderStateChange('paid');
        };

        // Act
        $job();

        // Assert
        $this->assertSame(
            $initialState,
            $system->getOrderState(),
            'Jobs must not mutate state without sovereign authority'
        );
    }
}
