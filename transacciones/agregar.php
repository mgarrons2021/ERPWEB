<?php
require_once '../config/conexion.inc.php';
$fecha=$_POST['fecha'];
$turno=$_POST['turno'];
$hora1=$_POST['hora1'];
$hora2=$_POST['hora2'];
$hora3=$_POST['hora3'];
$hora4=$_POST['hora4'];
$hora5=$_POST['hora5'];
$hora6=$_POST['hora6'];
$hora7=$_POST['hora7'];
$hora8=$_POST['hora8'];
$hora9=$_POST['hora9'];
$total=$_POST['total'];
$idsucursal=$_POST['idsucursal'];
$idusuario=$_POST['idusuario'];
if($turno=='1'){print	"<script>alert(\"Seleccione turno no sea tonto.\");window.location='nuevo.php';</script>";}
if($total==""||$total==null){print	"<script>alert(\"Precione en Sumar no sea tonto.\");window.location='nuevo.php';</script>";}
$sql = $db->Execute("insert into transacciones(turno,total,fecha,hora1,hora2,hora3,hora4,hora5,hora6,hora7,hora8,hora9,sucursal_id,usuario_id)
VALUE ('$turno','$total','$fecha','$hora1','$hora2','$hora3','$hora4','$hora5','$hora6','$hora7','$hora8','$hora9','$idsucursal','$idusuario')");
if ($sql=!null) {
 print	"<script>alert(\"Agregado exitosamente.\");window.location='listar.php';</script>";
# code...
}
else{
print	"<script>alert(\"Ne pudo agregar.\");window.location='listar.php';</script>";
}
	# code...
?>