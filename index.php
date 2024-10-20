<?php
require_once "./config/app.php";
require_once "./autoload.php";
require_once "./app/views/inc/session_start.php";

// Incluimos el controlador encargado de enviar correos
require_once "./app/controllers/vencimientoController.php";
use app\controllers\vencimientoController;

// Verificamos si es momento de enviar correos automáticos
$vencimientoController = new vencimientoController();
$vencimientoController->enviarCorreosDeAlerta();

if(isset($_GET["views"])){
    $url = explode("/", $_GET["views"]);
} else {
    $url = ["login"];
}

$current_view = $url[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once "./app/views/inc/head.php"; ?> 
</head>
<body>
    <?php 
    use app\controllers\viewsController;
    use app\controllers\loginController;

    $insLogin = new loginController();
    
    $viewsController = new viewsController(); 
    $vista = $viewsController->obtenerVistasControlador($url[0]);

    // Solo se muestra el contenido sin menú para login, 404 y registrarse
    if($vista == "login" || $vista == "404" || $vista == "registrarse"){
        require_once "./app/views/content/".$vista."-view.php";
    } else {

        // Verificación de sesión
        if(!isset($_SESSION['id']) || !isset($_SESSION['correo']) || !isset($_SESSION['nombre']) || 
        $_SESSION['id']=="" || $_SESSION['correo']=="" || $_SESSION['nombre']==""){
            $insLogin->cerrarSesionControlador();
            exit();
        }

        // Incluimos el menú solo para las vistas de la lista blanca
        require_once "./app/views/inc/navbar.php";
        require_once $vista; 
    }

    require_once "./app/views/inc/script.php"; 
    ?>
</body>
</html>
