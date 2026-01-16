<?php
declare(strict_types=1);

namespace DCIEN\Domain\Numbering;

interface NumberAllocator
{
    public function allocateRandom(int $seriesId, int $orderId): int;

    public function allocateSpecific(int $seriesId, int $number, int $orderId): int;
}
