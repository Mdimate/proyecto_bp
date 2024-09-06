<?php
    namespace app\controllers;
    use app\models\mainModel;
    use app\ajax\certificadoAjax;

    class certificateController extends mainModel{
        #controlador para registrar certificados 
        public function registrarCertificadoControlador(){

            #Almacenando datos 
            $nombre=$this->limpiarCadena($_POST['certificado_nombre']);
            $fecha=$this->limpiarCadena($_POST['certificado_fecha']);
            $grupo=$this->limpiarCadena($_POST['certificado_grupo']);
            $correo=$this->limpiarCadena($_POST['certificado_correo']);

            #verificando campos obligatorios 

            if ($nombre == "" || $fecha == "" || $grupo == "" || $correo == "") {
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
            if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El nombre no coincide con el formato solicitado",
                    "icono" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            

            if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $grupo)) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El grupo no coincide con el formato solicitado",
                    "icono" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if ($this->verificarDatos("(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/\d{4}", $fecha)) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "La fecha no coincide con el formato solicitado",
                    "icono" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            

            # Verificando email #
		    if($correo!=""){
				if(filter_var($correo,FILTER_VALIDATE_EMAIL)){
					
					}else{
                        $alerta = [
                            "tipo" => "simple",
                            "titulo" => "Ocurrió un error inesperado",
                            "texto" => "El correo ingresado no es valido",
                            "icono" => "error"
                        ];
                        echo json_encode($alerta);
                        exit();
                    }
                }
            
                $certificado_datos_reg=[
                    [
                        "campo_nombre"=>"nombre",
                        "campo_marcador"=>":Nombre",
                        "campo_valor"=>$nombre 
                    ],
                    [
                        "campo_nombre"=>"fecha_vencimiento",
                        "campo_marcador"=>":Fecha",
                        "campo_valor"=>$fecha
                    ],
                    [
                        "campo_nombre"=>"grupo",
                        "campo_marcador"=>":Grupo",
                        "campo_valor"=>$grupo 
                    ],
                    [
                        "campo_nombre"=>"correo_alertamiento",
                        "campo_marcador"=>":Correo",
                        "campo_valor"=>$correo 
                    ]
                ];

                $registrar_certificados=$this->guardarDatos("certificados",$certificado_datos_reg);

                if ($registrar_certificados->rowCount()==1) {
                    $alerta = [
                        "tipo" => "limpiar",
                        "titulo" => "Certificado registrado",
                        "texto" => "El certificado ".$nombre." se registro correctamente",
                        "icono" => "success"
                    ];
                }else{
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "El certificado no se pudo registrar correctamente, por favor intente nuevamente",
                        "icono" => "error"
                    ];

                }
                echo json_encode($alerta);
            }

        
# Controlador para listar certificados
    public function listarCertificadoControlador($pagina, $registros, $url, $busqueda){
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
        $consulta_datos = "SELECT * FROM certificados WHERE (nombre LIKE '%$busqueda%' OR grupo LIKE '%$busqueda%' OR correo_alertamiento LIKE '%$busqueda%') ORDER BY nombre ASC LIMIT $inicio, $registros";
        $consulta_total = "SELECT COUNT(id) FROM certificados WHERE (nombre LIKE '%$busqueda%' OR grupo LIKE '%$busqueda%' OR correo_alertamiento LIKE '%$busqueda%')";
    } else {
        $consulta_datos = "SELECT * FROM certificados ORDER BY nombre ASC LIMIT $inicio, $registros";
        $consulta_total = "SELECT COUNT(id) FROM certificados";
    }

    $datos = $this->ejecutarConsulta($consulta_datos);
    $datos = $datos->fetchAll();

    $total = $this->ejecutarConsulta($consulta_total);
    $total =(int) $total->fetchColumn();
    
    $numeroPaginas = ceil($total/$registros);

    $tabla .= '
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped" id="tabla">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Grupo de vencimiento</th>
                        <th scope="col">Correo alertamiento</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>';

    if ($total >= 1 && $pagina <= $numeroPaginas) {
        $contador = $inicio + 1;
        $pag_inicio = $inicio + 1;

        foreach ($datos as $rows) {
            $tabla.= '
            <tr>
                <th scope="row">' . $contador . '</th> 
                <td>' . $rows['nombre'] . '</td> 
                <td>' . $rows['grupo'] . '</td> 
                <td>' . $rows['correo_alertamiento'] . '</td> 
                <td>
                    <a href="' . APP_URL . 'certificateUpdate/' . $rows['id'] . '/" class="btn btn-sm btn-primary">Editar</a>
                    <form class="FormularioAjax" action="'.APP_URL.'app/ajax/certificadoAjax.php" method="POST" autocomplete="off">
                        <input type="hidden" name="modulo_certificado" value="eliminar">
                        <input type="hidden" name="id" value="' . $rows['id'] . '">
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            ';
            $contador++;
        }
        $pag_final = $contador - 1;

        $tabla .= '</tbody></table></div>';
        $tabla .= '<p class="text-right">Mostrando certificados <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
        $tabla .= $this->paginadorTablas($pagina, $numeroPaginas, $url, 7);
    } else {
        if ($total >= 1) {
            $tabla .= '
            <tr class="text-center">
                <td colspan="5">
                    <a href="' . $url . '1/" class="btn btn-link">Haga clic acá para recargar el listado</a>
                </td>
            </tr>';
        } else {
            $tabla .= '
            <tr class="text-center">
                <td colspan="5">No hay registros en el sistema</td>
            </tr>';
        }
        $tabla .= '</tbody></table></div>';
    }

    return $tabla;
}
    #Controlador para eliminar certificados 
    public function eliminarCertificadoControlador(){
        $id = $this->limpiarCadena($_POST['id']);
    #Verificando certificado 
        $datos = $this->ejecutarConsulta("SELECT * FROM certificados WHERE id ='$id'");

        if($datos->rowCount()<=0){
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se ha encontrado el certificado en el sistema",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $datos=$datos->fetch();
        }
        $eliminarCertificado=$this->eliminarRegistro("certificados","id",$id);

        if($eliminarCertificado->rowCount()==1){
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Certificado eliminado",
                "texto" => "El certificado ".$datos['nombre']." se eliminó correctamente",
                "icono" => "success"
            ];
        }else{
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El certificado ".$datos['nombre']." no se pudo eliminar correctamente, por favor intente nuevamente",
                "icono" => "error"
            ];
        }
        echo json_encode($alerta);
        exit();
        }
    }

?>
