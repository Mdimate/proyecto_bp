<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/index.css">
<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/buscar.css">

<div class="container is-fluid mb-6">
    <h1 class="title is-2" id="titulo2">Buscar Certificados</h1>
</div>

<div class="container pb-6 pt-6">
    <?php
    use app\controllers\vencimientoController;

    // Instanciar el controlador
    $insCertificado = new vencimientoController();

    if (!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])) {
    ?>
        <div class="columns is-centered">
            <div class="column is-8">
                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off">
                    <input type="hidden" name="modulo_buscador" value="buscar">
                    <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                    <div class="field has-addons">
                        <div class="control is-expanded">
                            <input class="input is-rounded" id="buscador" type="text" name="txt_buscador" placeholder="¿Qué estás buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" required>
                        </div>
                        <div class="control">
                            <button class="button is-info" type="submit">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } else { ?>
    <!-- Espacio adicional para separar de la tabla -->
            <div class="columns is-centered">
                <div class="column is-8">
                    <div class="is-flex is-justify-content-space-between is-align-items-center mb-4"> <!-- Espacio inferior para separación -->
                        <p class="subtitle">Estás buscando <strong>“<?php echo $_SESSION[$url[0]]; ?>”</strong></p>
                        <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off">
                            <input type="hidden" name="modulo_buscador" value="eliminar">
                            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                            <button type="submit" class="button is-danger is-rounded">Eliminar búsqueda</button>
                        </form>
                    </div>
                </div>
            </div>
    </div>

        <div class="mt-custom">
            <?php
            echo $insCertificado->listarCertificadoControlador($url[1], 15, $url[0], $_SESSION[$url[0]]);
            }
            ?>
        </div>
    </div>
