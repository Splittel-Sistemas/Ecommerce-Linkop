<!--=====================================
BANNER
======================================-->







<!------ Include the above in your HEAD tag ---------->



<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<!------ Include the above in your HEAD tag ---------->

<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet"> 
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">  -->

<style>
	@import url(https://fonts.googleapis.com/css?family=Raleway:400,900,700,600,500,300,200,100,800);

	section {
		padding: 60px 0px;
		font-family: 'Raleway', sans-serif;
	}

	h2 {
		color: #4C4C4C;
		word-spacing: 5px;
		font-size: 30px;
		font-weight: 700;
		margin-bottom: 30px;
		font-family: 'Raleway', sans-serif;
	}

	p {
		font-size: 13px;
	}

	.ion-minus {
		padding: 0px 10px;
	}

	#blog {
		background-color: #f6f6f6;
	}

	#blog .carousel-indicators {
		bottom: -60px;
	}

	#blog .carousel-indicators li {
		background-color: #5db4c0;
		height: 13px;
		width: 13px;
		margin: 5px;
	}

	#blog .carousel-indicators li.active {
		background-color: #888383;
	}

	#blog .card-block {
		padding: 10px;
	}

	#blog .card {
		background-color: #FFF;
		border: 1px solid #eceaea;
		margin: 20px 0px;
	}

	/* .btn.btn-default {
    background-color: #5db4c0;
    color: #fff;
    border-radius: 0;
    border: none;
    padding: 13px 20px;
    font-size: 13px;
    font-weight: 600;
} */
</style>

<section id="blog">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h2 style="color:#000000">
					<span class="ion-minus"></span>Blog Linkop<span class="ion-minus"></span>
				</h2>
			</div>
		</div>
		<div class="row">
			<?php
			$servidor = Ruta::ctrRutaServidor();

			$item = null;
			$valor = null;
			$i = 0;

			$banner = ControladorBlog::ctrMostrarBlog($item, $valor);
			foreach ($banner as $key => $value) {
				if($banner[$i]['estado'] == 1){
				echo '
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="card text-center">
			<img class="card-img-top" src="' . $servidor . $banner[$i]['img'] . '" alt="" width="100%">

				<div class="card-block">
					<h4 class="card-title"><b>' . $banner[$i]['ruta'] . '</b></h4>
					<p class="card-text">' . $banner[$i]['fecha'] . '</p>
					<a class="btn btn-default" href="blogs/' . $banner[$i]['id'] . '">Leer</a>
				</div>
			</div>
		</div>';

				}

				$i++;

			}
			?>






		</div>

</section>