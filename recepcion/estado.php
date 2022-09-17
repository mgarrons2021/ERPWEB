<?php
require_once '../config/conexion.inc.php';
$id=$_GET['id'];
$sql = $db->GetRow("select * from traspaso where idtraspaso = $id ");
$inventario_id=$db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sql['sucursal_id']);
$inventario_idinventario=$db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sql['sucursal_idtraspaso']);
if ($sql["estado"]=='si'){
//	$sql = $db->Execute("update traspaso set inventario_id='0' where idtraspaso=$id ");
//	$sql = $db->Execute("update traspaso set inventario_idinventario='0' where idtraspaso=$id ");
  $sql = $db->Execute("update traspaso set estado='no' where idtraspaso=$id ");
}
else{
//	$sql = $db->Execute("update traspaso set inventario_id='$inventario_id' where idtraspaso=$id ");
//	$sql = $db->Execute("update traspaso set inventario_idinventario='$inventario_idinventario' where idtraspaso=$id ");
	  $sql = $db->Execute("update traspaso set estado='si' where idtraspaso=$id ");
	  }
header("location: ../recepcion/index.php");
?>