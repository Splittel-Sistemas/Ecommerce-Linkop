<?php

require_once "conexion.php";

class ModeloCarrito
{

	/*=============================================
	MOSTRAR TARIFAS
	=============================================*/

	static public function mdlMostrarTarifas($tabla)
	{

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

		$tmt = null;
	}

	/*=============================================
	NUEVAS COMPRAS
	=============================================*/

	static public function mdlNuevasCompras($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_usuario, id_producto, metodo, email, direccion, pais, cantidad, detalle, pago) VALUES (:id_usuario, :id_producto, :metodo, :email, :direccion, :pais, :cantidad, :detalle, :pago)");

		$stmt->bindParam(":id_usuario", $datos["idUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $datos["idProducto"], PDO::PARAM_INT);
		$stmt->bindParam(":metodo", $datos["metodo"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":pais", $datos["pais"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
		$stmt->bindParam(":pago", $datos["pago"], PDO::PARAM_STR);

		if ($stmt->execute()) {


			$salida = "salida";
			$stmt1 = Conexion::conectar()->prepare("INSERT INTO log_stock (id_usuario_compras, id_producto, metodo, cantidad, detalle) VALUES (:id_usuario_compras, :id_producto, :metodo, :cantidad, :detalle)");

			$stmt1->bindParam(":id_usuario_compras", $datos["idUsuario"], PDO::PARAM_INT);
			$stmt1->bindParam(":id_producto", $datos["idProducto"], PDO::PARAM_INT);
			$stmt1->bindParam(":metodo", $datos["metodo"], PDO::PARAM_STR);

			$stmt1->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
			$stmt1->bindParam(":detalle", $salida, PDO::PARAM_STR);

			$stmt1->execute();
			$item1 = $datos["cantidad"] ; 
			$item2 =  $datos["idProducto"] ; 
			$stmt2 = Conexion::conectar()->prepare("UPDATE productos SET cantidad - $item1 WHERE id = $item2");

		/* 	$stmt2->bindParam(":cantidad", $item1, PDO::PARAM_INT);
			$stmt2->bindParam(":id", $item2, PDO::PARAM_INT);
 */
			$stmt2->execute();

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$tmt = null;
	}

	/*=============================================
	VERIFICAR PRODUCTO COMPRADO
	=============================================*/

	static public function mdlVerificarProducto($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario = :id_usuario AND id_producto = :id_producto");

		$stmt->bindParam(":id_usuario", $datos["idUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $datos["idProducto"], PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

		$tmt = null;
	}
}
