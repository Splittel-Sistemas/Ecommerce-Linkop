<?php 
require('./Openpay/Data/Openpay.php');
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac', 'MX');

        // Establecer la zona horaria predeterminada a usar. Disponible desde PHP 5.1
        date_default_timezone_set('America/Mexico_City');

        $fecha = date("m.d.y");

        $customer = array(
             'name' => $_POST["holder_name"],
             'email' => $_POST["email"],
             'phone_number' => $_POST["phone_number"],
             'card_number' => $_POST["card_number"],
             'expiration_month' => $_POST["expiration_month"],
             'expiration_year' => $_POST["expiration_year"],
             'creation_date' => $fecha,
             'cvv2' => $_POST["cvv"],);

        $chargeData = array(
            'method' => 'card',
            'source_id' => $_POST["token_id"],
            'amount' => $_POST["amount"], // formato númerico con hasta dos dígitos decimales. 
            'description' => "Compra de comida rápida",
            'device_session_id' => $_POST["deviceIdHiddenFieldName"],
            'customer' => $customer
            );

        $charge = $openpay->charges->create($chargeData);

