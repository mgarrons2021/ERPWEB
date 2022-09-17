<?php
require_once '../config/conexion.inc.php';
date_default_timezone_set('America/La_Paz');
session_start();
$date = date('Y-m-d'); 
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro=$_POST['nro']; 
$total_pedido = $db->GetOne("select sum(subtotal) from detallepedido where nro = '$nro'and sucursal_id='$sucur'");
//$inventario = $db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sucur);

$insertar = $db->Execute("insert into pedido(nro,fecha,total,estado,usuario_id,sucursal_id)
VALUE ('$nro','$date','$total_pedido','no','$usuario[idusuario]','$sucur')");

if($insertar != null) {
print "<script>alert(\"Pedido exitosamente.\");window.location='index.php';</script>";
}
else{
print "<script>alert(\"No se puedo Guardar.\");window.location='index.php';</script>";
}


?>