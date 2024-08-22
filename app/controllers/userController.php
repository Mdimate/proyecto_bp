<?php 
namespace app\controllers;
use app\models\mainModel;
use app\ajax\usuarioAjax;

class userController extends mainModel{
    #controlador para registrar usuarios
    public function registrarUsuarioControlador(){
        $nombre=$this->limpiarCadena($_POST['usuario_nombre']);
        $email=$this->limpiarCadena($_POST['usuario_email']);
        $clave=$this->limpiarCadena($_POST['usuario_clave']);

        
    #verificando campos obligatorios 

    if ($nombre == "" || $email == "" || $clave == "") {
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
    if (!$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
        $alerta = [
            "tipo" => "simple",
            "titulo" => "Ocurrió un error inesperado",
            "texto" => "El nombre no coincide con el formato solicitado",
            "icono" => "error"
        ];
        echo json_encode($alerta);
        exit();
    }
     # Verificando email #
     if($email!=""){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            
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
    
        if (!$this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El grupo no coincide con el formato solicitado",
                "icono" => "error"
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
                "campo_marcador"=>":Email",
                "campo_valor"=>$email
            ],
            [
                "campo_nombre"=>"contraseña",
                "campo_marcador"=>":Clave",
                "campo_valor"=>$clave 
            ]
        ];

        $registrar_usuarios=$this->guardarDatos("usuarios",$usuario_datos_reg);

                if ($registrar_usuarios->rowCount()==1) {
                    $alerta = [
                        "tipo" => "limpiar",
                        "titulo" => "Se ha registrado correctamente",
                        "texto" => "El usuario ".$nombre." se registro correctamente",
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