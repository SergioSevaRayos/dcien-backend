<?php

namespace DCIEN\Tests\Obedience\Immutability;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

final class MutationAttemptRejectedWhenBlockedTest extends TestCase
{
    public function test_mutation_attempt_is_rejected_when_system_is_blocked(): void
    {
        // Arrange
        $state = new SystemState();
        $state->block('systemic corruption');

        $system = new System($state);

        // Act
        $result = $system->attemptMutation(function () {
            // intento de mutación explícito (no debe ejecutarse)
        });

        // Assert
        $this->assertFalse(
            $result,
            'Any mutation attempt must be explicitly rejected while system is blocked'
        );
    }
}
