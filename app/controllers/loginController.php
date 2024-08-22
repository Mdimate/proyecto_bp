<?php
    namespace app\controllers;
    use app\models\mainModel; 
    
    class loginController extends mainModel{
        #Controlador iniciar sesion 

        public function iniciarSesionControlador(){
            #Almacenar datos 
            $usuario=$this->limpiarCadena($_POST['login_usuario']);
            $clave=$this->limpiarCadena($_POST['login_clave']);
            
            #verificando campos obligatorios 

            if ($usuario == "" || $clave == "") {
                echo "
                <script>
                    Swal.fire({
                    icon: 'error',
                    title: 'Ocurrio un error inesperado',
                    text: 'No ha llenado los campos obligatorios',
                    confirmButtonText: 'Aceptar'
                    });
                </script>
                ";
            }else{
                # Verificar integridad de datos
            if (!$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}", $usuario)) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El nombre no coincide con el formato solicitado",
                    "icono" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            }
        }
    }
?> 