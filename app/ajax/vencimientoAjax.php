<?php
require_once "../../config/app.php"; // Ajusta la ruta según la estructura
require_once "../views/inc/session_start.php"; // Ajusta esta ruta también
require_once "../../autoload.php"; // Ajusta esta ruta también

use app\controllers\vencimientoController;

// Comprobamos que la petición sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $insCertificado = new vencimientoController();

    // Si hay una acción para el módulo certificado
    if (isset($_POST['modulo_certificado'])) {
        if ($_POST['modulo_certificado'] == "registrar") {
            echo $insCertificado->registrarCertificadoControlador();
        }
        if ($_POST['modulo_certificado'] == "eliminar") {
            echo $insCertificado->eliminarCertificadoControlador();
        }
        if ($_POST['modulo_certificado'] == "actualizar") {
            echo $insCertificado->actualizarCertificadoControlador();
        }
    }

// Si se solicita obtener datos para el dashboard
if (isset($_POST['action']) && $_POST['action'] === 'obtenerDatosDashboard') {
    // Llamar al método para obtener datos
    try {
        echo $insCertificado->obtenerDatosDashboard(); // Llama directamente al método

        // Asegúrate de que $datos no contenga errores antes de enviar la respuesta
        if ($datos) {
            echo $datos; // Imprime los datos que ya están en formato JSON
        } else {
            // Si no se obtuvieron datos, enviar un mensaje de error
            echo json_encode([
                'error' => true,
                'mensaje' => 'No se encontraron datos.'
            ]);
        }
    } catch (Exception $e) {
        // Manejar cualquier error que ocurra al llamar al método
        echo json_encode([
            'error' => true,
            'mensaje' => $e->getMessage()
        ]);
    }
    exit(); // Termina la ejecución para evitar enviar contenido adicional
}



} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
    exit; // Asegúrate de que no se ejecute más código
}
?>
