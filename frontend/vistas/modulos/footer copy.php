<!--=====================================
FOOTER
======================================-->

<footer class="container-fluid">

	<div class="container">

		<div class="row">

		 	<!--=====================================
			CATEGORÍAS Y SUBCATEGORÍAS FOOTER
			======================================-->

			<div class="col-lg-5 col-md-6 col-xs-12 footerCategorias">

			<?php

				$url = Ruta::ctrRuta();

				$item = null;
				$valor = null;

				$categorias = ControladorProductos::ctrMostrarCategorias($item, $valor);

				foreach ($categorias as $key => $value) {

					echo '<div class="col-lg-4 col-md-3 col-sm-4 col-xs-12">

						<h4><a href="'.$url.$value["ruta"].'" class="pixelCategorias" titulo="'.$value["categoria"].'">'.$value["categoria"].'</a></h4>

						<hr>

						<ul>';

						$item = "id_categoria";

						$valor = $value["id"];

						$subcategorias = ControladorProductos::ctrMostrarSubCategorias($item, $valor);
						
						foreach ($subcategorias as $key => $value) {
						
							echo '<li><a href="'.$url.$value["ruta"].'" class="pixelSubCategorias" titulo="'.$value["subcategoria"].'">'.$value["subcategoria"].'</a></li>';

						}

						echo '</ul>

					</div>';

				}

			?>

			</div>

			<!--=====================================
			DATOS CONTACTO
			======================================-->

			<div class="col-md-3 col-sm-6 col-xs-12 text-left infoContacto">
				
				<h5>Dudas e inquietudes, contáctenos en:</h5>

				<br>
				
				<h5>
					
					<i class="fa fa-phone-square" aria-hidden="true"></i> Llámanos: 800 134 26 90 

					<br><br>

					<i class="fa fa-envelope" aria-hidden="true"></i> ventas@fibremex.com.mx

					<br><br>

					<i class="fa fa-map-marker" aria-hidden="true"></i> Lunes-Viernes: 8:00 am - 8:00 pm
					A partir del 19 de febrero tendremos horario sabatino de 9:00 am - 5:00 pm

					<br><br>
					Parque Tecnológico Innovación Querétaro, carretera estatal 431 Km. 2.2, Interior 28, El Marqués, Querétaro

				</h5>

<!-- 				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.061210342917!2d-75.60279258568647!3d6.255666795471985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4429739f2122e9%3A0x4812b922f0ad8f18!2sCl.+45f+%2382-31%2C+Medell%C3%ADn%2C+Antioquia!5e0!3m2!1ses!2sco!4v1511900955540" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>	
 -->				<iframe src="https://www.google.com/maps/embed?data=!4m5!3m4!1s0x0:0x448932fde9382fe0!8m2!3d20.5546298!4d-100.2710875" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>	

			</div>

			<!--=====================================
			FORMULARIO CONTÁCTENOS
			======================================-->

			<div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 formContacto">
				
				<h4>RESUELVA SU INQUIETUD</h4>

				<form role="form" method="post" onsubmit="return validarContactenos()">

			  		<input type="text" id="nombreContactenos" name="nombreContactenos" class="form-control" placeholder="Escriba su nombre" required> 

			   		<br>
	    	      
   					<input type="email" id="emailContactenos" name="emailContactenos" class="	form-control" placeholder="Escriba su correo electrónico" required>  

   					<br>
	    		     	          
	       			<textarea id="mensajeContactenos" name="mensajeContactenos" class="form-control" placeholder="Escriba su mensaje" rows="5" required></textarea>

	       			<br>
	    	
	       			<input type="submit" value="Enviar" class="btn btn-default backColor pull-right" id="enviar">         

				</form>

				<?php 

					$contactenos = new ControladorUsuarios();
					$contactenos -> ctrFormularioContactenos();

				?>

			</div>
			
		</div>

	</div>

</footer>


<!--=====================================
FINAL
======================================-->

<div class="container-fluid final">
	
	<div class="container">
	
		<div class="row">
			
			<div class="col-sm-6 col-xs-12 text-left text-muted">
				
				<h5>&copy; © Todos los derechos reservados. Hecho por Grupo Splittel</h5>

			</div>

			<div class="col-sm-6 col-xs-12 text-right social">
				
			<ul>

			<?php
				
			$social = ControladorPlantilla::ctrEstiloPlantilla();

				$jsonRedesSociales = json_decode($social["redesSociales"],true);		

				foreach ($jsonRedesSociales as $key => $value) {

					if($value["activo"] == 1){

						echo '<li>
								<a href="'.$value["url"].'" target="_blank">
									<i class="fa '.$value["red"].' redSocial '.$value["estilo"].'" aria-hidden="true"></i>
								</a>
							</li>';

					}
				}

			?>

			</ul>

			</div>

		</div>

	</div>

</div>