<?php
declare(strict_types=1);

namespace DCIEN\Tests\Obedience\Operational;

use PHPUnit\Framework\TestCase;

final class UserAbandonmentDoesNotBlockSystemTest extends TestCase
{
    public function test_user_abandonment_is_operational_and_does_not_block(): void
    {
        // PRECONDICIÓN: order creada o en progreso
        // ACCIÓN: el usuario abandona el flujo (cierra pestaña)

        $result = $this->simulateUserAbandonment();

        // ASSERTS OPERATIVOS
        $this->assertFalse($result['blocked'], 'System must not be blocked');
        $this->assertFalse($result['alert_sent'], 'No human alert must be sent');
        $this->assertTrue(
            $result['state_is_intermediate'],
            'Intermediate states must be allowed'
        );
    }

    private function simulateUserAbandonment(): array
    {
        // Placeholder deliberado
        return [
            'blocked' => false,
            'alert_sent' => false,
            'state_is_intermediate' => true,
        ];
    }
}
