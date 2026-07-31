<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once dirname(__DIR__) . '/app/database.php';

$files = glob(dirname(__DIR__) . '/database/migrations/*.sql') ?: [];
sort($files, SORT_NATURAL);

$pdo = database();
$pdo->exec(
    'CREATE TABLE IF NOT EXISTS schema_migrations (
        migration VARCHAR(190) PRIMARY KEY,
        applied_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
);
$alreadyApplied = $pdo->prepare('SELECT 1 FROM schema_migrations WHERE migration = :migration');
$markApplied = $pdo->prepare('INSERT INTO schema_migrations (migration) VALUES (:migration)');

foreach ($files as $file) {
    $migration = basename($file);
    $alreadyApplied->execute(['migration' => $migration]);
    if ($alreadyApplied->fetchColumn()) {
        fwrite(STDOUT, 'Omitida (ya aplicada): ' . $migration . PHP_EOL);
        continue;
    }
    $pdo->exec((string) file_get_contents($file));
    $markApplied->execute(['migration' => $migration]);
    fwrite(STDOUT, 'Aplicada: ' . $migration . PHP_EOL);
}

fwrite(STDOUT, 'Base de datos actualizada correctamente.' . PHP_EOL);
