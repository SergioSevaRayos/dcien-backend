<?php

namespace DCIEN\Tests\Obedience\Blocking;

use PHPUnit\Framework\TestCase;

use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;
use DCIEN\Application\Payment\PaymentService;

final class StartPaymentBlockedTest extends TestCase
{
    public function test_payment_start_is_blocked_when_system_is_blocked(): void
    {
        // Arrange
        $system = $this->systemBlocked();

        // Act
        $result = $system->startPayment();

        // Assert
        $this->assertFalse(
            $result,
            'Payment initiation must be blocked while system is blocked'
        );
    }

    private function systemBlocked(): PaymentService
    {
        $state = new SystemState();
        $state->block('test');

        $system = new System($state);

        return new PaymentService($system);
    }
}
