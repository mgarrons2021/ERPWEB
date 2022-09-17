<?php
require_once '../config/conexion.inc.php';
date_default_timezone_set('America/La_Paz');
session_start();
$date = date('Y-m-d'); 
$usuario = $_SESSION['usuario'];
$sucur=$usuario['idsucursal'];
$nro=$_POST['nro'];
$_sucursal=$_POST['sucursal_idtraspaso'];

$total_traspaso = $db->GetOne("select sum(subtotal) from detalletraspaso
							 where nro = '$nro'");
$inventario = $db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sucur);

$insertar = $db->Execute("insert into traspaso(nro,fecha,total,descripcion,usuario_id,sucursal_id,sucursal_idtraspaso,inventario_id)
VALUE ('$nro','$date','$total_traspaso','descripcion','$usuario[idusuario]','$sucur','$_sucursal','$inventario')");

if($insertar != null) {
print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
}
else{
print "<script>alert(\"No se puedo Guardar.\");window.location='nuevo.php';</script>";

}
?>