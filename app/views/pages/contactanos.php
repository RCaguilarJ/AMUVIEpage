<main>
    <section class="inner-hero">
        <div>
            <h1>Formulario de Contacto</h1>
            <p>Inicio / Contacto</p>
        </div>
    </section>

    <section class="contact-page" aria-label="Formulario de contacto">
        <div class="contact-card">
            <img
                class="contact-card__banner"
                src="/AmuvePage/assets/images/banner-contacto.jpg"
                alt="Contáctenos, estamos para servirle"
            >

            <form class="contact-card__form" method="post" data-contact-form>
                <label class="contact-card__field">
                    <span>Nombre Completo <span class="contact-card__required">*</span></span>
                    <input type="text" name="nombre" autocomplete="name" required>
                </label>

                <label class="contact-card__field">
                    <span>Correo Electrónico <span class="contact-card__required">*</span></span>
                    <input type="email" name="correo" autocomplete="email" required>
                </label>

                <label class="contact-card__field">
                    <span>Número Telefónico <span class="contact-card__required">*</span></span>
                    <input
                        type="tel"
                        name="telefono"
                        autocomplete="tel"
                        inputmode="tel"
                        pattern="[+()0-9 .-]{8,20}"
                        required
                    >
                </label>

                <label class="contact-card__field">
                    <span>Escribe tu Mensaje <span class="contact-card__required">*</span></span>
                    <textarea name="mensaje" minlength="10" required></textarea>
                </label>

                <label class="contact-card__verification">
                    <input type="checkbox" name="verificacion" required>
                    <span>Soy humano</span>
                    <span class="contact-card__verification-mark" aria-hidden="true">
                        <i class="fas fa-shield-alt"></i>
                        Verificación<br>local
                    </span>
                </label>

                <button class="contact-card__submit" type="submit">Enviar mensaje</button>
                <p class="contact-card__status" role="status" aria-live="polite" data-contact-status></p>
            </form>
        </div>
    </section>
</main>
