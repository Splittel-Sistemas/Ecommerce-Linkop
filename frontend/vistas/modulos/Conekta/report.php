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



<?php

date_default_timezone_set("America/Bogota");


$mail = new PHPMailer;

$mail->CharSet = 'UTF-8';

$mail->isMail();

$mail->setFrom('info@linkop.com.mx', 'Linkop');


$mail->Subject = "Solicitud de nueva contraseña";

$mail->addAddress("ramon.olea@splittel.com");

$mail->msgHTML('<html>
<head>
    <link href="styles.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <style>/* Reset -------------------------------------------------------------------- */




.opps-info:after {
	visibility: hidden;display: block;font-size: 0;content: " ";clear: both;height: 0;

}















</style>
</head>
<body style="font-size: 14px;margin: 0;padding: 0;">



    <div class="opps" style="width: 496px; border-radius: 4px;box-sizing: border-box;padding: 0 45px;margin: 40px auto;overflow: hidden;border: 1px solid #b0afb5;sans-serif;color: #4f5365;">
        <div class="opps-header">
            <div class="opps-reminder" style="position: relative;top: -1px;padding: 9px 0 10px;font-size: 11px;text-transform: uppercase;text-align: center;color: #ffffff;background: #000000;">Ficha digital. No es necesario imprimir.</div>
            <div class="opps-info" style="margin-top: 26px;position: relative;">
                <div class="opps-brand" style="width: 45%;float: left;"><img src="https://linkop.com.mx/vistas/modulos/Conekta/logos/oxxopay_brand.png" alt="OXXOPay" style="max-width: 150px;margin-top: 2px;"></div>
                <div class="opps-ammount" style="width: 55%;float: right;">
                     <h3 style="margin-bottom: 10px;font-size: 15px;font-weight: 600;text-transform: uppercase;">Monto a pagar</h3>
	
                    <h2 style="font-size: 36px;color: #000000;line-height: 24px;margin-bottom: 15px;"> <td>$'.substr($amount, 0, -2) .strtoupper($currency).'</td></sup></h2>
                    <p style="font-size: 10px;line-height: 14px;">OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
                </div>
            </div>
            <div class="opps-reference" style="margin-top: 14px;">
                 <h3 style="margin-bottom: 10px;font-size: 15px;font-weight: 600;text-transform: uppercase;">Referencia</h3>
                 <h3 style="margin-bottom: 10px;font-size: 15px;font-weight: 600;text-transform: uppercase;"><'. $barcode.'</h3>
            </div>
			<div>
			<td style="text-align:center;"><img src='.$barcode_url.'></td>
            </div>
            <div>
            </div>
        </div>
	
        <div class="opps-instructions" style="margin: 32px -45px 0;padding: 32px 45px 45px;border-top: 1px solid #b0afb5;background: #f8f9fa;">
             <h3 style="margin-bottom: 10px;font-size: 15px;font-weight: 600;text-transform: uppercase;">Instrucciones</h3>
            <ol style="margin: 17px 0 0 16px;">
                <li style="margin-top: 10px;color: #000000;">Acude a la tienda OXXO más cercana. <a href="https://www.google.com.mx/maps/search/oxxo/" style="color: #1155cc;"target="_blank">Encuéntrala aquí</a>.</li>
                <li style="margin-top: 10px;color: #000000;">Indica en caja que quieres realizar un pago de <strong>OXXOPay</strong>.</li>
                <li style="margin-top: 10px;color: #000000;">Dicta al cajero el número de referencia en esta ficha para que tecleé directamete en la pantalla de venta.</li>
                <li style="margin-top: 10px;color: #000000;">Realiza el pago correspondiente con dinero en efectivo.</li>
                <li style="margin-top: 10px;color: #000000;">Al confirmar tu pago, el cajero te entregará un comprobante impreso. <strong>En el podrás verificar que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
            </ol>
            <div class="opps-footnote" style="margin-top: 22px;padding: 22px 20 24px;color: #108f30;text-align: center;border: 1px solid #108f30;border-radius: 4px;background: #ffffff;">Al completar estos pasos recibirás un correo de <strong>Nombre del negocio</strong> confirmando tu pago.</div>
        </div>
    </div>	
</body>
</html>');

$envio = $mail->Send();

?>