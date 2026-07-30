<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once dirname(__DIR__) . '/app/auth.php';

$users = listUsers();
if ($users === []) {
    fwrite(STDOUT, 'No hay usuarios registrados.' . PHP_EOL);
    exit;
}

foreach ($users as $user) {
    printf(
        "%d | %s | %s | %s | %s\n",
        $user['id'],
        $user['username'],
        $user['email'],
        implode(',', $user['roles']),
        $user['status']
    );
}
