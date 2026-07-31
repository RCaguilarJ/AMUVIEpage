<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once dirname(__DIR__) . '/app/database.php';

try {
    $pdo = database();
    fwrite(STDOUT, "Conexión PDO: correcta\n");
    fwrite(STDOUT, 'Servidor: ' . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n");

    foreach (['users', 'roles', 'user_roles', 'user_profiles', 'schema_migrations'] as $table) {
        $statement = $pdo->query("SHOW TABLES LIKE " . $pdo->quote($table));
        fwrite(STDOUT, sprintf("Tabla %-20s %s\n", $table . ':', $statement->fetchColumn() ? 'correcta' : 'FALTA'));
    }

    $statement = $pdo->prepare('SELECT id, status FROM users WHERE username = :username LIMIT 1');
    $statement->execute(['username' => 'demo']);
    $demo = $statement->fetch();
    fwrite(STDOUT, 'Usuario demo: ' . ($demo ? 'presente (' . $demo['status'] . ')' : 'FALTA') . "\n");
} catch (Throwable $exception) {
    fwrite(STDERR, 'Diagnóstico fallido [' . $exception->getCode() . ']: ' . $exception->getMessage() . "\n");
    exit(1);
}
