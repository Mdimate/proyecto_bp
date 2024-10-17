<?php
namespace app\controllers;

use app\models\mainModel;
use app\ajax\vencimientoAjax;
use PHPMailer\PHPMailer\PHPMailer;

use PDO;
use DateTime;
use Exception;

require __DIR__ . '/../../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../PHPMailer/src/SMTP.php'; // Si también estás utilizando SMTP
require __DIR__ . '/../../PHPMailer/src/Exception.php'; // Para manejo de excepciones

class vencimientoController extends mainModel{
    #controlador para registrar certificados 
    public function registrarCertificadoControlador(){
        #Almacenando datos 
        $aplicacion = $this->limpiarCadena($_POST['aplicacion']);
        $fecha_vencimiento = $this->limpiarCadena($_POST['fecha_vencimiento']);
        $numero_serial = $this->limpiarCadena($_POST['numero_serial']);
        $correo_alertamiento = $this->limpiarCadena($_POST['correo_alertamiento']);
        $fecha_emision = $this->limpiarCadena($_POST['fecha_emision']);
        $area_responsable = $this->limpiarCadena($_POST['area_responsable']);
        $objetivo = $this->limpiarCadena($_POST['objetivo']);
        $url_servicio = $this->limpiarCadena($_POST['url_servicio']);
        $puerto = $this->limpiarCadena($_POST['puerto']);
        $ip_servidor = $this->limpiarCadena($_POST['ip_servidor']);
        $servicio_afectado = $this->limpiarCadena($_POST['servicio_afectado']);
        $sistema_operativo = $this->limpiarCadena($_POST['sistema_operativo']);
        $llavero = $this->limpiarCadena($_POST['llavero']);
        $ambiente = $this->limpiarCadena($_POST['ambiente']);
        $lider_tecnico = $this->limpiarCadena($_POST['lider_tecnico']);
        $tipo_certificado = $this->limpiarCadena($_POST['tipo_certificado']);
        $observaciones = $this->limpiarCadena($_POST['observaciones']);
    
        #verificando campos obligatorios 

    if ($aplicacion == "" || $fecha_vencimiento == "" || $numero_serial == "" || $correo_alertamiento == "" ||
                $fecha_emision == "" || $area_responsable == "" || $objetivo == "" || $url_servicio == "" || $puerto == ""
                || $ip_servidor == "" || $servicio_afectado == "" || $sistema_operativo == "" || $llavero == "" || $ambiente == ""
                || $lider_tecnico == "" || $tipo_certificado == "" || $observaciones == ""){
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "No has llenado todos los campos que son obligatorios",
                    "icono" => "error"
                ];
                echo json_encode($alerta);
                exit();
}
        

