<main>
    <section class="hero" aria-label="Asamblea General AMUVIE 2026"></section>

    <section class="sponsors" aria-labelledby="sponsors-title">
        <h1 class="section-title" id="sponsors-title">Patrocinadores Oficiales</h1>
        <div class="sponsors__card">
            <img src="/AmuvePage/assets/images/logo-ance.png" alt="ANCE Estándares">
            <img src="/AmuvePage/assets/images/logo-ema.png" alt="Entidad Mexicana de Acreditación">
        </div>
    </section>

    <section class="about" aria-labelledby="about-title">
        <div class="about__content">
            <h2 class="about__title" id="about-title">¿Quienes somos?</h2>
            <p class="about__text">
                La AMUVIE nace el 27 de junio de 2014 y actualmente tiene presencia en 31 estados de la República Mexicana.
                Sus más de 250 asociados, históricamente, dan fe de la unión del gremio eléctrico, así como también de la
                búsqueda del mejoramiento en sus áreas de aplicación a través de la capacitación continua.
            </p>
            <div class="about__actions">
                <a class="about__button" href="#">
                    <i class="fas fa-user-tie" aria-hidden="true"></i> ¡Conócenos!
                </a>
                <a class="about__button about__button--video" href="#">
                    <i class="fas fa-video" aria-hidden="true"></i> Video Promocional
                </a>
            </div>
        </div>

        <nav class="about__socials" aria-label="Redes sociales">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </nav>
    </section>

    <section class="affiliate" id="afiliate" aria-labelledby="affiliate-title">
        <div class="affiliate__content">
            <h2 class="affiliate__title" id="affiliate-title">Forma Parte de AMUVIE</h2>
            <p class="affiliate__text">
                De parte de la Asociación Mexicana de Unidades de verificación, Inspección y Estandarización
                nos complace hacerles una cordial invitación a formar parte de nuestro equipo, dándose la
                oportunidad de conocer y aproximarse a varias de las actividades, servicios y beneficios que
                como entidad ofrecemos a nuestros socios.
            </p>
            <a class="affiliate__button" href="#contacto">¡Quiero Afiliarme!</a>
        </div>
    </section>

    <section class="contact" id="contacto" aria-label="Contacto">
        <div class="contact__layout">
            <aside class="social-feed" aria-label="Publicaciones de AMUVIE en Facebook">
                <nav class="social-feed__tabs" aria-label="Redes sociales">
                    <a class="social-feed__tab" href="https://www.facebook.com/amuviemx/" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-facebook-f" aria-hidden="true"></i>
                        <span>FACEBOOK</span>
                    </a>
                    <a class="social-feed__tab" href="#" aria-label="Twitter">
                        <i class="fab fa-twitter" aria-hidden="true"></i>
                        <span>TWITTER</span>
                    </a>
                </nav>
                <div class="social-feed__frame-wrap">
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
            </aside>

            <form class="contact-form" action="#" method="post">
                <h2 class="contact-form__title">
                    <i class="fas fa-envelope" aria-hidden="true"></i>Formulario de Contacto
                </h2>
                <div class="contact-form__row">
                    <label>Nombre Completo *
                        <input type="text" name="nombre" required>
                    </label>
                    <label>Correo Electrónico *
                        <input type="email" name="correo" required>
                    </label>
                </div>
                <label>Número Telefónico *
                    <input type="tel" name="telefono" required>
                </label>
                <label>Escribe tu Mensaje *
                    <textarea name="mensaje" required></textarea>
                </label>
                <button class="contact-form__submit" type="submit">Enviar mensaje</button>
            </form>
        </div>
    </section>
</main>
