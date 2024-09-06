
<link rel="stylesheet" type="text/css" href="<?php echo APP_URL; ?>app/views/css/inventario.css">

    <h1>Inventario</h1>
    
    
        <?php
            use app\controllers\certificateController; 

            $insCertificado = new certificateController(); 

            echo $insCertificado->listarCertificadoControlador($url[1],15, $url[0],"");
            
        ?>
