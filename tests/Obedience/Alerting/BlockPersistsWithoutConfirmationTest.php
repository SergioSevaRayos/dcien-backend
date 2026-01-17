<?php

namespace DCIEN\Tests\Obedience\Alerting;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;

final class BlockPersistsWithoutConfirmationTest extends TestCase
{
    public function test_system_remains_blocked_without_human_confirmation(): void
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
            $system->isBlocked(),
            'System must remain blocked until human confirmation occurs'
        );
    }

    private function system(): System
    {
        return new System(new SystemState());
    }
}
