<?php
session_start();
require_once 'MyConekta.php';

$_SESSION['token'] = MyConekta::tokengenerator();

/* print_r($_POST);
exit; */
$amount = filter_input(INPUT_POST, 'amount');
$amount = (strstr($amount = $_POST['amount'], '.')) ? str_replace('.', '', $amount) : $amount.'00';
$email 	=  $_POST['correoE'];
$descriptions 	=  $_POST['tituloArray'];
$name 	=  $_POST['idUsuario'];
$phone 	=  $_POST['telefono'];


MyConekta::oxxo($amount, $email,$descriptions,$name, $phone);