<?php
declare(strict_types=1);

namespace DCIEN\Infrastructure\System;

final class SystemState
{
    private bool $blocked = false;

    public function block(string $reason): void
    {
        $this->blocked = true;
    }

    public function isBlocked(): bool
    {
        return $this->blocked;
    }
    public function auditSnapshot(array $snapshot): void
    {
        if ($this->isInvalidSnapshot($snapshot)) {
            $this->block('systemic corruption');
            $this->emitAlert();
        }
    }
    public function hasPendingAlert(): bool
    {
        return $this->alertPending === true;
    }
    private bool $alertPending = false;

    private function emitAlert(): void
    {
        $this->alertPending = true;
    }
    private function isInvalidSnapshot(array $snapshot): bool
    {
        // stub consciente para tests de obediencia
        return true;
    }




}
