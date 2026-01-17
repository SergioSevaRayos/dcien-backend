<?php
declare(strict_types=1);

namespace DCIEN\Infrastructure\Operations;

use DCIEN\Infrastructure\System\System;

final class Operations
{
    public function __construct(
        private ?System $system = null
    ) {
    }

    public function createOrder(): bool
    {
        return $this->guarded();
    }

    public function reserveNumber(): bool
    {
        return $this->guarded();
    }

    public function startPayment(): bool
    {
        return $this->guarded();
    }

    public function confirmSale(): bool
    {
        return $this->guarded();
    }
    public function forceOrderToPaid(): bool
    {
        return false;
    }


    private function guarded(): bool
    {
        if ($this->system === null) {
            return false;
        }

        return $this->system->attemptMutation(fn() => null);
    }
}
