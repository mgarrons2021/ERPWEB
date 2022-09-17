<?php
	$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');

session_start();
$idproducto = $_POST['idproducto'];
$nro= $_POST['inven'];
$usuario=$_SESSION['usuario'];
$sucur=$usuario['idsucursal'];

		 $consulta = "SELECT p.*,
		 ifnull(di.totali, 0)as entradi,
	   ifnull(dc.total, 0)as entrad,
	   ifnull(dt.totalss, 0)as salidas,
	   ifnull(dc.total, 0)+ifnull(di.totali, 0)-ifnull(dt.totalss, 0)as stock
	   from producto p
		 inner join
	   (select producto_id,sum(cantidad) totali from detalleinventario where  sucursal_id='$sucur' and nro='$nro'  and producto_id='$idproducto' ) di on p.idproducto = '$idproducto' 
 	   inner join
	   (select producto_id,sum(cantidad) total from detallecompra where sucursal_id='$sucur' and inventario_id='$nro'  and producto_id='$idproducto' ) dc on p.idproducto = '$idproducto' 
	   inner join
		 (select producto_id,sum(cantidad) totalss from detalletraspaso where sucursal_id='$sucur' and inventario_id='$nro'  and producto_id='$idproducto' ) dt on p.idproducto = '$idproducto';";


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