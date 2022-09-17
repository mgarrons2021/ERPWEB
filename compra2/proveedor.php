<?php

    $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
	$idproveedor = $_POST['idproveedor'];
	$consulta = "select * FROM proveedor WHERE idproveedor = '$idproveedor'";
	$result = $conexion->query($consulta);

	/*while ($ver=mysqli_fetch_row($result)) {
		$cadena=$ver[5];
		echo "$cadena";
	}*/

	$respuesta = new stdClass();
	if($result->num_rows > 0){
		$fila = $result->fetch_array();
		$respuesta->idproveedor = $fila['idproveedor'];
		$respuesta->codigoproveedor = $fila['empreza'];
		$respuesta->nombreproveedor = $fila['nombre'];
		$respuesta->nitproveedor = 	$fila['nit'];

	}
	echo json_encode($respuesta);
?>