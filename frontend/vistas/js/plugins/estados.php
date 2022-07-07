<?php 
$host='170.247.226.26';
$db='linkopcommx_ecommerce';
$user='linkopcommx_god';
$pass='U&V=Fx*qF$iG';
$conexion = new mysqli($host, $user, $pass, $db);

$query_cont1 = "SELECT *
          FROM estados
          ";

$query_cont12 = "SELECT id

FROM estados

ORDER BY id DESC LIMIT 1;
          ";
$consu_cont12 = $conexion->query($query_cont12);

$execu_id_sap = $consu_cont12->fetch_array(MYSQLI_BOTH);

$consu_cont1 = $conexion->query($query_cont1);
echo '[';
while ($execu_rb1 = $consu_cont1->fetch_array(MYSQLI_BOTH)) {
    $respuesta1 = $execu_id_sap['id'] == $execu_rb1['id'] ? '' : ',';
    echo'
    
        { "name": "'.$execu_rb1['name'].'", "code": "'.$execu_rb1['code'].'" ,"costo": "'.$execu_rb1['costo'].'" } '. $respuesta1.'
      
    ' ;
}
echo ']';
