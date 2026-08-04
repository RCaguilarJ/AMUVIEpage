<?php
declare(strict_types=1);

function readEnvironmentFile(string $file): array
{
    if (!is_file($file)) {
        return [];
    }

    $values = [];
    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$name, $value] = array_map('trim', explode('=', $line, 2));
        if ($name === '') {
            continue;
        }

        $values[$name] = trim($value, "\"'");
    }

    return $values;
}

$root = dirname(__DIR__);
$environment = array_merge(
    readEnvironmentFile($root . '/.env'),
    readEnvironmentFile($root . '/.env.local')
);

foreach ($environment as $name => $value) {
    if (getenv($name) !== false) {
        continue;
    }

    putenv("{$name}={$value}");
    $_ENV[$name] = $value;
}
