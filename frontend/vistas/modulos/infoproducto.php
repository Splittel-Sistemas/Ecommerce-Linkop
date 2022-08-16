<?php

$servidor = Ruta::ctrRutaServidor();
$url = Ruta::ctrRuta();

?>

<!--=====================================
BREADCRUMB INFOPRODUCTOS
======================================-->
<br>
<div class="container-fluid well well-sm">

	<div class="container">

		<div class="row">

			<ul class="breadcrumb fondoBreadcrumb text-uppercase">

				<li><a href="<?php echo $url;  ?>">INICIO</a></li>
				<li class="active pagActiva"><?php echo $rutas[0] ?></li>

			</ul>

		</div>

	</div>

</div>

<!--=====================================
INFOPRODUCTOS
======================================-->
<div class="container-fluid infoproducto">

	<div class="container">

		<div class="row">

			<?php

			$item =  "ruta";
			$valor = $rutas[0];
			$infoproducto = ControladorProductos::ctrMostrarInfoProducto($item, $valor);

			$multimedia = json_decode($infoproducto["multimedia"], true);


			/*=============================================
				VISOR DE IMÁGENES
				=============================================*/

			if ($infoproducto["tipo"] == "fisico") {

				echo '<div class="col-md-5 col-sm-6 col-xs-12 visorImg">
						
							<figure class="visor">';

				if ($multimedia != null) {

					for ($i = 0; $i < count($multimedia); $i++) {

						echo '<img id="lupa' . ($i + 1) . '" class="img-thumbnail" src="' . $servidor . $multimedia[$i]["foto"] . '">';
					}

					echo '</figure>

								<div class="flexslider">
								  
								  <ul class="slides">';

					for ($i = 0; $i < count($multimedia); $i++) {

						echo '<li>
								     	<img value="' . ($i + 1) . '" class="img-thumbnail" src="' . $servidor . $multimedia[$i]["foto"] . '" alt="' . $infoproducto["titulo"] . '">
								    </li>';
					}
				}

				echo '</ul>

							</div>

						</div>';
			} else {

				/*=============================================
					VISOR DE VIDEO
					=============================================*/

				echo '<div class="col-sm-6 col-xs-12">
							
						<iframe class="videoPresentacion" src="https://www.youtube.com/embed/' . $infoproducto["multimedia"] . '?rel=0&autoplay=0" width="100%" frameborder="0" allowfullscreen></iframe>

					</div>';
			}

			?>

			<!--=====================================
			PRODUCTO
			======================================-->

			<?php

			if ($infoproducto["tipo"] == "fisico") {

				echo '<div class="col-md-7 col-sm-6 col-xs-12">';
			} else {

				echo '<div class="col-sm-6 col-xs-12">';
			}

			?>

			<!--=====================================
				REGRESAR A LA TIENDA
				======================================-->

			<div class="col-xs-6">

				<h6>

					<a href="javascript:history.back()" class="text-muted">

						<i class="fa fa-reply"></i> Continuar Comprando

					</a>

				</h6>

			</div>

			<!--=====================================
				COMPARTIR EN REDES SOCIALES
				======================================-->

			<div class="col-xs-6">

				<h6>

					<a class="dropdown-toggle pull-right text-muted" data-toggle="dropdown" href="">

						<i class="fa fa-plus"></i> Compartir

					</a>

					<ul class="dropdown-menu pull-right compartirRedes">

						<li>
							<p class="btnFacebook">
								<i class="fa fa-facebook"></i>
								Facebook
							</p>
						</li>

					</ul>

				</h6>

			</div>

			<div class="clearfix"></div>

			<!--=====================================
				ESPACIO PARA EL PRODUCTO
				======================================-->

			<?php

			echo '<div class="comprarAhora" style="display:none">


						<button class="btn btn-default backColor quitarItemCarrito" idProducto="' . $infoproducto["id"] . '" peso="' . $infoproducto["peso"] . '"></button>

						<p class="tituloCarritoCompra text-left">' . $infoproducto["titulo"] . '</p>';


			if ($infoproducto["oferta"] == 0) {

				echo '<input class="cantidadItem" value="1" tipo="' . $infoproducto["tipo"] . '" precio="' . $infoproducto["precio"] . '" idProducto="' . $infoproducto["id"] . '">

							<p class="subTotal' . $infoproducto["id"] . ' subtotales">
						
								<strong> $<span>' . $infoproducto["precio"] . '</span></strong>

							</p>

							<div class="sumaSubTotal"><span>' . $infoproducto["precio"] . '</span></div>';
			} else {

				echo '<input class="cantidadItem" value="1" tipo="' . $infoproducto["tipo"] . '" precio="' . $infoproducto["precioOferta"] . '" idProducto="' . $infoproducto["id"] . '">

							<p class="subTotal' . $infoproducto["id"] . ' subtotales">
						
								<strong> $<span>' . $infoproducto["precioOferta"] . '</span></strong>

							</p>

							<div class="sumaSubTotal"><span>' . $infoproducto["precioOferta"] . '</span></div>';
			}






			echo '</div>';

			/*=============================================
					TITULO
					=============================================*/

			if ($infoproducto["oferta"] == 0) {

				$fecha = date('Y-m-d');
				$fechaActual = strtotime('-30 day', strtotime($fecha));
				$fechaNueva = date('Y-m-d', $fechaActual);

				if ($fechaNueva > $infoproducto["fecha"]) {

					echo '<h1 class="text-muted text-uppercase">' . $infoproducto["titulo"] . '</h1>';
				} else {

					echo '<h1 class="text-muted text-uppercase">' . $infoproducto["titulo"] . '

							<br>

						

							</h1>';
				}
			} else {

				$fecha = date('Y-m-d');
				$fechaActual = strtotime('-30 day', strtotime($fecha));
				$fechaNueva = date('Y-m-d', $fechaActual);

				if ($fechaNueva > $infoproducto["fecha"]) {

					echo '<h1 class=" text-uppercase">' . $infoproducto["titulo"] . '

							<br>';

					if ($infoproducto["precio"] != 0) {

						/* 	echo '<small>
							
									<span class="label label-danger">' . $infoproducto["descuentoOferta"] . '% off</span>

								</small>'; */
					}

					echo '</h1>';
				} else {

					echo '<h1 class=" text-uppercase">' . $infoproducto["titulo"] . '

							<br>';

					if ($infoproducto["precio"] != 0) {

						/* echo '<small>
									<span class="label label-warning">Nuevo</span> 
									<span class="label label-warning">' . $infoproducto["descuentoOferta"] . '% off</span> 

								</small>'; */
					}

					echo '</h1>';
				}
			}
			/*=============================================
					precio
					=============================================*/

			if ($infoproducto["precio"] == 0) {

				echo '<h2 class="text-muted">GRATIS</h2>';
			} else {

				if ($infoproducto["oferta"] == 0) {

					echo '<h2 class="text-muted"> $' . $infoproducto["precio"] . '</h2>';
				} else {

					echo '<h2 class="text-muted">
		
										<span>
										
											<strong class="oferta"> $' . $infoproducto["precio"] . '</strong>
		
										</span>
		
										<span>
											
											$' . $infoproducto["precioOferta"] . ' 
										</span>
		
									</h2>';
				}
			}
			$cantidadCalificacion = 0;

			$datos = array(
				"idUsuario" => "",
				"idProducto" => $infoproducto["id"]
			);

			$comentarios = ControladorUsuarios::ctrMostrarComentariosPerfil($datos);



			$sumaCalificacion = 0;

			foreach ($comentarios as $key => $value) {

				if ($value["calificacion"] != 0) {

					$cantidadCalificacion++;

					$sumaCalificacion += $value["calificacion"];
				}
			}
			$promedio = $sumaCalificacion > 0 ? $promedio = round($sumaCalificacion / $cantidadCalificacion, 1) : 0;

			if ($promedio > 0) {
				echo '<li class=""> ' . $promedio . ' | ';

				if ($promedio >= 0 && $promedio < 0.5) {

					echo '<i class="fa fa-star-half-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 0.5 && $promedio < 1) {

					echo '<i class="fa fa-star text-info"></i>
								  <i class="fa fa-star-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 1 && $promedio < 1.5) {

					echo '<i class="fa fa-star text-info"></i>
								  <i class="fa fa-star-half-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 1.5 && $promedio < 2) {

					echo '<i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 2 && $promedio < 2.5) {

					echo '<i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star-half-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 2.5 && $promedio < 3) {

					echo '<i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 3 && $promedio < 3.5) {

					echo '<i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star-half-o text-info"></i>
								  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 3.5 && $promedio < 4) {

					echo '<i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 4 && $promedio < 4.5) {

					echo '<i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star-half-o text-info"></i>';
				} else {

					echo '<i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>
								  <i class="fa fa-star text-info"></i>';
				}
			}



			/*=============================================
					DESCRIPCIÓN
					=============================================*/

			echo '<p>' . $infoproducto["descripcion"] . '</p>';


			?>


			<!-- 	<div id="faq" role="tablist" aria-multiselectable="true">

				<div class="panel panel-default">
					<div class="panel-heading " role="tab" id="questionOne">
						<h5 class="panel-title text-center ">
							<a data-toggle="collapse" data-parent="#faq" href="#answerOne" aria-expanded="true" aria-controls="answerOne">
								Details <i style="margin-right:10px" class="fa fa-plus"></i>
							</a>
						</h5>
					</div>
					<div id="answerOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="questionOne">
						<div class="panel-body">
							Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="questionTwo">
						<h5 class="panel-title text-center">
							<a class="collapsed" data-toggle="collapse" data-parent="#faq" href="#answerTwo" aria-expanded="false" aria-controls="answerTwo">
								Tech Specs <i style="margin-right:10px" class="fa fa-plus"></i>
							</a>
						</h5>
					</div>
					<div id="answerTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="questionTwo">
						<div class="panel-body">
							There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
						</div>
					</div>
				</div>

			

			</div> -->
			<!--=====================================
				BOTONES DE COMPRA
				======================================-->
			<!--=====================================
				CARACTERÍSTICAS DEL PRODUCTO
				======================================-->


			<div class="form-group row">

				<?php

				if ($infoproducto["detalles"] != null) {

					$detalles = json_decode($infoproducto["detalles"], true);

					if ($infoproducto["tipo"] == "fisico") {

						if ($detalles["Talla"] != null) {

							echo '<div class="col-md-6 col-xs-12">

					<select class="form-control seleccionarDetalle text-center" id="seleccionarTalla">
						
						<option value="">Tamaño</option>';

							for ($i = 0; $i < count($detalles["Talla"]); $i++) {

								echo '<option value="' . $detalles["Talla"][$i] . '">' . $detalles["Talla"][$i] . '</option>';
							}

							echo '</select>
							<input class="form-control rmn" id="rmn" type="hidden" value="' . $infoproducto["ruta"] . '" >

						</div>';
						} else {
							echo '<input class="form-control seleccionarDetalle" id="seleccionarTalla" type="hidden" >';
						}

						if ($detalles["Color"] != null) {

							echo '<div class="col-md-6 col-xs-12">

					<select class="form-control seleccionarDetalle text-center" id="seleccionarColor">
						
						<option value="" id="seleccionarColor1 ">Color</option>';

							for ($i = 0; $i < count($detalles["Color"]); $i++) {

								echo '<option value="' . $detalles["Color"][$i] . '">' . $detalles["Color"][$i] . '</option>';
							}

							echo '</select>
							<input class="form-control rmn1" id="rmn1" type="hidden" value="' . $infoproducto["ruta"] . '" >
							</div>';
						} else {
							echo '<input class="form-control seleccionarDetalle" id="seleccionarColor" type="hidden" >
							
							';
						}

						/* 		if ($detalles["Marca"] != null) {

							echo '<div class="col-md-4 col-xs-12">

						<select class="form-control seleccionarDetalle" id="seleccionarMarca">
						
						<option value="">Marca</option>';

							for ($i = 0; $i < count($detalles["Marca"]); $i++) {

								echo '<option value="' . $detalles["Marca"][$i] . '">' . $detalles["Marca"][$i] . '</option>';
							}

							echo '</select>

						</div>';
						} else {
							echo '<input class="form-control seleccionarDetalle" id="seleccionarMarca" type="hidden" >';
						} */
					} else {

						echo '<div class="col-xs-12">

							<li>
								<i style="margin-right:10px" class="fa fa-play-circle"></i> ' . $detalles["Clases"] . '
							</li>
							<li>
								<i style="margin-right:10px" class="fa fa-clock-o"></i> ' . $detalles["Tiempo"] . '
							</li>
							<li>
								<i style="margin-right:10px" class="fa fa-check-circle"></i> ' . $detalles["Nivel"] . '
							</li>
							<li>
								<i style="margin-right:10px" class="fa fa-info-circle"></i> ' . $detalles["Acceso"] . '
							</li>
							<li>
								<i style="margin-right:10px" class="fa fa-desktop"></i> ' . $detalles["Dispositivo"] . '
							</li>
							<li>
								<i style="margin-right:10px" class="fa fa-trophy"></i> ' . $detalles["Certificado"] . '
							</li>

						</div>';
					}
				}




				?>

			</div>
			<div class="row botonesCompra">

				<?php

				if ($infoproducto["precio"] == 0) {

					echo '<div class="col-md-6 col-xs-12">';

					if (isset($_SESSION["validarSesion"]) && $_SESSION["validarSesion"] == "ok") {

						if ($infoproducto["tipo"] == "virtual") {

							echo '<button class="btn btn-default btn-block btn-lg backColor agregarGratis" idProducto="' . $infoproducto["id"] . '" idUsuario="' . $_SESSION["id"] . '" tipo="' . $infoproducto["tipo"] . '" titulo="' . $infoproducto["titulo"] . '">ACCEDER AHORA</button>';
						} else {

							echo '<button class="btn btn-default btn-block btn-lg backColor agregarGratis" idProducto="' . $infoproducto["id"] . '" idUsuario="' . $_SESSION["id"] . '" tipo="' . $infoproducto["tipo"] . '" titulo="' . $infoproducto["titulo"] . '">SOLICITAR AHORA</button>

									<br>

									<div class="col-xs-12 panel panel-info text-left">

									<strong>¡Atención!</strong>

										El producto a solicitar es totalmente gratuito y se enviará a la dirección solicitada, sólo se cobrará los cargos de envío.

									</div>
								';
						}
					} else {

						echo '<a href="#modalIngreso" data-toggle="modal">

								<button class="btn btn-default btn-block btn-lg backColor">	SOLICITAR AHORA</button>

							</a>';
					}

					echo '</div>';
				} else {

					if ($infoproducto["tipo"] == "fisico") {

						if ($infoproducto["cantidad"] > 0) {



							echo '<div class="col-md-6 col-xs-12">';

							if (isset($_SESSION["validarSesion"])) {

								if ($_SESSION["validarSesion"] == "ok") {

									echo '<a id="btnCheckout" href="#modalComprarAhora" data-toggle="modal" idUsuario="' . $_SESSION["id"] . '"><button class="btn btn-default btn-block btn-lg backColor">
									<small>COMPRAR AHORA</small></button></a>';
								}
							} else {

								echo '<a href="#modalIngreso" data-toggle="modal"><button class="btn btn-default btn-block btn-lg backColor">
									<small>COMPRAR AHORA</small></button></a>';
							}

							echo '</div>

								<div class="col-md-6 col-xs-12 ">';

							if ($infoproducto["oferta"] != 0) {

								echo '<button class="btn btn-default btn-block btn-lg backColor agregarCarrito"  idProducto="' . $infoproducto["id"] . '" imagen="' . $servidor . $infoproducto["portada"] . '" titulo="' . $infoproducto["titulo"] . '" precio="' . $infoproducto["precioOferta"] . '" tipo="' . $infoproducto["tipo"] . '" peso="' . $infoproducto["peso"] . '">';
							} else {

								echo '<button class="btn btn-default btn-block btn-lg backColor agregarCarrito"  idProducto="' . $infoproducto["id"] . '" imagen="' . $servidor . $infoproducto["portada"] . '" titulo="' . $infoproducto["titulo"] . '" precio="' . $infoproducto["precio"] . '" tipo="' . $infoproducto["tipo"] . '" peso="' . $infoproducto["peso"] . '">';
							}

							echo   '<small>AÑADIR AL CARRITO</small> 

									<i class="fa fa-shopping-cart col-md-0"></i>

									</button>

								</div>';
						} else {


							echo '
							<div class="col-md-12 col-xs-12 ">
							<button class="btn btn-default btn-block btn-lg backColor">
						<small> SIN STOCK </small></button>
						</div>';
						}
					} else {

						echo '<div class="col-lg-6 col-md-8 col-xs-12">';

						if ($infoproducto["oferta"] != 0) {

							echo '<button class="btn btn-default btn-block btn-lg backColor agregarCarrito"  idProducto="' . $infoproducto["id"] . '" imagen="' . $servidor . $infoproducto["portada"] . '" titulo="' . $infoproducto["titulo"] . '" precio="' . $infoproducto["precioOferta"] . '" tipo="' . $infoproducto["tipo"] . '" peso="' . $infoproducto["peso"] . '">';
						} else {

							echo '<button class="btn btn-default btn-block btn-lg backColor agregarCarrito"  idProducto="' . $infoproducto["id"] . '" imagen="' . $servidor . $infoproducto["portada"] . '" titulo="' . $infoproducto["titulo"] . '" precio="' . $infoproducto["precio"] . '" tipo="' . $infoproducto["tipo"] . '" peso="' . $infoproducto["peso"] . '">';
						}


						echo 'AÑADIR AL CARRITO 

									<i class="fa fa-shopping-cart"></i>

									</button>

								</div>';
					}
				}

				?>

			</div>
			<!--=====================================
				CARACTERÍSTICAS DEL PRODUCTO
				======================================-->


			<div class="form-group row">

				<?php


				/*=============================================
						ENTREGA
						=============================================*/

				if ($infoproducto["entrega"] == 0) {

					if ($infoproducto["precio"] == 0) {

						echo '<h4 class="col-md-12 col-sm-0 col-xs-0">


				<span class="label label-default" style="font-weight:100;background:white;color:black;">

					<i class="fa fa-clock-o" style="margin-right:5px"></i>
					Entrega inmediata | 
					<i class="fa fa-shopping-cart" style="margin:0px 5px"></i>
					' . $infoproducto["ventasGratis"] . ' inscritos |
					<i class="fa fa-eye" style="margin:0px 5px"></i>
					Visto por <span class="vistas" tipo="' . $infoproducto["precio"] . '">' . $infoproducto["vistasGratis"] . '</span> personas

				</span>

			</h4>

			<h4 class="col-lg-0 col-md-0 col-xs-12">


				<small>

					<i class="fa fa-clock-o" style="margin-right:5px"></i>
					Entrega inmediata <br>
					<i class="fa fa-shopping-cart" style="margin:0px 5px"></i>
					' . $infoproducto["ventasGratis"] . ' inscritos <br>
					<i class="fa fa-eye" style="margin:0px 5px"></i>
					Visto por <span class="vistas" tipo="' . $infoproducto["precio"] . '">' . $infoproducto["vistasGratis"] . '</span> personas

				</small>

			</h4>';
					} else {

						echo '<h4 class="col-md-12 col-sm-0 col-xs-0">


				<span class="label label-default" style="font-weight:100;background:white;color:black;">

					<i class="fa fa-clock-o" style="margin-right:5px"></i>
					Entrega inmediata |
					<i class="fa fa-shopping-cart" style="margin:0px 5px"></i>
					' . $infoproducto["ventas"] . ' ventas |
					<i class="fa fa-eye" style="margin:0px 5px"></i>
					Visto por <span class="vistas" tipo="' . $infoproducto["precio"] . '">' . $infoproducto["vistas"] . ' </span> personas

				</span>

			</h4>

			<h4 class="col-lg-0 col-md-0 col-xs-12">


				<small>

					<i class="fa fa-clock-o" style="margin-right:5px"></i>
					Entrega inmediata <br> 
					<i class="fa fa-shopping-cart" style="margin:0px 5px"></i>
					' . $infoproducto["ventas"] . ' ventas <br>
					<i class="fa fa-eye" style="margin:0px 5px"></i>
					Visto por <span class="vistas" tipo="' . $infoproducto["precio"] . '">' . $infoproducto["vistas"] . '</span> personas

				</small>

			</h4>';
					}
				} else {

					if ($infoproducto["precio"] == 0) {

						echo '<h4 class="col-md-12 col-sm-0 col-xs-0">


				<span class="label label-default" style="font-weight:100;background:white;color:black;">
				
					<i class="fa fa-archive" style="margin-right:5px"></i>
					' . $parteCatalogo . ' DISPONIBLES  |

					<i class="fa fa-clock-o" style="margin-right:5px"></i>
					' . $infoproducto["entrega"] . ' días hábiles para la entrega  |
					<i class="fa fa-shopping-cart" style="margin:0px 5px"></i>
					' . $infoproducto["ventasGratis"] . ' solicitudes  |
					<i class="fa fa-eye" style="margin:0px 5px"></i>
					Visto por <span class="vistas" tipo="' . $infoproducto["precio"] . '">' . $infoproducto["vistasGratis"] . '</span> personas  

				</span>

			</h4>

			<h4 class="col-lg-0 col-md-0 col-xs-12">


				<small>
				
					<i class="fa fa-clock-o" style="margin-right:5px"></i>
					' . $infoproducto["entrega"] . ' días hábiles para la entrega  <br>
					<i class="fa fa-shopping-cart" style="margin:0px 5px"></i>
					' . $infoproducto["ventasGratis"] . ' solicitudes  <br>
					<i class="fa fa-eye" style="margin:0px 5px"></i>
					Visto por <span class="vistas" tipo="' . $infoproducto["precio"] . '">' . $infoproducto["vistasGratis"] . ' </span> personas 

				</small>

			</h4>';
					} else {
						$parteCatalogo =  $infoproducto["cantidad"] > 0 ?  $infoproducto["cantidad"] : 0;

						echo '<h4 class="col-md-12 col-sm-0 col-xs-0">


				<span class="label label-default" style="font-weight:100;background:white;color:black;">
				<i class="fa fa-archive" style="margin-right:5px"></i>
				' . $parteCatalogo . ' DISPONIBLES  |
					<i class="fa fa-clock-o" style="margin-right:5px"></i>
					' . $infoproducto["entrega"] . ' días hábiles para la entrega |
					<i class="fa fa-shopping-cart" style="margin:0px 5px"></i>
					' . $infoproducto["ventas"] . ' ventas |
					<i class="fa fa-eye" style="margin:0px 5px"></i>
					Visto por <span class="vistas" tipo="' . $infoproducto["precio"] . '">' . $infoproducto["vistas"] . ' </span> personas

				</span>

			</h4>

			<h4 class="col-lg-0 col-md-0 col-xs-12">


				<small>
				<i class="fa fa-archive" style="margin-right:5px"></i>
				' . $parteCatalogo . ' DISPONIBLES  |

					<i class="fa fa-clock-o" style="margin-right:5px"></i>
					' . $infoproducto["entrega"] . ' días hábiles para la entrega <br>
					<i class="fa fa-shopping-cart" style="margin:0px 5px"></i>
					' . $infoproducto["ventas"] . ' ventas <br>
					<i class="fa fa-eye" style="margin:0px 5px"></i>
					Visto por <span class="vistas" tipo="' . $infoproducto["precio"] . '">' . $infoproducto["vistas"] . '</span> personas

				</small>

			</h4>';
					}
				}

				?>

			</div>
			<!--=====================================
				ZONA DE LUPA
				======================================-->

			<figure class="lupa">

				<img src="">

			</figure>

		</div>

	</div>

	<!--=====================================
		COMENTARIOS
		======================================-->

	<br>

	<div class="row" role="tabpanel">

		<?php

		$datos = array(
			"idUsuario" => "",
			"idProducto" => $infoproducto["id"]
		);

		$comentarios = ControladorUsuarios::ctrMostrarComentariosPerfil($datos);

		$cantidad = 0;

		foreach ($comentarios as $key => $value) {

			if ($value["comentario"] != "") {

				$cantidad++;
			}
		}

		?>

		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item active" class="active">
				<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" aria-expanded="true">DESCRIPCION</a>
			</li>

			<!--   <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Informacion adicional</a>
  </li> -->


			<?php

			$cantidadCalificacion = 0;

			if ($cantidad == 0) {

				echo '<li class=""><a>ESTE PRODUCTO NO TIENE COMENTARIOS</a></li>
						  <li></li>';
			} else {

				echo ' <li class="nav-item">
				<a class="nav-link" id="contact-tab1" data-toggle="tab" href="#contact" role="tab" aria-controls="contact1" aria-selected="false">COMENTARIOS ' . $cantidad . '</a>
			  </li>
						  <li><a id="verMas" href="">Ver más </a></li>';


				$sumaCalificacion = 0;

				foreach ($comentarios as $key => $value) {

					if ($value["calificacion"] != 0) {

						$cantidadCalificacion++;

						$sumaCalificacion += $value["calificacion"];
					}
				}

				$promedio = round($sumaCalificacion / $cantidadCalificacion, 1);

				/* echo '<li class="pull-right"><a class="text-muted">PROMEDIO DE CALIFICACIÓN: ' . $promedio . ' | ';

				if ($promedio >= 0 && $promedio < 0.5) {

					echo '<i class="fa fa-star-half-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 0.5 && $promedio < 1) {

					echo '<i class="fa fa-star text-info"></i>
							  <i class="fa fa-star-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 1 && $promedio < 1.5) {

					echo '<i class="fa fa-star text-info"></i>
							  <i class="fa fa-star-half-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 1.5 && $promedio < 2) {

					echo '<i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 2 && $promedio < 2.5) {

					echo '<i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star-half-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 2.5 && $promedio < 3) {

					echo '<i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 3 && $promedio < 3.5) {

					echo '<i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star-half-o text-info"></i>
							  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 3.5 && $promedio < 4) {

					echo '<i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star-o text-info"></i>';
				} else if ($promedio >= 4 && $promedio < 4.5) {

					echo '<i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star-half-o text-info"></i>';
				} else {

					echo '<i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>
							  <i class="fa fa-star text-info"></i>';
				} */
			}


			?>


			</a></li>


		</ul>

		<br>

	</div>

	<div class="tab-content">
		<div class="tab-pane fade active in " id="home" role="tabpanel" aria-labelledby="home-tab">
			<?php
			echo '<img class="img-responsive center-block " src="' . $servidor . $infoproducto["portada"] . '" width="50%">';
			?>
			Acerca de este artículo Capacidad de datos de alta velocidad: el cable HDMI iVANKY 4K es compatible con HDMI 2.0b, incluyendo 18 Gbps, modo espejo y extensión, Ultra HD 4K 2160p, HD 2K 1080p, QHD 1440p, HDCP 2.2, 48 bits de color intenso, devolución de audio (ARC), audio Dolby TrueHD 7.1 y conexión en caliente. Cable HDMI 4K HDR: perfecto para tu televisor 4K UHD. Compatible con tus dispositivos de transmisión, Apple TV 4K, NVIDIA SHIELD TV, reproductores de CD/DVD/Blu-ray, Fire TV, Roku Ultra, PS4/3, Switch, computadoras u otros dispositivos habilitados para HDMI a tu televisor 4K/HD, monitores, pantallas o proyectores. Mejora innovadora: diseñado para todos los dispositivos con HDMI 2.0 estándares y compatibles con HDMI 1.4, 1.3 y 1.2. El blindaje de metal de hojalata y los conectores chapados en oro, resistentes a la corrosión pueden proteger contra interferencias de señal externas, garantizan que la transmisión de la señal sea estable y minimizan la pérdida de señal. Diseño ultra duradero: construido con carcasa de aluminio delgada y cubierta trenzada de nailon de gran calidad, este cable HDMI puede soportar ensayos de flexión de más de 10.000 veces sin reducir la flexibilidad del cable y garantizar el mejor rendimiento posible.
		</div>
		<div class="tab-pane fade active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
			<div class="row comentarios">

				<?php

				foreach ($comentarios as $key => $value) {

					if ($value["comentario"] != "") {

						$item = "id";
						$valor = $value["id_usuario"];

						$usuario = ControladorUsuarios::ctrMostrarUsuario($item, $valor);

						if (is_array($usuario)) {

							echo '<div class="panel-group col-md-3 col-sm-6 col-xs-12 alturaComentarios">
			
				<div class="panel panel-default">
				  
				  <div class="panel-heading text-uppercase">

					  ' . $usuario["nombre"] . '
					  <span class="text-right">';

							if ($usuario["modo"] == "directo" || $usuario["modo"] == "invitado") {

								if ($usuario["foto"] == "") {

									echo '<img class="img-circle pull-right" src="' . $servidor . 'vistas/img/usuarios/default/anonymous.png" width="20%">';
								} else {

									echo '<img class="img-circle pull-right" src="' . $url . $usuario["foto"] . '" width="20%">';
								}
							} else {

								echo '<img class="img-circle pull-right" src="' . $usuario["foto"] . '" width="20%">';
							}

							echo '</span>

				  </div>
				 
				  <div class="panel-body"><small>' . $value["comentario"] . '</small></div>

				  <div class="panel-footer">';

							switch ($value["calificacion"]) {

								case 0.5:
									echo '<i class="fa fa-star-half-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>';
									break;

								case 1.0:
									echo '<i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>';
									break;

								case 1.5:
									echo '<i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-half-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>';
									break;

								case 2.0:
									echo '<i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>';
									break;

								case 2.5:
									echo '<i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-half-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>';
									break;

								case 3.0:
									echo '<i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>';
									break;

								case 3.5:
									echo '<i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-half-o text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>';
									break;

								case 4.0:
									echo '<i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-o text-info" aria-hidden="true"></i>';
									break;

								case 4.5:
									echo '<i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star-half-o text-info" aria-hidden="true"></i>';
									break;

								case 5.0:
									echo '<i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>
							  <i class="fa fa-star text-info" aria-hidden="true"></i>';
									break;
							}

							echo '</div>
				
				</div>

			</div>';
						}
					}
				}

				?>

			</div>

		</div>
	</div>

