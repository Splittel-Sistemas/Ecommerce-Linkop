<?php

require_once "../controladores/blog.controlador.php";
require_once "../modelos/blog.modelo.php";

class TablaBlog{

 	/*=============================================
  	MOSTRAR LA TABLA DE BANNER
  	=============================================*/ 

 	public function mostrarTabla(){	

 		$item = null;
 		$valor = null;

 		$banner = ControladorBlog::ctrMostrarBlog($item, $valor);	

 		$datosJson = '{
		 
		  "data": [ ';

		 for($i = 0; $i < count($banner); $i++){

		 	/*=============================================
			REVISAR ESTADO
			=============================================*/ 
			
			if($banner[$i]["estado"] == 0){
				
				$colorEstado = "btn-danger";
				$textoEstado = "Desactivado";
				$estadoBanner = 1;

			}else{

				$colorEstado = "btn-success";
				$textoEstado = "Activado";
				$estadoBanner = 0;

			}	

			$estado = "<button class='btn ".$colorEstado." btn-xs btnActivar' estadoBanner='".$estadoBanner."' idBanner='".$banner[$i]["id"]."'>".$textoEstado."</button>";

			/*=============================================
			REVISAR IMAGEN BANNER
			=============================================*/ 

			$imgBanner = "<img class='img-thumbnail imgBanner' src='".$banner[$i]["img"]."' width='100px'>";

			/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/

  			 $acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarBanner' idBanner='".$banner[$i]["id"]."' data-toggle='modal' data-target='#modalEditarBanner'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarBanner' idBanner='".$banner[$i]["id"]."' imgBanner='".$banner[$i]["img"]."'><i class='fa fa-times'></i></button></div>";
				
			   $bodytag = str_replace('"', "'",$banner[$i]["tipo"]);

  			 $datosJson	 .= '[
					 	"'.($i+1).'",
					 	"'.$imgBanner.'",
				 	 	"'. $estado.'",
				      	"'.$banner[$i]["ruta"].'",
				      	"'.$bodytag.'",
				      	"'.$acciones.'"		   

  			  ],';
	    
		 }

	  	$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']
		  
		}'; 

		echo $datosJson;

 	}


}


/*=============================================
ACTIVAR TABLA DE BANNER
=============================================*/ 
$activar = new TablaBlog();
$activar -> mostrarTabla();