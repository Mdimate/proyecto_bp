<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/agregar.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<div class="container is-fluid mb-6">
    <h1 class="title" id="titulo">Certificados</h1>
    <h2 class="subtitle" id="subtitulo">Nuevo Certificado</h2>
</div>

<div class="container py-6">
    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/certificadoAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="modulo_certificado" value="registrar">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="certificado_nombre">Nombre Certificado</label>
                    <input type="text" class="form-control" id="certificado_nombre" name="certificado_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="certificado_fecha">Fecha vencimiento</label>
                    <input type="date" class="form-control" id="certificado_fecha" name="certificado_fecha" required>
                    <small class="form-text text-muted">Formato: dd/mm/aaaa</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="certificado_grupo">Grupo</label>
                    <input type="text" class="form-control" id="certificado_grupo" name="certificado_grupo" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="certificado_correo">Correo Alertamiento</label>
                    <input type="email" class="form-control" id="certificado_correo" name="certificado_correo" maxlength="70" required>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="reset" class="btn btn-secondary">Limpiar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>