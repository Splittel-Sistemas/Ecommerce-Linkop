<?php

$servidor = Ruta::ctrRutaServidor();
$url = Ruta::ctrRuta();

/*=============================================
INICIO DE SESIÓN USUARIO
=============================================*/

if (isset($_SESSION["validarSesion"])) {

	if ($_SESSION["validarSesion"] == "ok") {

		echo '<script>
		
			localStorage.setItem("usuario","' . $_SESSION["id"] . '");

		</script>';
	}
}

/*=============================================
API DE GOOGLE
=============================================*/

// https://console.developers.google.com/apis
// https://github.com/google/google-api-php-client

/*=============================================
CREAR EL OBJETO DE LA API GOOGLE
=============================================*/

$cliente = new Google_Client();
$cliente->setAuthConfig('modelos/client_secret.json');
$cliente->setAccessType("offline");
$cliente->setScopes(['profile', 'email']);

/*=============================================
RUTA PARA EL LOGIN DE GOOGLE
=============================================*/

$rutaGoogle = $cliente->createAuthUrl();

/*=============================================
RECIBIMOS LA VARIABLE GET DE GOOGLE LLAMADA CODE
=============================================*/

if (isset($_GET["code"])) {

	$token = $cliente->authenticate($_GET["code"]);

	$_SESSION['id_token_google'] = $token;

	$cliente->setAccessToken($token);
}

/*=============================================
RECIBIMOS LOS DATOS CIFRADOS DE GOOGLE EN UN ARRAY
=============================================*/
$social = ControladorPlantilla::ctrEstiloPlantilla();

if ($cliente->getAccessToken()) {

	$item = $cliente->verifyIdToken();

	$datos = array(
		"nombre" => $item["name"],
		"email" => $item["email"],
		"foto" => $item["picture"],
		"password" => "null",
		"modo" => "google",
		"verificacion" => 0,
		"emailEncriptado" => "null"
	);

	$respuesta = ControladorUsuarios::ctrRegistroRedesSociales($datos);

	echo '<script>
		
	setTimeout(function(){

		window.location = localStorage.getItem("rutaActual");

	},1000);

 	</script>';
}

?>

<!--=====================================
TOP
======================================-->


<!--=====================================
HEADER 
======================================-->

