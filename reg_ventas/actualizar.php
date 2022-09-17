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
$idreg_ventas=$_POST['idreg_ventas'];

if($turno=='1'){print	"<script>alert(\"Seleccione turno no sea tonto.\");window.location='nuevo.php';</script>";}
if($total==""||$total==null){print	"<script>alert(\"Precione en Sumar no sea tonto.\");window.location='nuevo.php';</script>";}

$sql = $db->Execute("update reg_ventas set  fecha='$fecha',turno='$turno', hora='$hora',gaseosas='$gaseosas', 
							plato_servido='$plato_servido',hamburguesas='$hamburguesas',delivery='$delivery' ,platos='$platos',kl='$kl',porciones='$porciones',refrescos='$refrescos',venta_externa='$venta_externa',total='$total',transacciones='$transacciones' where idreg_ventas= '$idreg_ventas'");

if ($sql=!null){
	print "<script>alert(\"Actualizado exitosamente.\");window.location='listar.php';</script>";
	# code...
}
else{
	print "<script>alert(\"No se pudo Actualizar.\");window.location='listar.php';</script>";
}
?>