<?php
declare(strict_types=1);

$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

$requestUri = $_SERVER['REQUEST_URI'];
$path = substr($requestUri, strlen($basePath));
$path = strtok($path, '?');
$path = trim($path, '/');

$segments = $path !== '' ? explode('/', $path) : [];
$vista = !empty($segments) ? end($segments) : 'inicio';

require __DIR__ . '/app/bootstrap.php';
