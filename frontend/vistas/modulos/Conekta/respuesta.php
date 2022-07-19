<?php
require_once '../../../extensiones/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once '../../../extensiones/vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$body = @file_get_contents('php://input');
$data = json_decode($body);
http_response_code(200); // Return 200 OK 
print_r($data);
if ($data->type == 'charge.paid'){
  $msg = "Tu pago ha sido comprobado.";
  mail("fulanito@conekta.com","Pago confirmado",$msg);
}


date_default_timezone_set("America/Bogota");


$mail = new PHPMailer;

$mail->CharSet = 'UTF-8';

$mail->isMail();

$mail->setFrom('info@linkop.com.mx', 'Linkop');


$mail->Subject = "Pago en Tienda OXXO";

$mail->addAddress('ramon.olea@splittel.com');

$mail->msgHTML('pago  '.$data.'');

$envio = $mail->Send();
