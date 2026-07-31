<main>
    <section class="inner-hero">
        <div>
            <h1>Formulario de Acceso</h1>
            <p>Inicio / Acceso</p>
        </div>
    </section>

    <section class="access-page" aria-label="Acceso al portal AMUVIE">
        <form class="access-card" method="post" data-access-form>
            <h2>Formulario de Acceso</h2>
            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>"
            >

            <label class="access-card__field">
                <span>Usuario</span>
                <input type="text" name="usuario" autocomplete="username" required>
            </label>

            <label class="access-card__field">
                <span>Contraseña</span>
                <span class="access-card__password">
                    <input
                        type="password"
                        name="contrasena"
                        autocomplete="current-password"
                        required
                        data-password-input
                    >
                    <button
                        type="button"
                        aria-label="Mostrar contraseña"
                        aria-pressed="false"
                        data-password-toggle
                    >
                        <i class="fas fa-eye" aria-hidden="true"></i>
                    </button>
                </span>
            </label>

            <button class="access-card__submit" type="submit">Acceder</button>
            <?php if ($loginError !== null): ?>
                <p class="access-card__status" role="alert">
                    <?= htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8') ?>
                </p>
            <?php endif; ?>
        </form>
    </section>
</main>
