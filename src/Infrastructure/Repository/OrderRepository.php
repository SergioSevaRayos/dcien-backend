<?php
declare(strict_types=1);

namespace DCIEN\Infrastructure\Repository;

use DCIEN\Infrastructure\System\System;

final class OrderRepository
{
    public function __construct(
        private ?System $system = null
    ) {
    }

    public function save(array $data): bool
    {
        if ($this->system === null) {
            return false;
        }

        return $this->system->attemptMutation(fn() => null);
    }
    public function forceOrderToPaid(): bool
    {
        return false;
    }

}
