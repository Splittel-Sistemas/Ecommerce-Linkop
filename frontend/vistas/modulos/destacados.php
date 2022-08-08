<!--=====================================
BANNER
======================================-->
<style>
	.MultiCarousel {
		float: left;
		overflow: hidden;
		padding: 15px;
		width: 100%;
		position: relative;
	}

	.MultiCarousel .MultiCarousel-inner {
		transition: 1s ease all;
		float: left;
	}

	.MultiCarousel .MultiCarousel-inner .item {
		float: left;
	}

	.MultiCarousel .MultiCarousel-inner .item>div {
		text-align: center;
		padding: 10px;
		margin: 10px;
		background: #f1f1f1;
		color: #666;
	}

	.MultiCarousel .leftLst,
	.MultiCarousel .rightLst {
		position: absolute;
		border-radius: 50%;
		top: calc(50% - 20px);
	}

	.MultiCarousel .leftLst {
		left: 0;
	}

	.MultiCarousel .rightLst {
		right: 0;
	}

	.MultiCarousel .leftLst.over,
	.MultiCarousel .rightLst.over {
		pointer-events: none;
		background: #ccc;
	}
</style>
<style>
	h2 {
		margin-bottom: .5em;
	}

	.grid-container {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
		grid-gap: 1em;
	}


	/* hover styles */
	.location-listing {
		position: relative;
	}

	.location-image {
		line-height: 0;
		overflow: hidden;
	}

	.location-image img {
		filter: blur(0px);
		transition: filter 0.3s ease-in;
		transform: scale(1.1);
	}

	.location-title {
		font-size: 1.5em;
		font-weight: bold;
		text-decoration: none;
		z-index: 1;
		position: absolute;
		height: 100%;
		width: 100%;
		top: 0;
		left: 0;
		opacity: 0;
		transition: opacity .5s;
		background: rgba(3, 15, 36, 0.72);
		color: white;

		/* position the text in t’ middle*/
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.location-listing:hover .location-title {
		opacity: 1;
	}

	.location-listing:hover .location-image img {
		filter: blur(2px);
	}


	/* for touch screen devices */
	@media (hover: none) {
		.location-title {
			opacity: 1;
		}

		.location-image img {
			filter: blur(2px);
		}
	}
</style>
<?php

$servidor = Ruta::ctrRutaServidor();

$ruta = "sin-categoria";



/*=============================================
PRODUCTOS DESTACADOS
=============================================*/

$titulosModulos = array(/* "ARTÍCULOS GRATUITOS", */ /* "PRODUCTOS", */"LO MÁS VENDIDO" /* , "LO MÁS VISTO" */);
$rutaModulos = array(/* "articulos-gratis", */"lo-mas-vendido" /* ,"lo-mas-visto" */);

$base = 0;
$tope = 4;

/* if($titulosModulos[0] == "ARTÍCULOS GRATUITOS"){

$ordenar = "id";
$item = "estado";
$valor = 0;
$modo = "DESC";

$gratis = ControladorProductos::ctrMostrarProductos($ordenar, $item, $valor, $base, $tope, $modo);

} */

if ($titulosModulos[0] == "LO MÁS VENDIDO") {

	$ordenar = "ventas";
	$item = "estado";
	$valor = 1;
	$modo = "DESC";

	$ventas = ControladorProductos::ctrMostrarProductos($ordenar, $item, $valor, $base, $tope, $modo);
}

/* if($titulosModulos[2] == "LO MÁS VISTO"){

$ordenar = "vistas";
$item = "estado";
$valor = 1;
$modo = "DESC";

$vistas = ControladorProductos::ctrMostrarProductos($ordenar, $item, $valor, $base, $tope, $modo);

} */

/* if ($titulosModulos[1] == "PRODUCTOS") {

	$base = 0;
	$tope = 4;

	$ordenar = "vistas";
	$item = "estado";
	$valor = 1;
	$modo = "DESC";

	$vistas1 = ControladorProductos::ctrMostrarProductos($ordenar, $item, $valor, $base, $tope, $modo);
} */
$modulos = array(/* $gratis, */ /* $vistas1 */ /* , $vistas */$ventas);

for ($i = 0; $i < count($titulosModulos); $i++) {
	/* <div class="container-fluid well well-sm barraProductos">

			<div class="container">
				
				<div class="row">
					
					<div class="col-xs-12 organizarProductos">

						<div class="btn-group pull-right">

							 <button type="button" class="btn btn-default btnGrid" id="btnGrid'.$i.'">
							 	
								<i class="fa fa-th" aria-hidden="true"></i>  

								<span class="col-xs-0 pull-right"> GRID</span>

							 </button>

							 <button type="button" class="btn btn-default btnList" id="btnList'.$i.'">
							 	
								<i class="fa fa-list" aria-hidden="true"></i> 

								<span class="col-xs-0 pull-right"> LIST</span>

							 </button>
							
						</div>		

					</div>

				</div>

			</div>

		</div> */
	echo '


		<div class="container-fluid productos">
	
			<div class="container">
		
			<div class="container"> 

			<div class="col-xs-12 tituloDestacado">

			<div class="col-sm-4 col-xs-4 text-center ">
			
				


				</div>
				<div class="col-sm-4 col-xs-12 text-center " >
			
				

					<a href="' . $rutaModulos[$i] . ' ">
						
					
						
					<h1 class="text-center" ><small style="font-weight: bold;" >' . $titulosModulos[$i] . ' </small></h1>


				</a>

				</div>
				<div class="col-sm-4 col-xs-4 text-center ">
			
				


				</div>
			

			</div>

			<div class="clearfix"></div>


		</div>

				<ul class="grid' . $i . '">';


	foreach ($modulos[$i] as $key => $value) {

		if ($value["estado"] != 0) {

			echo '<li class="col-md-3 col-sm-6 col-xs-6">

							<figure>
								
								<a href="' . $value["ruta"] . '" class="pixelProducto" >
									
									<center>
									<img src="' . $servidor . $value["portada"] . '" class="img-responsive" width="100%">
									</center>

								</a>

							</figure>

							<h4>
					
								<small>
									
									<a href="' . $value["ruta"] . '" class="pixelProducto">
										
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
						
												<strong class="oferta">MXN $' . $value["precio"] . '</strong>

											</small>

											<small>$' . $value["precioOferta"] . '</small>
										
										</h2>';
				} else {

					echo '<h2><small>MXN $' . $value["precio"] . '</small></h2>';
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

			echo '<a href="' . $value["ruta"] . '" class="pixelProducto">
									
										<button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Ver producto">
											
											<i class="fa fa-eye" aria-hidden="true"></i>

										</button>	
									
									</a>

								</div>

							</div>

						</li>';
		}
	}

	echo '</ul>

				<ul class="list' . $i . '" style="display:none">';

	foreach ($modulos[$i] as $key => $value) {

		if ($value["estado"] != 0) {

			echo '<li class="col-xs-12">
					  
				  		<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12>
							   
							<figure>
						
								<a href="' . $value["ruta"] . '" class="pixelProductoa">
									
									<img src="' . $servidor . $value["portada"] . '" class="img-responsive" >

								</a>

							</figure>

					  	</div>
							  
						<div class="col-lg-10 col-md-7 col-sm-8 col-xs-12">
							
							<h1>

								<small>
								
									<a href="' . $value["ruta"] . '" class="pixelProducto">
										
										' . $value["titulo"] . '<br>';

			$fecha = date('Y-m-d');
			$fechaActual = strtotime('-30 day', strtotime($fecha));
			$fechaNueva = date('Y-m-d', $fechaActual);

			if ($fechaNueva < $value["fecha"]) {

				echo '<span class="label label-warning">Nuevo</span> ';
			}

			if ($value["oferta"] != 0 && $value["precio"] != 0) {

				echo '<span class="label label-warning">' . $value["descuentoOferta"] . '% off</span>';
			}

			echo '</a>

								</small>

							</h1>

							<p class="text-muted">' . $value["titular"] . '</p>';

			if ($value["precio"] == 0) {

				echo '<h2><small>GRATIS</small></h2>';
			} else {

				if ($value["oferta"] != 0) {

					echo '<h2>

											<small>
						
												<strong class="oferta">MXN $' . $value["precio"] . '</strong>

											</small>

											<small>$' . $value["precioOferta"] . '</small>
										
										</h2>';
				} else {

					echo '<h2><small>MXN $' . $value["precio"] . '</small></h2>';
				}
			}

			echo '<div class="btn-group pull-left enlaces">
						  	
						  		<button type="button" class="btn btn-default btn-xs deseos"  idProducto="' . $value["id"] . '" data-toggle="tooltip" title="Agregar a mi lista de deseos">

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

			echo '<a href="' . $value["ruta"] . '" class="pixelProducto">

							  		<button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Ver producto">

							  		<i class="fa fa-eye" aria-hidden="true"></i>

							  		</button>

						  		</a>
							
							</div>

						</div>

						<div class="col-xs-12"><hr></div>

					</li>';
		}
	}

	echo '</ul>

			</div>

		</div>';
}

?>


<?php
/* $banner = ControladorProductos::ctrMostrarBanner($ruta);

if ($banner != null) {

	if ($banner["estado"] != 0) {

		echo '<figure class="bannera">

				<img src="' . $servidor . $banner["img"] . '" class="img-responsive" width="100%">	

			  </figure>';
	}
} */
?>

<?php

/*=============================================
CREADOR DE IP
=============================================*/

//https://www.browserling.com/tools/random-ip

$ip = $_SERVER['REMOTE_ADDR'];

//$ip = "153.205.198.22";

//http://www.geoplugin.net/

$informacionPais = file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip);

