<?php
$associates = require dirname(__DIR__, 2) . '/data/associates.php';
?>
<main>
    <section class="inner-hero">
        <div>
            <h1>Asociados</h1>
            <p>Inicio / Asociados</p>
        </div>
    </section>

    <article class="associates-page">
        <p class="associates-page__notice">
            *** Si deseas visualizar la información de contacto de nuestros asociados
            <a href="<?= htmlspecialchars(site_url('portal-amuvie/'), ENT_QUOTES, 'UTF-8') ?>">inicia sesión con tu cuenta.</a>
        </p>

        <div class="associates-toolbar">
            <label for="associates-search">Buscar:</label>
            <input
                id="associates-search"
                type="search"
                placeholder="Nombre o correo"
                autocomplete="off"
                data-associates-search
            >
        </div>

        <p class="associates-results" data-associates-results aria-live="polite">
            <?= count($associates) ?> asociados
        </p>

        <div class="associates-table-wrap">
            <table class="associates-table">
                <thead>
                    <tr>
                        <th scope="col">Nombre Unidad de Verificación</th>
                        <th scope="col">Correo</th>
                    </tr>
                </thead>
                <tbody data-associates-body>
                    <?php foreach ($associates as $associate): ?>
                        <tr data-associate-row>
                            <td data-label="Nombre Unidad de Verificación">
                                <?= htmlspecialchars($associate['name'], ENT_QUOTES, 'UTF-8') ?>
                            </td>
                            <td data-label="Correo">
                                <?= htmlspecialchars($associate['email'], ENT_QUOTES, 'UTF-8') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="associates-table__empty" data-associates-empty hidden>
                        <td colspan="2">No se encontraron asociados con ese criterio.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </article>
</main>
