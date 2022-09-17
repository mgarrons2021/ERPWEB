<?php
	$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
	$idproducto = $_POST['idproducto'];
	$consulta = "select * FROM producto where idproducto=".$idproducto;
	$result = $conexion->query($consulta);
	$respuesta = new stdClass();
	if($result->num_rows>0){
		$fila = $result->fetch_array();
		$respuesta->idproducto = $fila['idproducto'];
	  //$respuesta->codigoproducto = $fila['codigo_producto'];
    //$respuesta->nombreproducto = $fila['nombre'];
	 	$respuesta->precio_compra = $fila['precio_compra'];	
	}
	echo json_encode($respuesta);
?>