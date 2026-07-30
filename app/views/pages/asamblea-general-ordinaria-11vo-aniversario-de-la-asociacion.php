<?php
declare(strict_types=1);

$postIndex = 10;
$postTitle = 'Asamblea General Ordinaria & 11vo Aniversario de la Asociación';
$postEmailLayout = true;
$postImages = [
    [
        'src' => site_url('assets/images/blog-asamblea-aniversario-1.jpg'),
        'alt' => 'Invitación a la Asamblea General Ordinaria y 11vo aniversario de AMUVIE',
    ],
    [
        'src' => site_url('assets/images/blog-asamblea-aniversario-2.jpg'),
        'alt' => 'Información de hospedaje para la Asamblea General Ordinaria de AMUVIE',
    ],
];

require __DIR__ . '/../partials/blog-post-detail.php';
