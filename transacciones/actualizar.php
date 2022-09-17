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
$idtransacciones=$_POST['idtransacciones'];

if($turno=='1'){print	"<script>alert(\"Seleccione turno no sea tonto.\");window.location='nuevo.php';</script>";}
if($total==""||$total==null){print	"<script>alert(\"Precione en Sumar no sea tonto.\");window.location='nuevo.php';</script>";}

$sql = $db->Execute("update transacciones set  turno='$turno',total='$total',fecha='$fecha',hora1='$hora1',hora2='$hora2',hora3='$hora3',hora4='$hora4',hora5='$hora5',hora6='$hora6',hora7='$hora7',hora8='$hora8',hora8='$hora8',hora9='$hora9' where idtransacciones= '$idtransacciones'");

if ($sql=!null){
	print "<script>alert(\"Actualizado exitosamente.\");window.location='listar.php';</script>";
	# code...
}
else{
	print "<script>alert(\"No se pudo Actualizar.\");window.location='listar.php';</script>";
}
?>