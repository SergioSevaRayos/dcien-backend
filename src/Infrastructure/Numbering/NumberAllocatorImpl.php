<?php
declare(strict_types=1);

namespace DCIEN\Infrastructure\Numbering;

use DCIEN\Domain\Numbering\NumberAllocator;
use LogicException;

final class NumberAllocatorImpl implements NumberAllocator
{
    public function allocateRandom(int $seriesId, int $orderId): int
    {
        throw new LogicException('NumberAllocator not implemented');
    }

    public function allocateSpecific(int $seriesId, int $number, int $orderId): int
    {
        throw new LogicException('NumberAllocator not implemented');
    }
}
