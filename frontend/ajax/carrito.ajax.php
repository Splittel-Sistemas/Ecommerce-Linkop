<?php

require_once "../extensiones/paypal.controlador.php";

require_once "../controladores/carrito.controlador.php";
require_once "../modelos/carrito.modelo.php";

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
require_once "../modelos/usuarios.modelo.php";


class AjaxCarrito{

	/*=============================================
	MÉTODO PAYPAL
	=============================================*/	

	public $divisa;
	public $total;
	public $totalEncriptado;
	public $impuesto;
	public $envio;
	public $subtotal;
	public $tituloArray;
	public $cantidadArray;
	public $valorItemArray;
	public $idProductoArray;
	/* direccion */
	public $direccion;
	public $codigo;
	public $telefono;
	public $ciudad;
	

/* ACTUALIZAR USUARIO  */
public function ajaxEnviarOpen(){

	if(md5($this->total) == $this->totalEncriptado){

			$datos = array(
					"divisa"=>$this->divisa,
					"total"=>$this->total,
					"impuesto"=>$this->impuesto,
					"envio"=>$this->envio,
					"subtotal"=>$this->subtotal,
					"tituloArray"=>$this->tituloArray,
					"cantidadArray"=>$this->cantidadArray,
					"valorItemArray"=>$this->valorItemArray,
					"idProductoArray"=>$this->idProductoArray,
				);


			echo $respuesta;

	}
}

	/*  */

	public function ajaxEnviarPaypal(){

		if(md5($this->total) == $this->totalEncriptado){

				$datos = array(
						"divisa"=>$this->divisa,
						"total"=>$this->total,
						"impuesto"=>$this->impuesto,
						"envio"=>$this->envio,
						"subtotal"=>$this->subtotal,
						"tituloArray"=>$this->tituloArray,
						"cantidadArray"=>$this->cantidadArray,
						"valorItemArray"=>$this->valorItemArray,
						"idProductoArray"=>$this->idProductoArray,
					);

				$respuesta = Paypal::mdlPagoPaypal($datos);

				echo $respuesta;

		}
	}

	/* ACTUALIZAR USUARIO  */



	public function ajaxActualizarUser(){
		
		

				$datos = array(
						"direccion"=>$this->direccion,
						"codigo"=>$this->codigo,
						"ciudad"=>$this->ciudad,
						"telefono"=>$this->telefono,
						"idUsuario"=>$this->idUsuario,
						
					);

				$respuesta = ModeloUsuarios::mdlActualizarUserEnvio($datos);

				echo $respuesta;

	}


	/*  */
	/*=============================================
	MÉTODO PAYU
	=============================================*/

	public function ajaxTraerComercioPayu(){

		$respuesta = ControladorCarrito::ctrMostrarTarifas(); 

		echo json_encode($respuesta);
	}

	/*=============================================
	VERIFICAR QUE NO TENGA EL PRODUCTO ADQUIRIDO
	=============================================*/

	public $idUsuario;
	public $idProducto;

	public function ajaxVerificarProducto(){

		$datos = array("idUsuario"=>$this->idUsuario,
					   "idProducto"=>$this->idProducto);

		$respuesta = ControladorCarrito::ctrVerificarProducto($datos);

		echo json_encode($respuesta);

	}

}
/*=============================================
MÉTODO OPEN PAY
=============================================*/	

if( isset($_POST["metodoPago"]) && $_POST["metodoPago"] == "open" ){

	
	$idProductos = explode("," , $_POST["idProductoArray"]);
	$cantidadProductos = explode("," , $_POST["cantidadArray"]);
	$precioProductos = explode("," , $_POST["valorItemArray"]);

	$item = "id";


	$paypal = new AjaxCarrito();
	/* $paypal ->total = $_POST["total"];

	$paypal ->subtotal = $_POST["subtotal"]; */
	$paypal ->tituloArray = $_POST["tituloArray"];
	$paypal ->cantidadArray = $_POST["cantidadArray"];
	$paypal ->valorItemArray = $_POST["valorItemArray"];
	$paypal ->idProductoArray = $_POST["idProductoArray"];
	$paypal ->direccion = $_POST["direccion"];
	$paypal ->codigo = $_POST["codigo"];
	$paypal ->telefono = $_POST["telefono"];
	$paypal ->ciudad = $_POST["ciudad"];
	$paypal ->idUsuario = $_POST["idUsuario"];



	/* $paypal -> ajaxEnviarOpen(); */
	$paypal -> ajaxActualizarUser();


	return;
/* 	$paypal = new AjaxCarrito();
	$paypal -> ajaxTraerComercioPayu(); */

}
/*=============================================
MÉTODO PAYPAL
=============================================*/	

