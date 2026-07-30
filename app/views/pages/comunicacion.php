<?php
$posts = require dirname(__DIR__, 2) . '/data/blog-posts.php';
$months = [
    '01' => 'enero',
    '02' => 'febrero',
    '03' => 'marzo',
    '04' => 'abril',
    '05' => 'mayo',
    '06' => 'junio',
    '07' => 'julio',
    '08' => 'agosto',
    '09' => 'septiembre',
    '10' => 'octubre',
    '11' => 'noviembre',
    '12' => 'diciembre',
];
?>
<main>
    <section class="inner-hero">
        <div>
            <h1>Comunicación</h1>
            <p>Inicio / Comunicación</p>
        </div>
    </section>

    <article class="blog-page">
        <header class="blog-page__header">
            <h2>Notas y publicaciones</h2>
            <p>Consulta las noticias, actividades y comunicados más recientes de AMUVIE.</p>
        </header>

        <div class="blog-list" aria-label="Publicaciones de AMUVIE">
            <?php foreach ($posts as $post): ?>
                <?php
                [$year, $month, $day] = explode('-', $post['published_at']);
                $publishedLabel = (int) $day . ' de ' . $months[$month] . ', ' . $year;
                $postUrl = $post['local_url'] ?? $post['source_url'];
                $isLocalPost = isset($post['local_url']);
                ?>
                <article class="blog-card" data-post-id="<?= (int) $post['id'] ?>">
                    <a
                        class="blog-card__media"
                        href="<?= htmlspecialchars($postUrl, ENT_QUOTES, 'UTF-8') ?>"
                        <?= $isLocalPost ? '' : 'target="_blank" rel="noopener noreferrer"' ?>
                        aria-label="Leer <?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>"
                    >
                        <i class="far fa-newspaper" aria-hidden="true"></i>
                        <?php if ($post['thumbnail']): ?>
                            <img
                                src="<?= htmlspecialchars($post['thumbnail'], ENT_QUOTES, 'UTF-8') ?>"
                                alt=""
                                loading="lazy"
                                referrerpolicy="no-referrer"
                            >
                        <?php endif; ?>
                    </a>

                    <div class="blog-card__content">
                        <time datetime="<?= htmlspecialchars($post['published_at'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($publishedLabel, ENT_QUOTES, 'UTF-8') ?>
                        </time>
                        <h3>
                            <a
                                href="<?= htmlspecialchars($postUrl, ENT_QUOTES, 'UTF-8') ?>"
                                <?= $isLocalPost ? '' : 'target="_blank" rel="noopener noreferrer"' ?>
                            >
                                <?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </h3>
                        <p>
                            <?= htmlspecialchars(
                                $post['excerpt'] ?: 'Consulta la información completa de esta publicación.',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </p>
                        <a
                            class="blog-card__link"
                            href="<?= htmlspecialchars($postUrl, ENT_QUOTES, 'UTF-8') ?>"
                            <?= $isLocalPost ? '' : 'target="_blank" rel="noopener noreferrer"' ?>
                        >
                            Leer nota <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </article>
</main>
