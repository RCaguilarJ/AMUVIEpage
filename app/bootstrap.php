<?php
declare(strict_types=1);

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

require __DIR__ . '/views/layouts/site.php';
