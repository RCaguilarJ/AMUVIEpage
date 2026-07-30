<main>
    <section class="inner-hero">
        <div>
            <h1>Formatos de Portada</h1>
            <p>Inicio / Formatos de Portada</p>
        </div>
    </section>

    <article class="inner-page cover-page">
        <section class="cover-page__intro">
            <div>
                <h2>Formulario de Solicitud</h2>
                <h3>Los costos de los Formatos de Portadas (No Asociados) tienen un costo de:</h3>
                <ul class="cover-costs">
                    <li>Formato digital $17.50</li>
                    <li>Con envío $ 23.50</li>
                </ul>
            </div>
            <aside class="member-login">
                <h3>¿Ya eres socio?</h3>
                <img src="/AmuvePage/assets/images/member-icon.png" alt="">
                <a href="/AmuvePage/portal-amuvie/">Inicia Sesión en tu cuenta para agilizar tu solicitud</a>
            </aside>
        </section>

        <form class="cover-form" action="#" method="post" enctype="multipart/form-data">
            <h2 class="cover-form__title">Datos de la Unidad de Verificación</h2>
            <div class="cover-form__grid">
                <label>Nombre
                    <input type="text" name="nombre">
                </label>
                <fieldset>
                    <legend>Selecciona una opción</legend>
                    <div class="cover-radio">
                        <label><input type="radio" name="entrega" value="digital"> Digital</label>
                        <label><input type="radio" name="entrega" value="envio"> Con envío</label>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>¿Requiere Factura?</legend>
                    <div class="cover-radio">
                        <label><input type="radio" name="factura" value="si"> Sí</label>
                        <label><input type="radio" name="factura" value="no"> No</label>
                    </div>
                </fieldset>
            </div>

            <div class="cover-upload">
                <label for="comprobante">Adjunte su Comprobante de Pago y su Aprobación Vigente *</label>
                <label class="cover-upload__box" for="comprobante">
                    <i class="fas fa-upload" aria-hidden="true"></i>
                    <span>Suelta un archivo aquí o haz clic para subir</span>
                    <small>Maximum file size: 83.89MB</small>
                </label>
                <input id="comprobante" type="file" name="comprobante">
            </div>

            <p class="cover-help">
                Si tiene alguna duda o comentario por favor envíenos un correo electrónico a
                <strong>admin@amuvie.mx</strong> o bien a los teléfono<br>
                (311)456-7347 Cel. 332 5287 852
            </p>

            <div class="cover-notes">
                <p>NOTAS:</p>
                <p>* Solo se atenderán las Solicitudes de las Unidades de Verificación con aprobación vigente publicadas en el Padrón de Verificadores de SENER y CONUEE. En caso contrario, deberán enviar el Oficio mediante el cual les fue notificada su aprobación como Unidad de Verificación.</p>
                <p>* La Solicitud se deberá llenar mediante el formulario web con todos los campos requeridos.</p>
                <p>* El importe total de la Solicitud deberá depositarse o efectuarse una transferencia bancaria a la siguiente cuenta: Banamex, Sucursal: 7007 Cuenta: 8980212, CLABE Interbancaria: 0026 9070 0789 8021 27 a nombre de AMUVIE A.C.</p>
                <p>* La Solicitud deberá ser llenada y debe de adjuntar una copia de la ficha de depósito o transferencia bancaria y una copia de su aprobación vigente al correo: admin@amuvie.mx</p>
                <p>* En caso de requerir alguna aclaración o información adicional, le agradecemos comunicarse a los teléfonos: (311)456-7347, Whatsapp 378-105-64-26 o al correo: admin@amuvie.mx</p>
            </div>

            <div class="cover-total">
                <h3>Total a Pagar</h3>
                <strong>$0.00</strong>
            </div>

            <button class="cover-submit" type="submit">Enviar Solicitud</button>
        </form>
    </article>
</main>
