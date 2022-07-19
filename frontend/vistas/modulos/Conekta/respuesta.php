<?php

$body = @file_get_contents('php://input');
$data = json_decode($body);
http_response_code(200); // Return 200 OK 
print_r($data);
if ($data->type == 'charge.paid'){
  $msg = "Tu pago ha sido comprobado.";
  mail("fulanito@conekta.com","Pago confirmado",$msg);
}