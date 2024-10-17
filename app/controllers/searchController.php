<?php
    namespace app\controllers;
    use app\models\mainModel;
    use app\ajax\certificadoAjax;

    class searchController extends mainModel{
    
    public function modulosBusquedaControlador($modulo){
        $listaModulos=['buscar'];

        if(in_array($modulo,$listaModulos)){
            return false; 
        }else{
            return true;
        }
    }

    #controlador para iniciar busqueda 
    public function iniciarBuscadorControlador(){
        $url=$this->limpiarCadena($_POST['modulo_url']);
        $texto=$this->limpiarCadena($_POST['txt_buscador']);

        if($this->modulosBusquedaControlador($url)){
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No podemos procesar la peticion en este momento",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if($texto == ""){
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "Introduce un termino de busqueda",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}", $texto)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El termino de busqueda no coincide con el formato solicitado",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $_SESSION[$url]=$texto;
        $alerta = [
            "tipo" => "redireccionar",
            "url" =>APP_URL.$url."/"
        ];
        echo json_encode($alerta);
       
    }
    #controlador para eliminar busqueda

    public function eliminarBuscadorControlador(){

        $url=$this->limpiarCadena($_POST['modulo_url']);
        
        if($this->modulosBusquedaControlador($url)){
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No podemos procesar la peticion en este momento",
                "icono" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        unset($_SESSION[$url]);
        
        $alerta = [
            "tipo" => "redireccionar",
            "url" =>APP_URL.$url."/"
        ];
        echo json_encode($alerta);
    }


    }