<?php
session_start();
require_once 'MyConekta.php';

$_SESSION['token'] = MyConekta::tokengenerator();

/* print_r($_POST);
exit; */
$amount = filter_input(INPUT_POST, 'amount');
$amount = (strstr($amount = $_POST['amount'], '.')) ? str_replace('.', '', $amount) : $amount.'00';
$email 	= filter_input(INPUT_POST, $_POST['correoE']);
$descriptions 	= filter_input(INPUT_POST, $_POST['tituloArray']);


MyConekta::oxxo($amount, $email,$descriptions);