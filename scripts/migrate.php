<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once dirname(__DIR__) . '/app/database.php';

$files = glob(dirname(__DIR__) . '/database/migrations/*.sql') ?: [];
sort($files, SORT_NATURAL);

foreach ($files as $file) {
    database()->exec((string) file_get_contents($file));
    fwrite(STDOUT, 'Aplicada: ' . basename($file) . PHP_EOL);
}

fwrite(STDOUT, 'Base de datos actualizada correctamente.' . PHP_EOL);
