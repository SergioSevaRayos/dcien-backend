<?php

namespace DCIEN\Tests\Obedience\Blocking;

use PHPUnit\Framework\TestCase;

use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;
use DCIEN\Application\Numbering\NumberReservationService;

final class ReserveNumberBlockedTest extends TestCase
{
    public function test_number_reservation_is_blocked_when_system_is_blocked(): void
    {
        // Arrange
        $system = $this->systemBlocked();

        // Act
        $result = $system->reserveNumber();

        // Assert
        $this->assertFalse(
            $result,
            'Number reservation must be blocked while system is blocked'
        );
    }

    private function systemBlocked(): NumberReservationService
    {
        $state = new SystemState();
        $state->block('test');

        $system = new System($state);

        return new NumberReservationService($system);
    }
}