$datosPais = json_decode($informacionPais);

$pais = $datosPais->geoplugin_countryName;
$codigo = $datosPais->geoplugin_countryCode;

$enviarIp = ControladorVisitas::ctrEnviarIp($ip, $pais, $codigo);

$totalVisitas = ControladorVisitas::ctrMostrarTotalVisitas();

?>
<!------ Include the above in your HEAD tag ---------->
<!--=====================================
BREADCRUMB VISITAS
======================================-->

<!-- <div class="jumbotron jumbotron-fluid">
	<div class="container">
		<div class="row">
			<div class="col-md-4  text-center">
				
			</div>
			<div class="col-md-4  text-center">
				<a target="_blank" href="https://api.whatsapp.com/send?phone=+526692710170&amp;text=%C2%A1Hola! Me gustario obtener informacion sobre Linkop">
					<img src="<?php echo $url; ?>vistas/img/whatsapp(1).png" style="padding-bottom: 5px;"></a>
			</div>
			<div class="col-md-4  text-center">
			
			</div>

		</div>


		<div class="row">
			<br>
			<div class="col-md-12 text-center">
				<p style="color:#000000">

					Nuestros profesionales están para brindar la atención 24/7. Déjanos un mensaje y enseguida te contactamos.

					Nuestros horarios de atención en oficina desde 8:00 am a 7:00 pm. de lunes a viernes.</p>

				<br>

				<h2 class="pull-right"><small>Tu eres nuestro visitante # <?php echo $totalVisitas["total"]; ?></small></h2>
			</div>


		</div>

		
	</div>



