<?php
	$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
	$nit_ci =$_POST['nit'];
	$consulta = "SELECT * FROM cliente WHERE nit_ci='$nit_ci'";
	$result = $conexion->query($consulta);
	$respuesta = new stdClass();
	if($result->num_rows > 0){
		$fila = $result->fetch_array();
		$respuesta->idcliente =$fila['idcliente'];
		$respuesta->nombre =$fila['nombre'];
		$respuesta->celular =$fila['celular'];
		$respuesta->fecha =$fila['fecha'];
	}
	echo json_encode($respuesta);
?>

