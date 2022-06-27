<!--=====================================
FOOTER
======================================-->

<footer class="container-fluid">

	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 formContacto  text-center">

				<form class="form-inline" method="post" onsubmit="return validarContactenos()">
				<label for="exampleInputEmail2">
							<h4 style="color: white;">STAY CONNECTD</h4>
						</label>
					<div class="form-group">
					
						<input type="email" id="emailContactenos" name="emailContactenos" class="form-control" placeholder="Escriba su correo electrónico" required>

					</div>
					<input type="submit" value="Subscribe" class="btn btn-default backColor pull-center" id="enviar">

				</form>

				<?php

				$contactenos = new ControladorUsuarios();
				$contactenos->ctrFormularioContactenos();

				?>
			</div>


			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 formContacto  text-center">
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
					';
							}
						}

						?>


					</li>

				</ul>

			</div>
		</div>
		<div class="row">

			<!--=====================================
			CATEGORÍAS Y SUBCATEGORÍAS FOOTER
			======================================-->
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  text-center ">

				<h4><a href="#" class="" titulo="BLOG" style="color: white;">INFO</a></h4>
				<ul>
					<li><a href="#" class="pixelCategorias" style="color: gray;">Our Story</a></li>

					<li><a href="#" class="pixelCategorias" style="color: gray;">Careers</a></li>

					<li><a href="#" class="pixelCategorias" style="color: gray;">Bulk Order Inquiry</a></li>
					<li><a href="#" class="pixelCategorias" style="color: gray;">Customer Reviews</a></li>



				</ul>


			</div>
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  text-center ">

				<h4><a href="#" class="" titulo="BLOG" style="color: white;">LEGAL</a></h4>
				<ul>
					<li><a href="#" class="pixelCategorias" style="color: gray;">Privacy</a></li>

					<li><a href="#" class="pixelCategorias" style="color: gray;">Terms</a></li>

					<li><a href="#" class="pixelCategorias" style="color: gray;">Patents</a></li>
					<li><a href="#" class="pixelCategorias" style="color: gray;">Counterfeits</a></li>



				</ul>


			</div>
			<!-- <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  text-center">

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
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  text-center ">

				<h4><a href="#" class="" titulo="BLOG" style="color: white;">SUPPORT</a></h4>
				<ul>
					<li><a href="#" class="pixelCategorias" style="color: gray;">Contact</a></li>

					<li><a href="#" class="pixelCategorias" style="color: gray;">Shipping</a></li>

					<li><a href="#" class="pixelCategorias" style="color: gray;">Return</a></li>
					<li><a href="#" class="pixelCategorias" style="color: gray;">Warranty</a></li>

					<li><a href="#" class="pixelCategorias" style="color: gray;">Reward Policy</a></li>
					<li><a href="#" class="pixelCategorias" style="color: gray;">Web Accessibility</a></li>
					<li><a href="#" class="pixelCategorias" style="color: gray;">FAQ</a></li>

				</ul>


			</div>
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  text-center ">

				<h4><a href="#" class="" titulo="BLOG" style="color: white;">OTHERS</a></h4>
				<ul>
					<li><a href="#" class="pixelCategorias" style="color: gray;">My Account</a></li>

					<li><a href="#" class="pixelCategorias" style="color: gray;">Reward Program</a></li>

					<li><a href="#" class="pixelCategorias" style="color: gray;">Tracking Order</a></li>


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

			<div class="">

				<div class="row">

					<div class="col-sm-12 col-xs-12 text-left text-muted">

						<h5>&copy; Todos los derechos reservados. Hecho por Grupo Splittel</h5>

					</div>

					<!-- 	<div class="col-sm-6 col-xs-12 text-right social">

						<ul>
							<li>
								<a target="_blank" href="https://api.whatsapp.com/send?phone=+526692710170&amp;text=%C2%A1Hola! Me gustario obtener informacion sobre Linkop">
									<img src="<?php echo $url; ?>vistas/img/whatsapp(2).png" style="padding-bottom: 5px;"></a>
							</li>
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




						</ul>

					</div> -->

				</div>

			</div>

		</div>
	</div>


</footer>


<!--=====================================
FINAL
======================================-->