<?php
session_start();
/* require_once 'MyConekta.php'; */
require_once("conekta/lib/Conekta.php");

$_SESSION['token'] = MyConekta::tokengenerator();

/* print_r($_POST);
exit; */
$amount = filter_input(INPUT_POST, 'amount');
$amount = (strstr($amount = $_POST['amount'], '.')) ? str_replace('.', '', $amount) : $amount.'00';
$email 	=  $_POST['correoE'];
$descriptions 	=  $_POST['tituloArray'];
$idproductos 	=  $_POST['idProductoArray'];
$cantidadArray 	=  $_POST['cantidadArray'];
$valorItemArray 	=  $_POST['valorItemArray'];



$name 	=  $_POST['idUsuario'];
$phone 	=  $_POST['telefono'];


MyConekta::oxxo($amount, $email,$descriptions,$name, $phone,$idproductos,$cantidadArray,$valorItemArray);


class MyConekta {
	
	/* public static $api_key = 'key_uIXUFhVCmt9XmHtDynXtMK';//CONEKTA MODO PRUEBAS */
	public static $api_key = 'key_8Z1zbrraXkv7WMtbednE6L'; //CONEKTA MODO PRODUCCION

	public static $description = 'Donation';	
	public static $currency = 'mxn';	

	//Function to validate if the token does exist
	public static function check_token($token){
		if ($token == $_SESSION['token'])
			return true;

		return false;
	}

	//Function to generate a md5 32digits token
	public static function tokengenerator($len = 32){		
		//seed
		$keychars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";				
		// RANDOM KEY GENERATOR
		$id = "";
		$max = strlen($keychars) - 1;
		
		for ($i=0;$i<$len;$i++)
			$id .= substr($keychars, rand(0, $max), 1);
		
		return md5($id);
	}

	//Function to make payments in Bank
	public static function bank($amount, $name, $email, $phone, $bank){		
		Conekta::setApiKey(self::$api_key);
		$request = array(	
			'amount' => $amount,
			'currency' => self::$currency,
			'description' => self::$description,
			'details' => array(
			                'name' => $name,
			                'email' => $email,
			                'phone' => $phone
			                ),
			'bank' => array('type' => $bank)
			);

		try {
			$response = Conekta_Charge::create($request);  	

			echo
		    'status='.$response['status'].
		    '&currency='.$response['currency'].
		    '&description='.$response['description'].
		    '&amount='.$response['amount'].
		    '&service_name='.$response['payment_method']['service_name'].
		    '&service_number='.$response['payment_method']['service_number'].
		    '&reference='.$response['payment_method']['reference'].
		    '&type='.$response['payment_method']['type'].
		    '&expiry_date='.date('d/m/Y').
		    '&token='.$_SESSION['token'];
		  	
		} 
		catch (Exception $e) {
		  	// Catch all exceptions including validation errors.
		  	echo $e->getMessage(); 
		 }		
	}

	//Function to make payments in Oxxo stores
	public static function oxxo($amount, $email,$descriptions,$name, $phone,$idproductos,$cantidadArray,$valorItemArray){	

		Conekta::setApiKey(self::$api_key);
		$request = array(
            "livemode"=> false,
		    'amount' => $amount,
		    'currency' => 'MXN',
		    'description' => $descriptions."/".$idproductos."/".$cantidadArray."/".$valorItemArray,
			'details' => array(
				'name' => $name,
				'email' => $email,
				'phone' => $phone
			),
		    'cash'=> array('type' => 'oxxo'),
			"object" => "charge",
			"status" =>  "pending_payment",
		    );
			
		try {
			$response = Conekta_Charge::create($request);  
           /*  print_r($response);
			exit;  */
		/* 	$data = json_decode($response); */
		/* 	print_r($response['details']['email']);
			exit; */
			/* echo
		    'status='.$response['status'].
		    '&currency='.$response['currency'].
		    '&description='.$response['description'].
		    '&amount='.$response['amount'].
		    '&expiry_date='.$response['payment_method']['expiry_date'].
		    '&barcode='.$response['payment_method']['barcode'].
		    '&barcode_url='.$response['payment_method']['barcode_url'].
		    '&reference='.$response['payment_method']['reference'].
		    '&type='.$response['payment_method']['type'].
		    '&email='.$email.
		    '&token='.$_SESSION['token'];  	 */	
		  	  
		/* 	echo $response ; */
		/* 	return $response ; */
		return header("Location: report.php?status=".$response['status']."&currency=".$response['currency']."&description=".$response['description']."&amount=".$response['amount']."&expiry_date=".$response['payment_method']['expiry_date']."&barcode=".$response['payment_method']['barcode']."&barcode_url=".$response['payment_method']['barcode_url']."&type=".$response['payment_method']['type']."&email=".$response['details']['email']."&token=".$_SESSION['token']." ");

		  
		} 
		catch (Exception $e) {
		  	// Catch all exceptions including validation errors.
		  	echo $e->getMessage(); 
		}
	}

	//Function to make payments with a Credit/Debit Card
	public static function card($amount, $number, $exp_month, $exp_year, $cvc, $name){

		Conekta::setApiKey(self::$api_key);

		$data = array(
			'card' => array(
				'number' => $number, 
				'exp_month' => $exp_month, 
				'exp_year' => $exp_year, 
				'cvc' => $cvc, 
				'name' => $name
				), 
			'description' => self::$description, 
			'amount' => $amount, 
			'currency' => self::$currency
			);

		try {
		  $charge = Conekta_Charge::create($data);  
		  echo 'Thanks for your donation';
		} 
		catch (Exception $e) {
		  // Catch all exceptions including validation errors.
		  echo $e->getMessage(); 
		}
	}
	//END OF CLASS
}