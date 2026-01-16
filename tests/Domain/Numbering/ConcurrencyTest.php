<?php
declare(strict_types=1);

namespace DCIEN\Tests\Domain\Numbering;

use PHPUnit\Framework\TestCase;
use DCIEN\Tests\Support\UnimplementedNumberAllocator;
use LogicException;

final class ConcurrencyTest extends TestCase
{
    public function test_two_concurrent_allocations_only_one_can_succeed(): void
    {
        $allocator = new UnimplementedNumberAllocator();

        $this->expectException(LogicException::class);

        $allocator->allocateRandom(1, 1001);
        $allocator->allocateRandom(1, 1002);
    }
}
