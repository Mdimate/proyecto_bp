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
            if (!$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}", $nombre)) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El nombre no coincide con el formato solicitado",
                    "icono" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            

            if (!$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,100}", $grupo)) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El grupo no coincide con el formato solicitado",
                    "icono" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (!$this->verificarDatos("(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/\d{4}", $fecha)) {
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
}
    
?>