<?php
	$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');

	$idproducto = $_POST['idproducto'];
	$consulta = "select pro.*,u.nombre as um FROM unidad_medida u,producto pro where u.idunidad_medida=pro.idunidad_medida and idproducto='$idproducto'";
	$result = $conexion->query($consulta);
	$respuesta = new stdClass();
	if($result->num_rows > 0){
		$fila = $result->fetch_array();
		$respuesta->idproducto = $fila['idproducto'];
	  //$respuesta->codigoproducto = $fila['codigo_producto'];
    //$respuesta->nombreproducto = $fila['nombre'];
	 	$respuesta->precio_compra = $fila['precio_compra'];	
	 	 $respuesta->um=$fila['um'];
	}
	echo json_encode($respuesta);
?>