</div> -->





<!-- <div class="col-xs-12  text-center" style="display:block" id="listaProductos">
	<div class="row">

		<div class="col-xs-12 tituloDestacado">

			<div class="col-sm-4 col-xs-4 text-center ">




			</div>
			<div class="col-sm-4 col-xs-12 text-center " style="border:1px solid;">







				<h1 class="text-center"><small>CATEGORIAS </small></h1>



			</div>
			<div class="col-sm-4 col-xs-4 text-center ">




			</div>


		</div>

		<div class="clearfix"></div>

		<hr>

	</div>
	<?php

	/* $item = null;
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

				<ul>'; */
	/* 			<img  src="' . $servidor . $value["imgOferta"] . '" width="70%">
				' . $value["categoria"] . '</a> */
	/* 	$item = "id_categoria";

						$valor = $value["id"];

						$subcategorias = ControladorProductos::ctrMostrarSubCategorias($item, $valor);

						foreach ($subcategorias as $key => $value) {

							echo '<li><a href="' . $url . $value["ruta"] . '" class="pixelSubCategorias" titulo="' . $value["subcategoria"] . '">' . $value["subcategoria"] . '</a></li>';
						} */
	/* 
		echo '

				</div>';
	}

 */



	?>

</div> -->


<!-- <div class="container">
	<div class="row">
		<div class="MultiCarousel" id="MultiCarousel" data-interval="1000">
			<div class="MultiCarousel-inner">
				<div class="item">
					<div class="pad15">
						<p class="lead">Multi Item Carousel</p>
						<img src="<?php echo $url; ?>vistas/img/visa.png" style="padding-bottom: 5px;">

					</div>
				</div>
				<div class="item">
					<div class="pad15">
						<p class="lead">Multi Item Carousel</p>
						<img src="<?php echo $url; ?>vistas/img/paypal.png" style="padding-bottom: 5px;">

					</div>
				</div>
				<div class="item">
					<div class="pad15">
						<p class="lead">Multi Item Carousel</p>
						<img src="<?php echo $url; ?>vistas/img/apple-pay.png" style="padding-bottom: 5px;">

					</div>
				</div>
				<div class="item">
					<div class="pad15">
						<p class="lead">Multi Item Carousel</p>
						<img src="<?php echo $url; ?>vistas/img/american-express.png" style="padding-bottom: 5px;">

					</div>
				</div>
				<div class="item">
					<div class="pad15">
						<p class="lead">Multi Item Carousel</p>
						<img src="<?php echo $url; ?>vistas/img/visa.png" style="padding-bottom: 5px;">

					</div>
				</div>


			</div>
		</div>
	</div>
