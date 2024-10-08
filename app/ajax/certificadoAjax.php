<?php
    require_once "../../config/app.php";
    require_once "../views/inc/session_start.php";
    require_once "../../autoload.php";

    use app\controllers\certificateController;

    if (isset($_POST['modulo_certificado'])) {
        
        $insCertificado = new certificateController();

        if($_POST['modulo_certificado'] == "registrar"){
            echo $insCertificado->registrarCertificadoControlador();
        }
        if($_POST['modulo_certificado'] == "eliminar"){
            echo $insCertificado->eliminarCertificadoControlador();
        }
        if($_POST['modulo_certificado'] == "actualizar"){
            echo $insCertificado->actualizarCertificadoControlador();
        }
    } else {
        session_destroy();
        header("Location: ".APP_URL."login/");
    }
?>