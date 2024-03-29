<?php

  /*  print_r($_POST);
   exit; */
if(isset($_POST) &&  $_POST['metodoPago'] == 'open'){
   require_once "../../modelos/rutas.php";
   require_once "../../modelos/carrito.modelo.php";
   require_once "../../modelos/usuarios.modelo.php";
   require_once "../../modelos/notificaciones.modelo.php";
   require_once "../../modelos/productos.modelo.php";


   
   require_once "../../controladores/carrito.controlador.php";
   require_once "../../controladores/productos.controlador.php";
   require_once "../../controladores/usuarios.controlador.php";
   require_once "../../controladores/notificaciones.controlador.php";
   $url = Ruta::ctrRuta();

   
   #recibo los productos comprados
   $productos = explode(",", $_POST['idProductoArray']);
   $cantidad = explode(",", $_POST['cantidadArray']);
   $pago = explode(",", $_POST['valorItemArray']);
   $titulo = explode(",", $_POST['tituloArray']);


            $item = "id";
            $valor = $_POST['idUsuario'];

            $datosUsuarios = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
         $direccionBase = $datosUsuarios["direccion"].", ".$datosUsuarios["ciudad"].", ".$datosUsuarios["telefono"].", ".$datosUsuarios["codigo"];

               
         #Actualizamos la base de datos
         for($i = 0; $i < count($productos); $i++){

               $datos = array("idUsuario"=>$_POST['idUsuario'],
                           "idProducto"=>$productos[$i],
                           "metodo"=>"open pay",
                           "email"=>$datosUsuarios["email"],
                           "direccion"=>$direccionBase,
                           "pais"=>"MX",
                           "cantidad"=>$cantidad[$i],
                           "detalle"=>$titulo[$i],
                           "pago"=>$pago[$i]);

               $respuesta = ControladorCarrito::ctrNuevasCompras($datos);

               $ordenar = "id";
               $item = "id";
               $valor = $productos[$i];

               $productosCompra = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);

               foreach ($productosCompra as $key => $value) {

                  $item1 = "ventas";
                  $valor1 = $value["ventas"] + $cantidad[$i];
                  $item2 = "id";
                  $valor2 =$value["id"];

                  $actualizarCompra = ControladorProductos::ctrActualizarProducto($item1, $valor1, $item2, $valor2);
                  
               }

               if($respuesta == "ok" && $actualizarCompra == "ok"){

               

               }

}

}
/* PAGO CON OXXO PAY */


if(isset($_GET['metodoPago']) &&  $_GET['metodoPago'] == 'oxxo'){
   
 /*   $r = print_r($_GET); */
   
  


   require_once "../../modelos/rutas.php";
   require_once "../../modelos/carrito.modelo.php";
   require_once "../../modelos/usuarios.modelo.php";
   require_once "../../modelos/notificaciones.modelo.php";
   require_once "../../modelos/productos.modelo.php";


   
   require_once "../../controladores/carrito.controlador.php";
   require_once "../../controladores/productos.controlador.php";
   require_once "../../controladores/usuarios.controlador.php";
   require_once "../../controladores/notificaciones.controlador.php";
   $url = Ruta::ctrRuta();

   
   #recibo los productos comprados
   $productos = explode(",", $_GET['idProductoArray']);
   $cantidad = explode(",", $_GET['cantidadArray']);
   $pago = explode(",", $_GET['valorItemArray']);
   $titulo = explode(",", $_GET['tituloArray']);


            $item = "id";
            $valor = $_GET['idUsuario'];

            $datosUsuarios = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
         $direccionBase = $datosUsuarios["direccion"].", ".$datosUsuarios["ciudad"].", ".$datosUsuarios["telefono"].", ".$datosUsuarios["codigo"];

               
         #Actualizamos la base de datos
         for($i = 0; $i < count($productos); $i++){

               $datos = array("idUsuario"=>$_GET['idUsuario'],
                           "idProducto"=>$productos[$i],
                           "metodo"=>"oxxo",
                           "email"=>$datosUsuarios["email"],
                           "direccion"=>$direccionBase,
                           "pais"=>"MX",
                           "cantidad"=>$cantidad[$i],
                           "detalle"=>$titulo[$i],
                           "pago"=>$pago[$i]);

               $respuesta = ControladorCarrito::ctrNuevasCompras($datos);

               $ordenar = "id";
               $item = "id";
               $valor = $productos[$i];

               $productosCompra = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);

               foreach ($productosCompra as $key => $value) {

                  $item1 = "ventas";
                  $valor1 = $value["ventas"] + $cantidad[$i];
                  $item2 = "id";
                  $valor2 =$value["id"];

                  $actualizarCompra = ControladorProductos::ctrActualizarProducto($item1, $valor1, $item2, $valor2);
                  
               }

               if($respuesta == "ok" && $actualizarCompra == "ok"){
                  echo '<script>

            localStorage.removeItem("listaProductos");
            localStorage.removeItem("cantidadCesta");
            localStorage.removeItem("sumaCesta");
            window.location = "'.$url.'ofertas/aviso";


            </script>';
               }

            }
}

