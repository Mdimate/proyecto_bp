<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Certificado</title>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/modificar.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/index.css">
</head>
<body>

<div class="container is-fluid mb-6">
    <?php
    use app\controllers\vencimientoController;

        // Crear una instancia del controlador
        $insCertificado = new vencimientoController();

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
    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/vencimientoAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="modulo_certificado" value="actualizar">
        <input type="hidden" name="id" value="<?php echo $datos['id']; ?>">

        <?php include "./app/views/inc/btn_back.php"; ?>

<div class="form-group">
    <label for="aplicacion">Aplicación</label>
    <input type="text" class="form-control" id="aplicacion" name="aplicacion" value="<?php echo isset($datos['aplicacion']) ? $datos['aplicacion'] : ''; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" required>
</div>

<div class="form-group">
    <label for="fecha_vencimiento">Fecha Vencimiento</label>
    <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo isset($datos['fecha_vencimiento']) ? $datos['fecha_vencimiento'] : ''; ?>" required>
    <small class="form-text text-muted">Formato: dd/mm/aaaa</small>
</div>

<div class="form-group">
    <label for="correo_alertamiento">Correo Alertamiento</label>
    <input type="email" class="form-control" id="correo_alertamiento" name="correo_alertamiento" value="<?php echo isset($datos['correo_alertamiento']) ? $datos['correo_alertamiento'] : ''; ?>" maxlength="70" required>
</div>

<div class="form-group">
    <label for="numero_serial">Número Serial</label>
    <input type="text" class="form-control" id="numero_serial" name="numero_serial" value="<?php echo isset($datos['numero_serial']) ? $datos['numero_serial'] : ''; ?>" min="1" required>
</div>

<div class="form-group">
    <label for="fecha_emision">Fecha Emisión</label>
    <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" value="<?php echo isset($datos['fecha_emision']) ? $datos['fecha_emision'] : ''; ?>">
</div>

<div class="form-group">
    <label for="area_responsable">Área Responsable</label>
    <input type="text" class="form-control" id="area_responsable" name="area_responsable" value="<?php echo isset($datos['area_responsable']) ? $datos['area_responsable'] : ''; ?>" maxlength="200" required>
</div>

<div class="form-group">
    <label for="objetivo">Objetivo</label>
    <textarea class="form-control" id="objetivo" name="objetivo" rows="3" required><?php echo isset($datos['objetivo']) ? $datos['objetivo'] : ''; ?></textarea>
</div>

<div class="form-group">
    <label for="url_servicio">URL Servicio</label>
    <input type="url" class="form-control" id="url_servicio" name="url_servicio" value="<?php echo isset($datos['url_servicio']) ? $datos['url_servicio'] : ''; ?>" maxlength="1000" required>
</div>

<div class="form-group">
    <label for="puerto">Puerto</label>
    <input type="number" class="form-control" id="puerto" name="puerto" value="<?php echo isset($datos['puerto']) ? $datos['puerto'] : ''; ?>" min="1" required>
</div>

<div class="form-group">
    <label for="ip_servidor">IP Servidor</label>
    <input type="text" class="form-control" id="ip_servidor" name="ip_servidor" value="<?php echo isset($datos['ip_servidor']) ? $datos['ip_servidor'] : ''; ?>" maxlength="1000" required>
</div>

<div class="form-group">
    <label for="servicio_afectado">Servicio Afectado</label>
    <input type="text" class="form-control" id="servicio_afectado" name="servicio_afectado" value="<?php echo isset($datos['servicio_afectado']) ? $datos['servicio_afectado'] : ''; ?>" maxlength="1000" required>
</div>

<div class="form-group">
    <label for="sistema_operativo">Sistema Operativo</label>
    <input type="text" class="form-control" id="sistema_operativo" name="sistema_operativo" value="<?php echo isset($datos['sistema_operativo']) ? $datos['sistema_operativo'] : ''; ?>" maxlength="1000" required>
</div>

<div class="form-group">
    <label for="llavero">Llavero</label>
    <input type="text" class="form-control" id="llavero" name="llavero" value="<?php echo isset($datos['llavero']) ? $datos['llavero'] : ''; ?>" maxlength="10000" required>
</div>

<div class="form-group">
    <label for="ambiente">Ambiente</label>
    <input type="text" class="form-control" id="ambiente" name="ambiente" value="<?php echo isset($datos['ambiente']) ? $datos['ambiente'] : ''; ?>" maxlength="1000" required>
</div>

<div class="form-group">
    <label for="lider_tecnico">Líder Técnico</label>
    <input type="text" class="form-control" id="lider_tecnico" name="lider_tecnico" value="<?php echo isset($datos['lider_tecnico']) ? $datos['lider_tecnico'] : ''; ?>" maxlength="1000" required>
</div>

<div class="form-group">
    <label for="tipo_certificado">Tipo Certificado</label>
    <textarea class="form-control" id="tipo_certificado" name="tipo_certificado" rows="3" required><?php echo isset($datos['tipo_certificado']) ? $datos['tipo_certificado'] : ''; ?></textarea>
</div>

<div class="form-group">
    <label for="observaciones">Observaciones</label>
    <textarea class="form-control" id="observaciones" name="observaciones" rows="3"><?php echo isset($datos['observaciones']) ? $datos['observaciones'] : ''; ?></textarea>
</div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>

</body>
</html>
