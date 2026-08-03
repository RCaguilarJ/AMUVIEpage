<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$files = require dirname(__DIR__) . '/app/data/nom-document-files.php';
$destination = dirname(__DIR__) . '/assets/documents/comentarios-nom';
$sourceBase = 'https://www.amuvie.mx/images/';
$allowedExtensions = ['doc', 'docx', 'pdf', 'xls', 'xlsx'];

if (!is_dir($destination) && !mkdir($destination, 0755, true) && !is_dir($destination)) {
    fwrite(STDERR, "No fue posible crear {$destination}.\n");
    exit(1);
}

$downloaded = 0;
$existing = 0;
$failed = [];

foreach ($files as $file) {
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions, true) || basename($file) !== $file) {
        $failed[] = "Nombre no permitido: {$file}";
        continue;
    }

    $target = $destination . '/' . $file;
    if (is_file($target) && filesize($target) > 0) {
        $existing++;
        continue;
    }

    $temporary = $target . '.part';
    $stream = @fopen($sourceBase . rawurlencode($file), 'rb');
    if ($stream === false) {
        $failed[] = "No disponible: {$file}";
        continue;
    }

    $output = @fopen($temporary, 'wb');
    if ($output === false || stream_copy_to_stream($stream, $output) === false) {
        if (is_resource($output)) fclose($output);
        fclose($stream);
        @unlink($temporary);
        $failed[] = "No se pudo guardar: {$file}";
        continue;
    }
    fclose($output);
    fclose($stream);

    if (!is_file($temporary) || filesize($temporary) < 100) {
        @unlink($temporary);
        $failed[] = "Respuesta vacía: {$file}";
        continue;
    }

    $signature = file_get_contents($temporary, false, null, 0, 4);
    $validSignature = $extension === 'pdf'
        ? $signature === '%PDF'
        : str_starts_with((string) $signature, "PK");
    if (!$validSignature) {
        @unlink($temporary);
        $failed[] = "Contenido inesperado: {$file}";
        continue;
    }

    if (!rename($temporary, $target)) {
        @unlink($temporary);
        $failed[] = "No se pudo finalizar: {$file}";
        continue;
    }
    $downloaded++;
    fwrite(STDOUT, "Descargado: {$file}\n");
}

fwrite(STDOUT, "\nDescargados: {$downloaded}; existentes: {$existing}; fallidos: " . count($failed) . ".\n");
foreach ($failed as $error) fwrite(STDERR, "- {$error}\n");
exit($failed === [] ? 0 : 1);
