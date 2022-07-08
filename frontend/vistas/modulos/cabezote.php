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


	<br>
	<style>
		.pull-right>.dropdown-menu {
			right: 0;
			left: auto;
		}

		.dropup .caret,
		.navbar-fixed-bottom .dropdown .caret {
			border-top: 0;
			border-bottom: 4px solid #000000;
			content: "";
		}

		.dropup .dropdown-menu,
		.navbar-fixed-bottom .dropdown .dropdown-menu {
			top: auto;
			bottom: 100%;
			margin-bottom: 1px;
		}


		.dropdown-submenu>.dropdown-menu {
			top: 0;
			left: 100%;
			margin-top: -6px;
			margin-left: -1px;
			-webkit-border-radius: 0 6px 6px 6px;
			-moz-border-radius: 0 6px 6px 6px;
			border-radius: 0 6px 6px 6px;
		}

		.dropdown-submenu:hover>.dropdown-menu {
			display: block;
		}

		.dropup .dropdown-submenu>.dropdown-menu {
			top: auto;
			bottom: 0;
			margin-top: 0;
			margin-bottom: -2px;
			-webkit-border-radius: 5px 5px 5px 0;
			-moz-border-radius: 5px 5px 5px 0;
			border-radius: 5px 5px 5px 0;
		}

		.dropdown-submenu>a:after {
			display: block;
			float: right;
			width: 0;
			height: 0;
			margin-top: 5px;
			margin-right: -10px;
			border-color: transparent;
			border-left-color: #cccccc;
			border-style: solid;
			border-width: 5px 0 5px 5px;
			content: " ";
		}

		.dropdown-submenu:hover>a:after {
			border-left-color: #ffffff;
		}

		.dropdown-submenu.pull-left {
			float: none;
		}

		.dropdown-submenu.pull-left>.dropdown-menu {
			left: -100%;
			margin-left: 10px;
			-webkit-border-radius: 6px 0 6px 6px;
			-moz-border-radius: 6px 0 6px 6px;
			border-radius: 6px 0 6px 6px;
		}


		.navbar .nav li.dropdown>a:hover .caret,
		.navbar .nav li.dropdown>a:focus .caret {
			border-top-color: #333333;
			border-bottom-color: #333333;
		}

		.navbar .nav li.dropdown.open>.dropdown-toggle,
		.navbar .nav li.dropdown.active>.dropdown-toggle,
		.navbar .nav li.dropdown.open.active>.dropdown-toggle {
			color: #555555;
			background-color: #e5e5e5;
		}

		.navbar .nav li.dropdown>.dropdown-toggle .caret {
			border-top-color: #777777;
			border-bottom-color: #777777;
		}

		.navbar .nav li.dropdown.open>.dropdown-toggle .caret,
		.navbar .nav li.dropdown.active>.dropdown-toggle .caret,
		.navbar .nav li.dropdown.open.active>.dropdown-toggle .caret {
			border-top-color: #555555;
			border-bottom-color: #555555;
		}

		.navbar .pull-right>li>.dropdown-menu,
		.navbar .nav>li>.dropdown-menu.pull-right {
			right: 0;
			left: auto;
		}

		.navbar .pull-right>li>.dropdown-menu:before,
		.navbar .nav>li>.dropdown-menu.pull-right:before {
			right: 12px;
			left: auto;
		}

		.navbar .pull-right>li>.dropdown-menu:after,
		.navbar .nav>li>.dropdown-menu.pull-right:after {
			right: 13px;
			left: auto;
		}

		.navbar .pull-right>li>.dropdown-menu .dropdown-menu,
		.navbar .nav>li>.dropdown-menu.pull-right .dropdown-menu {
			right: 100%;
			left: auto;
			margin-right: -1px;
			margin-left: 0;
			-webkit-border-radius: 6px 0 6px 6px;
			-moz-border-radius: 6px 0 6px 6px;
			border-radius: 6px 0 6px 6px;
		}
	</style>

	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">

			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="<?php echo $url; ?>">

					<img src="<?php echo $servidor . $social["logo"]; ?>" class="img-responsive text-center" style="width:150px;padding-top:10px;">

				</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				
				<ul class="nav navbar-nav">
					<li class=""><a href="<?php echo $url; ?>">HOME</a></li>

					<!-- <li class="dropdown" id="productos">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false ">PRODUCTOS <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu" id="listaProductos">
							<?php

							/* $item = null;
							$valor = null;

							$categorias = ControladorProductos::ctrMostrarCategorias($item, $valor);

							foreach ($categorias as $key => $value) {
								
								$item = "id_categoria";

								$valor = $value["id"];





								echo '<li><a href="' . $url . $value["ruta"] . '" class="pixelSubCategorias " titulo="' . $value["categoria"] . '">' . $value["categoria"] . '</a></li>';

							
							}


 */


							?>

						</ul>
					</li>
 -->
					<ul class="nav navbar-nav">
						<li class="menu-item dropdown">
							<a href="#" class="dropdown-toggle" id="productos" data-toggle="dropdown">PRODUCTOS <b class="caret"></b></a>
							<ul class="dropdown-menu" id="listaProductos">


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





									echo '<li class="menu-item dropdown dropdown-submenu"><a href="' . $url . $value["ruta"] . '" class="dropdown-toggle" data-toggle="dropdown">' . $value["categoria"] . '</a>
								<ul class="dropdown-menu">
								';

									$subcategorias = ControladorProductos::ctrMostrarSubCategorias($item, $valor);

									foreach ($subcategorias as $key => $value) {

										echo '
									
									
									
									<li class="menu-item "><a href="' . $url . $value["ruta"] . '"  titulo="' . $value["subcategoria"] . '">' . $value["subcategoria"] . '</a></li>';
									}
									echo '</ul></li>';
								}





								?>



							</ul>
						</li>
					</ul>

					<!-- <li><a href="<?php echo $url; ?>categorias">CATEGORIAS</a></li>

					<li><a href=" <?php echo $url; ?>ofertas">OFERTAS</a></li> -->
					<li><a href=" <?php echo $url; ?>postblog">BLOG</a></li>
					<li><a href=" <?php echo $url; ?>contacto">CONTACTO</a></li>

				</ul>
				<ul class=" nav navbar-nav navbar-CENTER">


				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li>
						<div class="" id="buscador">





							<div class="input-group input-group-md" style="padding-top:6px; ">
								<input type="search" name="buscar" class="form-control" placeholder="Buscar...">

								<span class="input-group-btn">
									<a href="<?php echo $url; ?>buscador/1/recientes" style="color: black;">

										<!-- <button class="btn btn-default " type="submit" style="padding:5px">
										<img src="<?php echo $servidor; ?>vistas/img/plantilla/lupa.png" class=" text-center " style="width: 23px;padding-top:-12px; ">

											<i class="fa fa-search"></i>

										</button> -->

									</a>
								</span>
							</div>
						</div>
					</li>
					<!-- 	<li><a href="<?php #echo $url; 
											?>buscador/1/recientes" style="color: black;padding-top:10px;">

							<button class="btn btn-default " type="submit">

								<i class="fa fa-search"></i>

							</button>

						</a></li> -->
					<li class="dropdown notifications-menu ">

						<a href="<?php echo $url; ?>carrito-de-compras" style="color: black; " id="">

							<!-- <i class="fa fa-shopping-bag" aria-hidden="true"></i> -->

							<img src="<?php echo $servidor; ?>vistas/img/plantilla/12_full cart.png" class=" text-center " style="width: 30px;padding-top:-12px; ">




							<span class="label label-info cantidadCesta text-rigth"></span>



						</a>
						<!-- 			<i class="fa fa-clock-o"></i><span class="cantidadCesta"></span> -->
						<!-- <p>TU CESTA  <br> MXN $ <span class="sumaCesta"></span></p>  ds-->
					</li>
					<li class="dropdown user user-menu" id="usermenu">

						<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;">

							<!-- <i class="fa fa-user" aria-hidden="true"></i> -->
							<img src="<?php echo $servidor; ?>vistas/img/plantilla/08_member.png" style="width: 30px; padding-top:-12px;">
							<!-- <span class="label label-info sumaCesta text-rigth" ></span>	 -->

						</a>
						<ul class="dropdown-menu" id="productsmenu">

							<?php

							if (isset($_SESSION["validarSesion"])) {

								if ($_SESSION["validarSesion"] == "ok") {

									if ($_SESSION["modo"] == "directo" ||$_SESSION["modo"] == "invitado"  ) {

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

												

											</li>
											
												<li><a href="' . $url . 'perfil">Ver Perfil</a></li>
												
												<li><a href="' . $url . 'salir" class="salir">Salir</a></li>';
									}

									if ($_SESSION["modo"] == "google") {

										echo '<li>

												

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
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
		<?php
$mensaje = ControladorPlantilla::ctrMensajes();

if (isset($_SESSION["validarSesion"])) {
/* 	echo '<div class="alert alert-primary text-center" style="background-color: #030F24;margin-bottom: 0px;" role="alert">
	<strong style="color:white"> '. $mensaje["mensaje2"] .' </strong>
</div>'; */
$respuesta = $mensaje["mensaje2"] != null ? '<div class="alert alert-primary text-center" style="background-color: #030F24;margin-bottom: 0px;" role="alert">
<strong style="color:white"> '.$mensaje["mensaje2"].'  <a href="#modalRegistro" data-toggle="modal"></a> </strong>
</div>
</nav>
</header>
<br><br> ' : '</nav>
</header>
<br><br>';
echo $respuesta;
} else {

?>


<?php 
$respuesta1 = $mensaje["mensaje"] != null ? '<div class="alert alert-primary text-center" style="background-color: #030F24;margin-bottom: 0px;" role="alert">
<strong style="color:white"> '.$mensaje["mensaje"].'  <a href="#modalRegistro" data-toggle="modal">REGISTRARSE</a> </strong>
</div></nav>
</header>
<br><br><br><br>' : '</nav>
</header>
<br><br>';
echo $respuesta1;
?>
	

<?php


}

?>
	
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
VENTANA MODAL PARA EL REGISTRO
======================================-->


<div class="modal fade modalFormulario" id="modalRegistroInvitado" role="dialog">

	<div class="modal-content modal-dialog">

		<div class="modal-body modalTitulo">

			<h3 class="backColor">INVITADO</h3>

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			<!--=====================================
			REGISTRO FACEBOOK
			======================================-->

		<!-- 	<div class="col-sm-6 col-xs-12 facebook">

				<p>
					<i class="fa fa-facebook"></i>
					Registro con Facebook
				</p>

			</div> -->

			<!--=====================================
			REGISTRO GOOGLE
			======================================-->
			<!-- <a href="<?php #echo $rutaGoogle; ?>">

				<div class="col-sm-6 col-xs-12 google">

					<p>
						<i class="fa fa-google"></i>
						Registro con Google
					</p>

				</div>
			</a> -->

			<!--=====================================
			REGISTRO DIRECTO
			======================================-->

			<form method="post" onsubmit="return registroUsuarioInvitado()">

				<hr>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-user"></i>

						</span>

						<input type="text" class="form-control text-uppercase" id="regUsuario1" name="regUsuario1" placeholder="Nombre Completo" required>

					</div>

				</div>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-envelope"></i>

						</span>

						<input type="email" class="form-control" id="regEmail1" name="regEmail1" placeholder="Correo Electrónico" required>

					</div>

				</div>
<!-- 
				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-lock"></i>

						</span>

						<input type="password" class="form-control" id="regPassword" name="regPassword" placeholder="Contraseña" required>

					</div>

				</div> -->

				<!--=====================================
				https://www.iubenda.com/ CONDICIONES DE USO Y POLÍTICAS DE PRIVACIDAD
				======================================-->

				<div class="checkBox">

					<label>

						<input id="regPoliticas1" type="checkbox">

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
				$registro->ctrRegistroUsuarioInvitado();

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
				<br><br>
				<center><strong><a href="#modalRegistroInvitado" data-dismiss="modal"  class="btn btn-default backColor btn-block " data-toggle="modal">COMPRAR COMO INVITADO</a></strong></center>

			</form>

		</div>

		<div class="modal-footer">

			¿No tienes una cuenta registrada? | <strong><a href="#modalRegistro" data-dismiss="modal" data-toggle="modal">Registrarse</a></strong>

		</div>

	</div>

</div>






<!--=====================================
VENTANA MODAL PARA EL COSTO DE ENVIO
======================================-->

<div class="modal fade modalFormulario" id="modalIngreso1" role="dialog">

	<div class="modal-content modal-dialog">

		<div class="modal-body modalTitulo">

			<h3 class="">ENVIO DHL</h3>

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			

			<!--=====================================
			INGRESO DIRECTO
			======================================-->

			<form method="post" action="vistas/modulos/logi_etiq_dhl7.php" >

				<hr>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-envelope"></i>

						</span>

						<input type="number" class="form-control" id="cp" name="cp" placeholder="Codigo Postal" required>

					</div>
						<input type="hidden" class="form-control" id="kg" name="kg"  >

				</div>

				



			

				<input type="submit" class="btn btn-default backColor btn-block btnIngreso" value="ENVIAR">

				<br>


			</form>

		</div>

		<div class="modal-footer">

			<!-- ¿No tienes una cuenta registrada? | <strong><a href="#modalRegistro" data-dismiss="modal" data-toggle="modal">Registrarse</a></strong> -->

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