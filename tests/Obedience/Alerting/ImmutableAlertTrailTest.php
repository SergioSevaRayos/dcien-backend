<?php

namespace DCIEN\Tests\Obedience\Alerting;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

final class ImmutableAlertTrailTest extends TestCase
{
    public function test_event_alert_and_confirmation_are_immutably_recorded(): void
    {
        // Arrange
        $state = new SystemState();
        $system = new System($state);

        // Act
        $system->simulateSystemicCorruption('PAID_WITHOUT_SOLD');
        $system->confirmHumanAlert('operator-1');

        // Assert
        $this->assertSame(
            ['event', 'alert', 'confirmation'],
            $system->alertTrail(),
            'Event, alert and confirmation must be immutably recorded in order'
        );
    }
}