        # Verificar integridad de datos
        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $aplicacion)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "La aplicación no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("\d{4}-\d{2}-\d{2}", $fecha_vencimiento)) { // Formato: YYYY-MM-DD
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "La fecha de vencimiento no coincide con el formato solicitado (YYYY-MM-DD)",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[A-Za-z0-9\-]{5,50}", $numero_serial)) { // Personaliza el patrón según tu necesidad
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El número de serial no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (!filter_var($correo_alertamiento, FILTER_VALIDATE_EMAIL)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El correo ingresado no es válido",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("\d{4}-\d{2}-\d{2}", $fecha_emision)) { // Formato: YYYY-MM-DD
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "La fecha de emisión no coincide con el formato solicitado (YYYY-MM-DD)",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $area_responsable)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El área responsable no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $objetivo)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El objetivo no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("https?://[a-zA-Z0-9\-._~:\/?#[\]@!$&'()*+,;=%]+", $url_servicio)) { // Verifica formato de URL
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "La URL del servicio no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("\d{1,5}", $puerto)) { // Formato para puerto (1 a 5 dígitos)
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El puerto no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("([0-9]{1,3}\.){3}[0-9]{1,3}", $ip_servidor)) { // Formato para dirección IP
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "La dirección IP no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $servicio_afectado)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El servicio afectado no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $sistema_operativo)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El sistema operativo no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}", $llavero)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El llavero no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $ambiente)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El ambiente no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $lider_tecnico)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El líder técnico no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $tipo_certificado)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El tipo de certificado no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ,. ]{0,200}", $observaciones)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "Las observaciones no coinciden con el formato solicitado (máx. 200 caracteres)",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        # Preparar datos para guardar
        $certificado_datos_reg = [
            ["campo_nombre" => "aplicacion", "campo_marcador" => ":Aplicacion", "campo_valor" => $aplicacion],
            ["campo_nombre" => "fecha_vencimiento", "campo_marcador" => ":FechaVencimiento", "campo_valor" => $fecha_vencimiento],
            ["campo_nombre" => "numero_serial", "campo_marcador" => ":NumeroSerial", "campo_valor" => $numero_serial],
            ["campo_nombre" => "correo_alertamiento", "campo_marcador" => ":CorreoAlertamiento", "campo_valor" => $correo_alertamiento],
            ["campo_nombre" => "fecha_emision", "campo_marcador" => ":FechaEmision", "campo_valor" => $fecha_emision],
            ["campo_nombre" => "area_responsable", "campo_marcador" => ":AreaResponsable", "campo_valor" => $area_responsable],
            ["campo_nombre" => "objetivo", "campo_marcador" => ":Objetivo", "campo_valor" => $objetivo],
            ["campo_nombre" => "url_servicio", "campo_marcador" => ":UrlServicio", "campo_valor" => $url_servicio],
            ["campo_nombre" => "puerto", "campo_marcador" => ":Puerto", "campo_valor" => $puerto],
            ["campo_nombre" => "ip_servidor", "campo_marcador" => ":IpServidor", "campo_valor" => $ip_servidor],
            ["campo_nombre" => "servicio_afectado", "campo_marcador" => ":ServicioAfectado", "campo_valor" => $servicio_afectado],
            ["campo_nombre" => "sistema_operativo", "campo_marcador" => ":SistemaOperativo", "campo_valor" => $sistema_operativo],
            ["campo_nombre" => "llavero", "campo_marcador" => ":Llavero", "campo_valor" => $llavero],
            ["campo_nombre" => "ambiente", "campo_marcador" => ":Ambiente", "campo_valor" => $ambiente],
            ["campo_nombre" => "lider_tecnico", "campo_marcador" => ":LiderTecnico", "campo_valor" => $lider_tecnico],
            ["campo_nombre" => "tipo_certificado", "campo_marcador" => ":TipoCertificado", "campo_valor" => $tipo_certificado],
            ["campo_nombre" => "observaciones", "campo_marcador" => ":Observaciones", "campo_valor" => $observaciones]
        ];

        $registrar_certificados = $this->guardarDatos("certificados", $certificado_datos_reg);

        if ($registrar_certificados->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Certificado registrado",
                "texto" => "El certificado " . $aplicacion . " se registro correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El certificado no se pudo registrar correctamente, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        echo json_encode($alerta);
        exit();
    }

    # Controlador para listar certificados
    public function listarCertificadoControlador($pagina, $registros, $url, $busqueda)
    {
        $pagina = $this->limpiarCadena($pagina);
        $registros = $this->limpiarCadena($registros);
        $url = APP_URL . $this->limpiarCadena($url) . "/";
        $busqueda = $this->limpiarCadena($busqueda);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        $consulta_datos = "";
        $consulta_total = "";

        if (isset($busqueda) && $busqueda != "") {
            $consulta_datos = "SELECT * FROM certificados 
                        WHERE (aplicacion LIKE '%$busqueda%' 
                        OR fecha_vencimiento LIKE '%$busqueda%' 
                        OR area_responsable LIKE '%$busqueda%' 
                        OR correo_alertamiento LIKE '%$busqueda%' 
                        OR servicio_afectado LIKE '%$busqueda%' 
                        OR sistema_operativo LIKE '%$busqueda%') 
                        ORDER BY fecha_vencimiento ASC LIMIT $inicio, $registros";

            $consulta_total = "SELECT COUNT(id) FROM certificados 
                        WHERE (aplicacion LIKE '%$busqueda%' 
                        OR fecha_vencimiento LIKE '%$busqueda%' 
                        OR area_responsable LIKE '%$busqueda%' 
                        OR correo_alertamiento LIKE '%$busqueda%' 
                        OR servicio_afectado LIKE '%$busqueda%' 
                        OR sistema_operativo LIKE '%$busqueda%')";
        } else {
            $consulta_datos = "SELECT * FROM certificados ORDER BY fecha_vencimiento ASC LIMIT $inicio, $registros";
            $consulta_total = "SELECT COUNT(id) FROM certificados";
        }

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int)$total->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        $tabla .= '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vencimiento de Certificados</title>
        <link rel="stylesheet" href="' . APP_URL . 'app/views/css/inventario.css">
    </head>
    <body>
        <main>
            <h1>Vencimiento de Certificados</h1>
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="tabla">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Aplicación</th>
                                <th scope="col">Fecha Vencimiento</th>
                                <th scope="col">Número Serial</th>
                                <th scope="col">Correo Alertamiento</th>
                                <th scope="col">Fecha Emisión</th>
                                <th scope="col">Área Responsable</th>
                                <th scope="col">Objetivo</th>
                                <th scope="col">URL Servicio</th>
                                <th scope="col">Puerto</th>
                                <th scope="col">IP Servidor</th>
                                <th scope="col">Servicio Afectado</ th>
                                <th scope="col">Sistema Operativo</th>
                                <th scope="col">Llavero</th>
                                <th scope="col">Ambiente</th>
                                <th scope="col">Líder Técnico</th>
                                <th scope="col">Tipo Certificado</th>
                                <th scope="col">Observaciones</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($total >= 1 && $pagina <= $numeroPaginas) {
            $contador = $inicio + 1;

            foreach ($datos as $rows) {
                $tabla .= '
        <tr>
            <th scope="row">' . $contador . '</th> 
            <td>' . $rows['aplicacion'] . '</td>
            <td>' . (isset($rows['fecha_vencimiento']) ? $rows['fecha_vencimiento'] : 'No disponible') . '</td>  
            <td>' . (isset($rows['numero_serial']) ? $rows['numero_serial'] : 'No disponible') . '</td> 
            <td>' . (isset($rows['correo_alertamiento']) ? $rows['correo_alertamiento'] : 'No disponible') . '</td>
            <td>' . (isset($rows['fecha_emision']) ? $rows['fecha_emision'] : 'No disponible') . '</td>
            <td>' . (isset($rows['area_responsable']) ? $rows['area_responsable'] : 'No disponible') . '</td> 
            <td>' . (isset($rows['objetivo']) ? $rows['objetivo'] : 'No disponible') . '</td> 
            <td>' . (isset($rows['url_servicio']) ? $rows['url_servicio'] : 'No disponible') . '</td>
            <td>' . (isset($rows['puerto']) ? $rows['puerto'] : 'No disponible') . '</td>
            <td>' . (isset($rows['ip_servidor']) ? $rows['ip_servidor'] : 'No disponible') . '</td>
            <td>' . (isset($rows['servicio_afectado']) ? $rows['servicio_afectado'] : 'No disponible') . '</td>
            <td>' . (isset($rows['sistema_operativo']) ? $rows['sistema_operativo'] : 'No disponible') . '</td>
            <td>' . (isset($rows['llavero']) ? $rows['llavero'] : 'No disponible') . '</td>
            <td>' . (isset($rows['ambiente']) ? $rows['ambiente'] : 'No disponible') . '</td>
            <td>' . (isset($rows['lider_tecnico']) ? $rows['lider_tecnico'] : 'No disponible') . '</td>
            <td>' . (isset($rows['tipo_certificado']) ? $rows['tipo_certificado'] : 'No disponible') . '</td>
            <td>' . (isset($rows['observaciones']) ? $rows['observaciones'] : 'No disponible') . '</td>
            <td>
                <a href="' . APP_URL . 'certificateUpdate/' . $rows['id'] . '/" class="btn btn-sm btn-primary">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <form class="FormularioAjax"" action="' . APP_URL . 'app/ajax/vencimientoAjax.php" method="POST" autocomplete="off">
                    <input type="hidden" name="modulo_certificado" value="eliminar">
                    <input type="hidden" name="id" value="' . $rows['id'] . '">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </td>
        </tr>';
                $contador++;
            }

            $pag_final = $contador - 1;
            $tabla .= '</tbody></table></div>';
            $tabla .= '<p class="text-right">Mostrando certificados <strong>' . ($inicio + 1) . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
            $tabla .= $this->paginadorTablas($pagina, $numeroPaginas, $url, 7);
        } else {
            $tabla .= '<tr class="text-center"><td colspan="17">No hay registros en el sistema</td></tr>';
            $tabla .= '</tbody></table></div>';
        }

        return $tabla;
    }

    // Controlador para eliminar certificados 
