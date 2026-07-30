<?php
declare(strict_types=1);

/**
 * Genera una URL interna válida tanto en la raíz del dominio como en una
 * instalación dentro de una subcarpeta (por ejemplo, /AmuvePage en local).
 */
function site_url(string $path = ''): string
{
    $basePath = defined('SITE_BASE_PATH') ? SITE_BASE_PATH : '';
    $normalizedPath = ltrim($path, '/');

    if ($normalizedPath === '') {
        return $basePath === '' ? '/' : $basePath . '/';
    }

    return ($basePath === '' ? '' : $basePath) . '/' . $normalizedPath;
}
