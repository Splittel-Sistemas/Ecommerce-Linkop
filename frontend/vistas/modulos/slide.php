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
				
							<img src="'.$servidor.$value["imgFondo"].'">

							<div class="slideOpciones '.$value["tipoSlide"].'">';

								if($value["imgProducto"] != ""){

								echo '<img class="imgProducto" src="'.$servidor.$value["imgProducto"].'" style="top:'.$estiloImgProducto["top"].'%; right:'.$estiloImgProducto["right"].'%; width:'.$estiloImgProducto["width"].'%; left:'.$estiloImgProducto["left"].'%">';

								}					

								echo '<div class="textosSlide" style="top:'.$estiloTextoSlide["top"].'%; left:'.$estiloTextoSlide["left"].'%; width:'.$estiloTextoSlide["width"].'%; right:'.$estiloTextoSlide["right"].'%">
									
									<h1 style="color:'.$titulo1["color"].'">'.$titulo1["texto"].'</h1>

									<h2 style="color:'.$titulo2["color"].'">'.$titulo2["texto"].'</h2>

									<h3 style="color:'.$titulo3["color"].'">'.$titulo3["texto"].'</h3>';

								if($value["boton"] != ""){

									echo '<a href="'.$value["url"].'">
										
										<button class="btn btn-default backColor text-uppercase">

										'.$value["boton"].' <span class="fa fa-chevron-right"></span>

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

				for($i = 1; $i <= count($slide); $i++){

					echo '<li item="'.$i.'"><span class="fa fa-circle"></span></li>';

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

<center>
	
	<button id="btnSlide" class="backColor">
		
			<i class="fa fa-angle-up"></i>

	</button>

</center>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
  <div class="row">
    <div class="col-md-3">
	<i class="fa fa-ship" aria-hidden="true"></i>
	Envíos gratuitos al día siguiente
    </div>
    <div class="col-md-3">
	<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
	30 días garantizados para <br>
	regresarte tu dinero
    </div>
    <div class="col-md-3">
	<i class="fa fa-life-ring" aria-hidden="true"></i>

	Garantía Asegurada
    </div>
	<div class="col-md-3">
	<i class="fa fa-phone" aria-hidden="true"></i>

	  Servicio de atención de por vida
    </div>
  </div>
  </div>
</div>
<div class="col-xs-12  " style="display:block"  id="listaProductos">

	<?php

					$item = null;
					$valor = null;

					$categorias = ControladorProductos::ctrMostrarCategorias($item, $valor);

					foreach ($categorias as $key => $value) {

						echo '<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 ">

				<h4>
				<a href="' . $url . $value["ruta"] . '" class="pixelCategorias backColor " titulo="' . $value["categoria"] . '">
				<img  src="' . $servidor . $value["imgOferta"] . '" width="70%"><br>
				' . $value["categoria"] . '</a>
				</h4>

				<hr>

				<ul>';
						/* 			<img  src="' . $servidor . $value["imgOferta"] . '" width="70%">
				' . $value["categoria"] . '</a> */
					/* 	$item = "id_categoria";

						$valor = $value["id"];

						$subcategorias = ControladorProductos::ctrMostrarSubCategorias($item, $valor);

						foreach ($subcategorias as $key => $value) {

							echo '<li><a href="' . $url . $value["ruta"] . '" class="pixelSubCategorias" titulo="' . $value["subcategoria"] . '">' . $value["subcategoria"] . '</a></li>';
						} */

						echo '

				</div>';
					}

	?>

</div>