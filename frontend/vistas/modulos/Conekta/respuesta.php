<?php

$body = @file_get_contents('php://input');
$json 				= json_decode($body);
$json 				= $json->data->object;

$invoiceid 			= $json->reference_id;
$fee 				= $json->fee;
$amount 			= $json->amount;
$status				= $json->status;
$transid 			= $json->id;

if ($data->type == 'charge.paid'){
  $msg = "Tu pago ha sido comprobado.";
  mail("fulanito@conekta.com","Pago confirmado",$msg);
}

// Validamos que el IPN sea de Banorte

	// Guardar Log de webhook (comentar esto para no guardar logs)
	$fp = fopen('oxxo_'.md5(uniqid()).".txt","wb");
	fwrite($fp,$body);
	fclose($fp);
	
	// Convertimos montos con decimales
	$amount_2 			= substr($amount, 0, -2);
	$decimals_2 		= substr($amount, strlen($amount_2), strlen($amount));
	$amount				= $amount_2.'.'.$decimals_2;
	
	$amount_3 			= substr($fee, 0, -2);
	$decimals_3 		= substr($fee, strlen($amount_3), strlen($fee));
	$fee				= $amount_3.'.'.$decimals_3;
	
	$invoiceid 			= str_replace('factura_', '', $invoiceid);
	
	if($status=='paid'){$status=1;}else{$status=0;}
	
	
	


header("HTTP/1.0 200");
