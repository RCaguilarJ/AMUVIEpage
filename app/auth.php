<?php
declare(strict_types=1);

require_once __DIR__ . '/database.php';

function findUserByLogin(string $login): ?array
{
    $statement = database()->prepare(
        'SELECT u.id, u.username, u.email, u.password_hash, u.full_name, u.status,
                GROUP_CONCAT(r.name ORDER BY r.name SEPARATOR ",") AS roles
         FROM users u
         LEFT JOIN user_roles ur ON ur.user_id = u.id
         LEFT JOIN roles r ON r.id = ur.role_id
         WHERE u.username = :login OR u.email = :login
         GROUP BY u.id
         LIMIT 1'
    );
    $statement->execute(['login' => trim($login)]);
    $user = $statement->fetch();

    if (!$user) {
        return null;
    }

    $user['roles'] = $user['roles'] === null ? [] : explode(',', $user['roles']);
    return $user;
}

function createUser(
    string $username,
    string $email,
    string $password,
    string $fullName = '',
    array $roles = ['usuario']
): int {
    $username = trim($username);
    $email = mb_strtolower(trim($email), 'UTF-8');

    if (!preg_match('/^[a-zA-Z0-9._-]{3,50}$/', $username)) {
        throw new InvalidArgumentException('El usuario debe tener entre 3 y 50 caracteres válidos.');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('El correo electrónico no es válido.');
    }
    if (mb_strlen($password, 'UTF-8') < 12) {
        throw new InvalidArgumentException('La contraseña debe tener al menos 12 caracteres.');
    }
    if (findUserByLogin($username) !== null || findUserByLogin($email) !== null) {
        throw new DomainException('Ya existe un usuario con ese nombre o correo.');
    }

    $pdo = database();
    $pdo->beginTransaction();

    try {
        $statement = $pdo->prepare(
            'INSERT INTO users (username, email, password_hash, full_name)
             VALUES (:username, :email, :password_hash, :full_name)'
        );
        $statement->execute([
            'username' => $username,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'full_name' => trim($fullName) ?: null,
        ]);
        $userId = (int) $pdo->lastInsertId();

        $assignRole = $pdo->prepare(
            'INSERT IGNORE INTO user_roles (user_id, role_id)
             SELECT :user_id, id FROM roles WHERE name = :role'
        );
        foreach (array_unique($roles) as $role) {
            $assignRole->execute(['user_id' => $userId, 'role' => $role]);
            if ($assignRole->rowCount() === 0) {
                throw new DomainException("El rol '{$role}' no existe.");
            }
        }

        $pdo->commit();
        return $userId;
    } catch (Throwable $exception) {
        $pdo->rollBack();
        throw $exception;
    }
}

function authenticateUser(string $login, string $password): ?array
{
    $user = findUserByLogin($login);
    if (
        $user === null
        || $user['status'] !== 'activo'
        || !password_verify($password, $user['password_hash'])
    ) {
        return null;
    }

    if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
        $statement = database()->prepare(
            'UPDATE users SET password_hash = :password_hash WHERE id = :id'
        );
        $statement->execute([
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'id' => $user['id'],
        ]);
    }

    unset($user['password_hash']);
    return $user;
}

function loginUser(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => (int) $user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'full_name' => $user['full_name'],
        'roles' => $user['roles'],
    ];
}

function currentUser(): ?array
{
    return isset($_SESSION['user']) && is_array($_SESSION['user'])
        ? $_SESSION['user']
        : null;
}

function userHasRole(string $role): bool
{
    return in_array($role, currentUser()['roles'] ?? [], true);
}

function listUsers(): array
{
    $statement = database()->query(
        'SELECT u.id, u.username, u.email, u.full_name, u.status, u.last_login_at,
                u.created_at,
                GROUP_CONCAT(r.name ORDER BY r.name SEPARATOR ",") AS roles
         FROM users u
         LEFT JOIN user_roles ur ON ur.user_id = u.id
         LEFT JOIN roles r ON r.id = ur.role_id
         GROUP BY u.id
         ORDER BY u.created_at DESC, u.id DESC'
    );

    return array_map(
        static function (array $user): array {
            $user['roles'] = $user['roles'] === null ? [] : explode(',', $user['roles']);
            return $user;
        },
        $statement->fetchAll()
    );
}
