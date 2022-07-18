<?php
session_start();
require_once 'MyConekta.php';
require_once '../../../extensiones/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once '../../../extensiones/vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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

/* if(!isset($token_url) || !MyConekta::check_token($token_url))
    die('Reporte Invalido. Solo puede imprimir el reporte UNA vez, 
        vuelva a generar el donativo'); */

//Regenerate the token value to avoid repeat the report
$_SESSION['token'] = MyConekta::tokengenerator();
?>

<!-- <!DOCTYPE html>
<html>
    <head>
	    <title>Deposito en efectivo en <?=ucfirst($type)?></title>
    </head>
    <body>     
    	<h1>Resumen del Deposito</h1>
    	<div id="resumen">
    		<table>
    			<tr>
    				<td>Descripcion</td>
    				<td><?=$description?></td>
    			</tr>
    			<tr>
    				<td>Fecha <?=($type=='oxxo')?'de expiracion':''?></td>
    				<td>
    					<?php    						 
    						 if ($type == 'oxxo')
    							echo substr($expiry_date, 0, 2).'/'.substr($expiry_date, 2, 2).'/20'.substr($expiry_date, 4, 2);
    						else
    							echo $expiry_date;
    					?>
    				</td>
    			</tr>
    			<tr>
    				<td>Metodo de pago</td>
    				<td>Deposito en <?=ucfirst($type)?></td>
    			</tr>
    			<tr>
    				<td>Monto</td>
    				<td>$<?=substr($amount, 0, -2)?>.00 <?=strtoupper($currency)?></td>
    			</tr>
    		</table>
    	</div>

    	<h1>Informacion de la Ficha</h1>
    	<div id="informacion">
    		<?php if ($type != 'oxxo') : ?>
    		<table>
    			<tr>
    				<td>Banco</td>
    				<td><?=ucfirst($type)?></td>
    			</tr>
    			<tr>
    				<td>Nombre de Servicio</td>
    				<td><?=$service_name?></td>
    			</tr>
    			<tr>
    				<td>Numero de Servicio</td>
    				<td><?=$service_number?></td>
    			</tr>
    			<tr>
    				<td>Numero de Referencia</td>
    				<td><?=$reference?></td>
    				<td><img src="logos/<?=$type?>.png"></td>
    			</tr>
    			
    		</table>
    		<?php else :?>
			<table>
    			<tr>
    				<td><img src="<?=$barcode_url?>"></td>
    				<td><img src="logos/<?=$type?>.png"></td>
    			</tr>
    			<tr>
    				<td><?='<span class="txt-left">'.$barcode.'</span><span class="txt-right">EXP.'.$expiry_date.'</span>'?></td>
    				<td></td>
    			</tr>    			
    		</table>

    		<?php endif; ?>
    	</div>

    </body>    
</html> -->
<?php 
date_default_timezone_set("America/Bogota");


$mail = new PHPMailer;

$mail->CharSet = 'UTF-8';

$mail->isMail();

$mail->setFrom('notificaciones-splitnet@splittel.com', 'Linkop');




$mail->addAddress("olearamon3@gmail.com");

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
<body>



    <div class="opps">
        <div class="opps-header">
            <div class="opps-reminder">Ficha digital. No es necesario imprimir.</div>
            <div class="opps-info">
                <div class="opps-brand"><img src="logos/oxxopay_brand.png" alt="OXXOPay"></div>
                <div class="opps-ammount">
                    <h3>Monto a pagar</h3>
                    <h2> <td>$'. substr($amount, 0, -2) . strtoupper($currency).'</td></sup></h2>
                    <p>OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
                </div>
            </div>
            <div class="opps-reference">
                <h3>Referencia</h3>
                <h1>'.$reference.'</h1>
            </div>
			<div>
                <h3>'.$description.'</h3>
            </div>
            <div>
                <h3>"<span class="txt-left">'.$barcode.'</span><span class="txt-right">EXP.'.$expiry_date.'</span>"?</h3>
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
</html>');

$envio = $mail->Send();

if(!$envio){
	echo 'enviado';
/* 	echo '<script> 

		swal({
			  title: "¡ERROR!",
			  text: "¡Ha ocurrido un problema enviando verificación de correo electrónico a '.$_POST["regEmail"].$mail->ErrorInfo.'!",
			  type:"error",
			  confirmButtonText: "Cerrar",
			  closeOnConfirm: false
			},

			function(isConfirm){

				if(isConfirm){
					history.back();
				}
		});

	</script>'; */

}else{
	echo 'no';

	/* echo '<script> 

		swal({
			  title: "¡OK!",
			  text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo electrónico '.$_POST["regEmail"].' para verificar la cuenta!",
			  type:"success",
			  confirmButtonText: "Cerrar",
			  closeOnConfirm: false
			},

			function(isConfirm){

				if(isConfirm){
					history.back();
				}
		});

	</script>'; */

}



?>