if(isset($_POST["metodoPago"]) && $_POST["metodoPago"] == "paypal" ){

	$idProductos = explode("," , $_POST["idProductoArray"]);
	$cantidadProductos = explode("," , $_POST["cantidadArray"]);
	$precioProductos = explode("," , $_POST["valorItemArray"]);

	$item = "id";

	for($i = 0; $i < count($idProductos); $i ++){

		$valor = $idProductos[$i];

		$verificarProductos = ControladorProductos::ctrMostrarInfoProducto($item, $valor);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://free.currconv.com/api/v7/convert?q=MXN_".$_POST["divisa"]."&compact=ultra&apiKey=bdaab752b1d5aefb5db0-"); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200){
		
			$divisa = curl_exec($ch);

			$jsonDivisa = json_decode($divisa, true);   
			
			if($jsonDivisa["status"] == 400){

				$conversion = 1;
			
			}else{

				$conversion = $jsonDivisa["MXN_".$_POST["divisa"]];

			}

		}else{

			$conversion = 1;
		}

		if($verificarProductos["precioOferta"] == 0){

			$precio = $verificarProductos["precio"]*$conversion;
		
		}else{

			$precio = $verificarProductos["precioOferta"]*$conversion;

		}

		$verificarSubTotal = $cantidadProductos[$i]*$precio;

		// echo number_format($verificarSubTotal,2)."<br>";
		// echo number_format($precioProductos[$i],2)."<br>";

		// return;

		if(number_format($verificarSubTotal,2) != number_format($precioProductos[$i],2)){

			echo "carrito-de-compras";

			return;

		}

	}

	$paypal = new AjaxCarrito();
	$paypal ->divisa = $_POST["divisa"];
	$paypal ->total = $_POST["total"];
	$paypal ->totalEncriptado = $_POST["totalEncriptado"];
	$paypal ->impuesto = $_POST["impuesto"];
	$paypal ->envio = $_POST["envio"];
	$paypal ->subtotal = $_POST["subtotal"];
	$paypal ->tituloArray = $_POST["tituloArray"];
	$paypal ->cantidadArray = $_POST["cantidadArray"];
	$paypal ->valorItemArray = $_POST["valorItemArray"];
	$paypal ->idProductoArray = $_POST["idProductoArray"];
	/* RMN */
	$paypal ->direccion = $_POST["direccion"];
	$paypal ->codigo = $_POST["codigo"];
	$paypal ->telefono = $_POST["telefono"];
	$paypal ->ciudad = $_POST["ciudad"];
	$paypal ->idUsuario = $_POST["idUsuario"];



	/*  */
	$paypal -> ajaxEnviarPaypal();
	$paypal -> ajaxActualizarUser();



}

/*=============================================
MÉTODO PAYU
=============================================*/	

if(isset($_POST["metodoPago"]) && $_POST["metodoPago"] == "payu"){

	$idProductos = explode("," , $_POST["idProductoArray"]);
	$cantidadProductos = explode("," , $_POST["cantidadArray"]);
	$precioProductos = explode("," , $_POST["valorItemArray"]);

	$item = "id";

	for($i = 0; $i < count($idProductos); $i ++){

		$valor = $idProductos[$i];

		$verificarProductos = ControladorProductos::ctrMostrarInfoProducto($item, $valor);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://free.currconv.com/api/v7/convert?q=MXN_".$_POST["divisaPayu"]."&compact=ultra&apiKey=bdaab752b1d5aefb5db0"); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200){
		
			$divisa = curl_exec($ch);

			$jsonDivisa = json_decode($divisa, true);   

			if($jsonDivisa["status"] == 400){
			
				$conversion = 1;
			
			}else{

				$conversion = $jsonDivisa["MXN_".$_POST["divisaPayu"]];

			}

		}else{

			$conversion = 1;

		}

		if($verificarProductos["precioOferta"] == 0){

			$precio = $verificarProductos["precio"]*$conversion;
		
		}else{

			$precio = $verificarProductos["precioOferta"]*$conversion;

		}

		$verificarSubTotal = $cantidadProductos[$i]*$precio;

		// echo number_format($verificarSubTotal,2)."<br>";
		// echo number_format($precioProductos[$i],2)."<br>";

		// return;

		if(number_format($verificarSubTotal,2) != number_format($precioProductos[$i],2)){

			echo "carrito-de-compras";

			return;

		}

	}

	$payu = new AjaxCarrito();
	$payu -> ajaxTraerComercioPayu();

}

/*=============================================
VERIFICAR QUE NO TENGA EL PRODUCTO ADQUIRIDO
=============================================*/	

if(isset($_POST["idUsuario"]) && isset($_POST["idProducto"])){

	$deseo = new AjaxCarrito();
	$deseo -> idUsuario = $_POST["idUsuario"];
	$deseo -> idProducto = $_POST["idProducto"];
	$deseo ->ajaxVerificarProducto();
}