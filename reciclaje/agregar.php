<?php
require_once '../config/conexion.inc.php';
date_default_timezone_set('America/La_Paz');
session_start();
$date = date('Y-m-d');
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro=$_POST['nro'];
$obs=$_POST['obs'];
$hora=date("H:i:s");
$total_eliminacion = $db->GetOne("select sum(subtotal) from detallereciclaje
							 where nro = '$nro' and sucursal_id='$sucur'");
$inventario = $db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sucur);
$insertar = $db->Execute("insert into reciclaje(nro,hora,fecha,total,descripcion,usuario_id,sucursal_id,inventario_id)
VALUE ('$nro','$hora','$date','$total_eliminacion','$obs','$usuario[idusuario]','$sucur','$inventario')");
if($insertar != null){
print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
}
else{
print "<script>alert(\"No se puedo Guardar.\");window.location='nuevo.php';</script>";
}
?>