</div>

</div>

<!--=====================================
ARTÏCULOS RELACIONADOS
======================================-->
<div class="container-fluid productos">

	<div class="container">

		<div class="row">

			<div class="col-xs-12 tituloDestacado">

				<div class="col-sm-6 col-xs-12">

					<h1><small>PRODUCTOS RELACIONADOS</small></h1>

				</div>

				<div class="col-sm-6 col-xs-12">

					<?php

					$item = "id";
					$valor = $infoproducto["id_subcategoria"];

					$rutaArticulosDestacados = ControladorProductos::ctrMostrarSubcategorias($item, $valor);

					echo '<a href="' . $url . $rutaArticulosDestacados[0]["ruta"] . '">
						
						<button class="btn btn-default backColor pull-right">
							
							VER MÁS <span class="fa fa-chevron-right"></span>

						</button>

					</a>';

					?>

				</div>

			</div>

			<div class="clearfix"></div>

			<hr>

		</div>

		<?php

		$ordenar = "";
		$item = "id_subcategoria";
		$valor = $infoproducto["id_subcategoria"];
		$base = 0;
		$tope = 4;
		$modo = "Rand()";

		$relacionados = ControladorProductos::ctrMostrarProductos($ordenar, $item, $valor, $base, $tope, $modo);

		if (!$relacionados) {

			echo '<div class="col-xs-12 error404">

					

					<h2>No hay productos relacionados</h2>

				</div>';
		} else {

			echo '<ul class="grid0">';

			foreach ($relacionados as $key => $value) {

				if ($value["estado"] != 0) {

					echo '<li class="col-md-3 col-sm-6 col-xs-12">

						<figure>
							
							<a href="' . $url . $value["ruta"] . '" class="pixelProducto">
								
								<img src="' . $servidor . $value["portada"] . '" class="img-responsive">

							</a>

						</figure>

						

						<h4>
				
							<small>
								
								<a href="' . $url . $value["ruta"] . '" class="pixelProducto">
									
									' . $value["titulo"] . '<br>

									<span style="color:rgba(0,0,0,0)">-</span>';

					$fecha = date('Y-m-d');
					$fechaActual = strtotime('-30 day', strtotime($fecha));
					$fechaNueva = date('Y-m-d', $fechaActual);

					if ($fechaNueva < $value["fecha"]) {

						echo '<span class="label label-success fontSize">Nuevo</span> ';
					}

					if ($value["oferta"] != 0 && $value["precio"] != 0) {

						echo '<span class="label label-danger fontSize">' . $value["descuentoOferta"] . '% off</span>';
					}

					echo '</a>	

							</small>			

						</h4>

						<div class="col-xs-6 precio">';

					if ($value["precio"] == 0) {

						echo '<h2><small>GRATIS</small></h2>';
					} else {

						if ($value["oferta"] != 0) {

							echo '<h2>

										<small>
					
											<strong class="oferta"> $' . $value["precio"] . '</strong>

										</small>

										<small>$' . $value["precioOferta"] . '</small>
									
									</h2>';
						} else {

							echo '<h2><small> $' . $value["precio"] . '</small></h2>';
						}
					}

					echo '</div>

						<div class="col-xs-6 enlaces">
							
							<div class="btn-group pull-right">
								
								<button type="button" class="btn btn-default btn-xs deseos" idProducto="' . $value["id"] . '" data-toggle="tooltip" title="Agregar a mi lista de deseos">
									
									<i class="fa fa-heart" aria-hidden="true"></i>

								</button>';

					if ($value["tipo"] == "virtual" && $value["precio"] != 0) {

						if ($value["oferta"] != 0) {

							echo '<button type="button" class="btn btn-default btn-xs agregarCarrito"  idProducto="' . $value["id"] . '" imagen="' . $servidor . $value["portada"] . '" titulo="' . $value["titulo"] . '" precio="' . $value["precioOferta"] . '" tipo="' . $value["tipo"] . '" peso="' . $value["peso"] . '" data-toggle="tooltip" title="Agregar al carrito de compras">

										<i class="fa fa-shopping-cart" aria-hidden="true"></i>

										</button>';
						} else {

							echo '<button type="button" class="btn btn-default btn-xs agregarCarrito"  idProducto="' . $value["id"] . '" imagen="' . $servidor . $value["portada"] . '" titulo="' . $value["titulo"] . '" precio="' . $value["precio"] . '" tipo="' . $value["tipo"] . '" peso="' . $value["peso"] . '" data-toggle="tooltip" title="Agregar al carrito de compras">

										<i class="fa fa-shopping-cart" aria-hidden="true"></i>

										</button>';
						}
					}

					echo '<a href="' . $url . $value["ruta"] . '" class="pixelProducto">
								
									<button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Ver producto">
										
										<i class="fa fa-eye" aria-hidden="true"></i>

									</button>	
								
								</a>

							</div>

						</div>

					</li>';
				}
			}

			echo '</ul>';
		}

		?>

	</div>

