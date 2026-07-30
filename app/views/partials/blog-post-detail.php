<?php
$posts = require dirname(__DIR__, 2) . '/data/blog-posts.php';
$latestPosts = array_slice($posts, 0, 10);
$newerPost = $postIndex > 0 ? $posts[$postIndex - 1] : null;
$olderPost = $posts[$postIndex + 1] ?? null;
$postUrl = static fn (array $post): string => $post['local_url'] ?? $post['source_url'];
$postIsLocal = static fn (array $post): bool => isset($post['local_url']);
?>
<main>
    <section class="post-hero">
        <div class="post-hero__inner">
            <h1><?= htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8') ?></h1>

            <?php if ($olderPost): ?>
                <a
                    class="post-hero__navigation post-hero__navigation--previous"
                    href="<?= htmlspecialchars($postUrl($olderPost), ENT_QUOTES, 'UTF-8') ?>"
                    <?= $postIsLocal($olderPost) ? '' : 'target="_blank" rel="noopener noreferrer"' ?>
                >
                    <i class="fas fa-chevron-left" aria-hidden="true"></i>
                    <span>
                        <strong>Anterior</strong>
                        <?= htmlspecialchars($olderPost['title'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </a>
            <?php endif; ?>

            <?php if ($newerPost): ?>
                <a
                    class="post-hero__navigation post-hero__navigation--next"
                    href="<?= htmlspecialchars($postUrl($newerPost), ENT_QUOTES, 'UTF-8') ?>"
                    <?= $postIsLocal($newerPost) ? '' : 'target="_blank" rel="noopener noreferrer"' ?>
                >
                    <span>
                        <strong>Siguiente</strong>
                        <?= htmlspecialchars($newerPost['title'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                </a>
            <?php endif; ?>
        </div>
    </section>

    <article class="post-page">
        <div class="post-page__content">
            <h2><?= htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8') ?></h2>

            <?php if (!empty($postEmailLayout)): ?>
                <div class="post-email">
                    <div class="post-email__contact">
                        <a href="mailto:admin@amuvie.mx">admin@amuvie.mx</a>
                        | Teléfono: 332 5287 852 | WhatsApp 33 2528 7852
                    </div>
                    <div class="post-email__logo">
                        <img src="/AmuvePage/assets/images/logo-amuvie.png" alt="AMUVIE A.C.">
                    </div>
                    <div class="post-email__body">
                        <?php if (!empty($postEmailContent)): ?>
                            <div class="post-email__copy">
                                <?= $postEmailContent ?>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($postImages as $position => $image): ?>
                            <?php if (!empty($image['href'])): ?>
                                <a
                                    class="<?= htmlspecialchars($image['class'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                    href="<?= htmlspecialchars($image['href'], ENT_QUOTES, 'UTF-8') ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <img
                                        src="<?= htmlspecialchars($image['src'], ENT_QUOTES, 'UTF-8') ?>"
                                        alt="<?= htmlspecialchars($image['alt'], ENT_QUOTES, 'UTF-8') ?>"
                                        <?= $position === 0 ? '' : 'loading="lazy"' ?>
                                    >
                                    <?php if (!empty($image['caption'])): ?>
                                        <span><?= htmlspecialchars($image['caption'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php else: ?>
                                <img
                                    src="<?= htmlspecialchars($image['src'], ENT_QUOTES, 'UTF-8') ?>"
                                    alt="<?= htmlspecialchars($image['alt'], ENT_QUOTES, 'UTF-8') ?>"
                                    <?= $position === 0 ? '' : 'loading="lazy"' ?>
                                >
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="post-email__footer">
                        <div>
                            <a href="https://www.facebook.com/amuviemx" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://x.com/amuvieac" aria-label="X"><span aria-hidden="true">X</span></a>
                            <a href="https://www.youtube.com/" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        </div>
                        <p>
                            Copyright 2024 ® Asociación Mexicana de Unidades de Verificación, Inspección y Estandarización AC<br>
                            <a href="/AmuvePage/aviso-de-privacidad/">Aviso de Privacidad</a> |
                            <a href="#">Darme de Baja</a>
                        </p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($postImages as $position => $image): ?>
                    <img
                        src="<?= htmlspecialchars($image['src'], ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($image['alt'], ENT_QUOTES, 'UTF-8') ?>"
                        <?= $position === 0 ? '' : 'loading="lazy"' ?>
                    >
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="post-share" aria-label="Compartir esta publicación">
                <strong>Compartir esta Publicación:</strong>
                <div>
                    <a href="#" aria-label="Compartir en Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Compartir en Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Compartir en LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="Compartir en Telegram"><i class="fab fa-telegram-plane"></i></a>
                    <a href="#" aria-label="Compartir en WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" aria-label="Compartir por correo"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>

        <aside class="post-sidebar">
            <section class="latest-posts">
                <h2><i class="fas fa-file-signature" aria-hidden="true"></i> Últimos Boletines</h2>
                <ul>
                    <?php foreach ($latestPosts as $post): ?>
                        <li>
                            <a
                                href="<?= htmlspecialchars($postUrl($post), ENT_QUOTES, 'UTF-8') ?>"
                                <?= $postIsLocal($post) ? '' : 'target="_blank" rel="noopener noreferrer"' ?>
                            >
                                <?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <section class="post-facebook" aria-label="Publicaciones de AMUVIE en Facebook">
                <a
                    class="post-facebook__heading"
                    href="https://www.facebook.com/amuviemx/"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <i class="fab fa-facebook-f" aria-hidden="true"></i>
                    <span>Facebook</span>
                </a>
                <div class="post-facebook__frame">
                    <iframe
                        src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Famuviemx%2F&amp;tabs=timeline&amp;width=300&amp;height=555&amp;small_header=false&amp;adapt_container_width=true&amp;hide_cover=false&amp;show_facepile=true"
                        title="Publicaciones recientes de AMUVIE A.C. en Facebook"
                        width="300"
                        height="555"
                        scrolling="no"
                        frameborder="0"
                        allowfullscreen="true"
                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                        loading="lazy"
                    ></iframe>
                </div>
            </section>
        </aside>
    </article>
</main>
