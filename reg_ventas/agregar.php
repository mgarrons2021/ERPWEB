<?php
require_once '../config/conexion.inc.php';
$fecha=$_POST['fecha'];
$hora=date("H:m:s");
$idusuario=$_POST['idusuario'];
$idsucursal=$_POST['idsucursal'];
$turno=$_POST['turno'];
$gaseosas=$_POST['gaseosas'];
$plato_servido=$_POST['plato_servido'];
$hamburguesas=$_POST['hamburguesas'];
$delivery=$_POST['delivery'];
$platos=$_POST['platos'];
$kl=$_POST['kl'];
$porciones= $_POST['porciones'];
$refrescos=$_POST['refrescos'];
$venta_externa=$_POST['venta_externa'];
$transacciones=$_POST['transacciones'];
$total=$_POST['total'];
if($turno=='1'){print	"<script>alert(\"Seleccione turno no sea tonto.\");window.location='nuevo.php';</script>";}
if($total==""||$total==null){print	"<script>alert(\"Precione en Sumar no sea tonto.\");window.location='nuevo.php';</script>";}

$sql = $db->Execute("insert into reg_ventas(turno,fecha,hora,gaseosas,plato_servido,hamburguesas,delivery,platos,kl,porciones,refrescos,venta_externa,total,transacciones,sucursal_id,usuario_id)
VALUE ('$turno','$fecha','$hora','$gaseosas','$plato_servido','$hamburguesas','$delivery','$platos','$kl','$porciones','$refrescos','$venta_externa','$total','$transacciones','$idsucursal','$idusuario')");
if ($sql=!null) {
 print	"<script>alert(\"Agregado exitosamente.\");window.location='listar.php';</script>";
# code...
}
else{
print	"<script>alert(\"Ne pudo agregar.\");window.location='listar.php';</script>";
}
	# code...
?>
