<?php
declare(strict_types=1);


$envFile = __DIR__ . '/../.env.test';
if (!file_exists($envFile)) {
    throw new RuntimeException('.env.test not found');
}

$env = parse_ini_file($envFile);
if ($env === false) {
    throw new RuntimeException('Failed to parse .env.test');
}

$dsn = sprintf(
    'pgsql:host=%s;port=%s;dbname=%s',
    $env['DB_HOST'],
    $env['DB_PORT'],
    $env['DB_NAME']
);

$pdo = new PDO(
    $dsn,
    $env['DB_USER'],
    $env['DB_PASSWORD'],
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]
);

$schemaFile = __DIR__ . '/fixtures/schema.sql';
if (!file_exists($schemaFile)) {
    throw new RuntimeException('schema.sql not found');
}

$pdo->beginTransaction();

$schemaSql = file_get_contents($schemaFile);
if ($schemaSql === false) {
    throw new RuntimeException('Failed to read schema.sql');
}

$pdo->exec($schemaSql);

$pdo->commit();

// Exponer conexión a los tests
$GLOBALS['pdo'] = $pdo;
