<?php

namespace DCIEN\Tests\Obedience\Alerting;

use PHPUnit\Framework\TestCase;

final class AlertRequiresHumanConfirmationTest extends TestCase
{
    public function test_alert_without_human_confirmation_is_not_delivered(): void
    {
        // Arrange
        $system = $this->system();

        // Act
        $system->simulateSystemicCorruption('PAID_WITHOUT_SOLD');

        // Assert
        $this->assertFalse(
            $system->alertIsConfirmed(),
            'Alert without human confirmation must not be considered delivered'
        );
    }

    private function system()
    {
        // placeholder consciente
        return new class {
            public function simulateSystemicCorruption(string $type): void {}
            public function alertIsConfirmed(): bool { return false; }
        };
    }
}
