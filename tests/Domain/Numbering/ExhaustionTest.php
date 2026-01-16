<?php
declare(strict_types=1);

namespace DCIEN\Tests\Domain\Numbering;

use PHPUnit\Framework\TestCase;
use DCIEN\Tests\Support\UnimplementedNumberAllocator;
use LogicException;

final class ExhaustionTest extends TestCase
{
    public function test_allocation_fails_when_no_numbers_are_available(): void
    {
        $allocator = new UnimplementedNumberAllocator();

        $this->expectException(LogicException::class);

        $allocator->allocateRandom(99, 3001);
    }
}
