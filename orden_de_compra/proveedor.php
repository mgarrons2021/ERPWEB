<?php

	$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
	$idproveedor = $_POST['idproveedor'];
	$consulta = "select * FROM proveedor WHERE idproveedor = '$idproveedor'";
	$result = $conexion->query($consulta);
	$respuesta = new stdClass();
	if($result->num_rows > 0){
		$fila = $result->fetch_array();
		$respuesta->idproveedor = $fila['idproveedor'];
		$respuesta->codigoproveedor = $fila['empreza'];
		$respuesta->nombreproveedor = $fila['nombre'];	
	}
	echo json_encode($respuesta);
?>