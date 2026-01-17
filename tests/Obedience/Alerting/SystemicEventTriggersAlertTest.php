<?php

namespace DCIEN\Tests\Obedience\Alerting;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

final class SystemicEventTriggersAlertTest extends TestCase
{
    public function test_systemic_event_emits_human_alert(): void
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
            'Systemic corruption must emit a human alert'
        );
    }

    private function system(): System
    {
        return new System(new SystemState());
    }
}
