<?php

namespace DCIEN\Tests\Obedience\Alerting;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

final class AlertRetriesUntilConfirmedTest extends TestCase
{
    public function test_alert_persists_until_human_confirmation(): void
    {
        // Arrange
        $system = $this->system();

        // Act: provocar corrupción sistémica REAL
        $system->auditSnapshot([
            'order_state'  => 'paid',
            'number_state' => 'reserved',
        ]);

        // Assert
        $this->assertTrue(
            $system->alertIsStillPending(),
            'Alert must persist until human confirmation'
        );
    }

    private function system(): System
    {
        return new System(new SystemState());
    }
}
