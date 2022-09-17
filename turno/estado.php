<?php
require_once '../config/conexion.inc.php';
$id=$_GET['id'];
$sql = $db->GetRow("select * from turno where idturno = $id ");
if ($sql["estado"]=='si'){
	$sql = $db->Execute("update turno set estado='no' where idturno=$id ");
                             }
    else{
	  $sql = $db->Execute("update turno set estado='si' where idturno=$id ");
	  }
header("location: ../turno/turno.php");
?>