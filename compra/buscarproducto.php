<?php
	$conexion = mysqli_connect('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');

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
	// $term = $_POST['term'];
	// $sql = "select * from producto where nombre = '$term'";
	// $result =  mysqli_query($conexion, $sql);
	// $array = array();
	// if($result){
	// 	while ($row = mysqli_fetch_array($result)){
	// 		$producto = utf8_encode($row['nombre']);
	// 	   	$array 	  = array($producto); //productos
	// 	}
	// }
?>