<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ControladorUsuarios{

	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	public function ctrRegistroUsuario(){

		if(isset($_POST["regUsuario"])){

			if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["regUsuario"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["regEmail"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["regPassword"])){

			   	$encriptar = crypt($_POST["regPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$
			   		$2a$07$asxx54ahjppf45sd87a5auxq/SS293XhTEeizKWMnfhnpfay0AALe');

			   	$encriptarEmail = md5($_POST["regEmail"]);

				$datos = array("nombre"=>$_POST["regUsuario"],
							   "password"=> $encriptar,
							   "email"=> $_POST["regEmail"],
							   "foto"=>"",
							   "modo"=> "directo",
							   "verificacion"=> 1,
							   "emailEncriptado"=>$encriptarEmail);

				$tabla = "usuarios";

				$respuesta = ModeloUsuarios::mdlRegistroUsuario($tabla, $datos);

				if($respuesta == "ok"){

					/*=============================================
					ACTUALIZAR NOTIFICACIONES NUEVOS USUARIOS
					=============================================*/

					$traerNotificaciones = ControladorNotificaciones::ctrMostrarNotificaciones();

					$nuevoUsuario = $traerNotificaciones["nuevosUsuarios"] + 1;

					ModeloNotificaciones::mdlActualizarNotificaciones("notificaciones", "nuevosUsuarios", $nuevoUsuario);

					/*=============================================
					VERIFICACIÓN CORREO ELECTRÓNICO
					=============================================*/

					date_default_timezone_set("America/Bogota");

					$url = Ruta::ctrRuta();	

					$mail = new PHPMailer;

					$mail->CharSet = 'UTF-8';

					$mail->isMail();

					$mail->setFrom('notificaciones-splitnet@splittel.com', 'Linkop');

					

					$mail->Subject = "Por favor verifique su dirección de correo electrónico";

					$mail->addAddress($_POST["regEmail"]);

					$mail->msgHTML('<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
						
						<center>
							
							<img style="padding:20px; width:10%" src="">

						</center>

						<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
						
							<center>
							
							<img style="padding:20px; width:15%" src="">

							<h3 style="font-weight:100; color:#999">VERIFIQUE SU DIRECCIÓN DE CORREO ELECTRÓNICO</h3>

							<hr style="border:1px solid #ccc; width:80%">

							<h4 style="font-weight:100; color:#999; padding:0 20px">Para comenzar a usar su cuenta de Tienda Virtual, debe confirmar su dirección de correo electrónico</h4>

							<a href="'.$url.'verificar/'.$encriptarEmail.'" target="_blank" style="text-decoration:none">

							<div style="line-height:60px; background:#0aa; width:60%; color:white">Verifique su dirección de correo electrónico</div>

							</a>

							<br>

							<hr style="border:1px solid #ccc; width:80%">

							<h5 style="font-weight:100; color:#999">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>

							</center>

						</div>

					</div>');

					$envio = $mail->Send();

					if(!$envio){

						echo '<script> 

							swal({
								  title: "¡ERROR!",
								  text: "¡Ha ocurrido un problema enviando verificación de correo electrónico a '.$_POST["regEmail"].$mail->ErrorInfo.'!",
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},

								function(isConfirm){

									if(isConfirm){
										history.back();
									}
							});

						</script>';

					}else{

						echo '<script> 

							swal({
								  title: "¡OK!",
								  text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo electrónico '.$_POST["regEmail"].' para verificar la cuenta!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},

								function(isConfirm){

									if(isConfirm){
										history.back();
									}
							});

						</script>';

					}

				}

			}else{

				echo '<script> 

						swal({
							  title: "¡ERROR!",
							  text: "¡Error al registrar el usuario, no se permiten caracteres especiales!",
							  type:"error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

				</script>';

			}

		}

	}



	/* REGISTRO COMO INVITADO */

	public function ctrRegistroUsuarioInvitado(){

		if(isset($_POST["regUsuario1"])){

			if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["regUsuario1"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["regEmail1"]) ){

			   	$encriptar = crypt("12345", '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$
			   		$2a$07$asxx54ahjppf45sd87a5auxq/SS293XhTEeizKWMnfhnpfay0AALe');

			   	$encriptarEmail = md5($_POST["regEmail1"]);

				$datos = array("nombre"=>$_POST["regUsuario1"],
							   "password"=> $encriptar,
							   "email"=> $_POST["regEmail1"],
							   "foto"=>"",
							   "modo"=> "invitado",
							   "verificacion"=>0,
							   "emailEncriptado"=>$encriptarEmail);

				$tabla = "usuarios";

				$respuesta = ModeloUsuarios::mdlRegistroUsuarioInvitado($tabla, $datos);

				if($respuesta == "ok"){

					/*=============================================
					ACTUALIZAR NOTIFICACIONES NUEVOS USUARIOS
					=============================================*/

					$traerNotificaciones = ControladorNotificaciones::ctrMostrarNotificaciones();

					$nuevoUsuario = $traerNotificaciones["nuevosUsuarios"] + 1;

					ModeloNotificaciones::mdlActualizarNotificaciones("notificaciones", "nuevosUsuarios", $nuevoUsuario);

					/*=============================================
					VERIFICACIÓN CORREO ELECTRÓNICO
					=============================================*/
					
					/* echo'<script> 

					swal({
						  title: "¡OK!",
						  text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo electrónico para verificar la cuenta!",
						  type:"success",
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						},

						function(isConfirm){

							if(isConfirm){
								history.back();
							}
					});

				</script>'; */

				$tabla = "usuarios";
				$item = "email";
				$valor = $_POST["regEmail1"];

				$respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);
				$_SESSION["validarSesion"] = "ok";
				$_SESSION["id"] = $respuesta["id"];
				$_SESSION["nombre"] = $respuesta["nombre"];
				$_SESSION["foto"] = $respuesta["foto"];
				$_SESSION["email"] = $respuesta["email"];
				$_SESSION["password"] = $respuesta["password"];
				$_SESSION["modo"] = $respuesta["modo"];

				echo '<script>
					
				history.back();

				</script>';
				}

			}else{

				echo '<script> 

						swal({
							  title: "¡ERROR!",
							  text: "¡Error al registrar el usuario, no se permiten caracteres especiales!",
							  type:"error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

				</script>';

			}

		}

	}



	
	/*=============================================
	MOSTRAR USUARIO
	=============================================*/

	static public function ctrMostrarUsuario($item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	static public function ctrActualizarUsuario($id, $item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $id, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	INGRESO DE USUARIO
	=============================================*/

	public function ctrIngresoUsuario(){

		if(isset($_POST["ingEmail"])){

			if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["ingEmail"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){

				$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$tabla = "usuarios";
				$item = "email";
				$valor = $_POST["ingEmail"];

				$respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

				if($respuesta["email"] == $_POST["ingEmail"] && $respuesta["password"] == $encriptar){

					if($respuesta["verificacion"] == 1){

						echo'<script>

							swal({
								  title: "¡NO HA VERIFICADO SU CORREO ELECTRÓNICO!",
								  text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo para verififcar la dirección de correo electrónico '.$respuesta["email"].'!",
								  type: "error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
							},

							function(isConfirm){
									 if (isConfirm) {	   
									    history.back();
									  } 
							});

							</script>';

					}else{

						$_SESSION["validarSesion"] = "ok";
						$_SESSION["id"] = $respuesta["id"];
						$_SESSION["nombre"] = $respuesta["nombre"];
						$_SESSION["foto"] = $respuesta["foto"];
						$_SESSION["email"] = $respuesta["email"];
						$_SESSION["password"] = $respuesta["password"];
						$_SESSION["modo"] = $respuesta["modo"];

						echo '<script>
							
							window.location = localStorage.getItem("rutaActual");

						</script>';

					}

				}else{

					echo'<script>

							swal({
								  title: "¡ERROR AL INGRESAR!",
								  text: "¡Por favor revise que el email exista o la contraseña coincida con la registrada!",
								  type: "error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
							},

							function(isConfirm){
									 if (isConfirm) {	   
									    window.location = localStorage.getItem("rutaActual");
									  } 
							});

							</script>';

				}

			}else{

				echo '<script> 

						swal({
							  title: "¡ERROR!",
							  text: "¡Error al ingresar al sistema, no se permiten caracteres especiales!",
							  type:"error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

				</script>';

			}

		}

	}

	/*=============================================
	OLVIDO DE CONTRASEÑA
	=============================================*/

	public function ctrOlvidoPassword(){

		if(isset($_POST["passEmail"])){

			if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["passEmail"])){

				/*=============================================
				GENERAR CONTRASEÑA ALEATORIA
				=============================================*/

				function generarPassword($longitud){

					$key = "";
					$pattern = "1234567890abcdefghijklmnopqrstuvwxyz";

					$key = substr(str_shuffle($pattern),0,$longitud);

					return $key;

				}

				$nuevaPassword = generarPassword(11);

				$encriptar = crypt($nuevaPassword, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$tabla = "usuarios";

				$item1 = "email";
				$valor1 = $_POST["passEmail"];

				$respuesta1 = ModeloUsuarios::mdlMostrarUsuario($tabla, $item1, $valor1);

				if($respuesta1){

					$id = $respuesta1["id"];
					$item2 = "password";
					$valor2 = $encriptar;

					$respuesta2 = ModeloUsuarios::mdlActualizarUsuario($tabla, $id, $item2, $valor2);

					if($respuesta2  == "ok"){

						/*=============================================
						CAMBIO DE CONTRASEÑA
						=============================================*/

						date_default_timezone_set("America/Bogota");

						$url = Ruta::ctrRuta();	

						$mail = new PHPMailer;

						$mail->CharSet = 'UTF-8';

						$mail->isMail();

						$mail->setFrom('info@linkop.com.mx', 'Linkop');


						$mail->Subject = "Solicitud de nueva contraseña";

						$mail->addAddress($_POST["passEmail"]);

						$mail->msgHTML('<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
	
								<center>
									
									<img style="padding:20px; width:10%" src="">

								</center>

								<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
								
									<center>
									
									<img style="padding:20px; width:15%" src="">

									<h3 style="font-weight:100; color:#999">SOLICITUD DE NUEVA CONTRASEÑA</h3>

									<hr style="border:1px solid #ccc; width:80%">

									<h4 style="font-weight:100; color:#999; padding:0 20px"><strong>Su nueva contraseña: </strong>'.$nuevaPassword.'</h4>

									<a href="'.$url.'" target="_blank" style="text-decoration:none">

									<div style="line-height:60px; background:#0aa; width:60%; color:white">Ingrese nuevamente al sitio</div>

									</a>

									<br>

									<hr style="border:1px solid #ccc; width:80%">

									<h5 style="font-weight:100; color:#999">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>

									</center>

								</div>

							</div>');

						$envio = $mail->Send();

						if(!$envio){

							echo '<script> 

								swal({
									  title: "¡ERROR!",
									  text: "¡Ha ocurrido un problema enviando cambio de contraseña a '.$_POST["passEmail"].$mail->ErrorInfo.'!",
									  type:"error",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
									},

									function(isConfirm){

										if(isConfirm){
											history.back();
										}
								});

							</script>';

						}else{

							echo '<script> 

								swal({
									  title: "¡OK!",
									  text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo electrónico '.$_POST["passEmail"].' para su cambio de contraseña!",
									  type:"success",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
									},

									function(isConfirm){

										if(isConfirm){
											history.back();
										}
								});

							</script>';

						}

					}

				}else{

					echo '<script> 

						swal({
							  title: "¡ERROR!",
							  text: "¡El correo electrónico no existe en el sistema!",
							  type:"error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

					</script>';


				}

			}else{

				echo '<script> 

						swal({
							  title: "¡ERROR!",
							  text: "¡Error al enviar el correo electrónico, está mal escrito!",
							  type:"error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

				</script>';

			}

		}

	}

	/*=============================================
	REGISTRO CON REDES SOCIALES
	=============================================*/

	static public function ctrRegistroRedesSociales($datos){

		$tabla = "usuarios";
		$item = "email";
		$valor = $datos["email"];
		$emailRepetido = false;

		$respuesta0 = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

		if($respuesta0){

			if($respuesta0["modo"] != $datos["modo"]){

				echo '<script> 

						swal({
							  title: "¡ERROR!",
							  text: "¡El correo electrónico '.$datos["email"].', ya está registrado en el sistema con un método diferente a Google!",
							  type:"error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

				</script>';

				$emailRepetido = false;

			}

			$emailRepetido = true;

		}else{

			$respuesta1 = ModeloUsuarios::mdlRegistroUsuario($tabla, $datos);

		}

		if($emailRepetido || $respuesta1 == "ok"){

			$respuesta2 = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

			if($respuesta2["modo"] == "facebook"){

				session_start();

				$_SESSION["validarSesion"] = "ok";
				$_SESSION["id"] = $respuesta2["id"];
				$_SESSION["nombre"] = $respuesta2["nombre"];
				$_SESSION["foto"] = $respuesta2["foto"];
				$_SESSION["email"] = $respuesta2["email"];
				$_SESSION["password"] = $respuesta2["password"];
				$_SESSION["modo"] = $respuesta2["modo"];

				echo "ok";

			}else if($respuesta2["modo"] == "google"){

				$_SESSION["validarSesion"] = "ok";
				$_SESSION["id"] = $respuesta2["id"];
				$_SESSION["nombre"] = $respuesta2["nombre"];
				$_SESSION["foto"] = $respuesta2["foto"];
				$_SESSION["email"] = $respuesta2["email"];
				$_SESSION["password"] = $respuesta2["password"];
				$_SESSION["modo"] = $respuesta2["modo"];

				echo "<span style='color:white'>ok</span>";

			}

			else{

				echo "";
			}

		}
	}

	/*=============================================
	ACTUALIZAR PERFIL
	=============================================*/

	public function ctrActualizarPerfil(){

		if(isset($_POST["editarNombre"])){

			/*=============================================
			VALIDAR IMAGEN
			=============================================*/

			$ruta = $_POST["fotoUsuario"];

			if(isset($_FILES["datosImagen"]["tmp_name"]) && !empty($_FILES["datosImagen"]["tmp_name"])){

				/*=============================================
				PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
				=============================================*/

				$directorio = "vistas/img/usuarios/".$_POST["idUsuario"];

				if(!empty($_POST["fotoUsuario"])){

					unlink($_POST["fotoUsuario"]);
				
				}else{

					mkdir($directorio, 0755);

				}

				/*=============================================
				GUARDAMOS LA IMAGEN EN EL DIRECTORIO
				=============================================*/

				list($ancho, $alto) = getimagesize($_FILES["datosImagen"]["tmp_name"]);

				$nuevoAncho = 500;
				$nuevoAlto = 500;	

				$aleatorio = mt_rand(100, 999);

				if($_FILES["datosImagen"]["type"] == "image/jpeg"){

					$ruta = "vistas/img/usuarios/".$_POST["idUsuario"]."/".$aleatorio.".jpg";

					/*=============================================
					MOFICAMOS TAMAÑO DE LA FOTO
					=============================================*/

					$origen = imagecreatefromjpeg($_FILES["datosImagen"]["tmp_name"]);

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);

				}

				if($_FILES["datosImagen"]["type"] == "image/png"){

					$ruta = "vistas/img/usuarios/".$_POST["idUsuario"]."/".$aleatorio.".png";

					/*=============================================
					MOFICAMOS TAMAÑO DE LA FOTO
					=============================================*/

					$origen = imagecreatefrompng($_FILES["datosImagen"]["tmp_name"]);

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagealphablending($destino, FALSE);
    			
					imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);

				}

			}

			if($_POST["editarPassword"] == ""){

				$password = $_POST["passUsuario"];

			}else{

				$password = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			}

			$datos = array("nombre" => $_POST["editarNombre"],
						   "email" => $_POST["editarEmail"],
						   "password" => $password,
						   "foto" => $ruta,
						   "id" => $_POST["idUsuario"]);

			$tabla = "usuarios";

			$respuesta = ModeloUsuarios::mdlActualizarPerfil($tabla, $datos);

			if($respuesta == "ok"){

				$_SESSION["validarSesion"] = "ok";
				$_SESSION["id"] = $datos["id"];
				$_SESSION["nombre"] = $datos["nombre"];
				$_SESSION["foto"] = $datos["foto"];
				$_SESSION["email"] = $datos["email"];
				$_SESSION["password"] = $datos["password"];
				$_SESSION["modo"] = $_POST["modoUsuario"];

				echo '<script> 

						swal({
							  title: "¡OK!",
							  text: "¡Su cuenta ha sido actualizada correctamente!",
							  type:"success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

				</script>';


			}

		}

	}


	/*=============================================
	MOSTRAR COMPRAS
	=============================================*/

	static public function ctrMostrarCompras($item, $valor){

		$tabla = "compras";

		$respuesta = ModeloUsuarios::mdlMostrarCompras($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR COMENTARIOS EN PERFIL
	=============================================*/

	static public function ctrMostrarComentariosPerfil($datos){

		$tabla = "comentarios";

		$respuesta = ModeloUsuarios::mdlMostrarComentariosPerfil($tabla, $datos);

		return $respuesta;

	}


	/*=============================================
	ACTUALIZAR COMENTARIOS
	=============================================*/

	public function ctrActualizarComentario(){

		if(isset($_POST["idComentario"])){

			if(preg_match('/^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["comentario"])){

				if($_POST["comentario"] != ""){

					$tabla = "comentarios";

					$datos = array("id"=>$_POST["idComentario"],
								   "calificacion"=>$_POST["puntaje"],
								   "comentario"=>$_POST["comentario"]);

					$respuesta = ModeloUsuarios::mdlActualizarComentario($tabla, $datos);

					if($respuesta == "ok"){

						echo'<script>

								swal({
									  title: "¡GRACIAS POR COMPARTIR SU OPINIÓN!",
									  text: "¡Su calificación y comentario ha sido guardado!",
									  type: "success",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
								},

								function(isConfirm){
										 if (isConfirm) {	   
										   history.back();
										  } 
								});

							  </script>';

					}

				}else{

					echo'<script>

						swal({
							  title: "¡ERROR AL ENVIAR SU CALIFICACIÓN!",
							  text: "¡El comentario no puede estar vacío!",
							  type: "error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
						},

						function(isConfirm){
								 if (isConfirm) {	   
								   history.back();
								  } 
						});

					  </script>';

				}	

			}else{

				echo'<script>

					swal({
						  title: "¡ERROR AL ENVIAR SU CALIFICACIÓN!",
						  text: "¡El comentario no puede llevar caracteres especiales!",
						  type: "error",
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
					},

					function(isConfirm){
							 if (isConfirm) {	   
							   history.back();
							  } 
					});

				  </script>';

			}

		}

	}

	/*=============================================
	AGREGAR A LISTA DE DESEOS
	=============================================*/

	static public function ctrAgregarDeseo($datos){

		$tabla = "deseos";

		$respuesta = ModeloUsuarios::mdlAgregarDeseo($tabla, $datos);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR LISTA DE DESEOS
	=============================================*/

	static public function ctrMostrarDeseos($item){

		$tabla = "deseos";

		$respuesta = ModeloUsuarios::mdlMostrarDeseos($tabla, $item);

		return $respuesta;

	}

	/*=============================================
	QUITAR PRODUCTO DE LISTA DE DESEOS
	=============================================*/
	static public function ctrQuitarDeseo($datos){

		$tabla = "deseos";

		$respuesta = ModeloUsuarios::mdlQuitarDeseo($tabla, $datos);

		return $respuesta;

	}

	/*=============================================
	ELIMINAR USUARIO
	=============================================*/

	public function ctrEliminarUsuario(){

		if(isset($_GET["id"])){

			$tabla1 = "usuarios";		
			$tabla2 = "comentarios";
			$tabla3 = "compras";
			$tabla4 = "deseos";

			$id = $_GET["id"];

			if($_GET["foto"] != ""){

				unlink($_GET["foto"]);
				rmdir('vistas/img/usuarios/'.$_GET["id"]);

			}

			$respuesta = ModeloUsuarios::mdlEliminarUsuario($tabla1, $id);
			
			ModeloUsuarios::mdlEliminarComentarios($tabla2, $id);

			ModeloUsuarios::mdlEliminarCompras($tabla3, $id);

			ModeloUsuarios::mdlEliminarListaDeseos($tabla4, $id);

			if($respuesta == "ok"){

		    	$url = Ruta::ctrRuta();

		    	echo'<script>

						swal({
							  title: "¡SU CUENTA HA SIDO BORRADA!",
							  text: "¡Debe registrarse nuevamente si desea ingresar!",
							  type: "success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
						},

						function(isConfirm){
								 if (isConfirm) {	   
								   window.location = "'.$url.'salir";
								  } 
						});

					  </script>';

		    }

		}

	}

	/*=============================================
	FORMULARIO CONTACTENOS
	=============================================*/

	public function ctrFormularioContactenos(){

		if(isset($_POST['emailContactenos'])){

		

				/*=============================================
				ENVÍO CORREO ELECTRÓNICO
				=============================================*/

					date_default_timezone_set("America/Bogota");

					$url = Ruta::ctrRuta();	

					$mail = new PHPMailer;

					$mail->CharSet = 'UTF-8';

					$mail->isMail();

					$mail->setFrom('info@linkop.com.mx', 'Linkop');


					$mail->Subject = "Ha recibido una consulta";

					$mail->addAddress($_POST["emailContactenos"]);


					$mail->msgHTML("<!doctype html>
					<html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
						<head>
							<!-- NAME: 1 COLUMN - FULL WIDTH -->
							<!--[if gte mso 15]>
							<xml>
								<o:OfficeDocumentSettings>
								<o:AllowPNG/>
								<o:PixelsPerInch>96</o:PixelsPerInch>
								</o:OfficeDocumentSettings>
							</xml>
							<![endif]-->
							<meta charset='UTF-8'>
							<meta http-equiv='X-UA-Compatible' content='IE=edge'>
							<meta name='viewport' content='width=device-width, initial-scale=1'>
							<title>*|MC:SUBJECT|*</title>
							
						<style type='text/css'>
							p{
								margin:10px 0;
								padding:0;
							}
							table{
								border-collapse:collapse;
							}
							h1,h2,h3,h4,h5,h6{
								display:block;
								margin:0;
								padding:0;
							}
							img,a img{
								border:0;
								height:auto;
								outline:none;
								text-decoration:none;
							}
							body,#bodyTable,#bodyCell{
								height:100%;
								margin:0;
								padding:0;
								width:100%;
							}
							.mcnPreviewText{
								display:none !important;
							}
							#outlook a{
								padding:0;
							}
							img{
								-ms-interpolation-mode:bicubic;
							}
							table{
								mso-table-lspace:0pt;
								mso-table-rspace:0pt;
							}
							.ReadMsgBody{
								width:100%;
							}
							.ExternalClass{
								width:100%;
							}
							p,a,li,td,blockquote{
								mso-line-height-rule:exactly;
							}
							a[href^=tel],a[href^=sms]{
								color:inherit;
								cursor:default;
								text-decoration:none;
							}
							p,a,li,td,body,table,blockquote{
								-ms-text-size-adjust:100%;
								-webkit-text-size-adjust:100%;
							}
							.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
								line-height:100%;
							}
							a[x-apple-data-detectors]{
								color:inherit !important;
								text-decoration:none !important;
								font-size:inherit !important;
								font-family:inherit !important;
								font-weight:inherit !important;
								line-height:inherit !important;
							}
							.templateContainer{
								max-width:600px !important;
							}
							a.mcnButton{
								display:block;
							}
							.mcnImage,.mcnRetinaImage{
								vertical-align:bottom;
							}
							.mcnTextContent{
								word-break:break-word;
							}
							.mcnTextContent img{
								height:auto !important;
							}
							.mcnDividerBlock{
								table-layout:fixed !important;
							}
						/*
						@tab Page
						@section Background Style
						@tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
						*/
							body,#bodyTable{
								/*@editable*/background-color:#FAFAFA;
							}
						/*
						@tab Page
						@section Background Style
						@tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
						*/
							#bodyCell{
								/*@editable*/border-top:0;
							}
						/*
						@tab Page
						@section Heading 1
						@tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
						@style heading 1
						*/
							h1{
								/*@editable*/color:#202020;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:26px;
								/*@editable*/font-style:normal;
								/*@editable*/font-weight:bold;
								/*@editable*/line-height:125%;
								/*@editable*/letter-spacing:normal;
								/*@editable*/text-align:left;
							}
						/*
						@tab Page
						@section Heading 2
						@tip Set the styling for all second-level headings in your emails.
						@style heading 2
						*/
							h2{
								/*@editable*/color:#202020;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:22px;
								/*@editable*/font-style:normal;
								/*@editable*/font-weight:bold;
								/*@editable*/line-height:125%;
								/*@editable*/letter-spacing:normal;
								/*@editable*/text-align:left;
							}
						/*
						@tab Page
						@section Heading 3
						@tip Set the styling for all third-level headings in your emails.
						@style heading 3
						*/
							h3{
								/*@editable*/color:#202020;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:20px;
								/*@editable*/font-style:normal;
								/*@editable*/font-weight:bold;
								/*@editable*/line-height:125%;
								/*@editable*/letter-spacing:normal;
								/*@editable*/text-align:left;
							}
						/*
						@tab Page
						@section Heading 4
						@tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
						@style heading 4
						*/
							h4{
								/*@editable*/color:#202020;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:18px;
								/*@editable*/font-style:normal;
								/*@editable*/font-weight:bold;
								/*@editable*/line-height:125%;
								/*@editable*/letter-spacing:normal;
								/*@editable*/text-align:left;
							}
						/*
						@tab Preheader
						@section Preheader Style
						@tip Set the background color and borders for your email's preheader area.
						*/
							#templatePreheader{
								/*@editable*/background-color:#FAFAFA;
								/*@editable*/background-image:none;
								/*@editable*/background-repeat:no-repeat;
								/*@editable*/background-position:center;
								/*@editable*/background-size:cover;
								/*@editable*/border-top:0;
								/*@editable*/border-bottom:0;
								/*@editable*/padding-top:9px;
								/*@editable*/padding-bottom:9px;
							}
						/*
						@tab Preheader
						@section Preheader Text
						@tip Set the styling for your email's preheader text. Choose a size and color that is easy to read.
						*/
							#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
								/*@editable*/color:#656565;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:12px;
								/*@editable*/line-height:150%;
								/*@editable*/text-align:left;
							}
						/*
						@tab Preheader
						@section Preheader Link
						@tip Set the styling for your email's preheader links. Choose a color that helps them stand out from your text.
						*/
							#templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{
								/*@editable*/color:#656565;
								/*@editable*/font-weight:normal;
								/*@editable*/text-decoration:underline;
							}
						/*
						@tab Header
						@section Header Style
						@tip Set the background color and borders for your email's header area.
						*/
							#templateHeader{
								/*@editable*/background-color:#FFFFFF;
								/*@editable*/background-image:none;
								/*@editable*/background-repeat:no-repeat;
								/*@editable*/background-position:center;
								/*@editable*/background-size:cover;
								/*@editable*/border-top:0;
								/*@editable*/border-bottom:0;
								/*@editable*/padding-top:9px;
								/*@editable*/padding-bottom:0;
							}
						/*
						@tab Header
						@section Header Text
						@tip Set the styling for your email's header text. Choose a size and color that is easy to read.
						*/
							#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
								/*@editable*/color:#202020;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:16px;
								/*@editable*/line-height:150%;
								/*@editable*/text-align:left;
							}
						/*
						@tab Header
						@section Header Link
						@tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
						*/
							#templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{
								/*@editable*/color:#007C89;
								/*@editable*/font-weight:normal;
								/*@editable*/text-decoration:underline;
							}
						/*
						@tab Body
						@section Body Style
						@tip Set the background color and borders for your email's body area.
						*/
							#templateBody{
								/*@editable*/background-color:#FFFFFF;
								/*@editable*/background-image:none;
								/*@editable*/background-repeat:no-repeat;
								/*@editable*/background-position:center;
								/*@editable*/background-size:cover;
								/*@editable*/border-top:0;
								/*@editable*/border-bottom:0;
								/*@editable*/padding-top:9px;
								/*@editable*/padding-bottom:9px;
							}
						/*
						@tab Body
						@section Body Text
						@tip Set the styling for your email's body text. Choose a size and color that is easy to read.
						*/
							#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
								/*@editable*/color:#202020;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:16px;
								/*@editable*/line-height:150%;
								/*@editable*/text-align:left;
							}
						/*
						@tab Body
						@section Body Link
						@tip Set the styling for your email's body links. Choose a color that helps them stand out from your text.
						*/
							#templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{
								/*@editable*/color:#007C89;
								/*@editable*/font-weight:normal;
								/*@editable*/text-decoration:underline;
							}
						/*
						@tab Footer
						@section Footer Style
						@tip Set the background color and borders for your email's footer area.
						*/
							#templateFooter{
								/*@editable*/background-color:#FAFAFA;
								/*@editable*/background-image:none;
								/*@editable*/background-repeat:no-repeat;
								/*@editable*/background-position:center;
								/*@editable*/background-size:cover;
								/*@editable*/border-top:0;
								/*@editable*/border-bottom:0;
								/*@editable*/padding-top:9px;
								/*@editable*/padding-bottom:9px;
							}
						/*
						@tab Footer
						@section Footer Text
						@tip Set the styling for your email's footer text. Choose a size and color that is easy to read.
						*/
							#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
								/*@editable*/color:#656565;
								/*@editable*/font-family:Helvetica;
								/*@editable*/font-size:12px;
								/*@editable*/line-height:150%;
								/*@editable*/text-align:center;
							}
						/*
						@tab Footer
						@section Footer Link
						@tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
						*/
							#templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{
								/*@editable*/color:#656565;
								/*@editable*/font-weight:normal;
								/*@editable*/text-decoration:underline;
							}
						@media only screen and (min-width:768px){
							.templateContainer{
								width:600px !important;
							}
					
					}	@media only screen and (max-width: 480px){
							body,table,td,p,a,li,blockquote{
								-webkit-text-size-adjust:none !important;
							}
					
					}	@media only screen and (max-width: 480px){
							body{
								width:100% !important;
								min-width:100% !important;
							}
					
					}	@media only screen and (max-width: 480px){
							.mcnRetinaImage{
								max-width:100% !important;
							}
					
					}	@media only screen and (max-width: 480px){
							.mcnImage{
								width:100% !important;
							}
					
					}	@media only screen and (max-width: 480px){
							.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
								max-width:100% !important;
								width:100% !important;
							}
					
					}	@media only screen and (max-width: 480px){
							.mcnBoxedTextContentContainer{
								min-width:100% !important;
							}
					
					}	@media only screen and (max-width: 480px){
							.mcnImageGroupContent{
								padding:9px !important;
							}
					
					}	@media only screen and (max-width: 480px){
							.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
								padding-top:9px !important;
							}
					
					}	@media only screen and (max-width: 480px){
							.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
								padding-top:18px !important;
							}
					
					}	@media only screen and (max-width: 480px){
							.mcnImageCardBottomImageContent{
								padding-bottom:9px !important;
							}
					
					}	@media only screen and (max-width: 480px){
							.mcnImageGroupBlockInner{
								padding-top:0 !important;
								padding-bottom:0 !important;
							}
					
					}	@media only screen and (max-width: 480px){
							.mcnImageGroupBlockOuter{
								padding-top:9px !important;
								padding-bottom:9px !important;
							}
					
					}	@media only screen and (max-width: 480px){
							.mcnTextContent,.mcnBoxedTextContentColumn{
								padding-right:18px !important;
								padding-left:18px !important;
							}
					
					}	@media only screen and (max-width: 480px){
							.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
								padding-right:18px !important;
								padding-bottom:0 !important;
								padding-left:18px !important;
							}
					
					}	@media only screen and (max-width: 480px){
							.mcpreview-image-uploader{
								display:none !important;
								width:100% !important;
							}
					
					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Heading 1
						@tip Make the first-level headings larger in size for better readability on small screens.
						*/
							h1{
								/*@editable*/font-size:22px !important;
								/*@editable*/line-height:125% !important;
							}
					
					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Heading 2
						@tip Make the second-level headings larger in size for better readability on small screens.
						*/
							h2{
								/*@editable*/font-size:20px !important;
								/*@editable*/line-height:125% !important;
							}
					
					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Heading 3
						@tip Make the third-level headings larger in size for better readability on small screens.
						*/
							h3{
								/*@editable*/font-size:18px !important;
								/*@editable*/line-height:125% !important;
							}
					
					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Heading 4
						@tip Make the fourth-level headings larger in size for better readability on small screens.
						*/
							h4{
								/*@editable*/font-size:16px !important;
								/*@editable*/line-height:150% !important;
							}
					
					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Boxed Text
						@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
						*/
							.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
								/*@editable*/font-size:14px !important;
								/*@editable*/line-height:150% !important;
							}
					
					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Preheader Visibility
						@tip Set the visibility of the email's preheader on small screens. You can hide it to save space.
						*/
							#templatePreheader{
								/*@editable*/display:block !important;
							}
					
					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Preheader Text
						@tip Make the preheader text larger in size for better readability on small screens.
						*/
							#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
								/*@editable*/font-size:14px !important;
								/*@editable*/line-height:150% !important;
							}
					
					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Header Text
						@tip Make the header text larger in size for better readability on small screens.
						*/
							#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
								/*@editable*/font-size:16px !important;
								/*@editable*/line-height:150% !important;
							}
					
					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Body Text
						@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
						*/
							#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
								/*@editable*/font-size:16px !important;
								/*@editable*/line-height:150% !important;
							}
					
					}	@media only screen and (max-width: 480px){
						/*
						@tab Mobile Styles
						@section Footer Text
						@tip Make the footer content text larger in size for better readability on small screens.
						*/
							#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
								/*@editable*/font-size:14px !important;
								/*@editable*/line-height:150% !important;
							}
					
					}</style></head>
						<body>
							<!--*|IF:MC_PREVIEW_TEXT|*-->
							<!--[if !gte mso 9]><!----><span class='mcnPreviewText' style='display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;'>*|MC_PREVIEW_TEXT|*</span><!--<![endif]-->
							<!--*|END:IF|*-->
							<center>
								<table align='center' border='0' cellpadding='0' cellspacing='0' height='100%' width='100%' id='bodyTable'>
									<tr>
										<td align='center' valign='top' id='bodyCell'>
											<!-- BEGIN TEMPLATE // -->
											<table border='0' cellpadding='0' cellspacing='0' width='100%'>
												<tr>
													<td align='center' valign='top' id='templatePreheader'>
														<!--[if (gte mso 9)|(IE)]>
														<table align='center' border='0' cellspacing='0' cellpadding='0' width='600' style='width:600px;'>
														<tr>
														<td align='center' valign='top' width='600' style='width:600px;'>
														<![endif]-->
														<table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' class='templateContainer'>
															<tr>
																<td valign='top' class='preheaderContainer'><table class='mcnTextBlock' style='min-width:100%;' width='100%' cellspacing='0' cellpadding='0' border='0'>
						<tbody class='mcnTextBlockOuter'>
							<tr>
								<td class='mcnTextBlockInner' style='padding-top:9px;' valign='top'>
									  <!--[if mso]>
									<table align='left' border='0' cellspacing='0' cellpadding='0' width='100%' style='width:100%;'>
									<tr>
									<![endif]-->
									
									<!--[if mso]>
									<td valign='top' width='600' style='width:600px;'>
									<![endif]-->
									<table style='max-width:100%; min-width:100%;' class='mcnTextContentContainer' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
										<tbody><tr>
											
											<td class='mcnTextContent' style='padding: 0px 18px 9px; text-align: center;' valign='top'>
											
												<a href='*|ARCHIVE|*' target='_blank'>View this email in your browser</a>
											</td>
										</tr>
									</tbody></table>
									<!--[if mso]>
									</td>
									<![endif]-->
									
									<!--[if mso]>
									</tr>
									</table>
									<![endif]-->
								</td>
							</tr>
						</tbody>
					</table></td>
															</tr>
														</table>
														<!--[if (gte mso 9)|(IE)]>
														</td>
														</tr>
														</table>
														<![endif]-->
													</td>
												</tr>
												<tr>
													<td align='center' valign='top' id='templateHeader'>
														<!--[if (gte mso 9)|(IE)]>
														<table align='center' border='0' cellspacing='0' cellpadding='0' width='600' style='width:600px;'>
														<tr>
														<td align='center' valign='top' width='600' style='width:600px;'>
														<![endif]-->
														<table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' class='templateContainer'>
															<tr>
																<td valign='top' class='headerContainer'><table class='mcnImageBlock' style='min-width:100%;' width='100%' cellspacing='0' cellpadding='0' border='0'>
						<tbody class='mcnImageBlockOuter'>
								<tr>
									<td style='padding:9px' class='mcnImageBlockInner' valign='top'>
										<table class='mcnImageContentContainer' style='min-width:100%;' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
											<tbody><tr>
												<td class='mcnImageContent' style='padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;' valign='top'>
													
														
															<img alt='' src='https://mcusercontent.com/e43e04a7b435eefdf1d314db1/images/fa0d5bae-4e80-8554-792a-ef26e79fefad.png' style='max-width:100px; padding-bottom: 0; display: inline !important; vertical-align: bottom;' class='mcnImage' width='100' align='middle'>
														
													
												</td>
											</tr>
										</tbody></table>
									</td>
								</tr>
						</tbody>
					</table></td>
															</tr>
														</table>
														<!--[if (gte mso 9)|(IE)]>
														</td>
														</tr>
														</table>
														<![endif]-->
													</td>
												</tr>
												<tr>
													<td align='center' valign='top' id='templateBody'>
														<!--[if (gte mso 9)|(IE)]>
														<table align='center' border='0' cellspacing='0' cellpadding='0' width='600' style='width:600px;'>
														<tr>
														<td align='center' valign='top' width='600' style='width:600px;'>
														<![endif]-->
														<table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' class='templateContainer'>
															<tr>
																<td valign='top' class='bodyContainer'><table class='mcnTextBlock' style='min-width:100%;' width='100%' cellspacing='0' cellpadding='0' border='0'>
						<tbody class='mcnTextBlockOuter'>
							<tr>
								<td class='mcnTextBlockInner' style='padding-top:9px;' valign='top'>
									  <!--[if mso]>
									<table align='left' border='0' cellspacing='0' cellpadding='0' width='100%' style='width:100%;'>
									<tr>
									<![endif]-->
									
									<!--[if mso]>
									<td valign='top' width='600' style='width:600px;'>
									<![endif]-->
									<table style='max-width:100%; min-width:100%;' class='mcnTextContentContainer' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
										<tbody><tr>
											
											<td class='mcnTextContent' style='padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;' valign='top'>
											
												<h1 style='text-align: center;'><strong>Bienvenido a Link Op</strong><br>
					ahora podrás estar enterado de los productos y gadgets más interesantes en el mundo de la tecnología. Gracias.</h1>
					
					<p>&nbsp;</p>
					
											</td>
										</tr>
									</tbody></table>
									<!--[if mso]>
									</td>
									<![endif]-->
									
									<!--[if mso]>
									</tr>
									</table>
									<![endif]-->
								</td>
							</tr>
						</tbody>
					</table></td>
															</tr>
														</table>
														<!--[if (gte mso 9)|(IE)]>
														</td>
														</tr>
														</table>
														<![endif]-->
													</td>
												</tr>
												<tr>
													<td align='center' valign='top' id='templateFooter'>
														<!--[if (gte mso 9)|(IE)]>
														<table align='center' border='0' cellspacing='0' cellpadding='0' width='600' style='width:600px;'>
														<tr>
														<td align='center' valign='top' width='600' style='width:600px;'>
														<![endif]-->
														<table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' class='templateContainer'>
															<tr>
																<td valign='top' class='footerContainer'><table class='mcnFollowBlock' style='min-width:100%;' width='100%' cellspacing='0' cellpadding='0' border='0'>
						<tbody class='mcnFollowBlockOuter'>
							<tr>
								<td style='padding:9px' class='mcnFollowBlockInner' valign='top' align='center'>
									<table class='mcnFollowContentContainer' style='min-width:100%;' width='100%' cellspacing='0' cellpadding='0' border='0'>
						<tbody><tr>
							<td style='padding-left:9px;padding-right:9px;' align='center'>
								<table style='min-width:100%;' class='mcnFollowContent' width='100%' cellspacing='0' cellpadding='0' border='0'>
									<tbody><tr>
										<td style='padding-top:9px; padding-right:9px; padding-left:9px;' valign='top' align='center'>
											<table cellspacing='0' cellpadding='0' border='0' align='center'>
												<tbody><tr>
													<td valign='top' align='center'>
														<!--[if mso]>
														<table align='center' border='0' cellspacing='0' cellpadding='0'>
														<tr>
														<![endif]-->
														
															<!--[if mso]>
															<td align='center' valign='top'>
															<![endif]-->
															
															
																<table style='display:inline;' cellspacing='0' cellpadding='0' border='0' align='left'>
																	<tbody><tr>
																		<td style='padding-right:10px; padding-bottom:9px;' class='mcnFollowContentItemContainer' valign='top'>
																			<table class='mcnFollowContentItem' width='100%' cellspacing='0' cellpadding='0' border='0'>
																				<tbody><tr>
																					<td style='padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;' valign='middle' align='left'>
																						<table width='' cellspacing='0' cellpadding='0' border='0' align='left'>
																							<tbody><tr>
																								
																									<td class='mcnFollowIconContent' width='24' valign='middle' align='center'>
																										<a href='http://www.facebook.com/Linkopmexico' target='_blank'><img src='https://cdn-images.mailchimp.com/icons/social-block-v2/color-facebook-48.png' alt='Facebook' style='display:block;' class='' width='24' height='24'></a>
																									</td>
																								
																								
																							</tr>
																						</tbody></table>
																					</td>
																				</tr>
																			</tbody></table>
																		</td>
																	</tr>
																</tbody></table>
															
															<!--[if mso]>
															</td>
															<![endif]-->
														
															<!--[if mso]>
															<td align='center' valign='top'>
															<![endif]-->
															
															
																<table style='display:inline;' cellspacing='0' cellpadding='0' border='0' align='left'>
																	<tbody><tr>
																		<td style='padding-right:0; padding-bottom:9px;' class='mcnFollowContentItemContainer' valign='top'>
																			<table class='mcnFollowContentItem' width='100%' cellspacing='0' cellpadding='0' border='0'>
																				<tbody><tr>
																					<td style='padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;' valign='middle' align='left'>
																						<table width='' cellspacing='0' cellpadding='0' border='0' align='left'>
																							<tbody><tr>
																								
																									<td class='mcnFollowIconContent' width='24' valign='middle' align='center'>
																										<a href='https://linkop.com.mx/' target='_blank'><img src='https://cdn-images.mailchimp.com/icons/social-block-v2/color-link-48.png' alt='Website' style='display:block;' class='' width='24' height='24'></a>
																									</td>
																								
																								
																							</tr>
																						</tbody></table>
																					</td>
																				</tr>
																			</tbody></table>
																		</td>
																	</tr>
																</tbody></table>
															
															<!--[if mso]>
															</td>
															<![endif]-->
														
														<!--[if mso]>
														</tr>
														</table>
														<![endif]-->
													</td>
												</tr>
											</tbody></table>
										</td>
									</tr>
								</tbody></table>
							</td>
						</tr>
					</tbody></table>
					
								</td>
							</tr>
						</tbody>
					</table><table class='mcnDividerBlock' style='min-width:100%;' width='100%' cellspacing='0' cellpadding='0' border='0'>
						<tbody class='mcnDividerBlockOuter'>
							<tr>
								<td class='mcnDividerBlockInner' style='min-width: 100%; padding: 10px 18px 25px;'>
									<table class='mcnDividerContent' style='min-width: 100%;border-top: 2px solid #EEEEEE;' width='100%' cellspacing='0' cellpadding='0' border='0'>
										<tbody><tr>
											<td>
												<span></span>
											</td>
										</tr>
									</tbody></table>
					<!--            
									<td class='mcnDividerBlockInner' style='padding: 18px;'>
									<hr class='mcnDividerContent' style='border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;' />
					-->
								</td>
							</tr>
						</tbody>
					</table></td>
															</tr>
														</table>
														<!--[if (gte mso 9)|(IE)]>
														</td>
														</tr>
														</table>
														<![endif]-->
													</td>
												</tr>
											</table>
											<!-- // END TEMPLATE -->
										</td>
									</tr>
								</table>
							</center>
						<script type='text/javascript'  src='/B-BCXngC7M/1L4K/PQbNmd/p7Q5SzkGru/CiMWKzkB/QDM/9ZHd-aEs'></script></body>
					</html>
					");

					$envio = $mail->Send();

					if(!$envio){

						echo '<script> 

							swal({
								  title: "¡ERROR!",
								  text: "¡Ha ocurrido un problema enviando el mensaje!",
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},

								function(isConfirm){

									if(isConfirm){
										history.back();
									}
							});

						</script>';

					}else{
						$tabla = "suscripcion";
						$datos = array("nombre"=>"SUSCRIPCION",
						"email"=>$_POST['emailContactenos']
					);
						 ModeloUsuarios::mdlRegistroUsuarioSub($tabla, $datos );

						echo '<script> 

							swal({
							  title: "¡OK!",
							  text: "¡Su mensaje ha sido enviado, muy pronto le responderemos!",
							  type: "success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){
									 if (isConfirm) {	  
											history.back();
										}
							});

						</script>';

					}

			

		}

	}

}