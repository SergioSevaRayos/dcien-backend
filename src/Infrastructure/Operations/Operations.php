<?php
declare(strict_types=1);

namespace DCIEN\Infrastructure\Operations;

use DCIEN\Infrastructure\System\System;

final class Operations
{
    public function __construct(
        private System $system
    ) {}

    public function createOrder(): bool
    {
        return !$this->system->isBlocked();
    }

    public function reserveNumber(): bool
    {
        return !$this->system->isBlocked();
    }

    public function startPayment(): bool
    {
        return !$this->system->isBlocked();
    }

    public function confirmSale(): bool
    {
        return !$this->system->isBlocked();
    }
}
