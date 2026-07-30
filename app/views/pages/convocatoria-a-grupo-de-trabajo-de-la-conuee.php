<?php
declare(strict_types=1);

$postIndex = 14;
$postTitle = 'Convocatoria a Grupo de Trabajo de la CONUEE';
$postEmailLayout = true;
$postImages = [
    [
        'src' => '/AmuvePage/assets/images/blog-grupo-trabajo-conuee.jpg',
        'alt' => 'Convocatoria de AMUVIE a grupo de trabajo de la CONUEE',
    ],
    [
        'src' => '/AmuvePage/assets/images/icono-documento-word.png',
        'alt' => 'Descargar documento de la convocatoria',
        'href' => '/AmuvePage/assets/documents/convocatoria-grupo-trabajo-conuee.docx',
        'class' => 'post-email__download',
        'caption' => 'Descargar Documento',
    ],
];

require __DIR__ . '/../partials/blog-post-detail.php';
