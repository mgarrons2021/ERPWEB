<?php
require_once '../config/conexion.inc.php';
$idpedido=$_GET['id'];
$sql = $db->Execute("update pedido set estado='si' where idpedido=$idpedido");
header("location:index.php");
?>