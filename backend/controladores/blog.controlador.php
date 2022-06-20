<?php

class ControladorBlog{

	/*=============================================
	MOSTRAR BANNER
	=============================================*/

	static public function ctrMostrarBlog($item, $valor){

		$tabla = "blog";

		$respuesta = ModeloBlog::mdlMostrarBanner($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR BANNER
	=============================================*/

	static public function ctrCrearBlog(){

		if(isset($_POST["tipoBanner"])){

			/*=============================================
			VALIDAR IMAGEN BANNER
			=============================================*/

			$rutaBanner = "";

			if(isset($_FILES["fotoBanner"]["tmp_name"]) && !empty($_FILES["fotoBanner"]["tmp_name"])){

				/*=============================================
				DEFINIMOS LAS MEDIDAS
				=============================================*/

				list($ancho, $alto) = getimagesize($_FILES["fotoBanner"]["tmp_name"]);

				$nuevoAncho = 1600;
				$nuevoAlto = 550;

				/*=============================================
				DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
				=============================================*/	

				if($_FILES["fotoBanner"]["type"] == "image/jpeg"){

					/*=============================================
					GUARDAMOS LA IMAGEN EN EL DIRECTORIO
					=============================================*/

					$rutaBanner = "vistas/img/blog/".$_FILES["fotoBanner"]["name"].".jpg";

					$origen = imagecreatefromjpeg($_FILES["fotoBanner"]["tmp_name"]);	

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $rutaBanner);

				}

				if($_FILES["fotoBanner"]["type"] == "image/png"){

					/*=============================================
					GUARDAMOS LA IMAGEN EN EL DIRECTORIO
					=============================================*/

					$rutaBanner = "vistas/img/blog/".$_FILES["fotoBanner"]["name"].".png";

					$origen = imagecreatefrompng($_FILES["fotoBanner"]["tmp_name"]);						

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagealphablending($destino, FALSE);
			
					imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $rutaBanner);

				}

			}

			if(isset($_POST["rutaBanner"]) && !empty($_POST["rutaBanner"])){

				$ruta = $_POST["rutaBanner"];

			}else{

				$ruta = "sin-categoria";

			}

			$datos = array("img"=>$rutaBanner,
						   "estado"=>1,
						   "tipo"=>$_POST["tipoBanner"],
						   "ruta"=>$ruta);

			$respuesta = ModeloBlog::mdlIngresarBanner("blog", $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El Blog ha sido guardado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "blog";

						}
					})

				</script>';

			}

		}

	}

	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/

	static public function mdlMostrarBlogs($tabla, $ordenar, $item, $valor, $base, $tope, $modo){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT *FROM $tabla WHERE $item = :$item ORDER BY $ordenar $modo LIMIT $base, $tope");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT *FROM $tabla ORDER BY $ordenar $modo LIMIT $base, $tope");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	EDITAR BANNER
	=============================================*/

	static public function ctrEditarBanner(){

		if(isset($_POST["editarTipoBanner"])){

			/*=============================================
			VALIDAR IMAGEN BANNER
			=============================================*/

			$rutaBanner = $_POST["antiguaFotoBanner"];

			if(isset($_FILES["fotoBanner"]["tmp_name"]) && !empty($_FILES["fotoBanner"]["tmp_name"])){

				/*=============================================
				BORRAMOS ANTIGUA FOTO PORTADA
				=============================================*/

				unlink($_POST["antiguaFotoBanner"]);


				/*=============================================
				DEFINIMOS LAS MEDIDAS
				=============================================*/

				list($ancho, $alto) = getimagesize($_FILES["fotoBanner"]["tmp_name"]);

				$nuevoAncho = 1600;
				$nuevoAlto = 550;

				/*=============================================
				DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
				=============================================*/	

				if($_FILES["fotoBanner"]["type"] == "image/jpeg"){

					/*=============================================
					GUARDAMOS LA IMAGEN EN EL DIRECTORIO
					=============================================*/

					$rutaBanner = "vistas/img/blog/".$_POST["rutaBanner"].".jpg";

					$origen = imagecreatefromjpeg($_FILES["fotoBanner"]["tmp_name"]);	

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $rutaBanner);

				}

				if($_FILES["fotoBanner"]["type"] == "image/png"){

					/*=============================================
					GUARDAMOS LA IMAGEN EN EL DIRECTORIO
					=============================================*/

					$rutaBanner = "vistas/img/blog/".$_POST["rutaBanner"].".png";

					$origen = imagecreatefrompng($_FILES["fotoBanner"]["tmp_name"]);						

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagealphablending($destino, FALSE);
			
					imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $rutaBanner);

				}

			}

			$datos = array("id"=>$_POST["idBanner"],
						   "img"=>$rutaBanner,
						   "tipo"=>$_POST["editarTipoBanner"],
						   "ruta"=>$_POST["rutaBanner"]);

			$respuesta = ModeloBlog::mdlEditarBanner("blog", $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El Blog ha sido editado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "blog";

						}
					})

				</script>';

			}


		}

	}

	/*=============================================
	ELIMINAR BANNER
	=============================================*/

	static public function ctrEliminarBanner(){

		if(isset($_GET["idBanner"])){

			/*=============================================
			ELIMINAR IMAGEN BANNER
			=============================================*/

			if($_GET["imgBanner"] != ""){

				unlink($_GET["imgBanner"]);		

			}

			$respuesta = ModeloBlog::mdlEliminarBanner("blog", $_GET["idBanner"]);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El blog ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "blog";

								}
							})

				</script>';

			}		


		}

	}



}