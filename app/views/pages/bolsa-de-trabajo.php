<main>
    <section class="inner-hero">
        <div>
            <h1>Bolsa de Trabajo</h1>
            <p>Inicio / Bolsa de Trabajo</p>
        </div>
    </section>

    <article class="jobs-page">
        <h2 class="jobs-page__heading">¿Estas interesado en trabajar en AMUVIE?</h2>
        <p class="jobs-page__intro">Envíanos tu información y con gusto te contactaremos para platicar contigo sobre una vacante libre en la Asociación</p>

        <form class="jobs-form" action="#" method="post" enctype="multipart/form-data">
            <label>
                Nombre Completo
                <input type="text" name="nombre" placeholder="Nombre Completo" autocomplete="name" required>
            </label>

            <label>
                Correo Electrónico
                <input type="email" name="correo" placeholder="Correo Electrónico" autocomplete="email" required>
            </label>

            <label>
                Numero Telefónico
                <input type="tel" name="telefono" placeholder="Numero Telefónico" autocomplete="tel" required>
            </label>

            <label>
                Dirección
                <input type="text" name="direccion" placeholder="Dirección" autocomplete="street-address">
            </label>

            <div class="jobs-form__location">
                <label>
                    Estado:
                    <select name="estado" aria-label="Estado">
                        <option value=""></option>
                        <option>Aguascalientes</option>
                        <option>Baja California</option>
                        <option>Ciudad de México</option>
                        <option>Jalisco</option>
                        <option>Estado de México</option>
                        <option>Nayarit</option>
                        <option>Nuevo León</option>
                        <option>Querétaro</option>
                    </select>
                </label>
                <label>
                    Ciudad
                    <input type="text" name="ciudad" placeholder="Ciudad" autocomplete="address-level2">
                </label>
                <label>
                    Municipio
                    <input type="text" name="municipio" placeholder="Municipio" autocomplete="address-level3">
                </label>
            </div>

            <label>
                Nivel de Estudios
                <input type="text" name="estudios" placeholder="Nivel de Estudios">
            </label>

            <label>
                Adjunta tu CV (PDF)
                <input type="file" name="cv" accept=".pdf,application/pdf" required>
            </label>

            <label>
                ¿Porque te interesa laborar en AMUVIE?
                <textarea name="motivacion" placeholder="¿Porque te interesa laborar en AMUVIE?" required></textarea>
            </label>

            <button class="jobs-form__submit" type="submit">Enviar Información</button>
        </form>
    </article>
</main>
