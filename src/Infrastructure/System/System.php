<?php
declare(strict_types=1);

namespace DCIEN\Infrastructure\System;

final class System
{
    // =========================
    // === TEST-ONLY STATE =====
    // =========================

    // Estado interno simulado de order (solo para tests de inmutabilidad)
    private string $orderState = 'created';

    /** @var string[] */
    private array $alertTrail = [];

    private bool $alertConfirmed = false;

    public function __construct(
        private SystemState $state
    ) {
    }

    // =========================
    // === ORDER STATE (TEST) ==
    // =========================

    public function forceOrderStateChange(string $newState): void
    {
        // 🚫 Bloqueo global: ninguna mutación permitida
        if ($this->state->isBlocked()) {
            return;
        }

        // Estados finales cerrados
        $finalStates = ['paid', 'cancelled'];

        if (in_array($this->orderState, $finalStates, true)) {
            return;
        }

        $this->orderState = $newState;
    }





    public function getOrderState(): string
    {
        return $this->orderState;
    }

    // =========================
    // === SYSTEM STATE =========
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
    // === ALERTING CONTRACT ===
    // =========================

    public function simulateSystemicCorruption(string $code): void
    {
        // evento detectado
        $this->alertTrail[] = 'event';

        // bloqueo inmediato
        $this->state->block($code);

        // alerta humana emitida
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

    public function attemptMutation(callable $mutation): bool
    {
        if ($this->state->isBlocked()) {
            return false;
        }

        $mutation();
        return true;
    }

}
