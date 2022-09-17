<?php
require_once '../config/conexion.inc.php';
$id=$_GET['id'];
$sql = $db->GetRow("select * from venta where idventa='$id'");
if ($sql["estado"]=='V'){
	$sql = $db->Execute("update venta set estado='A' where idventa='$id'");
                             }
else{
	  $sql= $db->Execute("update venta set estado='V' where idventa='$id'");
	  }
	  if($sql==true){ header("location: ./ventas_sucursales.php");}
	  else{ print "<script>alert(\"No se pudo realizar la accion.\");window.location='../ventas/index.php';</script>";}

?>