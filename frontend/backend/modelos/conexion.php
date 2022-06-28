<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=170.247.226.26;dbname=linkopcommx_ecommerce",
						"linkopcommx_god",
						'U&V=Fx*qF$iG',
						array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		                      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
						);

		return $link;

	}


}



