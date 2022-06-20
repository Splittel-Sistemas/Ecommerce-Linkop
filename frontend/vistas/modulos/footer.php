<!--=====================================
FOOTER
======================================-->

<footer class="container-fluid">

	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 formContacto  text-center">

				<h4 style="color: white;">Sé el primero en conocer nuestros nuevos productos</h4>
				<p style="color: white;">Regístrate a nuestra newsletter de clientes preferenciales y recibe promociones personalizadas.</p>
				<form role="form" method="post" onsubmit="return validarContactenos()">

					<!-- <input type="text" id="nombreContactenos" name="nombreContactenos" class="form-control" placeholder="Escriba su nombre" required> 

							<br> -->

					<input type="email" id="emailContactenos" name="emailContactenos" class="	form-control" placeholder="Escriba su correo electrónico" required>

					<!--    	          
						<textarea id="mensajeContactenos" name="mensajeContactenos" class="form-control" placeholder="Escriba su mensaje" rows="5" required></textarea>

						<br> -->
						<br>

					<input type="submit" value="Subscribe" class="btn btn-default backColor pull-center" id="enviar">

				</form>

				<?php

				$contactenos = new ControladorUsuarios();
				$contactenos->ctrFormularioContactenos();

				?>

			</div>

			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center social">
						<br>
						<br>
						<br>

				<ul>
				<li>			<!-- <li>
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
						<a href="' . $value["url"] . '" target="_blank">
							<i class="fa ' . $value["red"] . ' redSocial ' . $value["estilo"] . '" aria-hidden="true"></i>
						</a>
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

			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  text-center">

				<h4><a href="#" class="" titulo="CONOCENOS" style="color: white;">QUIENES SOMOS</a></h4>

				<ul>
					<li><a href="#" class="pixelCategorias"> Nuestra historia</a></li>
				</ul>
				<ul>
					<li><a href="#" class="pixelCategorias">Términos y Condiciones</a></li>
				</ul>

				<ul>
					<li><a href="#" class="pixelCategorias">Política de Privacidad</a></li>
				</ul>

				<ul>
					<li><a href="#" class="pixelCategorias">Política de devoluciones</a></li>
				</ul>



			</div>
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  text-center">

				<h4><a href="#" class="" titulo="PRODUCTOS" style="color: white;">PRODUCTOS</a></h4>



				<?php

				$url = Ruta::ctrRuta();

				$item = null;
				$valor = null;

				$categorias = ControladorProductos::ctrMostrarCategorias($item, $valor);

				foreach ($categorias as $key => $value) {


					echo '<ul> <li><a href="' . $url . $value["ruta"] . '" class="pixelCategorias" titulo="' . $value["categoria"] . '">' . $value["categoria"] . '</a></li> </ul>';
				}

				?>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  text-center ">

				<h4><a href="#" class="" titulo="BLOG" style="color: white;">BLOG</a></h4>
				<ul>
					<li><a href="#" class="pixelCategorias"> Nuestra historia</a></li>
				</ul>
				<ul>
					<li><a href="#" class="pixelCategorias">Términos y Condiciones</a></li>
				</ul>

				<ul>
					<li><a href="#" class="pixelCategorias">Política de Privacidad</a></li>
				</ul>


			</div>
			<div class="col-md-3 col-sm-12 col-xs-12 text-left infoContacto  text-center">

				<h5 style="color: white;">CONTACTO</h5>


				<h5>

					<i class="fa fa-phone-square" aria-hidden="true" style="color: white;"></i> Llámanos: 800 134 26 90

					<br><br>

					<i class="fa fa-envelope" aria-hidden="true" style="color: white;"></i> ventas@fibremex.com.mx



				</h5>

			</div>
			<!--=====================================
			DATOS CONTACTO
			======================================-->



			<!--=====================================
			FORMULARIO CONTÁCTENOS
			======================================-->



		</div>



	</div>

	
</footer>


<!--=====================================
FINAL
======================================-->