<?php
require_once '../config/conexion.inc.php';
//date_default_timezone_set('America/La_Paz');
session_start();
//$date = date('Y-m-d'); 
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$idusuario=$usuario['idusuario'];
$nro=$_POST['nro'];
$total_ped = $db->GetAll("select p.*,dp.* from detallepedido dp, producto p where p.idproducto=dp.producto_id and dp.nro ='$nro' and dp.sucursal_id='$sucur'");
//$inventario = $db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sucur);
$total1 = 0;$total2 = 0;
foreach($total_ped as $reg){
if($reg['idcategoria']!=2){$total1 += $reg['subtotal'];}
else{$total2 += $reg['subtotal'];}
}
$actualizar= $db->Execute("update pedido set total='$total1', total2='$total2' where nro='$nro' and sucursal_id='$sucur'");

if($actualizar!= null) {
print "<script>alert(\"Actualizado exitosamente.\");window.location='index.php';</script>";
}
else{
print "<script>alert(\"No se puedo Actualizar.\");window.location='index.php';</script>";
}
?>