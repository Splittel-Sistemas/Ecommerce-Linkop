<!--=====================================
BANNER
======================================-->

<?php

$servidor = Ruta::ctrRutaServidor();

$ruta = "sin-categoria";



/*=============================================
PRODUCTOS DESTACADOS
=============================================*/


?>






<!------ Include the above in your HEAD tag ---------->



<div class="col-xs-12  text-center" style="display:block" id="listaProductoss">
	<div class="row">

		<div class="col-xs-12 tituloDestacado">

			<div class="col-sm-4 col-xs-4 text-center ">




			</div>
			<div class="col-sm-4 col-xs-12 text-center ">




			<hr>



				<h1 class="text-center "><small>CATEGORIAS </small></h1>



			</div>
			<div class="col-sm-4 col-xs-4 text-center ">




			</div>


		</div>

		<div class="clearfix"></div>


	</div>
	<?php

	$item = null;
	$valor = null;

	$categorias = ControladorProductos::ctrMostrarCategorias($item, $valor);

	foreach ($categorias as $key => $value) {

		echo '<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 ">

				<h4></h4>
				<a href="' . $url . $value["ruta"] . '" class="  " titulo="' . $value["categoria"] . '">
				<img  src="' . $servidor . $value["portada"] . '" width="50%"><br>
				' . $value["categoria"] . '</a>
				</h4>


				<ul>';
		/* 			<img  src="' . $servidor . $value["imgOferta"] . '" width="70%">
				' . $value["categoria"] . '</a> */
			$item = "id_categoria";

						$valor = $value["id"];

						$subcategorias = ControladorProductos::ctrMostrarSubCategorias($item, $valor);
/* 
						foreach ($subcategorias as $key => $value) {

							echo '<li><a href="' . $url . $value["ruta"] . '" class="pixelSubCategorias" titulo="' . $value["subcategoria"] . '">' . $value["subcategoria"] . '</a></li>';
						} */

		echo '

				</div>';
	}





	?>

</div>

  
<div class="container">

</div>
<br><br><br>
<div class="jumbotron jumbotron-fluid">
<div class="container">
		<div class="row text-center">
			<div class="col-md-4" style="font-size: 20px;color: #000f33">
				<img src="<?php echo $url; ?>vistas/img/ED.png" style="padding-bottom: 5px;"><br>

				ENTREGA A DOMICILIO
			</div>
			
			<div class="col-md-4" style="font-size: 20px;color: #000f33">
				<img src="<?php echo $url; ?>vistas/img/GP.png" style="padding-bottom: 5px;"><br>

				GARANTIA DE PRODUCTOS
			</div>
			<div class="col-md-4" style="font-size: 20px;color: #000f33">
				<img src="<?php echo $url; ?>vistas/img/MP.png" style="padding-bottom: 5px;"><br>


				METODOS DE PAGO 100% SEGUROS
			</div>
		</div>
	</div>
</div>