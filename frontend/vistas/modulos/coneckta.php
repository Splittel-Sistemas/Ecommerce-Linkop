<?php 
require_once("lib/Conekta.php");
\Conekta\Conekta::setApiKey("key_eYvWV7gSDkNYXsmr");
\Conekta\Conekta::setApiVersion("2.0.0");

try{
    $thirty_days_from_now = (new DateTime())->add(new DateInterval('P30D'))->getTimestamp(); 
  
    $order = \Conekta\Order::create(
      [
        "line_items" => [
          [
            "name" => "Tacos",
            "unit_price" => 1000,
            "quantity" => 12
          ]
        ],
        "shipping_lines" => [
          [
            "amount" => 1500,
            "carrier" => "FEDEX"
          ]
        ], //shipping_lines - physical goods only
        "currency" => "MXN",
        "customer_info" => [
          "name" => "Fulanito Pérez",
          "email" => "fulanito@conekta.com",
          "phone" => "+5218181818181"
        ],
        "shipping_contact" => [
          "address" => [
            "street1" => "Calle 123, int 2",
            "postal_code" => "06100",
            "country" => "MX"
          ]
        ], //shipping_contact - required only for physical goods
        "charges" => [
          [
            "payment_method" => [
              "type" => "oxxo_cash",
              "expires_at" => $thirty_days_from_now
            ]
          ]
        ]
      ]
    );
  } catch (\Conekta\ParameterValidationError $error){
    echo $error->getMessage();
  } catch (\Conekta\Handler $error){
    echo $error->getMessage();
  }
  


/*   echo "ID: ". $order->id;
echo "Payment Method:". $order->charges[0]->payment_method->service_name;
echo "Reference: ". $order->charges[0]->payment_method->reference;
echo "$". $order->amount/100 . $order->currency;
echo "Order";
echo $order->line_items[0]->quantity .
      "-". $order->line_items[0]->name .
      "- $". $order->line_items[0]->unit_price/100;
 */

// Response
// ID: ord_2fsQdMUmsFNP2WjqS
// Payment Method: OxxoPay
// Reference: 123456789012
// $ 135.0 MXN
// Order
// 12 - Tacos - $10.0

?><html>
<head>
    <link href="styles.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <style>/* Reset -------------------------------------------------------------------- */
* 	 { margin: 0;padding: 0; }
body { font-size: 14px; }

/* OPPS --------------------------------------------------------------------- */

h3 {
	margin-bottom: 10px;
	font-size: 15px;
	font-weight: 600;
	text-transform: uppercase;
}

.opps {
	width: 496px; 
	border-radius: 4px;
	box-sizing: border-box;
	padding: 0 45px;
	margin: 40px auto;
	overflow: hidden;
	border: 1px solid #b0afb5;
	font-family: 'Open Sans', sans-serif;
	color: #4f5365;
}

.opps-reminder {
	position: relative;
	top: -1px;
	padding: 9px 0 10px;
	font-size: 11px;
	text-transform: uppercase;
	text-align: center;
	color: #ffffff;
	background: #000000;
}

.opps-info {
	margin-top: 26px;
	position: relative;
}

.opps-info:after {
	visibility: hidden;
     display: block;
     font-size: 0;
     content: " ";
     clear: both;
     height: 0;

}

.opps-brand {
	width: 45%;
	float: left;
}

.opps-brand img {
	max-width: 150px;
	margin-top: 2px;
}

.opps-ammount {
	width: 55%;
	float: right;
}

.opps-ammount h2 {
	font-size: 36px;
	color: #000000;
	line-height: 24px;
	margin-bottom: 15px;
}

.opps-ammount h2 sup {
	font-size: 16px;
	position: relative;
	top: -2px
}

.opps-ammount p {
	font-size: 10px;
	line-height: 14px;
}

.opps-reference {
	margin-top: 14px;
}

h1 {
	font-size: 27px;
	color: #000000;
	text-align: center;
	margin-top: -1px;
	padding: 6px 0 7px;
	border: 1px solid #b0afb5;
	border-radius: 4px;
	background: #f8f9fa;
}

.opps-instructions {
	margin: 32px -45px 0;
	padding: 32px 45px 45px;
	border-top: 1px solid #b0afb5;
	background: #f8f9fa;
}

ol {
	margin: 17px 0 0 16px;
}

li + li {
	margin-top: 10px;
	color: #000000;
}

a {
	color: #1155cc;
}

.opps-footnote {
	margin-top: 22px;
	padding: 22px 20 24px;
	color: #108f30;
	text-align: center;
	border: 1px solid #108f30;
	border-radius: 4px;
	background: #ffffff;
}
</style>
</head>
<body>



    <div class="opps">
        <div class="opps-header">
            <div class="opps-reminder">Ficha digital. No es necesario imprimir.</div>
            <div class="opps-info">
                <div class="opps-brand"><img src="oxxopay_brand.png" alt="OXXOPay"></div>
                <div class="opps-ammount">
                    <h3>Monto a pagar</h3>
                    <h2><?php echo "$". $order->amount/100 ;?> <sup><?php echo $order->currency;?> </sup></h2>
                    <p>OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
                </div>
            </div>
            <div class="opps-reference">
                <h3>Referencia</h3>
                <h1><?php echo "Reference: ". $order->charges[0]->payment_method->reference;?></h1>
            </div>
            <div>
                <h3><?php echo $order->line_items[0]->quantity .
      "-". $order->line_items[0]->name .
      "- $". $order->line_items[0]->unit_price/100; ?></h3>
            </div>
        </div>
        <div class="opps-instructions">
            <h3>Instrucciones</h3>
            <ol>
                <li>Acude a la tienda OXXO más cercana. <a href="https://www.google.com.mx/maps/search/oxxo/" target="_blank">Encuéntrala aquí</a>.</li>
                <li>Indica en caja que quieres realizar un pago de <strong>OXXOPay</strong>.</li>
                <li>Dicta al cajero el número de referencia en esta ficha para que tecleé directamete en la pantalla de venta.</li>
                <li>Realiza el pago correspondiente con dinero en efectivo.</li>
                <li>Al confirmar tu pago, el cajero te entregará un comprobante impreso. <strong>En el podrás verificar que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
            </ol>
            <div class="opps-footnote">Al completar estos pasos recibirás un correo de <strong>Nombre del negocio</strong> confirmando tu pago.</div>
        </div>
    </div>	
</body>
</html>