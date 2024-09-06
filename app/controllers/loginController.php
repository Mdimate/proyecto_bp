<?php
namespace app\controllers;

use app\models\mainModel;

class loginController extends mainModel {
    # Controlador iniciar sesión
    public function iniciarSesionControlador() {
        # Almacenando datos 
        $correo = $this->limpiarCadena($_POST['login_usuario']);
        $clave = $this->limpiarCadena($_POST['login_clave']);

        # Verificando campos obligatorios 
        if ($correo == "" || $clave == "") {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Ocurrió un error inesperado',
                    text: 'No has llenado todos los campos que son obligatorios',
                    confirmButtonText: 'Aceptar'
                });
            </script>
            ";
            return;
        }

        # Verificando integridad de los datos 
        if ($this->verificarDatos("/[a-zA-Z0-9$@.-]{7,100}/", $clave)) {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Ocurrió un error inesperado',
                    text: 'La clave ingresada no coincide con el formato solicitado',
                    confirmButtonText: 'Aceptar'
                });
            </script>
            ";
            return;
        }

        # Verificando email 
        if ($correo != "" && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Ocurrió un error inesperado',
                    text: 'El correo ingresado no coincide con el formato solicitado',
                    confirmButtonText: 'Aceptar'
                });
            </script>
            ";
            return;
        }

        # Verificando usuario
        $check_usuario = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE correo = '$correo'");

        if ($check_usuario->rowCount() == 1) {
            $check_usuario = $check_usuario->fetch();

            if ($check_usuario['correo'] == $correo && password_verify($clave, $check_usuario['contrasena'])) {

                $_SESSION['id'] = $check_usuario['id'];
                $_SESSION['correo'] = $check_usuario['correo'];
                $_SESSION['nombre'] = $check_usuario['nombre'];
                $_SESSION['contrasena'] = $check_usuario['contrasena'];

                if (headers_sent()) {
                    echo "<script> window.location.href='" . APP_URL . "dashboard/';</script>";
                } else {
                    header("Location: " . APP_URL . "dashboard/");
                }

            } else {
                echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Ocurrió un error inesperado',
                        text: 'Usuario o clave incorrectos',
                        confirmButtonText: 'Aceptar'
                    });
                </script>
                ";
            }
        } else {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Ocurrió un error inesperado',
                    text: 'Usuario o clave incorrectos',
                    confirmButtonText: 'Aceptar'
                });
            </script>
            ";
        }
    }
#Controlador cerrar sesion

public function cerrarSesionControlador(){
    
    session_destroy(); 

    if (headers_sent()) {
        echo "<script> window.location.href='" . APP_URL . "login/';</script>";
    } else {
        header("Location: " . APP_URL . "login/");
    }
}

}
