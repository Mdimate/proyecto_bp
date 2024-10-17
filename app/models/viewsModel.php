<?php
	namespace App\models;
	class viewsModel{
		protected function obtenerVistasModelo($vista){
		   // Agregar "registrarse" a la lista blanca
		$listaBlanca = ["dashboard", "vencimiento", "buscar", "agregar", "LogOut", "certificateUpdate"];

		if(in_array($vista, $listaBlanca)){
			if(is_file("./app/views/content/".$vista."-view.php")){
				$contenido = "./app/views/content/".$vista."-view.php";
			
			} else {
				$contenido = "404";
			}
		} elseif($vista == "login" || $vista == "index") {
			$contenido = "login";
		}elseif($vista == "registrarse"){
			$contenido = "registrarse";
		}else {
			$contenido = "404";
		}
		return $contenido;
	}
}

?>