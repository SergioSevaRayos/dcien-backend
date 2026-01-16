<?php
declare(strict_types=1);

namespace DCIEN\Tests\Domain\Numbering;

use PHPUnit\Framework\TestCase;
use DCIEN\Tests\Support\UnimplementedNumberAllocator;
use LogicException;

final class IdempotencyTest extends TestCase
{
    public function test_same_order_id_always_returns_same_number(): void
    {
        $allocator = new UnimplementedNumberAllocator();

        $this->expectException(LogicException::class);

        $allocator->allocateRandom(1, 2001);
        $allocator->allocateRandom(1, 2001);
    }
}
