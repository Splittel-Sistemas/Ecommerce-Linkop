<?php

$body = @file_get_contents('php://input');
$data = json_decode($body);
http_response_code(200); // Return 200 OK 

if ($data->type == 'charge.paid'){
  $msg = "Tu pago ha sido comprobado.";
  mail("fulanito@conekta.com","Pago confirmado",$msg);
}
ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log",  "conekta_error_log");
ini_set($data->type ,  "conekta_error_log");