</div> -->
<!-- 3 IMAGENES JUNTAS -->
<div class="container-fluid">
	<div class="row border border-dark ">
		<div class="container-fluid">
			<!-- AQUI  -->
			<div class="col-xs-12 col-sm-12 col-md-6  text-center">
				<div class="col-sm-12 text-center" style="height:100%;border: 1px solid white;">


					<article id="3685" class="location-listing">

						<a class="location-title" href="<?php echo $url; ?>cargadores" style="color: white;">
							CARGADORES </a>

						<div class="location-image">
							<a href="#">
								<img src="<?php echo  $servidor; ?>vistas/img/productos/cargadores.jpg" alt="Random Name" width="100%" height="100%">


							</a>

						</div>

					</article>


					<!-- 
					<a href=" <?php #echo $url 
								?>cables">
						<img src="<?php # echo  $servidor; 
									?>vistas/img/productos/12.jpg" alt="Random Name" width="105%" height="100%">
					</a> -->
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 text-center">
				<div class="col-sm-12" style="border: 1px solid white;">
					<!-- <a href=" <?php #echo $url 
									?>router">
						<img src="<?php #echo  $servidor; 
									?>vistas/img/productos/aa.jpg" alt="Random Name" width="100%" height="50%">
					</a> -->

					<article id="3685" class="location-listing">

						<a class="location-title" href="<?php echo $url; ?>cables" style="color: white;">
							CABLES </a>

						<div class="location-image">
							<a href="#">
								<img src="<?php echo  $servidor; ?>vistas/img/productos/red.jpg" alt="Random Name" width="100%" height="50%">
								<?php
																	/* 
									$item = 'cables';

									$categorias = ControladorProductos::ctrMostrarCategorias1($item, $valor);


									echo '
									<img  src="' . $servidor . $categorias["portada"] . '" alt="Random Name" width="100%" height="50%">
									';



									*/




								?>
							</a>

						</div>

					</article>
				</div>
				<div class="col-sm-12 text-center" style="border: 1px solid white;">



					<article id="3685" class="location-listing">

						<a class="location-title" href="<?php echo $url; ?>hubs-y-adaptadores" style="color: white;">
						HUBS Y ADAPTADORES </a>

						<div class="location-image">
							<a href="#">
								<img src="<?php echo  $servidor; ?>vistas/img/productos/hubs.jpg" alt="Random Name" width="100%" height="50%">

							</a>

						</div>

					</article>
				</div>
			</div>
		</div>
	</div>
