<?php
require_once '../config/conexion.inc.php';
//date_default_timezone_set('America/La_Paz');
session_start();
//$date = date('Y-m-d'); 
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro=$_POST['nro']; 
$total_eliminacion = $db->GetOne("select sum(subtotal) from detalleeliminacion where nro = '$nro' and sucursal_id='$sucur'");

//$inventario = $db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sucur);

$actualizar= $db->Execute("update eliminacion set total='$total_eliminacion' where nro='$nro' and sucursal_id='$sucur'");

if($actualizar!= null) {
print "<script>alert(\"Actualizado exitosamente.\");window.location='index.php';</script>";
}
else{
print "<script>alert(\"No se puedo Actualizar.\");window.location='index.php';</script>";
}
?>