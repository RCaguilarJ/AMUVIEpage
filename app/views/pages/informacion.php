<?php
$informationDocuments = require dirname(__DIR__, 2) . '/data/information-documents.php';
?>
<main>
    <section class="inner-hero">
        <div>
            <h1>Información</h1>
            <p>Inicio / Servicios Educativos</p>
        </div>
    </section>

    <section class="information-page" aria-labelledby="information-title">
        <h2 id="information-title">Comentarios NOM</h2>

        <ul class="information-documents">
            <?php foreach ($informationDocuments as $document): ?>
                <li>
                    <a
                        href="/AmuvePage/assets/documents/informacion/<?= rawurlencode($document['file']) ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <i class="fas fa-file-pdf" aria-hidden="true"></i>
                        <span>
                            <strong><?= htmlspecialchars($document['code'], ENT_QUOTES, 'UTF-8') ?></strong>
                            <span aria-hidden="true"> | </span>
                            <?= htmlspecialchars($document['title'], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>
