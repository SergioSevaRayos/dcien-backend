<?php
declare(strict_types=1);

namespace DCIEN\Tests\Obedience\Global;

use PHPUnit\Framework\TestCase;
use LogicException;

final class UndefinedEventFailsTest extends TestCase
{
    public function test_event_not_defined_in_matrix_causes_failure(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Event not defined in decision matrix');

        // Evento inexistente / no clasificado
        $eventName = 'SOME_UNKNOWN_EVENT';

        // Punto único de decisión del sistema (aún no implementado)
        // El test exige que NO exista comportamiento por defecto
        $this->dispatchEvent($eventName);
    }

    /**
     * Este método representa el punto soberano de decisión.
     * Mientras no exista implementación real, debe fallar.
     */
    private function dispatchEvent(string $event): void
    {
        throw new LogicException('Event not defined in decision matrix');
    }
}
