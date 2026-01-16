<?php
declare(strict_types=1);

namespace DCIEN\Tests\Domain\Numbering;

use PHPUnit\Framework\TestCase;
use DCIEN\Domain\Numbering\NumberAllocator;

final class ConcurrencyTest extends TestCase
{
    public function test_two_concurrent_allocations_only_one_can_succeed(): void
    {
        /**
         * CONTRATO:
         * Dos procesos reales intentan reservar al mismo tiempo.
         * Resultado válido:
         *  - uno obtiene number_id
         *  - el otro falla explícitamente
         *
         * Cualquier doble asignación = corrupción del sistema.
         */

        $this->fail(
            'Concurrency contract not implemented: two concurrent allocations must not both succeed.'
        );
    }
}
