<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/agregar.css">
<div class="container is-fluid mb-6">
    <h1 class="title">Certificados</h1>
    <h2 class="subtitle">Agregar Certificado</h2>
</div>

<div class="container pb-6 pt-6">

    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/certificadoAjax.php" method="POST" autocomplete="off">

        <input type="hidden" name="modulo_certificado" value="registrar">

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre del Certificado</label>
                    <input class="input" type="text" name="certificado_nombre" id="nombreCertificado" placeholder="Nombre del Certificado" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Fecha de Vencimiento</label>
                    <input class="input" type="date" name="certificado_fecha" id="fechaVencimiento" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Grupo</label>
                    <input class="input" type="text" name="certificado_grupo" id="grupo" placeholder="Grupo" pattern="[a-zA-Z0-9 ]{3,40}" maxlength="40" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Correo de Alertamiento</label>
                    <input class="input" type="email" name="certificado_correo" id="correoAlertamiento" placeholder="ejemplo@correo.com" maxlength="70" required>
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
            <button type="submit" class="button is-info is-rounded">Agregar Certificado</button>
        </p>

    </form>
</div>
<script>
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita el envío del formulario automáticamente

            if (this.checkValidity()) {
                // Si todos los campos son válidos, procede con la validación personalizada
                // Aquí puedes agregar validaciones adicionales
                console.log("Formulario válido. Proceder con el envío.");

                // Si quieres enviar el formulario después de la validación:
                this.submit();
            } else {
                // Si algún campo no es válido, puedes mostrar un mensaje personalizado o manejarlo como desees
                console.log("Formulario no válido. Maneja la validación aquí.");
            }
        });
    </script>