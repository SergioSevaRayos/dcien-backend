<?php
declare(strict_types=1);

namespace DCIEN\Application\Order;

use DCIEN\Infrastructure\System\System;

final class OrderService
{
    public function __construct(
        private System $system
    ) {
    }
    public function forceOrderToPaid(): bool
    {
        return $this->system->attemptMutation(function () {
            $this->system->forceOrderStateChange('paid');
        });
    }


    public function createOrder(): bool
    {
        if ($this->system->isBlocked()) {
            return false;
        }

        return true;
    }
}
