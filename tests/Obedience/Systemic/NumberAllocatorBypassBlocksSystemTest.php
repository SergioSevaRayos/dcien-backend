<?php
declare(strict_types=1);

namespace DCIEN\Tests\Obedience\Systemic;

use PHPUnit\Framework\TestCase;

final class NumberAllocatorBypassBlocksSystemTest extends TestCase
{
    public function test_direct_number_mutation_outside_allocator_triggers_block(): void
    {
        // PRECONDICIÓN: number en estado válido
        // ACCIÓN: mutación directa fuera de NumberAllocator (ilegal)

        $result = $this->simulateDirectNumberMutation();

        // ASSERTS DE SOBERANÍA
        $this->assertTrue($result['blocked'], 'System must be blocked');
        $this->assertTrue($result['alert_sent'], 'Human alert must be sent');
        $this->assertTrue(
            $result['numberallocator_intact'],
            'NumberAllocator sovereignty must remain intact'
        );
        $this->assertFalse(
            $result['mutation_applied'],
            'Direct mutation must not be applied'
        );
    }

    private function simulateDirectNumberMutation(): array
    {
        // Placeholder deliberado
        return [
            'blocked' => false,
            'alert_sent' => false,
            'numberallocator_intact' => true,
            'mutation_applied' => false,
        ];
    }
}
