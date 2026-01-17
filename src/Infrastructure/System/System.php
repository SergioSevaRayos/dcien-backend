<?php
declare(strict_types=1);

namespace DCIEN\Infrastructure\System;

use DCIEN\Infrastructure\System\Sovereign;

final class System
{
    // =========================
    // === TEST-ONLY STATE =====
    // =========================

    private string $orderState = 'created';

    /** @var string[] */
    private array $alertTrail = [];

    private bool $alertConfirmed = false;

    private Sovereign $sovereign;

    public function __construct(
        private SystemState $state
    ) {
        $this->sovereign = new Sovereign();
    }

    // =========================
    // === ORDER STATE (TEST) ==
    // =========================

    public function forceOrderStateChange(string $newState): void
    {
        // 🚫 bloqueo total
        if ($this->state->isBlocked()) {
            return;
        }

        // 🚫 estados finales inmutables
        $finalStates = ['paid', 'cancelled'];
        if (in_array($this->orderState, $finalStates, true)) {
            return;
        }

        // 🚫 sin permiso soberano
        if (!$this->sovereign->allowsMutation()) {
            return;
        }

        $this->orderState = $newState;
    }

    public function getOrderState(): string
    {
        return $this->orderState;
    }

    // =========================
    // === SYSTEM STATE ========
    // =========================

    public function isBlocked(): bool
    {
        return $this->state->isBlocked();
    }

    public function auditSnapshot(array $snapshot): void
    {
        $this->state->auditSnapshot($snapshot);
    }

    public function alertIsStillPending(): bool
    {
        return $this->state->hasPendingAlert();
    }

    // =========================
    // === ALERTING ============
    // =========================

    public function simulateSystemicCorruption(string $code): void
    {
        $this->alertTrail[] = 'event';

        $this->state->block($code);

        $this->alertTrail[] = 'alert';
    }

    public function confirmHumanAlert(string $operatorId): void
    {
        if ($this->alertConfirmed) {
            return;
        }

        $this->alertConfirmed = true;
        $this->alertTrail[] = 'confirmation';
    }

    public function alertTrail(): array
    {
        return $this->alertTrail;
    }

    // =========================
    // === SOVEREIGN GATE ======
    // =========================

    public function attemptMutation(callable $mutation): bool
    {
        if ($this->state->isBlocked()) {
            return false;
        }

        if (!$this->sovereign->allowsMutation()) {
            return false;
        }

        $mutation();
        return true;
    }

    // === test-only explicit authority ===

    public function grantSovereignPermission(): void
    {
        $this->sovereign->grant();
    }

    public function revokeSovereignPermission(): void
    {
        $this->sovereign->revoke();
    }
}
