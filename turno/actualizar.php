<?php
require_once '../config/conexion.inc.php';
//date_default_timezone_set('America/La_Paz');
session_start();
//$date = date('Y-m-d'); 
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$turno=$_GET['turno'];
$date=date('Y-m-d');
$hora=date('H:m:s');
$idturno=$_GET['idturno'];
$nro=$_GET['nro'];
$total_turno = $db->GetOne("SELECT sum(v.total)as total
FROM venta v
WHERE  v.idturno='$idturno' and estado='V'");
$actualizar= $db->Execute("update turno set estado='no',total='$total_turno',hora_fin='$hora' where idturno='$idturno'");
if($actualizar!= null){
print "<script>alert(\"Cierre de turno Exitoso.\");window.location='../turno/turno.php';</script>";
}
else{
print "<script>alert(\"No se puedo Realizar el Cierre.\");window.location='../ventas/nuevo.php';</script>";
}
?>