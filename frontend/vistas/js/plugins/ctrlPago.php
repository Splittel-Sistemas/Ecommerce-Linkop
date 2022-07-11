<?php 
require('Openpay/Data/Openpay.php');

$openpay = Openpay::getInstance('mzpbsqxe2u5jgqywfd3u', 'sk_2185308880ac4f3e884aefadada9f1e3', 'MX');

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

