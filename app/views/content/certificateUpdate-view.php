<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/modificar.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<div class="container is-fluid mb-6">
<?php
    use app\controllers\certificateController;

    // Crear una instancia del controlador
    $insCertificado = new certificateController();

    // Limpiar el valor de $url[1] usando el método limpiarCadena()
    if(isset($url[1])) {
        $id = $insCertificado->limpiarCadena($url[1]);
    } else {
        echo "Error: ID no proporcionado en la URL";
        exit();
    }

    // Obtener los datos del certificado
    $datos = $insCertificado->seleccionarDatos("Unico", "certificados", "id", $id);

    if($datos->rowCount() == 1) {
        $datos = $datos->fetch();
    } else {
        echo "Error: Certificado no encontrado";
        exit();
    }
?>
    <h1 class="title" id="titulo">Certificados</h1>
    <h2 class="subtitle" id="subtitulo">Actualizar Certificado</h2>
</div>

<div class="container py-6">
    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/certificadoAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="modulo_certificado" value="actualizar">
        <input type="hidden" name="id" value="<?php echo $datos['id']; ?>"> <!-- Este se mostrará ahora solo si $datos está definido -->

        <?php include "./app/views/inc/btn_back.php"; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="certificado_nombre">Nombre Certificado</label>
                    <input type="text" class="form-control" id="certificado_nombre" name="certificado_nombre" value="<?php echo $datos['nombre']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="certificado_fecha">Fecha vencimiento</label>
                    <input type="date" class="form-control" id="certificado_fecha" name="certificado_fecha" value="<?php echo $datos['fecha_vencimiento']; ?>" required>
                    <small class="form-text text-muted">Formato: dd/mm/aaaa</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="certificado_grupo">Grupo</label>
                    <input type="text" class="form-control" id="certificado_grupo" name="certificado_grupo" value="<?php echo $datos['grupo']; ?>" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="certificado_correo">Correo Alertamiento</label>
                    <input type="email" class="form-control" id="certificado_correo" name="certificado_correo" value="<?php echo $datos['correo_alertamiento']; ?>" maxlength="70" required>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
