<?php
declare(strict_types=1);

/**
 * Compatibilidad con la URL antigua /inicio.php.
 */
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
if ($basePath === '.') {
    $basePath = '';
}
define('SITE_BASE_PATH', $basePath);
require_once __DIR__ . '/app/helpers.php';

$config = require __DIR__ . '/app/config/site.php';
$requestedView = $_GET['vista'] ?? $config['default_view'];

if (!is_string($requestedView) || !array_key_exists($requestedView, $config['titles'])) {
    $requestedView = $config['default_view'];
}

$nestedRoutes = [
    'eventos' => site_url('comunicacion/eventos/'),
    'memoria-de-eventos' => site_url('comunicacion/memoria-de-eventos/'),
    'boletines' => site_url('comunicacion/boletines/'),
];

$destination = $nestedRoutes[$requestedView] ?? site_url("{$requestedView}/");

header('Location: ' . $destination, true, 301);
exit;
