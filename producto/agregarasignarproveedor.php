<?php
require_once '../config/conexion.inc.php';
$fecha = date('Y-m-d');
$producto=$_POST['producto'];
$sucursal=$_POST['sucursal'];
$proveedor=$_POST['proveedor'];
$precio=$_POST['precio'];
	$delete = $db->Execute("DELETE FROM producto_proveedor WHERE producto_id = $producto and sucursal_id = $sucursal and proveedor_id = $proveedor;");
	$sql = $db->Execute("insert into producto_proveedor (producto_id,proveedor_id,sucursal_id,precio,
    fecha)VALUE ('$producto','$proveedor', '$sucursal', '$precio', '$fecha')");
if ($sql==true) {
	print "<script>alert(\"Agregado exitosamente.\");window.location='asignarproveedor.php';</script>";
}
else{
	print "<script>alert(\"No se pudo Registrar.\");window.location='asignarproveedor.php';</script>";
}

?>