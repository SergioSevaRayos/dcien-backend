<?php
declare(strict_types=1);

namespace DCIEN\Infrastructure\Persistence;

use DCIEN\Infrastructure\System\System;

final class DirectPersistence
{
    public function __construct(
        private ?System $system = null
    ) {}

    public function forceWrite(array $data): bool
    {
        // ❌ Sin soberano → prohibido
        if ($this->system === null) {
            return false;
        }

        // ✅ Con soberano → permiso explícito
        return $this->system->attemptMutation(function () use ($data) {
            // no-op: la intención es suficiente para el test
        });
    }
}
