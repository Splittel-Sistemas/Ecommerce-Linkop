<?php
session_start();
require_once 'MyConekta.php';
require_once '../../../extensiones/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once '../../../extensiones/vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
/* print_r($_GET);
exit; */
//Filter all the GET[] variables
$token_url      = filter_input(INPUT_GET, 'token');
$type           = filter_input(INPUT_GET, 'type');
$description    = filter_input(INPUT_GET, 'description');
$expiry_date    = filter_input(INPUT_GET, 'expiry_date');
$amount         = filter_input(INPUT_GET, 'amount');
$currency       = filter_input(INPUT_GET, 'currency');
$service_name   = filter_input(INPUT_GET, 'service_name');
$service_number = filter_input(INPUT_GET, 'service_number');
$reference      = filter_input(INPUT_GET, 'reference');
$barcode        = filter_input(INPUT_GET, 'barcode');
$barcode_url    = filter_input(INPUT_GET, 'barcode_url');
$correo    = filter_input(INPUT_GET, 'email');

if(!isset($token_url) || !MyConekta::check_token($token_url))
    die('Reporte Invalido. Solo puede imprimir el reporte UNA vez, 
        vuelva a generar el donativo');

//Regenerate the token value to avoid repeat the report
$_SESSION['token'] = MyConekta::tokengenerator();
?>



<?php

date_default_timezone_set("America/Bogota");


$mail = new PHPMailer;

$mail->CharSet = 'UTF-8';

$mail->isMail();

$mail->setFrom('info@linkop.com.mx', 'Linkop');


$mail->Subject = "Pago en Tienda OXXO";

$mail->addAddress($correo);

$mail->msgHTML('<html>
<head>
    <link href="styles.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
	<style>
	* 	 { margin: 0;padding: 0; }
	body { font-size: 14px; }
	
	
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
		font-family: "Open Sans", sans-serif;
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
<body >



    <div class="opps">
        <div class="opps-header">
            <div class="opps-reminder" >Ficha digital. No es necesario imprimir.</div>
            <div class="opps-info" >
                <div class="opps-brand" ><img src="data:image/png;base64,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" alt="OXXOPay" ></div>
                <div class="opps-ammount" >
                     <h3 >Monto a pagar</h3>
	
                    <h2 > <td>$'.substr($amount, 0, -2) .strtoupper($currency).'</td></sup></h2>
                    <p >OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
                </div>
            </div>
            <div class="opps-reference" >
                 <h3 >Referencia</h3>
                 <h3 >'. $barcode.'</h3>
            </div>
			<div>
			<td ><img src='.$barcode_url.'></td>
            </div>
            <div>
            </div>
        </div>
	
        <div class="opps-instructions" >
             <h3 >Instrucciones</h3>
            <ol >
                <li >Acude a la tienda OXXO más cercana. <a href="https://www.google.com.mx/maps/search/oxxo/" target="_blank">Encuéntrala aquí</a>.</li>
                <li >Indica en caja que quieres realizar un pago de <strong>OXXOPay</strong>.</li>
                <li >Dicta al cajero el número de referencia en esta ficha para que tecleé directamete en la pantalla de venta.</li>
                <li >Realiza el pago correspondiente con dinero en efectivo.</li>
                <li >Al confirmar tu pago, el cajero te entregará un comprobante impreso. <strong>En el podrás verificar que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
            </ol>
            <div class="opps-footnote" >Al completar estos pasos recibirás un correo de <strong>Nombre del negocio</strong> confirmando tu pago.</div>
        </div>
    </div>	
</body>
</html>');

$envio = $mail->Send();

?>