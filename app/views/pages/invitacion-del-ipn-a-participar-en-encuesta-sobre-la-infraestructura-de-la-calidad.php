<?php
$postIndex = 5;
$postTitle = 'Invitación del IPN a participar en encuesta sobre la Infraestructura de la Calidad';
$postEmailLayout = true;
$surveyUrl = 'https://forms.gle/RrpKYGQj5kd5McKQ6';
$postImages = [
    [
        'src' => site_url('assets/images/blog-invitacion-ipn-encuesta.jpg'),
        'alt' => 'Oficio del Instituto Politécnico Nacional para responder una encuesta sobre infraestructura de la calidad',
        'href' => $surveyUrl,
    ],
    [
        'src' => site_url('assets/images/blog-invitacion-ipn-boton.png'),
        'alt' => 'Realizar encuesta',
        'href' => $surveyUrl,
        'class' => 'post-email__action',
    ],
];

require __DIR__ . '/../partials/blog-post-detail.php';
