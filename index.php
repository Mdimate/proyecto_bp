<?php
    require_once "./config/app.php";
    require_once "./autoload.php";
    require_once "./app/views/inc/session_start.php";

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
    $vista = $viewsController->obtenerVistasControlador($current_view);

    if($vista == "login" || $vista == "404" || $vista == "registrarse"){
        require_once "./app/views/content/".$vista."-view.php";
    } else {
        require_once "./app/views/inc/navbar.php";
        require_once $vista; 
    }
    require_once "./app/views/inc/script.php"; 
    ?>
</body>
</html>
