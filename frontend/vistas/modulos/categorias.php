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


</div>

<div class="col-xs-12  text-center" style="display:block" id="listaProductos">
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


<div class="container">

</div>