</div>

<!--=====================================
VENTANA MODAL PARA CHECKOUT
======================================-->

<div id="modalComprarAhora" class="modal fade modalFormulario" role="dialog">
	<link rel="stylesheet" href="vistas/css/estilos.css">
	<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
	<script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>

	<script>
		/* chance costo de estado  */
		$(document).ready(function() {

			OpenPay.setId('mzpbsqxe2u5jgqywfd3u');
			OpenPay.setApiKey('pk_4c7ac187abf243d08a2893b31d78a6c3');
			OpenPay.setSandboxMode(true);
			//Se genera el id de dispositivo
			var deviceSessionId = OpenPay.deviceData.setup("formulario-tarjeta", "deviceIdHiddenFieldName");

		});
	</script>
	<div class="modal-content modal-dialog">

		<div class="modal-body modalTitulo">

			<h3 class="backColor">REALIZAR PAGO</h3>

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			<div class="contenidoCheckout">

				<?php
				$item = "id";
				$valor = $_SESSION["id"];

				$datosUsuario = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
				$respuesta = ControladorCarrito::ctrMostrarTarifas();

				echo '<input type="hidden" id="tasaImpuesto" value="' . $respuesta["impuesto"] . '">
					  <input type="hidden" id="envioNacional" value="' . $respuesta["envioNacional"] . '">
				      <input type="hidden" id="envioInternacional" value="' . $respuesta["envioInternacional"] . '">
				      <input type="hidden" id="tasaMinimaNal" value="' . $respuesta["tasaMinimaNal"] . '">
				      <input type="hidden" id="tasaMinimaInt" value="' . $respuesta["tasaMinimaInt"] . '">
				      <input type="hidden" id="tasaPais" value="' . $respuesta["pais"] . '">

				';

				?>

				<div class="formEnvio row">

					<h4 class="text-center well text-muted text-uppercase">Información de envío</h4>


					<div class="col-xs-12 text-center ">


						<label>Direccion de envio</label>

						<input type="text" class="form-control seleccionedireccion" name="direccion" id="direccion" placeholder="Direccion de envio" value="<?php echo $datosUsuario["direccion"] ?>">

					</div>
					<br>

					<div class="row">
						<br>
						<div class="col-xs-6 text-center ">


							<label>Numero de telefono</label>

							<input type="number" class="form-control " name="telefono" id="telefono" placeholder="Numero de telefono" value="<?php echo $datosUsuario["telefono"] ?>">

						</div>
						<div class="col-xs-6 text-center ">


							<label>Codigo Postal</label>

							<input type="number" class="form-control " name="codigo" id="codigo" placeholder="Codigo Postal" value="<?php echo $datosUsuario["codigo"] ?>">

						</div>
						<input name="idUsuario" id="idUsuario" type="hidden" value="<?php echo $_SESSION["id"] ?>" />
						<input name="correoE" id="correoE" type="hidden" value="<?php echo $datosUsuario["email"] ?>" />

					</div>

					<br>


										<!-- <div class="col-xs-12 seleccionePais">
								
								

							</div> -->
					<div class="row">
						<div class="col-xs-6 text-center ">


							<label>Ciudad</label>

							<input type="text" class="form-control " name="ciudad" id="ciudad" placeholder="Ciudad" value="<?php echo $datosUsuario["ciudad"] ?>">

						</div>
						<label> Estado</label>

						<div class="col-xs-6 seleccioneEstado text-center">



						</div>
					</div>





				</div>

				<br>

				<div class="formaPago row">

					<h4 class="text-center well text-muted text-uppercase">Elige la forma de pago</h4>

					<figure class="col-xs-4">

						<center>

							<input id="checkPaypal" type="radio" name="pago" value="paypal" >

						</center>

						<img src="<?php echo $url; ?>vistas/img/plantilla/paypal.jpg" class="img-thumbnail">

					</figure>
					<figure class="col-xs-4">

						<center>

							<input id="open" type="radio" name="pago" value="open">

						</center>

						<img src="<?php echo $url;
									?>vistas/img/plantilla/open.png" class="img-thumbnail">

					</figure>

						<figure class="col-xs-4">

					<center>

						<input id="oxxo" type="radio" name="pago" value="oxxo">

					</center>

						<img src="<?php echo $url; 
										?>vistas/img/plantilla/oxxopay.png" class="img-thumbnail">

					</figure>

				</div>

				<br>
				<div class="contenedor col-sm-12 col-xs-12 text-center" id="tarjetasr" style="display: none;">

					<!-- Tarjeta -->
					<section class="tarjeta" id="tarjeta">
						<div class="delantera">
							<div class="logo-marca" id="logo-marca">
								<!-- <img src="img/logos/visa.png" alt=""> -->
							</div>
							<img src="vistas/img/chip-tarjeta.png" class="chip" alt="">
							<div class="datos">
								<div class="grupo" id="numero">
									<p class="label">Número Tarjeta</p>
									<p class="numero">#### #### #### ####</p>
								</div>
								<div class="flexbox">
									<div class="grupo" id="nombre">
										<p class="label">Nombre Tarjeta</p>
										<p class="nombre"></p>
									</div>

									<div class="grupo" id="expiracion">
										<p class="label">Expiracion</p>
										<p class="expiracion"><span class="mes">MM</span> / <span class="year">AA</span></p>
									</div>
								</div>
							</div>
						</div>

						<div class="trasera">
							<div class="barra-magnetica"></div>
							<div class="datos">
								<div class="grupo" id="firma">
									<p class="label">Firma</p>
									<div class="firma">
										<p></p>
									</div>
								</div>
								<div class="grupo" id="ccv">
									<p class="label">CCV</p>
									<p class="ccv"></p>
								</div>
							</div>