<header class="container-fluid">

	<?php

	if (isset($_SESSION["validarSesion"])) {
	} else {

	?>

		<!-- REGISTRATE -->
		<div class="alert alert-warning   alert-dismissible fade in text-center" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Regístrate y recíbe un 15% de descuento en tu primer compra. <a href="#modalRegistro" data-toggle="modal">REGISTRARSE</a> </strong>
		</div>


		<!-- FIN REGISTRATE -->
	<?php


	}

	?>
	<br>
	<nav class="navbar ">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>

			</div>

			<div class="container">

				<div class="row" id="navbar-collapse">
					<div class="col-md-2 text-center"> <a href="<?php echo $url; ?>">

							<img src="<?php echo $servidor . $social["logo"]; ?>" class="img-responsive">

						</a>

					</div>



					<div class="col-md-5">

						<a href="<?php echo $url; ?>" class=" btn  btn-rounded " id="boton" style="font-size: 12px;">
							INICIO</a>


						<a href="<?php echo $url; ?>categorias" class="dropdown btn  btn-rounded" id="productos" name="productos" style="font-size: 12px;">
							PRODUCTOS
							<ul class="dropdown-menu" role="menu" id="listaProductosa">
								<?php

								$item = null;
								$valor = null;

								$categorias = ControladorProductos::ctrMostrarCategorias($item, $valor);

								foreach ($categorias as $key => $value) {
																/* 
								echo '<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 ">

										<h4>
										<a href="' . $url . $value["ruta"] . '" class="pixelCategorias backColor " titulo="' . $value["categoria"] . '">
										<img  src="' . $servidor . $value["imgOferta"] . '" width="70%"><br>
										' . $value["categoria"] . '</a>
										</h4>

										<hr>

										<ul>'; */
																/* 			<img  src="' . $servidor . $value["imgOferta"] . '" width="70%">
										' . $value["categoria"] . '</a> */
									$item = "id_categoria";

									$valor = $value["id"];




									echo '<li><a href="' . $url . $value["ruta"] . '" class="pixelSubCategorias " titulo="' . $value["categoria"] . '">' . $value["categoria"] . '</a></li>';;
								}





								?>
							</ul>
						</a>


						<a href="<?php echo $url; ?>ofertas" class="btn  btn-rounded" id="boton" style="font-size: 12px;">
							OFERTAS</a>

						<a href="<?php echo $url; ?>" class="btn  btn-rounded" id="boton" style="font-size: 12px;">
							CONTACTO</a>


						<a href="<?php echo $url; ?>vistas/modulos/blog.php" class="btn  btn-rounded" id="boton" style="font-size: 12px;">
							BLOG</a>
					</div>
					<div class="col-md-3" id="buscador">
						<input type="search" name="buscar" class="form-control" placeholder="Buscar...">

						<a href="<?php echo $url; ?>buscador/1/recientes" style="color: black;">

							<!-- <button class="btn btn-default backColor" type="submit">

									<i class="fa fa-search"></i>

								</button> -->

						</a>

					</div>

					<div class="col-md-1">
						<li class="dropdown notifications-menu ">

							<a href="<?php echo $url; ?>carrito-de-compras" style="color: black; " id="">

								<!-- <i class="fa fa-shopping-bag" aria-hidden="true"></i> -->

								<img src="<?php echo $servidor; ?>vistas/img/plantilla/shopping-cart.png" class=" text-center " style="width: 30px; ">




								<span class="label label-info cantidadCesta text-rigth"></span>



							</a>
							<!-- 			<i class="fa fa-clock-o"></i><span class="cantidadCesta"></span> -->
							<!-- <p>TU CESTA  <br> USD $ <span class="sumaCesta"></span></p> -->
						</li>
					</div>
					<div class="col-md-1">



						<li class="dropdown user user-menu" id="usermenu">

							<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;">

								<!-- <i class="fa fa-user" aria-hidden="true"></i> -->
								<img src="<?php echo $servidor; ?>vistas/img/plantilla/user(1).png" style="width: 30px;">
								<!-- <span class="label label-info sumaCesta text-rigth" ></span>	 -->

							</a>
							<ul class="dropdown-menu" id="productsmenu">

								<?php

								if (isset($_SESSION["validarSesion"])) {

									if ($_SESSION["validarSesion"] == "ok") {

										if ($_SESSION["modo"] == "directo") {

											/* if ($_SESSION["foto"] != "") {

														echo '<li>

												<img class="img-circle" src="' . $url . $_SESSION["foto"] . '" width="25%">

											</li>';
													} else {

														echo '<li>

											<img class="img-circle" src="' . $servidor . 'vistas/img/usuarios/default/anonymous.png" width="25%">

														</li>';
													} */

											echo '
										<li><a href="' . $url . 'perfil">Ver Perfil</a></li>
										
										<li><a href="' . $url . 'salir">Salir</a></li>';
										}

										if ($_SESSION["modo"] == "facebook") {

											echo '<li>

												<img class="img-circle" src="' . $_SESSION["foto"] . '" width="10%">

											</li>
											
												<li><a href="' . $url . 'perfil">Ver Perfil</a></li>
												
												<li><a href="' . $url . 'salir" class="salir">Salir</a></li>';
										}

										if ($_SESSION["modo"] == "google") {

											echo '<li>

												<img class="img-circle" src="' . $_SESSION["foto"] . '" width="10%">

											</li>
											
												<li><a href="' . $url . 'perfil">Ver Perfil</a></li>
												
												<li><a href="' . $url . 'salir">Salir</a></li>';
										}
									}
								} else {

									echo '<li><a href="#modalIngreso" data-toggle="modal">Ingresar</a></li>
									
									<li><a href="#modalRegistro" data-toggle="modal">Crear una cuenta</a></li>';
								}

								?>
							</ul>
						</li>
					</div>
				</div>
			</div>


		</div>

	</nav>


</header>

<!--=====================================
VENTANA MODAL PARA EL REGISTRO
======================================-->

