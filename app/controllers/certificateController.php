<?php
    namespace app\controllers;
    use app\models\mainModel;

    class certificateController extends mainModel{
        #controlador para registrar certificados 
        public function registrarCertificadoControlador(){

            #Almacenando datos 
            $nombre=$this->limpiarCadena($_POST['certificado_nombre']);
            $fecha=$this->limpiarCadena($_POST['certificado_fecha']);
            $grupo=$this->limpiarCadena($_POST['certificado_grupo']);
            $correo=$this->limpiarCadena($_POST['certificado_correo']);

            #verificando campos obligatorios 

            if($nombre=="" || $fecha=="" || $grupo=="" || $correo==""){
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrió un errror inesperado",
                    "texto"=>"No has llenado todos los campos que son obligatorios",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }
        }
    }
?>