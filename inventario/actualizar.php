<?php
require_once '../config/conexion.inc.php';
//date_default_timezone_set('America/La_Paz');
session_start();
//$date = date('Y-m-d'); 
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro=$_POST['nro'];
$ids=$_POST['ids'];
$hora=date("H:i:s");
$total_inventario = $db->GetOne("select sum(subtotal) from detalleinventario where nro = '$nro' and sucursal_id='$sucur'");
//$inventario = $db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sucur);
$actualizar= $db->Execute("update inventario set estado='$ids',total='$total_inventario' where nro='$nro' and sucursal_id='$sucur'");
if($actualizar!= null){
print "<script>alert(\"Actualizado exitosamente.\");window.location='index.php';</script>";
}
else{
print "<script>alert(\"No se puedo Actualizar.\");window.location='index.php';</script>";
}
?>