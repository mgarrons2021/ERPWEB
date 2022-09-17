<?php
require_once '../config/conexion.inc.php';
session_start();
$date = date('Y-m-d'); 
$hora=date("H:i:s");
//$date2=$_POST['fechaentrega'];
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id']; 
$nro=$_POST['nro']; 
$ids=$_POST['ids']; 
$turno=$_POST['turno']; 
//$idsucursal=$_POST['idsucursal'];
if($turno=="0"){
   print "<script>alert(\"Seleccione turno.\");window.location='nuevo.php';</script>"; 
}else{
 $total_compra = $db->GetOne("select sum(subtotal) from detalleinventario where nro = '$nro' and sucursal_id=$sucur ");
$insertar = $db->Execute("insert into inventario(nro,total,fecha,estado,hora,turno,sucursal_id,usuario_id)
VALUE ('$nro','$total_compra','$date','$ids','$hora','$turno','$usuario[sucursal_id]','$usuario[idusuario]')");   
}


//$c_almacen = $db->GetAll("select producto_id from almacen");
if($insertar != null){
print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
}
else{
print "<script>alert(\"No se puedo Guardar.\");window.location='nuevo.php';</script>";
}
?>