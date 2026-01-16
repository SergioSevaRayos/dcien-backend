<?php
declare(strict_types=1);

namespace DCIEN\Infrastructure\Numbering;

use DCIEN\Domain\Numbering\NumberAllocator;
use LogicException;
use PDO;

final class NumberAllocatorImpl implements NumberAllocator
{
    public function allocateRandom(int $seriesId, int $orderId): int
    {
        $pdo = $GLOBALS['pdo'];

        $ownsTransaction = !$pdo->inTransaction();
        if ($ownsTransaction) {
            $pdo->beginTransaction();
        }

        try {
            // 1. Idempotencia
            $stmt = $pdo->prepare(
                "SELECT number
             FROM numbers
             WHERE series_id = :series
               AND assigned_order_id = :order
             FOR UPDATE"
            );
            $stmt->execute([
                'series' => $seriesId,
                'order' => $orderId,
            ]);

            $existing = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($existing !== false) {
                if ($ownsTransaction) {
                    $pdo->commit();
                }
                return (int) $existing['number'];
            }

            // 2. Buscar número disponible
            $stmt = $pdo->prepare(
                "SELECT id, number
             FROM numbers
             WHERE series_id = :series
               AND status = 'available'
             ORDER BY number
             LIMIT 1
             FOR UPDATE"
            );
            $stmt->execute(['series' => $seriesId]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row === false) {
                if ($ownsTransaction) {
                    $pdo->rollBack();
                }
                throw new LogicException('No available numbers');
            }

            // 3. Reservar
            $stmt = $pdo->prepare(
                "UPDATE numbers
             SET status = 'reserved',
                 assigned_order_id = :order
             WHERE id = :id"
            );
            $stmt->execute([
                'order' => $orderId,
                'id' => $row['id'],
            ]);

            if ($ownsTransaction) {
                $pdo->commit();
            }

            return (int) $row['number'];
        } catch (\Throwable $e) {
            if ($ownsTransaction && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }


    public function allocateSpecific(int $seriesId, int $number, int $orderId): int
    {
        throw new LogicException('Not implemented');
    }
}
