<?php

namespace DCIEN\Tests\Obedience\Sovereignty;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;
use DCIEN\Application\Order\OrderService;

final class ApplicationServiceCannotBypassSovereignTest extends TestCase
{
    public function test_application_service_cannot_mutate_state_without_sovereign(): void
    {
        // Arrange
        $state = new SystemState();
        $system = new System($state);

        $orderService = new OrderService($system);

        // Act
        $result = $orderService->forceOrderToPaid();

        // Assert
        $this->assertFalse(
            $result,
            'Application services must not bypass sovereign authority'
        );
    }
}
