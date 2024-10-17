<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/index.css">
<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/agregar.css">
<div class="container is-fluid mb-6">
    <h1 class="title" id="titulo">Certificados</h1>
    <h2 class="subtitle" id="subtitulo">Nuevo Certificado</h2>
</div>

<div class="container py-6">
    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/vencimientoAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="modulo_certificado" value="registrar">

        <div class="form-group">
            <label for="aplicacion">Aplicacion</label>
            <input type="text" class="form-control" id="aplicacion" name="aplicacion" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" required>
        </div>

        <div class="form-group">
            <label for="fecha_vencimiento">Fecha Vencimiento</label>
            <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
            <small class="form-text text-muted">Formato: dd/mm/aaaa</small>
        </div>

        <div class="form-group">
            <label for="correo_alertamiento">Correo Alertamiento</label>
            <input type="email" class="form-control" id="correo_alertamiento" name="correo_alertamiento" maxlength="70" required>
        </div>

        <div class="form-group">
            <label for="numero_serial">Número Serial</label>
            <input type="text" class="form-control" id="numero_serial" name="numero_serial" min="1" required>
        </div>

        <div class="form-group">
            <label for="fecha_emision">Fecha Emision</label>
            <input type="date" class="form-control" id="fecha_emision" name="fecha_emision">
        </div>

        <div class="form-group">
            <label for="area_responsable">Área Responsable</label>
            <input type="text" class="form-control" id="area_responsable" name="area_responsable" maxlength="200" required>
        </div>

        <div class="form-group">
            <label for="objetivo">Objetivo</label>
            <textarea class="form-control" id="objetivo" name="objetivo" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="url_servicio">URL Servicio</label>
            <input type="url" class="form-control" id="url_servicio" name="url_servicio" maxlength="1000" required>
        </div>

        <div class="form-group">
            <label for="puerto">Puerto</label>
            <input type="number" class="form-control" id="puerto" name="puerto" min="1" required>
        </div>

        <div class="form-group">
            <label for="ip_servidor">IP Servidor</label>
            <input type="text" class="form-control" id="ip_servidor" name="ip_servidor" maxlength="1000" required>
        </div>

        <div class="form-group">
            <label for="servicio_afectado">Servicio Afectado</label>
            <input type="text" class="form-control" id="servicio_afectado" name="servicio_afectado" maxlength="1000" required>
        </div>

        <div class="form-group">
            <label for="sistema_operativo">Sistema Operativo</label>
            <input type="text" class="form-control" id="sistema_operativo" name="sistema_operativo" maxlength="1000" required>
        </div>

        <div class="form-group">
            <label for="llavero">Llavero</label>
            <input type="text" class="form-control" id="llavero" name="llavero" maxlength="10000" required>
        </div>

        <div class="form-group">
            <label for="ambiente">Ambiente</label>
            <input type="text" class="form-control" id="ambiente" name="ambiente" maxlength="1000" required>
        </div>

        <div class="form-group">
            <label for="lider_tecnico">Líder Técnico</label>
            <input type="text" class="form-control" id="lider_tecnico" name="lider_tecnico" maxlength="1000" required>
        </div>

        <div class="form-group">
            <label for="tipo_certificado">Tipo Certificado</label>
            <textarea class="form-control" id="tipo_certificado" name="tipo_certificado" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
        </div>

        <div class="text-center">
            <button type="reset" class="btn btn-secondary">Limpiar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
