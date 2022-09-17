<?php
require_once '../config/conexion.inc.php';
session_start();
$date = date('Y-m-d'); 
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nv='1'; 
$nro			   = $_POST['nro']; 
$idprovedor        = $_POST['idproveedor'];

//Calcula el precio Total de la compra
$inventario = $db->GetOne("SELECT max(nro) FROM inventario WHERE sucursal_id=".$sucur);
$total_compra = $db->GetOne("SELECT sum(subtotal) FROM detallecompra
							 WHERE nro = '$nro' AND sucursal_id='$sucur'");

//Formateando decimales para que se guarde en la base de datos con decimal
$deuda = number_format($total_compra, 2);
$total = number_format($total_compra, 2);

	if($idprovedor=="")	{
		print "<script>alert(\"Seleccione proveedor.\");window.location='nuevo.php';</script>";
	}
	else{
$insertar = $db->Execute("INSERT INTO compra(
	nro,
	deuda,
	total,
	fecha,
	descripcion,
	usuario_id,
	sucursal_id,
	proveedor_id,
	inventario_id,
	estado)
VALUES(
	'$nro',
	'$total_compra',
	'$total_compra',
	'$date',
	'descripcion',
	'$usuario[idusuario]',
	'$usuario[sucursal_id]',
	'$idprovedor',
	'$inventario', 
	'activa')");

if($insertar != null ) {
print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
$db->Execute("UPDATE detallecompra SET estado = 'si' WHERE nro = '$nro'");
}
else{
	print "<script>alert(\"No se puedo Guardar.\");window.location='nuevo.php';</script>";
 }
}
?>