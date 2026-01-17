<?php
declare(strict_types=1);

namespace DCIEN\Application\Numbering;

use DCIEN\Infrastructure\System\System;

final class NumberReservationService
{
    public function __construct(
        private System $system
    ) {}

    public function reserveNumber(): bool
    {
        if ($this->system->isBlocked()) {
            return false;
        }

        return true;
    }
}
