<?php
require_once '../config/conexion.inc.php';
date_default_timezone_set('America/La_Paz');
session_start();
$date = date('Y-m-d'); 
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro=$_POST['nro']; 
$hora=date("H:i:s");
$turno=$_POST['turno'];



if($turno=="0"){
   print "<script>alert(\"Seleccione turno.\");window.location='nuevo.php';</script>"; 
}else{
    $total_eliminacion = $db->GetOne("select sum(subtotal) from detalle_parte_produccion
							 where nro = '$nro' and sucursal_id='$sucur'");
$inventario = $db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sucur);
$insertar = $db->Execute("insert into parte_produccion(nro,hora,fecha,total,turno,usuario_id,sucursal_id,inventario_id)
VALUE ('$nro','$hora','$date','$total_eliminacion','$turno','$usuario[idusuario]','$sucur','$inventario')");
}
if($insertar != null){
print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
}
else{
print "<script>alert(\"No se puedo Guardar.\");window.location='nuevo.php';</script>";

}


?>