<?php
declare(strict_types=1);

namespace DCIEN\Application\Payment;

use DCIEN\Infrastructure\System\System;

final class PaymentService
{
    public function __construct(
        private System $system
    ) {}

    public function startPayment(): bool
    {
        if ($this->system->isBlocked()) {
            return false;
        }

        return true;
    }

    public function confirmSale(): bool
    {
        if ($this->system->isBlocked()) {
            return false;
        }

        return true;
    }
}