/* FIN PAGO OXXO PAY */
/*=============================================
PAGO PAYU
=============================================*/

if(!isset($_SESSION["validarSesion"])){

   echo '<script>window.location = "'.$url.'";</script>';

   exit();

}
/* require_once "../../extensiones/bootstrap.php"; */
#requerimos las credenciales de paypal
require 'extensiones/bootstrap.php';
require_once "modelos/carrito.modelo.php";
#importamos librería del SDK
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

/*=============================================
PAGO PAYPAL
=============================================*/

#evaluamos si la compra está aprobada
if(isset( $_GET['paypal']) && $_GET['paypal'] === 'true'){

   #recibo los productos comprados
   $productos = explode("-", $_GET['productos']);
   $cantidad = explode("-", $_GET['cantidad']);
   $pago = explode("-", $_GET['pago']);

   #capturamos el Id del pago que arroja Paypal
   $paymentId = $_GET['paymentId'];

   #Creamos un objeto de Payment para confirmar que las credenciales si tengan el Id de pago resuelto
   $payment = Payment::get($paymentId, $apiContext);

   #creamos la ejecución de pago, invocando la clase PaymentExecution() y extraemos el id del pagador
   $execution = new PaymentExecution();
   $execution->setPayerId($_GET['PayerID']);

   #validamos con las credenciales que el id del pagador si coincida
   $payment->execute($execution, $apiContext);
   $datosTransaccion = $payment->toJSON();

   $datosUsuario = json_decode($datosTransaccion);

   $emailComprador = $datosUsuario->payer->payer_info->email;
   $dir = $datosUsuario->payer->payer_info->shipping_address->line1;
   $ciudad = $datosUsuario->payer->payer_info->shipping_address->city;
   $estado = $datosUsuario->payer->payer_info->shipping_address->state;
   $codigoPostal = $datosUsuario->payer->payer_info->shipping_address->postal_code;
   $pais = $datosUsuario->payer->payer_info->shipping_address->country_code;
	            $item = "id";
					$valor = $_SESSION["id"];

					$datosUsuarios = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
   $direccion = $dir.", ".$ciudad.", ".$estado.", ".$codigoPostal;
   $direccionBase = $datosUsuarios["direccion"].", ".$datosUsuarios["ciudad"].", ".$datosUsuarios["telefono"].", ".$datosUsuarios["codigo"];

         
   #Actualizamos la base de datos
   for($i = 0; $i < count($productos); $i++){

         $datos = array("idUsuario"=>$_SESSION["id"],
                     "idProducto"=>$productos[$i],
                     "metodo"=>"paypal",
                     "email"=>$emailComprador,
                     "direccion"=>$direccionBase,
                     "pais"=>$pais,
                     "cantidad"=>$cantidad[$i],
                     "detalle"=>$datosUsuario->transactions[0]->item_list->items[$i]->name,
                     "pago"=>$pago[$i]);

         $respuesta = ControladorCarrito::ctrNuevasCompras($datos);

         $ordenar = "id";
         $item = "id";
         $valor = $productos[$i];

         $productosCompra = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);

         foreach ($productosCompra as $key => $value) {

            $item1 = "ventas";
            $valor1 = $value["ventas"] + $cantidad[$i];
            $item2 = "id";
            $valor2 =$value["id"];

            $actualizarCompra = ControladorProductos::ctrActualizarProducto($item1, $valor1, $item2, $valor2);
            
         }

         if($respuesta == "ok" && $actualizarCompra == "ok"){

            echo '<script>

            localStorage.removeItem("listaProductos");
            localStorage.removeItem("cantidadCesta");
            localStorage.removeItem("sumaCesta");
            window.location = "'.$url.'ofertas/aviso";


            </script>';

         }

   }

