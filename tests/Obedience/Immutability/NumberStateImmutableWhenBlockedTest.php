<?php

namespace DCIEN\Tests\Obedience\Immutability;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

final class NumberStateImmutableWhenBlockedTest extends TestCase
{
    public function test_number_state_does_not_mutate_when_system_is_blocked(): void
    {
        // Arrange: sistema bloqueado
        $state = new SystemState();
        $state->block('systemic corruption');

        $system = new System($state);

        // Estado inicial del number
        $numberState = 'reserved';

        // Act: intento explícito de mutación (aunque esté bloqueado)
        try {
            // simulación de intento ilegítimo de mutación
            $system->attemptMutation(function () use (&$numberState) {
    $numberState = 'sold';
});
        } catch (\Throwable $e) {
            // no importa: la mutación NO debe ocurrir
        }

        // Assert: el estado NO debe cambiar
        $this->assertSame(
            'reserved',
            $numberState,
            'Number state must remain immutable while system is blocked'
        );
    }
}
