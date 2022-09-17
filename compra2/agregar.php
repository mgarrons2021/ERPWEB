<?php
require_once '../config/conexion.producto.php';
$precio_venta  = 0;
$excluir_ventas = 'no';
$producto_list = json_decode($_POST['producto_list'], true); // recogemos toda la lista que nos llega desde ajax
//return print(json_encode( $producto_list ));
$respuesta = array();

foreach ($producto_list['producto'] as $item) { 
	foreach ($producto_list['glosa'] as $descripcion){
	$codigo = (int)($item['codigo']);
	$precio_compra = (float)($item['costounitario']);
	$precio_venta = 0;
	$cantidad = (float)($item['cantidad']);
	$subtotal = (float)($item['subtotal']);

	$nro = (int)($item['nro']);
	$compraid = (int)($item['compraid']);
	$fecha = $fecha=date('Y-m-d');
	$id_producto = (int) $item['nombre'];
	$id_usuario = (int) $item['usuarioid'];
	$id_proveedor = (int) $item['proveedorid'];
	$id_inventario = (int)($item['inventarioid']);
	$id_sucursal = (int)($item['sucursal']);
	$estado = $item['estado'];
	$descripcion = $descripcion;

	/*registro pago*/
	$deuda_actual = $subtotal;
	$codigo_control    = ($item['codigocontrol']);
	$fecha_vencimiento = date( $item['fecha_vencimiento']);
	//return print(json_encode( $fecha_vencimiento ));
	$nro_autorizacion  = (int)($item['nroautorizacion']);
	$nro_factura  = (int)($item['nrofactura']);
	$nro_recibo  = (int)($item['nrorecibo']);
	$fecha_actual =	$fecha;
	$emite_factura = $item['emitefactura'];
	$emite_recibo = $item['emiterecibo'];
	$nit = $item['nitproveedor'];
	
	/*Datos temporales */
	$tipo_pago ="value";
	$banco = "value";
	$nro_comprobante = 1;
	$nro_cheque = 1;
	$monto = 0;
	$nro_cuenta = 12345;


	//Pago
	$insert_pago = "INSERT INTO pago(compra_id, fecha, monto, tipo_pago, deuda, emite_factura, recibo,
	nro_recibo, nro_factura, nit, fecha_vencimiento, banco,nro_cuenta, nro_comprobante, nro_cheque, nro_autorizacion, cod_control) 
	VALUES( '$nro', '$fecha_actual', '$monto', '$tipo_pago', '$deuda_actual','$emite_factura','$emite_recibo','$nro_recibo',
	'$nro_factura', '$nit', '$fecha_vencimiento', '$banco', '$nro_cuenta', '$nro_comprobante', '$nro_cheque','$nro_autorizacion', 
	'$codigo_control')";
	//return print(json_encode( $insert_pago ));
	//Compra
	$insert_compra = "insert into compra( nro, total,deuda, fecha, descripcion, usuario_id, sucursal_id, proveedor_id, inventario_id) 
	VALUES ('$nro',' $deuda_actual', '$deuda_actual', '$fecha', '$descripcion','$id_usuario','$id_sucursal','$id_proveedor', '$id_inventario')";
	//return print(json_encode( $insert_compra ));
	/*$nrocompra = "*/

	$nrocompra = "SELECT max(nro) as numero_compra, fecha, descripcion, usuario_id,
	sucursal_id, proveedor_id, inventario_id, SUM(total) as suma, SUM(deuda) as sumadeuda  FROM compra WHERE nro = $nro and sucursal_id =$id_sucursal";
	$nropago = "SELECT * ,sum(deuda) as sumadeuda FROM `pago` WHERE compra_id = $nro;";

	$eliminacion = "DELETE from compra where nro = $nro";
	$eliminacion_pago = "DELETE from pago where compra_id = $nro";



	if (mysqli_multi_query($db, $insert_pago) ) {
		mysqli_multi_query($db, $insert_compra);
		$idcompra = mysqli_insert_id($db);
		$insert_detalle = "INSERT INTO detallecompra(nro, subtotal, cantidad, precio_compra, precio_venta,
			estado, producto_id, sucursal_id, inventario_id) 
			VALUES ('$nro','$subtotal','$cantidad','$precio_compra','$precio_compra','$estado',
		'$id_producto', '$id_sucursal', '$id_inventario')";
		$sql_detalle = mysqli_query($db, $insert_detalle);
		$sumas = mysqli_query($db, $nrocompra);
		$sumaspago = mysqli_query($db, $nropago);
		while ($row = $sumas->fetch_assoc()) {
			$nro = (int) ($row['numero_compra']);
			$total = (float)($row['suma']);
			$deuda = (float)($row['sumadeuda']);
			$fecha =  date($row['fecha']);
			$descripcion =  $row['descripcion'];
			$id_usuario = (int) ($row['usuario_id']);
			$id_proveedor = (int) ($row['proveedor_id']);
			$id_inventario = (int)($row['inventario_id']);
			$id_sucursal = (int)($row['sucursal_id']);
			$estado = 'activo';

			$insertar = "insert into compra( nro, total,deuda, fecha, descripcion, usuario_id, sucursal_id, proveedor_id, inventario_id, estado ) 
			VALUES ('$nro', '$total', '$deuda', '$fecha','$descripcion',
			'$id_usuario', '$id_sucursal', '$id_proveedor', '$id_inventario', '$estado')"; 

			$eliminar = mysqli_query($db, $eliminacion);
			$comprasumada = mysqli_query($db, $insertar);
			
		}
		while ($row = $sumaspago->fetch_assoc()) {
			$nro = $row['compra_id'];
			$fecha = date($row['fecha']);
			$monto = 0;
			$tipo_pago = $row['tipo_pago'];
			$deuda =(float)($row['sumadeuda']);
			$emite_factura = $row['emite_factura'];
			$recibo = $row['recibo'];
			$nro_recibo = $row['nro_recibo'];
			$nro_factura = (int)($row['nro_factura']);
			$nit = $row['nit'];
			$fecha_vencimiento = $row['fecha_vencimiento'];
			$banco = $row['banco'];
			$nro_cuenta = $row['nro_cuenta'];
			$nro_comprobante = $row['nro_comprobante'];
			$nro_cheque = $row['nro_cheque'];
			$nro_autorizacion = $row['nro_autorizacion'];
			$cod_control = $row['cod_control'];

				
			$insertar_pago = "INSERT INTO pago(compra_id, fecha, monto, tipo_pago, deuda, emite_factura, recibo,
			nro_recibo, nro_factura, nit, fecha_vencimiento, banco,nro_cuenta, nro_comprobante, nro_cheque, nro_autorizacion, cod_control) 
			VALUES( '$nro', '$fecha', '$monto', '$tipo_pago', '$deuda','$emite_factura','$recibo','$nro_recibo',
			'$nro_factura', '$nit', '$fecha_vencimiento', '$banco', '$nro_cuenta', '$nro_comprobante', '$nro_cheque','$nro_autorizacion', 
			'$cod_control')";

			$eliminar_p = mysqli_query($db, $eliminacion_pago);
			$pagosumado = mysqli_query($db, $insertar_pago);

		}


		$respuesta = array("estado" => "true");
	}else{
		$respuesta = array("estado" => "false");
	}
	}
}
return print(json_encode( $respuesta ));
?>