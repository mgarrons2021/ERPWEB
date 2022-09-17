<?php
require_once '../config/conexion.inc.php';
date_default_timezone_set('America/La_Paz');
session_start();
$date = date('Y-m-d'); 
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro=$_POST['nro']; 
$_sucursal=$_POST['sucursal_idtraspaso'];
$inventario_idinventario=$db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$_sucursal);
$total_traspaso = $db->GetOne("select sum(subtotal) from detalletraspaso
							 where nro = '$nro' and sucursal_id='$sucur'");
$inventario = $db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sucur);

if ($_sucursal==""){
print "<script>alert(\"Selecione sucursal.\");window.location='nuevo.php';</script>";
}
else{
$insertar = $db->Execute("insert into traspaso(nro,fecha,total,descripcion,estado,usuario_id,sucursal_id,sucursal_idtraspaso,inventario_id,inventario_idinventario)
VALUE ('$nro','$date','$total_traspaso','descripcion','no','$usuario[idusuario]','$sucur','$_sucursal','$inventario','$inventario_idinventario')");

if($insertar != null) {
print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
}
else{
print "<script>alert(\"No se puedo Guardar.\");window.location='nuevo.php';</script>";

}

}
?>