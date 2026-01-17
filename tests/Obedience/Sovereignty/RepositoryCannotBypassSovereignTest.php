<?php

namespace DCIEN\Tests\Obedience\Sovereignty;

use PHPUnit\Framework\TestCase;
use DCIEN\Infrastructure\System\System;
use DCIEN\Infrastructure\System\SystemState;
use DCIEN\Infrastructure\Repository\OrderRepository;

final class RepositoryCannotBypassSovereignTest extends TestCase
{
    public function test_repository_cannot_mutate_state_without_sovereign(): void
    {
        // Arrange: sistema NO bloqueado (caso más peligroso)
        $state = new SystemState();
        $system = new System($state);

        $repository = new OrderRepository($system);

        // Act: intento directo de mutación desde repositorio
        $result = $repository->forceOrderToPaid();

        // Assert: el repositorio NO debe poder mutar por sí mismo
        $this->assertFalse(
            $result,
            'Repositories must not bypass sovereign authority'
        );
    }
}