public function eliminarCertificadoControlador()
{
    $id = $this->limpiarCadena($_POST['id']);

    // Verificando si el certificado existe
    $datos = $this->ejecutarConsulta("SELECT * FROM certificados WHERE id ='$id'");

    if ($datos->rowCount() <= 0) {
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Ocurrió un error inesperado",
            "texto" => "No se ha encontrado el certificado en el sistema",
            "icono" => "error"
        ];
        echo json_encode($alerta);
        exit();
    } else {
        $datos = $datos->fetch();
    }

    // Eliminando el certificado
    $eliminarCertificado = $this->eliminarRegistro("certificados", "id", $id);

    if ($eliminarCertificado) { // Asegúrate de que la función devuelva un resultado correcto
        $alerta = [
            "tipo" => "recargar",
            "titulo" => "Certificado eliminado",
            "texto" => "El certificado '{$datos['aplicacion']}' (ID: $id) se eliminó correctamente.",
            "icono" => "success"
        ];
    } else {
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Ocurrió un error inesperado",
            "texto" => "El certificado '{$datos['aplicacion']}' (ID: $id) no se pudo eliminar correctamente, por favor intente nuevamente.",
            "icono" => "error"
        ];
    }

    // Retornar la alerta en formato JSON
    echo json_encode($alerta);
    exit();
}

    public function actualizarCertificadoControlador()
    {
        // Obtener el ID del certificado
        $id = $this->limpiarCadena($_POST['id']);

        // Verificar si el certificado existe en la base de datos
        $insCertificado = new vencimientoController(); // Crear instancia del controlador
        $datos = $insCertificado->seleccionarDatos("Unico", "certificados", "id", $id); // Verificar existencia del certificado

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "No hemos encontrado el certificado en el sistema",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // Obtener los datos enviados por el formulario
        $aplicacion = $this->limpiarCadena($_POST['aplicacion']);
        $fecha_vencimiento = $this->limpiarCadena($_POST['fecha_vencimiento']);
        $numero_serial = $this->limpiarCadena($_POST['numero_serial']);
        $correo_alertamiento = $this->limpiarCadena($_POST['correo_alertamiento']);
        $fecha_emision = $this->limpiarCadena($_POST['fecha_emision']);
        $area_responsable = $this->limpiarCadena($_POST['area_responsable']);
        $objetivo = $this->limpiarCadena($_POST['objetivo']);
        $url_servicio = $this->limpiarCadena($_POST['url_servicio']);
        $puerto = $this->limpiarCadena($_POST['puerto']);
        $ip_servidor = $this->limpiarCadena($_POST['ip_servidor']);
        $servicio_afectado = $this->limpiarCadena($_POST['servicio_afectado']);
        $sistema_operativo = $this->limpiarCadena($_POST['sistema_operativo']);
        $llavero = $this->limpiarCadena($_POST['llavero']);
        $ambiente = $this->limpiarCadena($_POST['ambiente']);
        $lider_tecnico = $this->limpiarCadena($_POST['lider_tecnico']);
        $tipo_certificado = $this->limpiarCadena($_POST['tipo_certificado']);
        $observaciones = $this->limpiarCadena($_POST['observaciones']);

       // Verificar campos obligatorios
if (
    empty($aplicacion) || 
    empty($fecha_vencimiento) || 
    empty($correo_alertamiento) || 
    empty($numero_serial) || 
    empty($area_responsable) || 
    empty($objetivo) || 
    empty($url_servicio) || 
    empty($puerto) || 
    empty($ip_servidor) || 
    empty($servicio_afectado) || 
    empty($sistema_operativo) || 
    empty($llavero) || 
    empty($ambiente) || 
    empty($lider_tecnico) || 
    empty($tipo_certificado)
) {
    $alerta = [
        "tipo" => "simple",
        "titulo" => "Error",
        "texto" => "Faltan campos obligatorios",
        "icono" => "error"
    ];
    echo json_encode($alerta);
    exit();
}

// Preparar los datos para la actualización
$certificado_datos_up = [
    [
        "campo_nombre" => "aplicacion", // Corregido
        "campo_marcador" => ":Aplicacion",
        "campo_valor" => $aplicacion
    ],
    [
        "campo_nombre" => "fecha_vencimiento",
        "campo_marcador" => ":FechaVencimiento",
        "campo_valor" => $fecha_vencimiento
    ],
    // ... otros campos ...
    [
        "campo_nombre" => "observaciones",
        "campo_marcador" => ":Observaciones",
        "campo_valor" => $observaciones // Asegúrate de que esto esté definido
    ]
];

// Condición para la actualización
$condicion = [
    "condicion_campo" => "id",
    "condicion_marcador" => ":ID",
    "condicion_valor" => $id // Asegúrate de que $id esté definido
];

// Ejecutar la actualización
if ($this->actualizarDatos("certificados", $certificado_datos_up, $condicion)) {
    $alerta = [
        "tipo" => "recargar",
        "titulo" => "Éxito",
        "texto" => "Certificado actualizado correctamente",
        "icono" => "success"
    ];
} else {
    $alerta = [
        "tipo" => "simple",
        "titulo" => "Error",
        "texto" => "No se pudo actualizar el certificado",
        "icono" => "error"
    ];
}

// Retornar la alerta en formato JSON
echo json_encode($alerta);
exit();
    }
    public function obtenerDatosDashboard() {
        try {
            // Ejecutar las consultas
            $top5Aplicaciones = $this->ejecutarConsulta("SELECT aplicacion, fecha_vencimiento FROM certificados WHERE fecha_vencimiento > NOW() ORDER BY fecha_vencimiento ASC LIMIT 5");
            $totalCertificados = $this->ejecutarConsulta("SELECT COUNT(*) AS total_certificados FROM certificados WHERE fecha_vencimiento > NOW()");
            $top5Areas = $this->ejecutarConsulta("SELECT area_responsable, COUNT(*) AS total FROM certificados WHERE fecha_vencimiento > NOW() GROUP BY area_responsable ORDER BY total DESC LIMIT 5");
            $totalPendientes = $this->ejecutarConsulta("SELECT COUNT(*) AS total_pendientes FROM certificados WHERE correo_enviado = 0");
    
            // Preparar los datos para devolver
            $datos = [
                "top5_aplicaciones" => $top5Aplicaciones->fetchAll(PDO::FETCH_ASSOC),
                "total_certificados" => $totalCertificados->fetch(PDO::FETCH_ASSOC)['total_certificados'],
                "top5_areas" => $top5Areas->fetchAll(PDO::FETCH_ASSOC),
                "total_pendientes" => $totalPendientes->fetch(PDO::FETCH_ASSOC)['total_pendientes'],
            ];
    
            // Convertir las fechas al formato ISO 8601
            foreach ($datos['top5_aplicaciones'] as &$app) {
                try {
                    if ($this->isValidDate($app['fecha_vencimiento'])) {
                        $fecha = new DateTime($app['fecha_vencimiento']);
                        $app['fecha_vencimiento'] = $fecha->format(DateTime::ATOM); // Formato ISO 8601
                    } else {
                        $app['fecha_vencimiento'] = null; // o valor predeterminado
                    }
                } catch (Exception $e) {
                    // Manejar el error
                    $app['fecha_vencimiento'] = null; // o cualquier valor por defecto que desees
                }
            }
    
            // Devolver los datos en formato JSON
            header('Content-Type: application/json');
            echo json_encode($datos);
        } catch (Exception $e) {
            // Manejar el error y devolver un mensaje JSON
            header('Content-Type: application/json');
            echo json_encode([
                "error" => true,
                "mensaje" => $e->getMessage(),
            ]);
        }
        exit(); // Terminar el script después de enviar la respuesta
    }
    
    // Validar formato de fecha
    private function isValidDate($date) {
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        return $d && $d->format('Y-m-d H:i:s') === $date;
    }

    public function enviarCorreosDeAlerta()
{
    // Obtener la fecha actual
    $fecha_actual = date('Y-m-d');

    // Calcular las fechas de alerta
    $fecha_30_dias = date('Y-m-d', strtotime($fecha_actual . ' + 30 days'));
    $fecha_15_dias = date('Y-m-d', strtotime($fecha_actual . ' + 15 days'));
    $fecha_1_dia = date('Y-m-d', strtotime($fecha_actual . ' + 1 day'));

    // Consultar certificados que están a 30, 15 y 1 día de vencer y que no han recibido correo
    $consulta = "SELECT id, aplicacion, fecha_vencimiento, correo_alertamiento 
                 FROM certificados 
                 WHERE (fecha_vencimiento = :fecha_30_dias 
                     OR fecha_vencimiento = :fecha_15_dias 
                     OR fecha_vencimiento = :fecha_1_dia) 
                 AND correo_enviado = FALSE";
    
    $sql = $this->conectar()->prepare($consulta);
    $sql->bindParam(':fecha_30_dias', $fecha_30_dias);
    $sql->bindParam(':fecha_15_dias', $fecha_15_dias);
    $sql->bindParam(':fecha_1_dia', $fecha_1_dia);
    $sql->execute();

    $certificados = $sql->fetchAll(PDO::FETCH_ASSOC);

    // Log para verificar los certificados recuperados
    error_log('Certificados encontrados: ' . print_r($certificados, true));

    // Enviar correos y marcar como enviado
    foreach ($certificados as $certificado) {
        // Log para cada certificado antes de enviar el correo
        error_log('Enviando correo para el certificado: ' . print_r($certificado, true));
        if ($this->enviarCorreoAlerta($certificado)) {
            $this->marcarCorreoEnviado($certificado['id']);
        }
    }
}

