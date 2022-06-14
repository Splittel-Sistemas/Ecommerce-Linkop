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
<?php

$servidor = Ruta::ctrRutaServidor();

$ruta = "sin-categoria";



/*=============================================
PRODUCTOS DESTACADOS
=============================================*/

$titulosModulos = array("LO MÁS VENDIDO");
$rutaModulos = array("lo-mas-vendido");

$base = 0;
$tope = 4;



if ($titulosModulos[0] == "LO MÁS VENDIDO") {

	$ordenar = "ventas";
	$item = "estado";
	$valor = 1;
	$modo = "DESC";

	$ventas = ControladorProductos::ctrMostrarProductos($ordenar, $item, $valor, $base, $tope, $modo);
}




$modulos = array($ventas);

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
		
				<div class="row">

					<div class="col-xs-12 tituloDestacado">

					<div class="col-sm-4 col-xs-4 text-center ">
					
						


						</div>
						<div class="col-sm-4 col-xs-12 text-center " style="border:1px solid;">
					
						

							<a href="' . $rutaModulos[$i] . ' ">
								
							
								
							<h1 class="text-center" ><small>' . $titulosModulos[$i] . ' </small></h1>


						</a>

						</div>
						<div class="col-sm-4 col-xs-4 text-center ">
					
						


						</div>
					

					</div>

					<div class="clearfix"></div>

					<hr>

				</div>

				<ul class="grid' . $i . '"  style="border: 1px solid #EEEEEE;">';


	foreach ($modulos[$i] as $key => $value) {

		if ($value["estado"] != 0) {

			echo '<li class="col-md-3 col-sm-6 col-xs-12" style="border: 1px solid #EEEEEE;">

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

				echo '<span class="label label-warning fontSize">' . $value["descuentoOferta"] . '% off</span>';
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
						
												<strong class="oferta">USD $' . $value["precio"] . '</strong>

											</small>

											<small>$' . $value["precioOferta"] . '</small>
										
										</h2>';
				} else {

					echo '<h2><small>USD $' . $value["precio"] . '</small></h2>';
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
					  
				  		<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
							   
							<figure>
						
								<a href="' . $value["ruta"] . '" class="pixelProducto">
									
									<img src="' . $servidor . $value["portada"] . '" class="img-responsive">

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
						
												<strong class="oferta">USD $' . $value["precio"] . '</strong>

											</small>

											<small>$' . $value["precioOferta"] . '</small>
										
										</h2>';
				} else {

					echo '<h2><small>USD $' . $value["precio"] . '</small></h2>';
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
$banner = ControladorProductos::ctrMostrarBanner($ruta);

if ($banner != null) {

	if ($banner["estado"] != 0) {

		echo '<figure class="bannera">

				<img src="' . $servidor . $banner["img"] . '" class="img-responsive" width="100%">	

			  </figure>';
	}
}
?>

<div class="jumbotron jumbotron-fluid">
	<div class="container">
		<div class="row">
			<div class="col-md-4  text-center">
				<!-- <a target="_blank" href="https://api.whatsapp.com/send?phone=+526692710170&amp;text=%C2%A1Hola! Me gustario obtener informacion sobre Linkop">
					<img src="<?php echo $url; ?>vistas/img/whatsapp(2).png" style="padding-bottom: 5px;"></a> -->
			</div>
			<div class="col-md-4  text-center">
				<a target="_blank" href="https://api.whatsapp.com/send?phone=+526692710170&amp;text=%C2%A1Hola! Me gustario obtener informacion sobre Linkop">
					<img src="<?php echo $url; ?>vistas/img/whatsapp(1).png" style="padding-bottom: 5px;"></a>
			</div>
			<div class="col-md-4  text-center">
				<!-- 	<a target="_blank" href="https://api.whatsapp.com/send?phone=+526692710170&amp;text=%C2%A1Hola! Me gustario obtener informacion sobre Linkop">
					<img src="<?php echo $url; ?>vistas/img/whatsapp(2).png" style="padding-bottom: 5px;"></a> -->
			</div>

		</div>


		<div class="row">
			<br>
			<div class="col-md-12 text-center">
				<p>

					Nuestros profesionales están para brindar la atención 24/7. Déjanos un mensaje y enseguida te contactamos.

					Nuestros horarios de atención en oficina desde 8:00 am a 7:00 pm. de lunes a viernes.</p>
			</div>


		</div>
	</div>
</div>


<!------ Include the above in your HEAD tag ---------->


</div>


<div class="container">
	<div class="row">
		<div class="MultiCarousel"  id="MultiCarousel" data-interval="1000">
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
</div>