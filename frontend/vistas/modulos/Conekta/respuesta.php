<?php
require_once '../../../extensiones/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once '../../../extensiones/vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$body = @file_get_contents('php://input');
$json 				= json_decode($body);
$json 				= $json->data->object;

$invoiceid 			= $json->reference_id;
$fee 				= $json->fee;
$amount 			= $json->amount;
$status				= $json->status;
$transid 			= $json->id;
$correo             =$json->details->email;
$idUsuario             =$json->details->name;
$productos             =$json->description;

 $pars =  explode("/",$productos);

// Validamos que el IPN sea de Banorte
if($json->payment_method->type=='oxxo'){

	
	if($status=='paid'){$status=1;}else{$status=0;}
    if ($status=="1") {
	  // Guardar Log de webhook (comentar esto para no guardar logs)
	/* $fp = fopen('oxxo_'.md5(uniqid()).".txt","wb");
	fwrite($fp,$body);
	fclose($fp);
 */
    date_default_timezone_set("America/Bogota");


    $mail = new PHPMailer;
    
    $mail->CharSet = 'UTF-8';
    
    $mail->isMail();
    
    $mail->setFrom('info@linkop.com.mx', 'Linkop');
    
    
    $mail->Subject = "Pago en Tienda OXXO Realizado";
    
    $mail->addAddress($correo);
    
    $mail->msgHTML('PAGO EXITOSO REVISE SU PERFIL PARA COMPROBAR LOS ARCHIVOS COMPRADOS '.$pars[0].'');
    
    $envio = $mail->Send();

    return header("Location: ../finalizar-compra.php?tituloArray=".$pars[0]."&idProductoArray=".$pars[1].".&cantidadArray=".$pars[2]."&valorItemArray=".$pars[3]."&idUsuario=".$idUsuario."&metodoPago=oxxo ");


	} else {
	
	}
	
}


header("HTTP/1.0 200");
