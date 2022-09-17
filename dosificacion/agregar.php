<?php
require_once '../config/conexion.inc.php';

$n_auto=$_POST['n_auto'];
$fech_ini=$_POST['fech_ini'];
$fech_fin=$_POST['fech_fin'];
$nit_suc=$_POST['nit_suc'];
$n_factura=$_POST['n_factura'];
$llave=$_POST['llave'];
$estado=$_POST['estado'];
$sucursal=$_POST['sucursal'];

	$sql = $db->Execute("insert into auntorizacion (n_auto ,fech_ini, fech_fin ,nit_suc,n_factura,llave, estado, sucursal_id)VALUE ('$n_auto','$fech_ini','$fech_fin','$nit_suc','$n_factura','$llave','$estado','$sucursal')");
if ($sql=!null) {
	print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
}
else{
	print "<script>alert(\"No se pudo Registrar.\");window.location='nuevo.php';</script>";
}

?>