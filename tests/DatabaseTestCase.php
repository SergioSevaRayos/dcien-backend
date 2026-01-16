<?php
declare(strict_types=1);

namespace DCIEN\Tests;

use PHPUnit\Framework\TestCase;
use PDO;
use RuntimeException;

abstract class DatabaseTestCase extends TestCase
{
    protected PDO $pdo;

    protected function setUp(): void
    {
        parent::setUp();

        if (!isset($GLOBALS['pdo']) || !$GLOBALS['pdo'] instanceof PDO) {
            throw new RuntimeException('PDO not available in tests');
        }

        $this->pdo = $GLOBALS['pdo'];

        $schemaFile = __DIR__ . '/fixtures/schema.sql';
        if (!file_exists($schemaFile)) {
            throw new RuntimeException('schema.sql not found');
        }

        $schemaSql = file_get_contents($schemaFile);
        if ($schemaSql === false) {
            throw new RuntimeException('Failed to read schema.sql');
        }

        $this->pdo->beginTransaction();
        $this->pdo->exec($schemaSql);
        $this->pdo->commit();
    }
}
