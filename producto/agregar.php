<?php
require_once '../config/conexion.producto.php';
$precio_venta  = 0;
$excluir_ventas = 'no';
$producto_list = json_decode($_POST['producto_list'], true); // recogemos toda la lista que nos llega desde ajax
$respuesta = array();
foreach ($producto_list['producto'] as $item) {
	$codigo        = $item['codigo'];
	$nombre        = $item['nombre'];
	$descripcion   = $item['descripcion'];
	$precio_compra = $item['precio'];
	$tipo_impuesto = (int)$item['tipo_impuesto'];
	$tipo_articulo = (int)$item['tipo_articulo'];
	$unidad_medida = (int)$item['unidad_medida'];
	$categoria 	   = (int)$item['categoria'];
	$estado        = $item['estado'];
	$proveedor_id  = (int)$item['proveedor'];

	$insert = "INSERT INTO producto(codigo_producto, nombre, descripcion, precio_compra, estado, idtipo_impuesto, idtipo_articulo, idunidad_medida, idcategoria, idproveedor, precio_venta, excluir_ventas) 
	VALUES ('$codigo','$nombre','$descripcion', $precio_compra,'$estado',$tipo_impuesto,$tipo_articulo,$unidad_medida,$categoria, $proveedor_id, '$precio_venta','$excluir_ventas')";

	if (mysqli_query($db, $insert)) {
		$producto_id = mysqli_insert_id($db);
		$insert_detalle = "INSERT INTO detalle_producto_proveedor(producto_id, proveedor_id) VALUES($producto_id,$proveedor_id)";
		$sql_detalle = mysqli_query($db, $insert_detalle);
		$respuesta = array("estado" => "true");
	}else{
		$respuesta = array("estado" => "false");
	}
}
return print(json_encode( $respuesta ));
?>