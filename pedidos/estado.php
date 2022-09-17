<?php
require_once '../config/conexion.inc.php';
$idpedido=$_GET['idpedido'];
$id = $db->GetRow("select * from pedido where idpedido=$idpedido");
//$inventario1=$db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$id['sucursal_id']);
//$inventario2=$db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=1");
$sql = $db->Execute("update pedido set estado='si' where idpedido=$idpedido");
header("location:index.php");
?>