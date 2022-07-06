<!--=====================================
SLIDESHOW  
======================================-->

<div class="container-fluid" id="slide">

	<div class="row">

		<!--=====================================
		DIAPOSITIVAS
		======================================-->

		<ul>

			<?php

			$servidor = Ruta::ctrRutaServidor();

			$slide = ControladorSlide::ctrMostrarSlide();

			foreach ($slide as $key => $value) {

				$estiloImgProducto = json_decode($value["estiloImgProducto"], true);
				$estiloTextoSlide = json_decode($value["estiloTextoSlide"], true);
				$titulo1 = json_decode($value["titulo1"], true);
				$titulo2 = json_decode($value["titulo2"], true);
				$titulo3 = json_decode($value["titulo3"], true);

				echo '<li>
				
							<img src="' . $servidor . $value["imgFondo"] . '">

							<div class="slideOpciones ' . $value["tipoSlide"] . '">';

				if ($value["imgProducto"] != "") {

					echo '<img class="imgProducto" src="' . $servidor . $value["imgProducto"] . '" style="top:' . $estiloImgProducto["top"] . '%; right:' . $estiloImgProducto["right"] . '%; width:' . $estiloImgProducto["width"] . '%; left:' . $estiloImgProducto["left"] . '%">';
				}

				echo '<div class="textosSlide text-center" style="top:' . $estiloTextoSlide["top"] . '%; left:' . $estiloTextoSlide["left"] . '%; width:' . $estiloTextoSlide["width"] . '%; right:' . $estiloTextoSlide["right"] . '%">
									
									<h1 style="color:' . $titulo1["color"] . '">' . $titulo1["texto"] . '</h1>

									<h2 style="color:' . $titulo2["color"] . '">' . $titulo2["texto"] . '</h2>

									<h3 style="color:' . $titulo3["color"] . '">' . $titulo3["texto"] . '</h3>';

				if ($value["boton"] != "") {

					echo '<a href="' . $value["url"] . '">
										
										<button class="btn btn-default backColor text-uppercase">

										' . $value["boton"] . ' <span class="fa fa-chevron-right"></span>

										</button>

									</a>';
				}

				echo '</div>	

							</div>

						</li>';
			}

			?>

		</ul>

		<!--=====================================
		PAGINACIÓN
		======================================-->

		<ol id="paginacion">

			<?php

			for ($i = 1; $i <= count($slide); $i++) {

				echo '<li item="' . $i . '"><span class="fa fa-circle"></span></li>';
			}

			?>

		</ol>

		<!--=====================================
		FLECHAS
		======================================-->

		<div class="flechas" id="retroceder"><span class="fa fa-chevron-left"></span></div>
		<div class="flechas" id="avanzar"><span class="fa fa-chevron-right"></span></div>

	</div>

</div>

<!-- <center>
	
	<button id="btnSlide" class="">
		
			<i class="fa fa-angle-up"></i>

	</button>

</center> -->

<div class="jumbotron jumbotron-fluid">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-3" style="font-size: 20px;color: #000f33">
				<img src="<?php echo $url; ?>vistas/img/camion-de-reparto.png" style="padding-bottom: 5px;"><br>

				ENTREGA A <br> DOMICILIO
			</div>
			<div class="col-md-3" style="font-size: 20px;color: #000f33">
				<img src="<?php echo $url; ?>vistas/img/demostracion-en-la-tienda.png" style="padding-bottom: 5px;"><br>

				PUNTO DE VENTA Y ENTREGA NO DISPONIBLE
			</div>
			<div class="col-md-3" style="font-size: 20px;color: #000f33">
				<img src="<?php echo $url; ?>vistas/img/garantia.png" style="padding-bottom: 5px;"><br>

				GARANTIA DE PRODUCTOS
			</div>
			<div class="col-md-3" style="font-size: 20px;color: #000f33">
				<img src="<?php echo $url; ?>vistas/img/tarjeta-de-credito.png" style="padding-bottom: 5px;"><br>


				COMPRA  <br> SEGURA
			</div>
		</div>
	</div>
</div>