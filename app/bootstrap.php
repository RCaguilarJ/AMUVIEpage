<?php
declare(strict_types=1);

$basePath ??= rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
if ($basePath === '.') {
    $basePath = '';
}

if (!defined('SITE_BASE_PATH')) {
    define('SITE_BASE_PATH', $basePath);
}

require_once __DIR__ . '/helpers.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'cookie_secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'use_strict_mode' => true,
    ]);
}

$config = require __DIR__ . '/config/site.php';
$requestedView = $vista ?? ($_GET['vista'] ?? $config['default_view']);
$titles = $config['titles'];

if (!is_string($requestedView) || !array_key_exists($requestedView, $titles)) {
    $requestedView = $config['default_view'];
}

$vista = $requestedView;
$pageTitle = $titles[$vista];
$constructionViews = $config['construction_views'] ?? [];
$isConstructionView = in_array($vista, $constructionViews, true);
$viewFile = $isConstructionView
    ? __DIR__ . '/views/pages/construction.php'
    : __DIR__ . "/views/pages/{$vista}.php";

if (!is_file($viewFile)) {
    throw new RuntimeException("No existe la vista registrada: {$vista}");
}

$loginError = null;
if ($vista === 'portal-amuvie' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    require_once __DIR__ . '/auth.php';

    $submittedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'] ?? '', $submittedToken)) {
        $loginError = 'La sesión del formulario expiró. Recarga la página e inténtalo nuevamente.';
    } else {
        $login = is_string($_POST['usuario'] ?? null) ? $_POST['usuario'] : '';
        $password = is_string($_POST['contrasena'] ?? null) ? $_POST['contrasena'] : '';

        try {
            $authenticatedUser = authenticateUser($login, $password);
            if ($authenticatedUser === null) {
                $loginError = 'Usuario, correo o contraseña incorrectos.';
            } else {
                loginUser($authenticatedUser);
                $statement = database()->prepare(
                    'UPDATE users SET last_login_at = NOW() WHERE id = :id'
                );
                $statement->execute(['id' => $authenticatedUser['id']]);
                header('Location: ' . ($_SERVER['REQUEST_URI'] ?? site_url('portal-amuvie/')));
                exit;
            }
        } catch (PDOException) {
            $loginError = 'No fue posible conectar con el portal. Inténtalo nuevamente más tarde.';
        }
    }
}

$_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));

require __DIR__ . '/views/layouts/site.php';
