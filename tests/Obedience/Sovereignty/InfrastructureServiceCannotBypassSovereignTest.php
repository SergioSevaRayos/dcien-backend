<?php

namespace DCIEN\Tests\Obedience\Sovereignty;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;
use DCIEN\Infrastructure\Operations\Operations;

final class InfrastructureServiceCannotBypassSovereignTest extends TestCase
{
    public function test_infrastructure_service_cannot_mutate_without_sovereign(): void
    {
        // Arrange
        $state = new SystemState(); // sistema activo
        $system = new System($state);

        $operations = new Operations($system);

        // Act
        $result = $operations->forceOrderToPaid();

        // Assert
        $this->assertFalse(
            $result,
            'Infrastructure services must not bypass sovereign authority'
        );
    }
}
