<?php
$conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
session_start();
$idproducto = $_POST['idproducto'];
$inventario= $_POST['inventario'];
$usuario=$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
		 $consulta = "SELECT p.*,
		 ifnull(di.totali, 0)as entradi,
	   ifnull(dc.total, 0)as entrad,
		 ifnull(de.totale, 0)as entrade,
		 ifnull(dpro.totalpro, 0)as entradpro,
		 ifnull(dtt.totalst, 0)as entradt,
		  ifnull(dp.totalp, 0)as entradp,
      ifnull(dpp.totalpp, 0)as salidapp,
	   ifnull(dt.totalss, 0)as salidas,
	   ifnull(dc.total, 0)+ifnull(di.totali, 0)+ifnull(dtt.totalst, 0)+ifnull(dp.totalp, 0)-ifnull(dpro.totalpro, 0)-ifnull(de.totale, 0)-ifnull(dpp.totalpp, 0)-ifnull(dt.totalss, 0)as stock
	   from producto p
		 inner join
	   (select producto_id,sum(cantidad) totali from detalleinventario where  sucursal_id='$sucur' and nro='$inventario'  and producto_id='$idproducto' ) di on p.idproducto = '$idproducto' 
 	   inner join
	   (select producto_id,sum(cantidad) total from detallecompra where sucursal_id='$sucur' and inventario_id='$inventario'  and producto_id='$idproducto' ) dc on p.idproducto = '$idproducto'
		  inner join
	   (select producto_id,sum(cantidad) totale from detalleeliminacion d, eliminacion e  where d.sucursal_id='$sucur' and e.inventario_id='$inventario' and d.sucursal_id=e.sucursal_id and d.nro=e.nro  and d.producto_id='$idproducto' ) de on p.idproducto = '$idproducto'
		  inner join
	   (select producto_id,sum(cantidad) totalpro from detalleproduccion d, produccion pro  where d.sucursal_id='$sucur' and d.sucursal_id=pro.sucursal_id and pro.inventario_id='$inventario' and d.nro=pro.nro  and d.producto_id='$idproducto' ) dpro on p.idproducto = '$idproducto'
		 inner join
		 (select d.producto_id,sum(d.cantidad_envio) totalp from detallepedido d, pedido p where d.nro=p.nro and d.sucursal_id='$sucur' and d.sucursal_id=p.sucursal_id and p.estado='si' and  p.inventario_id='$inventario'  and producto_id='$idproducto' ) dp on p.idproducto = '$idproducto'
		  inner join
		 (select d.producto_id,sum(d.cantidad_envio) totalpp from detallepedido d, pedido p where d.nro=p.nro and p.sucursal_idsucursal='$sucur' and p.estado='si' and  p.inventario_idinventario='$inventario'  and producto_id='$idproducto' ) dpp on p.idproducto = '$idproducto'
		 inner join
		 (select d.producto_id,sum(d.cantidad) totalss from detalletraspaso d, traspaso t where d.nro=t.nro and d.sucursal_id='$sucur' and t.estado='si' and d.sucursal_id=t.sucursal_id and t.inventario_id='$inventario'  and producto_id='$idproducto' ) dt on p.idproducto = '$idproducto'
		  inner join
		 (select d.producto_id,sum(d.cantidad) totalst from detalletraspaso d, traspaso t where d.nro=t.nro and d.sucursal_idtraspaso='$sucur' and t.estado='si' and d.sucursal_id=t.sucursal_id and  t.inventario_idinventario='$inventario'  and producto_id='$idproducto' ) dtt on p.idproducto = '$idproducto'
		 ;";
	$result = $conexion->query($consulta);
	$respuesta = new stdClass();
	if($result->num_rows > 0){
		$fila = $result->fetch_array();
	 	$respuesta->idproducto = $fila['idproducto'];
		$respuesta->stockactual =$fila['stock'];
    $respuesta->nroi =$fila['stock'];
	}
	echo json_encode($respuesta);
?>