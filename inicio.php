<?php
declare(strict_types=1);

/**
 * Compatibilidad con la URL antigua /inicio.php.
 */
$config = require __DIR__ . '/app/config/site.php';
$requestedView = $_GET['vista'] ?? $config['default_view'];

if (!is_string($requestedView) || !array_key_exists($requestedView, $config['titles'])) {
    $requestedView = $config['default_view'];
}

$nestedRoutes = [
    'eventos' => '/AmuvePage/comunicacion/eventos/',
    'memoria-de-eventos' => '/AmuvePage/comunicacion/memoria-de-eventos/',
    'boletines' => '/AmuvePage/comunicacion/boletines/',
];

$destination = $nestedRoutes[$requestedView] ?? "/AmuvePage/{$requestedView}/";

header('Location: ' . $destination, true, 301);
exit;
