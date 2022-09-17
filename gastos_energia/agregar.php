<?php
require_once '../config/conexion.inc.php';
date_default_timezone_set('America/La_Paz');
session_start();
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro=$_POST['nro'];
$date = date('Y-m-d');
$hora= time();
$time = date("G:i");
$datoingresado= (float)($_POST['consumototal']);
$acumulado=$db->GetOne("SELECT SUM(consumo) FROM `consumoelectrico` WHERE sucursal_id = $sucur and fecha = '$date';");
$consumototal=number_format(($datoingresado + $acumulado),2);
   $insertar = $db->Execute("insert into consumoelectrico(nro,fecha, hora, consumo,sucursal_id, usuario_id)
   VALUES ('$nro','$date','$time','$datoingresado','$usuario[sucursal_id]','$usuario[idusuario]')");
if($insertar != null){
print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";

}
else{
print "<script>alert(\"No se puedo Guardar.\");window.location='nuevo.php';</script>";
}
?>