<?php
declare(strict_types=1);

namespace DCIEN\Tests\Domain\Numbering;

use PHPUnit\Framework\TestCase;
use DCIEN\Domain\Numbering\NumberAllocator;

final class IdempotencyTest extends TestCase
{
    public function test_same_order_id_always_returns_same_number(): void
    {
        /**
         * CONTRATO:
         * Llamar varias veces con el mismo order_id
         * debe devolver SIEMPRE el mismo number_id.
         *
         * No se permiten nuevas reservas.
         */

        $this->fail(
            'Idempotency contract not implemented: repeated calls with same order_id must be stable.'
        );
    }
}