<div class="modal fade modalFormulario" id="modalRegistro" role="dialog">

	<div class="modal-content modal-dialog">

		<div class="modal-body modalTitulo">

			<h3 class="backColor">REGISTRARSE</h3>

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			<!--=====================================
			REGISTRO FACEBOOK
			======================================-->

			<div class="col-sm-6 col-xs-12 facebook">

				<p>
					<i class="fa fa-facebook"></i>
					Registro con Facebook
				</p>

			</div>

			<!--=====================================
			REGISTRO GOOGLE
			======================================-->
			<a href="<?php echo $rutaGoogle; ?>">

				<div class="col-sm-6 col-xs-12 google">

					<p>
						<i class="fa fa-google"></i>
						Registro con Google
					</p>

				</div>
			</a>

			<!--=====================================
			REGISTRO DIRECTO
			======================================-->

			<form method="post" onsubmit="return registroUsuario()">

				<hr>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-user"></i>

						</span>

						<input type="text" class="form-control text-uppercase" id="regUsuario" name="regUsuario" placeholder="Nombre Completo" required>

					</div>

				</div>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-envelope"></i>

						</span>

						<input type="email" class="form-control" id="regEmail" name="regEmail" placeholder="Correo Electrónico" required>

					</div>

				</div>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-lock"></i>

						</span>

						<input type="password" class="form-control" id="regPassword" name="regPassword" placeholder="Contraseña" required>

					</div>

				</div>

				<!--=====================================
				https://www.iubenda.com/ CONDICIONES DE USO Y POLÍTICAS DE PRIVACIDAD
				======================================-->

				<div class="checkBox">

					<label>

						<input id="regPoliticas" type="checkbox">

						<small>

							Al registrarse, usted acepta nuestras condiciones de uso y políticas de privacidad

							<br>

							<a href="https://www.iubenda.com/privacy-policy/26778001" class="iubenda-white iubenda-noiframe iubenda-embed iubenda-noiframe " title="Política de Privacidad ">Política de Privacidad</a>
							<script type="text/javascript">
								(function(w, d) {
									var loader = function() {
										var s = d.createElement("script"),
											tag = d.getElementsByTagName("script")[0];
										s.src = "https://cdn.iubenda.com/iubenda.js";
										tag.parentNode.insertBefore(s, tag);
									};
									if (w.addEventListener) {
										w.addEventListener("load", loader, false);
									} else if (w.attachEvent) {
										w.attachEvent("onload", loader);
									} else {
										w.onload = loader;
									}
								})(window, document);
							</script>
						</small>

					</label>

				</div>

				<?php

				$registro = new ControladorUsuarios();
				$registro->ctrRegistroUsuario();

				?>

				<input type="submit" class="btn btn-default backColor btn-block" value="ENVIAR">

			</form>

		</div>

		<div class="modal-footer">

			¿Ya tienes una cuenta registrada? | <strong><a href="#modalIngreso" data-dismiss="modal" data-toggle="modal">Ingresar</a></strong>

		</div>

	</div>

</div>

<!--=====================================
VENTANA MODAL PARA EL INGRESO
======================================-->

<div class="modal fade modalFormulario" id="modalIngreso" role="dialog">

	<div class="modal-content modal-dialog">

		<div class="modal-body modalTitulo">

			<h3 class="backColor">INGRESAR</h3>

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			<!--=====================================
			INGRESO FACEBOOK
			======================================-->

			<div class="col-sm-6 col-xs-12 facebook">

				<p>
					<i class="fa fa-facebook"></i>
					Ingreso con Facebook
				</p>

			</div>

			<!--=====================================
			INGRESO GOOGLE
			======================================-->
			<a href="<?php echo $rutaGoogle; ?>">

				<div class="col-sm-6 col-xs-12 google">

					<p>
						<i class="fa fa-google"></i>
						Ingreso con Google
					</p>

				</div>

			</a>

			<!--=====================================
			INGRESO DIRECTO
			======================================-->

			<form method="post">

				<hr>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-envelope"></i>

						</span>

						<input type="email" class="form-control" id="ingEmail" name="ingEmail" placeholder="Correo Electrónico" required>

					</div>

				</div>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-lock"></i>

						</span>

						<input type="password" class="form-control" id="ingPassword" name="ingPassword" placeholder="Contraseña" required>

					</div>

				</div>



				<?php

				$ingreso = new ControladorUsuarios();
				$ingreso->ctrIngresoUsuario();

				?>

				<input type="submit" class="btn btn-default backColor btn-block btnIngreso" value="ENVIAR">

				<br>

				<center>

					<a href="#modalPassword" data-dismiss="modal" data-toggle="modal">¿Olvidaste tu contraseña?</a>

				</center>

			</form>

		</div>

		<div class="modal-footer">

			¿No tienes una cuenta registrada? | <strong><a href="#modalRegistro" data-dismiss="modal" data-toggle="modal">Registrarse</a></strong>

		</div>

	</div>

</div>


<!--=====================================
VENTANA MODAL PARA OLVIDO DE CONTRASEÑA
======================================-->

<div class="modal fade modalFormulario" id="modalPassword" role="dialog">

	<div class="modal-content modal-dialog">

		<div class="modal-body modalTitulo">

			<h3 class="backColor">SOLICITUD DE NUEVA CONTRASEÑA</h3>

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			<!--=====================================
			OLVIDO CONTRASEÑA
			======================================-->

			<form method="post">

				<label class="text-muted">Escribe el correo electrónico con el que estás registrado y allí te enviaremos una nueva contraseña:</label>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-envelope"></i>

						</span>

						<input type="email" class="form-control" id="passEmail" name="passEmail" placeholder="Correo Electrónico" required>

					</div>

				</div>

				<?php

				$password = new ControladorUsuarios();
				$password->ctrOlvidoPassword();

				?>

				<input type="submit" class="btn btn-default backColor btn-block" value="ENVIAR">

			</form>

		</div>

		<div class="modal-footer">

			¿No tienes una cuenta registrada? | <strong><a href="#modalRegistro" data-dismiss="modal" data-toggle="modal">Registrarse</a></strong>

		</div>

	</div>

</div>