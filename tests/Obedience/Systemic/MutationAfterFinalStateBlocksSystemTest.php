<?php
declare(strict_types=1);

namespace DCIEN\Tests\Obedience\Systemic;

use PHPUnit\Framework\TestCase;

final class MutationAfterFinalStateBlocksSystemTest extends TestCase
{
    public function test_mutation_after_final_state_triggers_block(): void
    {
        // PRECONDICIÓN: estado final alcanzado
        // Ejemplo: order.paid + number.sold

        // ACCIÓN: intento de mutación posterior (ilegal)
        $result = $this->simulateMutationAfterFinalState();

        // ASSERTS DE OBEDIENCIA
        $this->assertTrue($result['blocked'], 'System must be blocked');
        $this->assertTrue($result['alert_sent'], 'Human alert must be sent');
        $this->assertTrue(
            $result['final_states_unchanged'],
            'Final states must remain immutable'
        );
        $this->assertFalse(
            $result['mutation_applied'],
            'Illegal mutation must not be applied'
        );
    }

    private function simulateMutationAfterFinalState(): array
    {
        // Placeholder deliberado
        return [
            'blocked' => false,
            'alert_sent' => false,
            'final_states_unchanged' => true,
            'mutation_applied' => false,
        ];
    }
}
