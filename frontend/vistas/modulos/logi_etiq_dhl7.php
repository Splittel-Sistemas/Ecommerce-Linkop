
<?php

print_r($_POST);
exit;
$nombre=utf8_decode($_SESSION["nombre"]);
$apellido=utf8_decode($_SESSION["apaterno"]);
date_default_timezone_set('America/Mexico_City');

$time = time();
$tiempo =  date("Y-m-dTH:i:sP", $time);
//$tiempo =  date("Y-m-dCSTH:i:sP", $time);
$fecha = date("Y-m-d", $time);
$hoy=date("Y-m-d");
$tiempo =str_replace ( "CD",  "", $tiempo );
$tiempo =str_replace ( "CS",  "", $tiempo );
$tiempoRecoleccion = "PT".date("H", $time)."H".date("i", $time)."M";

$host='192.168.2.29';
	$db='fibreco_fmx';
	$user='fibremex';
	$pass='FBSrvAD*0316.';
//Crear Objeto para conexion
$conexion = new mysqli($host, $user, $pass, $db);

$site = 'v62_XYBNuJJ3l2';
$password = 'g1uz1Yq70H';
/* $url ="https://xmlpi-ea.dhl.com/XMLShippingServlet"; */
$url ="http://xmlpitest-ea.dhl.com/XMLShippingServlet";
$emp_au="FIBREMEX SA DE CV";
$nom_app="FIBREMEX APP";

$pzas=$_POST['pzs'];
$peso=$_POST['kg'];
$montoseg=$_POST['seg'];
$fcp='76246';
$tcp=$_POST['cp'];
$countryCode= 'MX';
$dimensionUnit = "CM";
$weigthUnit = "KG";
$countryCode1= 'MXN';

 $buffer= '<?xml version="1.0" encoding="UTF-8"?>
<p:DCTRequest xmlns:p="http://www.dhl.com" xmlns:p1="http://www.dhl.com/datatypes" xmlns:p2="http://www.dhl.com/DCTRequestdatatypes" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com DCT-req.xsd">
	<GetQuote>
			<Request>
				<ServiceHeader>
					<MessageTime>'.$tiempo.'</MessageTime>
					<MessageReference>1234567890123456789012345678901</MessageReference>
					<SiteID>'.$site.'</SiteID>
					<Password>'.$password.'</Password>
				</ServiceHeader>
			</Request>
    <From>
				<CountryCode>'.$countryCode.'</CountryCode>
				<Postalcode>'.$fcp.'</Postalcode>
			</From>
   <BkgDetails>
				<PaymentCountryCode>'.$countryCode.'</PaymentCountryCode>
				<Date>'.$hoy.'</Date>
				<ReadyTime>'.$tiempoRecoleccion.'</ReadyTime>
				<ReadyTimeGMTOffset>-05:00</ReadyTimeGMTOffset>
				<DimensionUnit>'.$dimensionUnit.'</DimensionUnit>
				<WeightUnit>'.$weigthUnit.'</WeightUnit>
				<Pieces>';              
   
        for($i=1; $i<=$pzas; $i++){
            $buffer.='<Piece>
                        <PieceID>'.$i.'</PieceID>
                        <Height>1</Height>
                        <Depth>1</Depth> 
                        <Width>1</Width>
                        <Weight>'.round(($peso/$pzas),2).'</Weight>                                                                                                                                               
                    </Piece>';
        }
    $buffer .='</Pieces>
				<!--<PaymentAccountNumber>cuenta</PaymentAccountNumber>-->
				<IsDutiable>N</IsDutiable>
				<NetworkTypeCode>AL</NetworkTypeCode>
                <InsuredValue>'.$montoseg.'</InsuredValue>
                <InsuredCurrency>'.$countryCode1.'</InsuredCurrency>
            </BkgDetails>
			<To>
				<CountryCode>'.$countryCode.'</CountryCode>
				<Postalcode>'.$tcp.'</Postalcode>
			</To>
		</GetQuote>
	</p:DCTRequest>';

$prexml = $buffer;
//echo htmlentities($prexml);
//echo "<br/><br/><br/>";
//Iniciamos una sesion cURL
$soap_do = curl_init();
//Indicamos a donde deseamos enviar nuestro post
curl_setopt($soap_do, CURLOPT_URL,$url );
//Indicamos lo que queremos enviar en nuestro post, en este caso un xml
curl_setopt($soap_do, CURLOPT_POSTFIELDS,$prexml);
//A?adimos una opci?n m?s para poder almacenar la respuesta en una variable
curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 300);
curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, 1);
//Ejecutamos el curl y almacenamos la respuesta en una variable

$respuesta=curl_exec($soap_do);
//echo htmlentities($respuesta);
//Cerramos nuesta sesi?n
curl_close($soap_do);

//echo htmlentities($respuesta);
$xml=simplexml_load_string(utf8_encode($respuesta)) or die("Error: Cannot create object");
//print_r($xml);
//echo htmlentities($respuesta);
$new_pdf = fopen ("./Response_7.txt", "w");
  fwrite($new_pdf,$respuesta);
  fclose($new_pdf);
$serv='';
if(isset($xml-> Response -> Status -> ActionStatus)){
$error=($xml-> Response -> Status -> ActionStatus);
$desc_error=($xml-> Response -> Status -> Condition -> ConditionData);
}else{
    $error='';
}
if($error==''){
   foreach ($xml -> GetQuoteResponse -> BkgDetails -> QtdShp  as $tipo) {
    if($tipo->ProductShortName!='MEDICAL EXPRESS' &&
       $tipo->ProductShortName!='DOMESTICO ENVIO RETORNO' &&
       $tipo->ProductShortName!='SAMEDAY SPRINTLINE' &&
       $tipo->ProductShortName!='DOMESTIC EXPRESS EASY PREPAID' &&
       $tipo->ProductShortName!='DOMESTIC SHIPMENT DEPARTURE' &&
       $tipo->ProductShortName!='EXPRESS EDOMM' ){
    $serv.= $tipo->ProductShortName." - Precio(Iva Incluido) : $".$tipo->ShippingCharge." MXN \n";
   }

}

echo $serv;

}else{
    
    echo "Error: ".$error." / ". $desc_error;
    }
?>