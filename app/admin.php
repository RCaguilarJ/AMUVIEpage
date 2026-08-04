<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';

function adminLog(int $adminId, string $action, string $entityType, ?int $entityId = null, array $details = []): void
{
    $statement = database()->prepare(
        'INSERT INTO admin_activity_log (admin_user_id, action, entity_type, entity_id, details)
         VALUES (:admin_user_id, :action, :entity_type, :entity_id, :details)'
    );
    $statement->execute([
        'admin_user_id' => $adminId,
        'action' => $action,
        'entity_type' => $entityType,
        'entity_id' => $entityId,
        'details' => $details === [] ? null : json_encode($details, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
    ]);
}

function adminDashboardCounts(): array
{
    $pdo = database();
    return [
        'users' => (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn(),
        'active_users' => (int) $pdo->query("SELECT COUNT(*) FROM users WHERE status='activo'")->fetchColumn(),
        'documents' => (int) $pdo->query("SELECT COUNT(*) FROM documents WHERE status='activo'")->fetchColumn(),
        'requests' => (int) $pdo->query("SELECT COUNT(*) FROM format_requests WHERE status IN ('recibida','en_revision')")->fetchColumn(),
        'messages' => (int) $pdo->query("SELECT COUNT(*) FROM member_messages WHERE status IN ('recibido','en_revision')")->fetchColumn(),
    ];
}

function adminListDocuments(): array
{
    return database()->query(
        'SELECT d.*, c.name AS category_name, u.username AS uploaded_by_name
         FROM documents d JOIN document_categories c ON c.id=d.category_id
         JOIN users u ON u.id=d.uploaded_by ORDER BY d.created_at DESC, d.id DESC'
    )->fetchAll();
}

function adminListCategories(): array
{
    return database()->query('SELECT id, slug, name FROM document_categories ORDER BY name')->fetchAll();
}

function adminListRequests(): array
{
    return database()->query(
        'SELECT f.*, u.username FROM format_requests f JOIN users u ON u.id=f.user_id ORDER BY f.created_at DESC, f.id DESC LIMIT 100'
    )->fetchAll();
}

function adminListMessages(): array
{
    return database()->query(
        'SELECT m.*, u.username FROM member_messages m JOIN users u ON u.id=m.user_id ORDER BY m.created_at DESC, m.id DESC LIMIT 100'
    )->fetchAll();
}

function adminListActivity(): array
{
    return database()->query(
        'SELECT a.*, u.username FROM admin_activity_log a JOIN users u ON u.id=a.admin_user_id ORDER BY a.created_at DESC, a.id DESC LIMIT 150'
    )->fetchAll();
}

function adminCreateUser(array $data): int
{
    $roles = in_array($data['role'], ['usuario', 'editor', 'administrador'], true) ? [$data['role']] : ['usuario'];
    if (!in_array('usuario', $roles, true)) $roles[] = 'usuario';
    return createUser($data['username'], $data['email'], $data['password'], $data['full_name'], $roles);
}

function adminSetUserStatus(int $userId, string $status, int $adminId): void
{
    if ($userId === $adminId) throw new DomainException('No puedes cambiar el estado de tu propia cuenta.');
    if (!in_array($status, ['activo', 'inactivo', 'bloqueado'], true)) throw new InvalidArgumentException('Estado no válido.');
    if ($status !== 'activo') {
        $check = database()->prepare("SELECT COUNT(*) FROM user_roles ur JOIN roles r ON r.id=ur.role_id WHERE ur.user_id=:id AND r.name='administrador'");
        $check->execute(['id'=>$userId]);
        if ((int) $check->fetchColumn() > 0) {
            $adminCount = (int) database()->query("SELECT COUNT(DISTINCT ur.user_id) FROM user_roles ur JOIN roles r ON r.id=ur.role_id JOIN users u ON u.id=ur.user_id WHERE r.name='administrador' AND u.status='activo'")->fetchColumn();
            if ($adminCount <= 1) throw new DomainException('Debe permanecer al menos un administrador activo.');
        }
    }
    $statement = database()->prepare('UPDATE users SET status=:status WHERE id=:id');
    $statement->execute(['status' => $status, 'id' => $userId]);
}

function adminUpdateUser(int $userId, string $email, string $fullName, string $role): void
{
    $email = mb_strtolower(trim($email), 'UTF-8');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new InvalidArgumentException('El correo no es válido.');
    if (!in_array($role, ['usuario', 'editor', 'administrador'], true)) throw new InvalidArgumentException('El rol no es válido.');
    $pdo = database();
    $currentRole = $pdo->prepare("SELECT COUNT(*) FROM user_roles ur JOIN roles r ON r.id=ur.role_id WHERE ur.user_id=:id AND r.name='administrador'");
    $currentRole->execute(['id'=>$userId]);
    if ((int) $currentRole->fetchColumn() > 0 && $role !== 'administrador') {
        $adminCount = (int) $pdo->query("SELECT COUNT(DISTINCT ur.user_id) FROM user_roles ur JOIN roles r ON r.id=ur.role_id JOIN users u ON u.id=ur.user_id WHERE r.name='administrador' AND u.status='activo'")->fetchColumn();
        if ($adminCount <= 1) throw new DomainException('Debe permanecer al menos un administrador activo.');
    }
    $pdo->beginTransaction();
    try {
        $statement = $pdo->prepare('UPDATE users SET email=:email, full_name=:full_name WHERE id=:id');
        $statement->execute(['email'=>$email, 'full_name'=>trim($fullName) ?: null, 'id'=>$userId]);
        $delete = $pdo->prepare("DELETE ur FROM user_roles ur JOIN roles r ON r.id=ur.role_id WHERE ur.user_id=:id AND r.name IN ('administrador','editor')");
        $delete->execute(['id'=>$userId]);
        if ($role !== 'usuario') {
            $assign = $pdo->prepare('INSERT IGNORE INTO user_roles (user_id, role_id) SELECT :id, id FROM roles WHERE name=:role');
            $assign->execute(['id'=>$userId, 'role'=>$role]);
        }
        $ensureUser = $pdo->prepare("INSERT IGNORE INTO user_roles (user_id, role_id) SELECT :id, id FROM roles WHERE name='usuario'");
        $ensureUser->execute(['id'=>$userId]);
        $pdo->commit();
    } catch (Throwable $exception) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        throw $exception;
    }
}

function adminResetPassword(int $userId, string $password): void
{
    if (mb_strlen($password, 'UTF-8') < 12) throw new InvalidArgumentException('La contraseña temporal debe tener al menos 12 caracteres.');
    $statement = database()->prepare('UPDATE users SET password_hash=:password_hash, must_change_password=1 WHERE id=:id');
    $statement->execute(['password_hash' => password_hash($password, PASSWORD_DEFAULT), 'id' => $userId]);
}

function adminChangeOwnPassword(int $userId, string $password): void
{
    if (mb_strlen($password, 'UTF-8') < 12) throw new InvalidArgumentException('La nueva contraseña debe tener al menos 12 caracteres.');
    $statement = database()->prepare('UPDATE users SET password_hash=:password_hash, must_change_password=0 WHERE id=:id');
    $statement->execute(['password_hash' => password_hash($password, PASSWORD_DEFAULT), 'id' => $userId]);
}
