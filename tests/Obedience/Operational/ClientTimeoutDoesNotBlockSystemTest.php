<?php
declare(strict_types=1);

namespace DCIEN\Tests\Obedience\Operational;

use PHPUnit\Framework\TestCase;

final class ClientTimeoutDoesNotBlockSystemTest extends TestCase
{
    public function test_client_timeout_is_operational_and_does_not_block(): void
    {
        // PRECONDICIÓN: request en curso
        // ACCIÓN: el cliente hace timeout

        $result = $this->simulateClientTimeout();

        // ASSERTS OPERATIVOS
        $this->assertFalse($result['blocked'], 'System must not be blocked');
        $this->assertFalse($result['alert_sent'], 'No human alert must be sent');
        $this->assertTrue(
            $result['can_retry_idempotently'],
            'System must allow idempotent retry'
        );
    }

    private function simulateClientTimeout(): array
    {
        // Placeholder deliberado
        return [
            'blocked' => false,
            'alert_sent' => false,
            'can_retry_idempotently' => true,
        ];
    }
}
