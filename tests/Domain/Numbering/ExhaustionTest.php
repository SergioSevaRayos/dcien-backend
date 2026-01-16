<?php
declare(strict_types=1);

namespace DCIEN\Tests\Domain\Numbering;

use PHPUnit\Framework\TestCase;
use DCIEN\Domain\Numbering\NumberAllocator;

final class ExhaustionTest extends TestCase
{
    public function test_allocation_fails_when_no_numbers_are_available(): void
    {
        /**
         * CONTRATO:
         * Cuando no hay numbers en estado 'available':
         * - allocateRandom() DEBE fallar explícitamente
         * - no puede devolver null
         * - no puede inventar estados
         */

        $this->fail(
            'Exhaustion contract not implemented: allocation must fail explicitly when no numbers are available.'
        );
    }
}
