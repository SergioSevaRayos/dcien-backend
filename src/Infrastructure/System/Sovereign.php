<?php
declare(strict_types=1);

namespace DCIEN\Infrastructure\System;

final class Sovereign
{
    private bool $permissionGranted = false;

    public function grant(): void
    {
        $this->permissionGranted = true;
    }

    public function revoke(): void
    {
        $this->permissionGranted = false;
    }

    public function allowsMutation(): bool
    {
        return $this->permissionGranted;
    }
}
