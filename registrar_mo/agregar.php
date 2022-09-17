<?php
require_once '../config/conexion.inc.php';
date_default_timezone_set('America/La_Paz');
session_start();
$date = date('Y-m-d');
$ventas=$_POST['ventas'];
$horas=$_POST['horas'];
$totalhoras=$horas*8.84;
$porcentaje=($totalhoras/$ventas)*100;
$porcentaje = round($porcentaje, 2);
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro=$_POST['nro'];
$turno=$_POST['turno'];
$fecha = $_POST['fecha'];

if($turno=="0"){
   print "<script>alert(\"Seleccione turno.\");window.location='nuevo.php';</script>"; 
}else{
   $insertar = $db->Execute("insert into registrar(nro,fecha,ventas,horas,totalhoras,porcentaje,turno,sucursal_id,usuario_id)
   VALUE ('$nro','$fecha','$ventas','$horas','$totalhoras','$porcentaje','$turno','$usuario[sucursal_id]','$usuario[idusuario]')");

}

if($insertar != null){
print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
}
else{
print "<script>alert(\"No se puedo Guardar.\");window.location='nuevo.php';</script>";
}
?>