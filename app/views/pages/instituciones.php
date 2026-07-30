<?php
$institutions = [
    [
        'name' => 'ANCE',
        'image' => 'institucion-ance.png',
        'url' => 'https://www.ance.org.mx/',
    ],
    [
        'name' => 'Secretaría de Energía',
        'image' => 'institucion-sener.png',
        'url' => 'https://www.gob.mx/sener',
    ],
    [
        'name' => 'CANAME',
        'image' => 'institucion-caname.png',
        'url' => 'https://caname.org.mx/',
    ],
    [
        'name' => 'Comisión Federal de Electricidad',
        'image' => 'institucion-cfe.png',
        'url' => 'https://www.cfe.mx/',
    ],
    [
        'name' => 'CONUEE',
        'image' => 'institucion-conuee.png',
        'url' => 'https://www.gob.mx/conuee',
    ],
    [
        'name' => 'Comisión Reguladora de Energía',
        'image' => 'institucion-cre.jpg',
        'url' => 'https://www.gob.mx/cre',
    ],
    [
        'name' => 'Entidad Mexicana de Acreditación',
        'image' => 'institucion-ema.png',
        'url' => 'https://www.ema.org.mx/',
    ],
    [
        'name' => 'FECIME',
        'image' => 'institucion-fecime.png',
        'url' => 'http://www.fecime.com/',
    ],
    [
        'name' => 'UNCE',
        'image' => 'institucion-unce.png',
        'url' => 'https://unce.org.mx/',
    ],
];
?>
<main>
    <section class="inner-hero">
        <div>
            <h1>Instituciones</h1>
            <p>Inicio / Instituciones</p>
        </div>
    </section>

    <section class="institutions-page" aria-label="Instituciones relacionadas con AMUVIE">
        <div class="institutions-grid">
            <?php foreach ($institutions as $institution): ?>
                <a
                    class="institution-link"
                    href="<?= htmlspecialchars($institution['url'], ENT_QUOTES, 'UTF-8') ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Visitar el sitio de <?= htmlspecialchars($institution['name'], ENT_QUOTES, 'UTF-8') ?>"
                >
                    <img
                        src="/AmuvePage/assets/images/<?= htmlspecialchars($institution['image'], ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($institution['name'], ENT_QUOTES, 'UTF-8') ?>"
                        loading="lazy"
                    >
                </a>
            <?php endforeach; ?>
        </div>
    </section>
</main>