</div>
<br>
<div class="child-page-listing text-center">


	<div class="container-fluid">

		<article id="3685" class="location-listing">

			<a class="location-title" href="<?php echo $url; ?>categorias" style="color: white;">
				CATEGORIAS </a>

			<div class="location-image">
				<a href="#">


					<?php
					$banner = ControladorProductos::ctrMostrarBanner($ruta);

					if ($banner != null) {

						if ($banner["estado"] != 0) {

							echo '

				<img src="' . $servidor . $banner["img"] . '" class="img-responsive" width="100%">	

			 ';
						}
					}
					?>


				</a>

			</div>

		</article>

		<!--  <article id="3688" class="location-listing">

      <a class="location-title" href="#" style="color: black;">
          COMPUTADORAS            </a>

      <div class="location-image">
        <a href="#">
            <img width="300" height="169" src="<?php echo $servidor ?>vistas/img/productos/pc.png" alt="COMPUTADORAS">  </a>

      </div>

    </article>

    <article id="3691" class="location-listing">

      <a class="location-title" href="#" style="color: black;">
          ROUTER            </a>

      <div class="location-image">
  
        <a href="#" >
            <img width="300" height="169" src="<?php echo $servidor ?>vistas/img/productos/wifi.png" alt="ROUTER">  </a>

      </div>

    </article>

    <article id="3694" class="location-listing">

      <a class="location-title" href="#" style="color: black;">
          CABLES           </a>

      <div class="location-image">
        <a href="#">
            <img width="300" height="169" src="<?php echo $servidor ?>vistas/img/productos/hdmi.png" alt="CABLES">  </a>

      </div>

    </article> -->



	</div>
	<!-- end grid container -->

	<style>
		.containera {
			padding: 80px 120px;
		}

		.person {
			margin-bottom: 25px;
			width: 100%;
			height: 100%;
			opacity: 0.7;
		}

		.person:hover {
			border-color: #00365f;
			background-color: #00365f;
		}
	</style>

	<!-- 	<div class="containera text-center">
		<h3></h3>

		<div class="row">
			<div class="col-sm-3">
				<p class="text-center"><strong>CABLES</strong></p><br>
				<a href=" <?php echo $url ?>cables">
					<img src="<?php echo  $servidor; ?>vistas/img/productos/hdmi.png" class="img-responsive person" alt="Random Name" width="355" height="355">
				</a>
				<div id="demo" class="collapse">
					<p>Guitarist and Lead Vocalist</p>
					<p>Loves long walks on the beach</p>
					<p>Member since 1988</p>
				</div>
			</div>
			<div class="col-sm-3">
				<p class="text-center"><strong>ROUTER</strong></p><br>
				<a href=" <?php echo $url ?>router">
					<img src="<?php echo  $servidor; ?>vistas/img/productos/wifi.png" class="img-responsive person" alt="Random Name" width="355" height="355">
				</a>
				<div id="demo2" class="collapse">
					<p>Drummer</p>
					<p>Loves drummin'</p>
					<p>Member since 1988</p>
				</div>
			</div>
			<div class="col-sm-3">
				<p class="text-center"><strong>BATERIAS</strong></p><br>
				<a href=" <?php echo $url ?>baterias">
					<img src="<?php echo  $servidor; ?>vistas/img/productos/asas.png" class="img-responsive person" alt="Random Name" width="355" height="355">
				</a>
				<div id="demo3" class="collapse">
					<p>Bass player</p>
					<p>Loves math</p>
					<p>Member since 2005</p>
				</div>
			</div>
			<div class="col-sm-3">
				<p class="text-center"><strong>PC</strong></p><br>
				<a href=" <?php echo $url ?>computadoras">
					<img src="<?php echo  $servidor; ?>vistas/img/productos/pc.png" class="img-responsive person" alt="Random Name" width="355" height="355">
				</a>
				<div id="demo3" class="collapse">
					<p>Bass player</p>
					<p>Loves math</p>
					<p>Member since 2005</p>
				</div>
			</div>

		</div>
	</div> -->
</div>