<!-- 							<p class="leyenda">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus exercitationem, voluptates illo.</p>
 -->							<!-- 	<a href="#" class="link-banco">www.tubanco.com</a> -->
						</div>
					</section>
					<br><br><br><br><br>
					<br><br>


					<form action="" id="formulario-tarjeta" method="POST" class="formulario-tarjeta">
						<input type="hidden" name="token_id" id="token_id">

						<div class="grupo">
							<label for="inputNumero">Número Tarjeta</label>
							<input type="text" class="form-control" id="inputNumero" maxlength="16" autocomplete="off" data-openpay-card="card_number">
						</div>
						<div class="grupo">
							<label for="inputNombre">Nombre</label>
							<input type="text" class="form-control" id="inputNombre" autocomplete="off" data-openpay-card="holder_name">
						</div>
						<br>
						<div class="row">
							<label for="inputNombre">Expiracion</label>

							<br>
							<div class="col-xs-6 text-center ">


<select name="mes" class="form-control" id="selectMes" data-openpay-card="expiration_month">
	<option disable selected>mes</option>
</select>
</div>
<div class="col-xs-6 text-center ">

<select name="year" class="form-control" id="selectYear" data-openpay-card="expiration_year">
	<option disable selected>año</option>
</select>
</div>

						</div>

						<div class="grupo ccv">
							<label for="inputCCV">CCV</label>
							<input type="text" class="form-control" id="inputCCV" maxlength="3" data-openpay-card="cvv2">
						</div>
						Tus pagos se realizan de forma segura con encriptación de 256 bits
						<br>
						<!-- <button type="submit" class="btn-enviar">Enviar</button> -->


					</form>
				</div>

				<div class="listaProductos row">


					<table class="table table-striped tablaProductos">

						<thead>

							<tr>
								<th>Producto</th>
								<th>Cantidad</th>
								<th>Precio</th>
							</tr>

						</thead>

						<tbody>


							<h4 class="text-center well text-muted text-uppercase">Productos a comprar</h4>

						</tbody>

					</table>

					<div class="col-sm-6 col-xs-12 pull-right">


						<table class="table table-striped tablaTasas">

							<tbody>

								<tr>
									<td>Subtotal</td>
									<td><span class="cambioDivisa">MXN</span> $<span class="valorSubtotal" valor="0">0</span></td>
								</tr>

								<tr>
									<td>Envío</td>
									<td><span class="cambioDivisa">MXN</span> $<span class="valorTotalEnvio" valor="0">0</span></td>
								</tr>

								<tr>
									<td>Impuesto</td>
									<td><span class="cambioDivisa">MXN</span> $<span class="valorTotalImpuesto" valor="0">0</span></td>
								</tr>

								<tr>
									<td><strong>Total</strong></td>
									<td><strong><span class="cambioDivisa">MXN</span> $<span class="valorTotalCompra" valor="0">0</span></strong></td>
								</tr>

							</tbody>

						</table>

						<div class="divisa">

							<select class="form-control" id="cambiarDivisa" name="divisa">



							</select>

							<br>

						</div>

					</div>

					<div class="clearfix"></div>

					<form class="formPayu" style="display:none">

						<input name="merchantId" type="hidden" value="" />
						<input name="accountId" type="hidden" value="" />
						<input name="description" type="hidden" value="" />
						<input name="referenceCode" type="hidden" value="" />
						<input name="amount" type="hidden" value="" />
						<input name="tax" type="hidden" value="" />
						<input name="taxReturnBase" type="hidden" value="" />
						<input name="shipmentValue" type="hidden" value="" />
						<input name="currency" type="hidden" value="" />
						<input name="lng" type="hidden" value="es" />
						<input name="confirmationUrl" type="hidden" value="" />
						<input name="responseUrl" type="hidden" value="" />
						<input name="declinedResponseUrl" type="hidden" value="" />
						<input name="displayShippingInformation" type="hidden" value="" />
						<input name="test" type="hidden" value="" />
						<input name="signature" type="hidden" value="" />

						<input name="Submit" class="btn btn-block btn-lg btn-default backColor" type="submit" value="PAGAR">
					</form>

					<button class="btn btn-block btn-lg btn-default backColor btnPagar" id="pay-button">PAGAR</button>

				</div>

			</div>


	</div>

	<div class="modal-footer">

	</div>

</div>
<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
<script src="vistas/js/main.js"></script>
</div>


<?php

if ($infoproducto["tipo"] == "fisico") {

	echo '<script type="application/ld+json">

			{
			  "@context": "http://schema.org/",
			  "@type": "Product",
			  "name": "' . $infoproducto["titulo"] . '",
			  "image": [';

	for ($i = 0; $i < count($multimedia); $i++) {

		echo $servidor . $multimedia[$i]["foto"] . ',';
	}

	echo '],
			  "description": "' . $infoproducto["descripcion"] . '"
	  
			}

		</script>';
} else {

	echo '<script type="application/ld+json">

			{
			  "@context": "http://schema.org",
			  "@type": "Course",
			  "name": "' . $infoproducto["titulo"] . '",
			  "description": "' . $infoproducto["descripcion"] . '",
			  "provider": {
			    "@type": "Organization",
			    "name": "Tu Logo",
			    "sameAs": "' . $url . $infoproducto["ruta"] . '"
			  }
			}

		</script>';
}

?>