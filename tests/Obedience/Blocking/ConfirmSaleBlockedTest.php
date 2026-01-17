<?php

namespace DCIEN\Tests\Obedience\Blocking;

use PHPUnit\Framework\TestCase;

use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;
use DCIEN\Application\Payment\PaymentService;

final class ConfirmSaleBlockedTest extends TestCase
{
    public function test_sale_confirmation_is_blocked_when_system_is_blocked(): void
    {
        // Arrange
        $system = $this->systemBlocked();

        // Act
        $result = $system->confirmSale();

        // Assert
        $this->assertFalse(
            $result,
            'Sale confirmation must be blocked while system is blocked'
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
