<?php

namespace DCIEN\Tests\Obedience\Blocking;

use PHPUnit\Framework\TestCase;

use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;
use DCIEN\Application\Order\OrderService;

final class CreateOrderBlockedTest extends TestCase
{
    public function test_create_order_is_blocked_when_system_is_blocked(): void
    {
        // Arrange
        $system = $this->systemBlocked();

        // Act
        $result = $system->createOrder();

        // Assert
        $this->assertFalse(
            $result,
            'Order creation must be blocked while system is blocked'
        );
    }

    private function systemBlocked(): OrderService
    {
        $state = new SystemState();
        $state->block('test');

        $system = new System($state);

        return new OrderService($system);
    }
}
