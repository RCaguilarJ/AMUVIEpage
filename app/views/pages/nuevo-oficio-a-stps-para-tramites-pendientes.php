<?php
declare(strict_types=1);

$postIndex = 19;
$postTitle = 'Nuevo oficio a STPS para trámites pendientes';
$postEmailLayout = true;
$postEmailContent = <<<'HTML'
    <p>
        Estimados Asociados, nuevamente hemos tocado las puertas de la STPS
        para mediar sobre la problemática de trámites pendientes para aprobación
        y ampliaciones. Los invitamos a permanecer en unión.
    </p>
    <p>
        Y si aún no son parte de <strong>AMUVIE STPS</strong>, los invitamos a afiliarse ya.<br>
        Hagamos unidad.
    </p>
HTML;
$postImages = [
    [
        'src' => site_url('assets/images/icono-documento-pdf.png'),
        'alt' => 'Descargar nuevo oficio a STPS para trámites pendientes',
        'href' => site_url('assets/documents/oficio-tramites-pendientes-stps.pdf'),
        'class' => 'post-email__download',
    ],
];

require __DIR__ . '/../partials/blog-post-detail.php';
