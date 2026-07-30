<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once dirname(__DIR__) . '/app/auth.php';

if ($argc < 4) {
    fwrite(STDERR, "Uso: php scripts/create-user.php usuario correo rol [nombre]\n");
    fwrite(STDERR, "La contraseña se solicitará después y no quedará en el historial.\n");
    exit(1);
}

[$script, $username, $email, $role] = $argv;
$fullName = $argv[4] ?? '';

fwrite(STDOUT, 'Contraseña (mínimo 12 caracteres): ');
$password = trim((string) fgets(STDIN));

try {
    $userId = createUser($username, $email, $password, $fullName, [$role]);
    fwrite(STDOUT, "Usuario registrado con ID {$userId}." . PHP_EOL);
} catch (Throwable $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
