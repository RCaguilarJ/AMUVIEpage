<main>
    <section class="inner-hero">
        <div>
            <h1>Consejo Directivo</h1>
            <p>Inicio / Consejo Directivo</p>
        </div>
    </section>

    <article class="inner-page council-page">
        <section class="council-grid" aria-label="Integrantes del Consejo Directivo">
            <article class="council-member">
                <img src="<?= htmlspecialchars(site_url('assets/images/consejo-luis.jpg'), ENT_QUOTES, 'UTF-8') ?>" alt="Luis Ignacio Olvera Ochoa">
                <h2>M. en C. Luis Ignacio Olvera Ochoa</h2><strong>Presidente</strong><small>Tepic, Nayarit.</small>
            </article>
            <article class="council-member">
                <img src="<?= htmlspecialchars(site_url('assets/images/consejo-ignacio.jpg'), ENT_QUOTES, 'UTF-8') ?>" alt="Ignacio Castañeda Mosqueda">
                <h2>Ing. Ignacio Castañeda Mosqueda</h2><strong>Vicepresidente</strong><small>Morelia, Michoacán.</small>
            </article>
            <article class="council-member">
                <img src="<?= htmlspecialchars(site_url('assets/images/consejo-carlos.jpg'), ENT_QUOTES, 'UTF-8') ?>" alt="Carlos Betancourt de León">
                <h2>Ing. Carlos Betancourt de León</h2><strong>Secretario</strong><small>Chihuahua, Chihuahua.</small>
            </article>
            <article class="council-member">
                <img src="<?= htmlspecialchars(site_url('assets/images/consejo-efraim.jpg'), ENT_QUOTES, 'UTF-8') ?>" alt="Efraim Castellanos Frayre">
                <h2>Ing. Efraim Castellanos Frayre</h2><strong>Tesorero</strong><small>Durango, Durango.</small>
            </article>
            <article class="council-member">
                <img src="<?= htmlspecialchars(site_url('assets/images/consejo-placeholder.png'), ENT_QUOTES, 'UTF-8') ?>" alt="">
                <h2>Ing. Ricardo Quijas González</h2><strong>Sub - secretario</strong><small>Guadalajara, Jalisco.</small>
            </article>
            <article class="council-member">
                <img src="<?= htmlspecialchars(site_url('assets/images/consejo-daniel.jpeg'), ENT_QUOTES, 'UTF-8') ?>" alt="Daniel Mauricio Reynada Ramos">
                <h2>Ing. Daniel Mauricio Reynada Ramos</h2><strong>Sub - tesorero</strong><small>CDMX.</small>
            </article>
        </section>

        <h2 class="regional-title">Vicepresidencias Regionales</h2>
        <?php
        $vicepresidencias = [
            ['JESÚS JOSÉ MENDIVIL ARGUELLES', 'Vicepresidente Baja California'],
            ['JOSÉ LUIS ARROYO', 'Vicepresidente Bajío'],
            ['RAFAEL GARCÍA MORENO', 'Vicepresidente Centro Occidente'],
            ['ROGELIO VÁZQUEZ PERALES', 'Vicepresidente Centro Oriente'],
            ['GILBERTO AVILA MORENO', 'Vicepresidente Centro Sur'],
            ['JOSÉ HUMBERTO GONZÁLEZ FIGUEROA', 'Vicepresidente Golfo Centro'],
            ['ELIUD EMMANUEL BENAVIDES MEDRANO', 'Vicepresidente Golfo Norte'],
            ['OCTAVIO GONZÁLEZ MEZA', 'Vicepresidente Jalisco'],
            ['ADRIÁN BENITO RUBÍ ROSALES', 'Vicepresidente Noroeste'],
            ['MONSERRATT ALBERTINA ÁVILA ELIZONDO', 'Vicepresidente Norte'],
            ['LAURA VENTURA FLORES', 'Vicepresidente Oriente'],
            ['RICARDO ALBERTO GONZÁLEZ LÓPEZ', 'Vicepresidente Sureste'],
            ['DANIEL MAURICIO REYNADA RAMOS', 'Vicepresidente Valle de México Centro'],
            ['MIGUEL MARTÍNEZ MARÍN', 'Vicepresidente Valle de México Norte'],
        ];
        ?>
        <section class="regional-grid" aria-label="Vicepresidencias regionales">
            <?php foreach ($vicepresidencias as [$nombre, $cargo]): ?>
                <article class="regional-member">
                    <i class="far fa-user-circle" aria-hidden="true"></i>
                    <h3><?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?></h3>
                    <strong><?= htmlspecialchars($cargo, ENT_QUOTES, 'UTF-8') ?></strong>
                </article>
            <?php endforeach; ?>
        </section>
    </article>
</main>
