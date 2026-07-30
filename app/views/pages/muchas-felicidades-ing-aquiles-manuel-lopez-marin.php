<?php
declare(strict_types=1);

$postIndex = 17;
$postTitle = '¡Muchas felicidades Ing. Aquiles Manuel López Marin!';
$postEmailLayout = true;
$postImages = [
    [
        'src' => site_url('assets/images/blog-felicidades-aquiles-lopez-1.jpg'),
        'alt' => 'Felicitación al Ing. Aquiles Manuel López Marín como presidente de CANAME',
    ],
    [
        'src' => site_url('assets/images/blog-felicidades-aquiles-lopez-2.jpg'),
        'alt' => 'Participación de AMUVIE en la Asamblea CANAME 2025',
    ],
];

require __DIR__ . '/../partials/blog-post-detail.php';