// Método para enviar correo de alerta para un certificado específico
private function enviarCorreoAlerta($certificado)
{
    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587; // Cambiado a número sin comillas
    $mail->Username = 'danieladimate2411@gmail.com';  // Cambia esto por tu correo
    $mail->Password = 'ypwb whbt yxcm ylez';         // Cambia esto por tu contraseña

    $mail->setFrom('tu_correo@gmail.com', 'Sistema de Certificados');
    $mail->addAddress($certificado['correo_alertamiento']);

    // Asunto y cuerpo del correo
    $mail->Subject = 'Alerta de Vencimiento de Certificado';
    $mail->Body = "Estimado usuario,\n\nEl certificado de la aplicación '{$certificado['aplicacion']}' con fecha de vencimiento '{$certificado['fecha_vencimiento']}' está próximo a vencer.\n\nPor favor, tome las medidas necesarias.\n\nSaludos,\nSistema de Certificados";

    // Verificar el envío del correo
    if (!$mail->send()) {
        error_log('Error al enviar el correo: ' . $mail->ErrorInfo);
        return false; // Retornar false si hay un error
    }
    return true; // Retornar true si se envió correctamente
}

// Método para marcar como enviado el correo para un certificado específico
private function marcarCorreoEnviado($id)
{
    $consulta = "UPDATE certificados SET correo_enviado = TRUE WHERE id = :id";
    $sql = $this->conectar()->prepare($consulta);
    $sql->bindParam(':id', $id);
    $sql->execute();
}

}
?>
