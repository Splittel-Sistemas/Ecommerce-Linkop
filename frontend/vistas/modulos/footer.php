<!--=====================================
FOOTER
======================================-->

<footer class="container-fluid">
	<div class="container">

		<div class="row">
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 formContacto  text-center">
							<h4 style="color: white;">MANTENTE CONECTADO</h4>
			
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-11 formContacto  text-center">
				<!-- <label for="exampleInputEmail2">
							<h4 style="color: white;">STAY CONNECTD</h4>
						</label> -->
				<form class="form" method="post" onsubmit="return validarContactenos()">


					<div class="input-group input-group-md">
						<input type="email" id="emailContactenos" name="emailContactenos" class="form-control" placeholder="Escriba su correo electrónico" required>

						<span class="input-group-btn">
							<input type="submit" value="Subscribete" class="btn btn-default backColor pull-center" id="enviar">

						</span>
					</div>
				</form>

				<?php

				$contactenos = new ControladorUsuarios();
				$contactenos->ctrFormularioContactenos();

				?>
			</div>


			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 formContacto  text-center">
				<ul>
					<li>
						<!-- <li>
							<a target="_blank" href="https://api.whatsapp.com/send?phone=+526692710170&amp;text=%C2%A1Hola! Me gustario obtener informacion sobre Linkop">
								<img src="<?php #echo $url; 
											?>vistas/img/whatsapp(2).png" style="padding-bottom: 5px;"></a>
						</li> -->
						<?php

						$social = ControladorPlantilla::ctrEstiloPlantilla();

						$jsonRedesSociales = json_decode($social["redesSociales"], true);

						foreach ($jsonRedesSociales as $key => $value) {

							if ($value["activo"] == 1) {

								echo '
						<a href="' . $value["url"] . '" target="_blank" ">
							<i class="fa ' . $value["red"] . ' redSocial ' . $value["estilo"] . '  fa-2x" aria-hidden="true"> </i>
						</a>
						&nbsp
						&nbsp
						&nbsp
						&nbsp
						&nbsp
					';
							}
						}

						?>


					</li>

				</ul>

			</div>
		</div>
	</div>
<br>
	<div class="row">

		<!--=====================================
			CATEGORÍAS Y SUBCATEGORÍAS FOOTER
			======================================-->
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12  text-center ">

			<h4><a href="#" class="" titulo="BLOG" style="color: white;">INFO</a></h4>
			<ul>
				<li><a href="#" class="pixelCategorias" style="color: gray;">Nuestra historia</a></li>

				<li><a href="#" class="pixelCategorias" style="color: gray;">Servicio al cliente</a></li>

				<li><a href="#" class="pixelCategorias" style="color: gray;">Regístrate</a></li>



			</ul>


		</div>
		<!-- <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12  text-center ">

			<h4><a href="#" class="" titulo="BLOG" style="color: white;">LEGAL</a></h4>
			<ul>
				<li><a href="#" class="pixelCategorias" style="color: gray;">Privacy</a></li>

				<li><a href="#" class="pixelCategorias" style="color: gray;">Terms</a></li>

				<li><a href="#" class="pixelCategorias" style="color: gray;">Patents</a></li>
				<li><a href="#" class="pixelCategorias" style="color: gray;">Counterfeits</a></li>



			</ul>


		</div> -->
		<!-- <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12  text-center">

				<h4><a href="#" class="" titulo="PRODUCTOS" style="color: white;">PRODUCTOS</a></h4>



				<?php
				/* 
				$url = Ruta::ctrRuta();

				$item = null;
				$valor = null;

				$categorias = ControladorProductos::ctrMostrarCategorias($item, $valor);

				foreach ($categorias as $key => $value) {


					echo '<ul> <li><a href="' . $url . $value["ruta"] . '" class="pixelCategorias" titulo="' . $value["categoria"] . '">' . $value["categoria"] . '</a></li> </ul>';
				} */

				?>
			</div> -->
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12  text-center ">

			<h4><a href="#" class="" titulo="BLOG" style="color: white;">SOPORTE </a></h4>
			<ul>
				<li><a href="#" class="pixelCategorias" style="color: gray;">Garantías y envíos:</a></li>

				<li><a href="#" class="pixelCategorias" style="color: gray;">Garantía de devolución:</a></li>

				<li><a href="#" class="pixelCategorias" style="color: gray;">Métodos de pago</a></li>
				<li><a href="#" class="pixelCategorias" style="color: gray;">Preguntas Frecuentes</a></li>

		

			</ul>


		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12  text-center ">

			<h4><a href="#" class="" titulo="BLOG" style="color: white;">LO QUE DEBES SABER</a></h4>
			<ul>
				<li><a href="#" class="pixelCategorias" style="color: gray;">Políticas de Privacidad</a></li>

				<li><a href="#" class="pixelCategorias" style="color: gray;">Términos y Condiciones</a></li>



			</ul>


		</div>
		<!--=====================================
			DATOS CONTACTO
			======================================-->



		<!--=====================================
			FORMULARIO CONTÁCTENOS
			======================================-->



	</div>

	<div class="container-fluid final">



		<div class="col-sm-6 col-xs-12 text-center">
			<?php

			$social = ControladorPlantilla::ctrEstiloPlantilla();
			$servidor = Ruta::ctrRutaServidor();


			?>
			<img src="<?php echo $servidor . $social["logo"]; ?>" class="img-responsive" style="width:150px;">


		</div>

		<div class="col-sm-6 col-xs-12 text-center ">

			<h5 style="color:white">&copy; Todos los derechos reservados. Hecho por Grupo Splittel</h5>

			<!-- <li>
								<a target="_blank" href="https://api.whatsapp.com/send?phone=+526692710170&amp;text=%C2%A1Hola! Me gustario obtener informacion sobre Linkop">
									<img src="<?php echo $url; ?>vistas/img/whatsapp(2).png" style="padding-bottom: 5px;"></a>
							</li> -->
			<?php
			/* 
							$social = ControladorPlantilla::ctrEstiloPlantilla();

							$jsonRedesSociales = json_decode($social["redesSociales"], true);

							foreach ($jsonRedesSociales as $key => $value) {

								if ($value["activo"] == 1) {

									echo '<li>
						<a href="' . $value["url"] . '" target="_blank">
							<i class="fa ' . $value["red"] . ' redSocial ' . $value["estilo"] . '" aria-hidden="true"></i>
						</a>
					</li>';
								}
							} */

			?>





		</div>


	</div>



</footer>


<!--=====================================
FINAL
======================================-->