/*=============================================
 PAGO PAYU
=============================================*/

}else if(isset( $_GET['payu']) && $_GET['payu'] === 'true'){ 

   $respuesta = ControladorCarrito::ctrMostrarTarifas();

   $ApiKey = $respuesta["apiKeyPayu"];
   $merchant_id = $_REQUEST['merchantId'];
   $referenceCode = $_REQUEST['referenceCode'];
   $TX_VALUE = $_REQUEST['TX_VALUE'];
   $New_value = number_format($TX_VALUE, 1, '.', '');
   $currency = $_REQUEST['currency'];
   $transactionState = $_REQUEST['transactionState'];
   $firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
   $firmacreada = md5($firma_cadena);
   $firma = $_REQUEST['signature'];
   $reference_pol = $_REQUEST['reference_pol'];
   $cus = $_REQUEST['cus'];
   $extra1 = $_REQUEST['description'];
   $pseBank = $_REQUEST['pseBank'];
   $lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
   $transactionId = $_REQUEST['transactionId'];

   if ($_REQUEST['transactionState'] == 4 ) {
      $estadoTx = "Transacción aprobada";
   }

   else if ($_REQUEST['transactionState'] == 6 ) {
      $estadoTx = "Transacción rechazada";
   }

   else if ($_REQUEST['transactionState'] == 104 ) {
      $estadoTx = "Error";
   }

   else if ($_REQUEST['transactionState'] == 7 ) {
      $estadoTx = "Transacción pendiente";
   }

   else {
      $estadoTx=$_REQUEST['mensaje'];
   }


   if (strtoupper($firma) == strtoupper($firmacreada) && $estadoTx == "Transacción aprobada") {

      $productos = explode("-", $_GET['productos']);
      $cantidad = explode("-", $_GET['cantidad']);
      $pago = explode("-", $_GET['pago']);

      #Actualizamos la base de datos
      for($i = 0; $i < count($productos); $i++){

         $datos = array("idUsuario"=>$_SESSION["id"],
                        "idProducto"=>$productos[$i],
                        "metodo"=>"payu",
                        "email"=>$_REQUEST['buyerEmail'],
                        "direccion"=>"",
                        "pais"=>"",                        
                        "cantidad"=>$cantidad[$i],
                        "detalle"=>"",
                        "pago"=>$pago[$i]);

         $respuesta = ControladorCarrito::ctrNuevasCompras($datos);

         $ordenar = "id";
         $item = "id";
         $valor = $productos[$i];

         $productosCompra = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);

         foreach ($productosCompra as $key => $value) {

            $item1 = "ventas";
            $valor1 = $value["ventas"] + $cantidad[$i];
            $item2 = "id";
            $valor2 =$value["id"];

            $actualizarCompra = ControladorProductos::ctrActualizarProducto($item1, $valor1, $item2, $valor2);
            
         }
/* window.location = "'.$url.'perfil";  */
         if($respuesta == "ok" && $actualizarCompra == "ok"){

            echo '<script>

            localStorage.removeItem("listaProductos");
            localStorage.removeItem("cantidadCesta");
            localStorage.removeItem("sumaCesta");
           
            window.location = "'.$url.'ofertas/aviso";
            </script>';

         }

      }

   }

}

/*=============================================
ADQUISICIONES GRATUITAS
=============================================*/
else if(isset( $_GET['gratis']) && $_GET['gratis'] === 'true'){

   $producto = $_GET['producto'];
   $titulo = $_GET['titulo'];

   $datos = array(  "idUsuario"=>$_SESSION["id"],
                    "idProducto"=>$producto,
                    "metodo"=>"gratis",
                    "email"=>$_SESSION["email"],
                    "direccion"=>"",
                    "pais"=>"",
                    "cantidad"=>"",
                    "detalle"=>"",
                    "pago"=>"");

   $respuesta = ControladorCarrito::ctrNuevasCompras($datos);

   $ordenar = "id";
   $item = "id";
   $valor = $producto;

   $productosGratis = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);

   foreach ($productosGratis as $key => $value) {
    
         $item1 = "ventasGratis";
         $valor1 = $value["ventasGratis"] + 1;
         $item2 = "id";
         $valor2 =$value["id"];

         $actualizarSolicitud = ControladorProductos::ctrActualizarProducto($item1, $valor1, $item2, $valor2);
   }

   if($respuesta == "ok" && $actualizarSolicitud == "ok"){

      echo '<script>
         
            window.location = "'.$url.'ofertas/aviso";

         </script>';

   }

}else{

   echo '<script>window.location = "'.$url.'cancelado";</script>';


}