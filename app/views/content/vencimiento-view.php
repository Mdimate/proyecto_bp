<link rel="stylesheet" type="text/css" href="<?php echo APP_URL; ?>app/views/css/inventario.css">

<?php
    use app\controllers\vencimientoController; 

    // Crear una instancia del controlador de vencimientos
    $insCertificado = new vencimientoController(); 

    // Llamar al método que lista certificados (como ya lo tienes)
    echo $insCertificado->listarCertificadoControlador($url[1],15, $url[0],"");

    // Llamar al método que envía los correos de alerta para hacer la prueba
    $insCertificado->enviarCorreosDeAlerta(); 
?>
