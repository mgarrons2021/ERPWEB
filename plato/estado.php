<?php
require_once '../config/conexion.inc.php';
$id=$_GET['id'];
$sql = $db->GetRow("select * from plato where idplato = $id ");
if ($sql["estado"]=='si'){
	$sql = $db->Execute("update plato set estado='no' where idplato=$id ");
                             }
    else{
	  $sql = $db->Execute("update plato set estado='si' where idplato=$id ");
	  }
header("location: ../plato/index.php");
?>