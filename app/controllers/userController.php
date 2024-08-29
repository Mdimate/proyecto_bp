<?php
    namespace app\controllers; 
    use app\models\mainModel;
    use app\ajax\usuarioAjax;

    class userController extends mainModel{

        # Controlador registrar usuarios # 
        public function registrarUsuarioControlador(){
            # Almacenando datos # 

            $nombre=$this->limpiarCadena($_POST['usuario_nombre']);
            $email=$this->limpiarCadena($_POST['usuario_email']);
            $clave1=$this->limpiarCadena($_POST['usuario_clave_1']);
            $clave2=$this->limpiarCadena($_POST['usuario_clave_2']);

            #Verificando campos obligatorios 
            if ($nombre == ""||$email == ""||$clave1 == ""||$clave2 =="") {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrio un error inesperado",
                    "texto"=>"No has llenado todos los campos que son obligatorios", 
                    "icono"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            #Verificar integridad de datos#

            if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)){
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrio un error inesperado",
                    "texto"=>"Nombre no coincide con el formato solicitado", 
                    "icono"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave1) || 
            $this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave2)){
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrio un error inesperado",
                    "texto"=>"Las claves no coinciden con el formato solicitado", 
                    "icono"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            #Verificando email 
            if($email!=""){
                if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $check_email=$this->ejecutarConsulta("SELECT 
                    correo FROM usuarios WHERE correo='$email'");

                    if($check_email->rowCount()>0){
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"Ocurrio un error inesperado",
                            "texto"=>"El correo ingresado ya se encuentra registrado.", 
                            "icono"=>"error"
                        ];
                        echo json_encode($alerta);
                        exit();

                    }
                }else{
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrio un error inesperado",
                        "texto"=>"Ha ingresado un correo no valido", 
                        "icono"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            #Verificando claves 

            if($clave1!=$clave2){
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrio un error inesperado",
                    "texto"=>"Las claves que acaba de ingresar no coinciden", 
                    "icono"=>"error"
                ];
                echo json_encode($alerta);
                exit();

            }else{
                $clave=password_hash($clave1,PASSWORD_BCRYPT,["cost"=>10]);
            }

            #Verificando usuario
            $check_usuario=$this->ejecutarConsulta("SELECT 
            Nombre FROM usuarios WHERE Nombre='$nombre'");
                    if($check_usuario->rowCount()>0){
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"Ocurrio un error inesperado",
                            "texto"=>"El usuario ingresado ya se encuentra registrado.", 
                            "icono"=>"error"
                        ];
                        echo json_encode($alerta);
                        exit();

                    }
            $usuario_datos_reg=[
                [
                    "campo_nombre"=>"nombre",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre
                ],
                [
                    "campo_nombre"=>"correo",
                    "campo_marcador"=>":Correo",
                    "campo_valor"=>$email
                ],
                [
                    "campo_nombre"=>"contrasena",
                    "campo_marcador"=>":Clave",
                    "campo_valor"=>$clave
                ]
            ];

                $registrar_usuario=$this->guardarDatos("usuarios",$usuario_datos_reg);

                if($registrar_usuario->rowCount()==1){
                    $alerta=[
                        "tipo"=>"limpiar",
                        "titulo"=>"Usuario registrado",
                        "texto"=>"El usuario ".$nombre." "."se registro exitosamente", 
                        "icono"=>"success"
                    ];
                }else{
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrio un error inesperado",
                        "texto"=>"No se pudo registrar el usuario, por favor intente nuevamente", 
                        "icono"=>"error"
                    ];
                }
                echo json_encode($alerta);
        }
    }
?>