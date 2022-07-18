<?php
session_start();
require_once 'MyConekta.php';
require_once '../../../extensiones/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once '../../../extensiones/vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
/* print_r($_GET); */
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

if(!isset($token_url) || !MyConekta::check_token($token_url))
    die('Reporte Invalido. Solo puede imprimir el reporte UNA vez, 
        vuelva a generar el donativo');

//Regenerate the token value to avoid repeat the report
$_SESSION['token'] = MyConekta::tokengenerator();
?>

<html>
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
                <div class="opps-brand"><img src="https://linkop.com.mx/vistas/modulos/Conekta/logos/oxxopay_brand.png" alt="OXXOPay"></div>
                <div class="opps-ammount">
                    <h3>Monto a pagar</h3>
                    <h2> <td>$<?=substr($amount, 0, -2)?><?=strtoupper($currency)?></td></sup></h2>
                    <p>OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
                </div>
            </div>
            <div class="opps-reference">
                <h3>Referencia</h3>
                <h3><?php echo $barcode?></h3>
            </div>
			<div>
			<td style="text-align:center;"><img src="<?=$barcode_url?>"></td>
            </div>
            <div>
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

<?php

date_default_timezone_set("America/Bogota");


$mail = new PHPMailer;

$mail->CharSet = 'UTF-8';

$mail->isMail();

$mail->setFrom('info@linkop.com.mx', 'Linkop');


$mail->Subject = "Solicitud de nueva contraseña";

$mail->addAddress("ramon.olea@splittel.com");

$mail->msgHTML('<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">

		<center>
			
			<img style="padding:20px; width:10%" src="">

		</center>

		<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
		
			<center>
			
			<img style="padding:20px; width:15%" src="">

			<h3 style="font-weight:100; color:#999">SOLICITUD DE NUEVA CONTRASEÑA</h3>

			<hr style="border:1px solid #ccc; width:80%">

			<h4 style="font-weight:100; color:#999; padding:0 20px"><strong>Su nueva contraseña: </strong></h4>

			<a href="" target="_blank" style="text-decoration:none">

			<div style="line-height:60px; background:#0aa; width:60%; color:white">Ingrese nuevamente al sitio</div>

			</a>

			<br>

			<hr style="border:1px solid #ccc; width:80%">

			<h5 style="font-weight:100; color:#999">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>

			</center>

		</div>

	</div>');

$envio = $mail->Send();

?>