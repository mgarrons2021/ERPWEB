<?php
	$conexion = mysqli_connect('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
    $idproducto = $_POST['idproducto'];
	$sucursal = $_POST['sucursal'];
	$proveedor = $_POST['idproveedor'];
	$consulta = "SELECT propr.producto_id, propr.precio, um.nombre as unidadmedida from producto p  inner JOIN
	producto_proveedor propr on p.idproducto = propr.producto_id inner join 
	proveedor pro on propr.proveedor_id = pro.idproveedor inner join unidad_medida um on p.idunidad_medida= um.idunidad_medida 
	WHERE propr.producto_id = $idproducto and
	p.estado = 'activo' and propr.sucursal_id = $sucursal
	and pro.idproveedor = $proveedor
	ORDER BY `p`.`nombre`  ASC;";
	$result = $conexion->query($consulta);
	$respuesta = new stdClass();	
	if($result->num_rows > 0){
		$fila = $result->fetch_array();
		$respuesta->idproducto = $fila['producto_id'];
		$respuesta->precio_compra = $fila['precio'];	
		$respuesta->um=$fila['unidadmedida'];
	}
	echo json_encode($respuesta);
?>