<?php
require_once '../config/conexion.inc.php';
$id=$_GET['id'];
$sql = $db->GetRow("select * from pre_pla where plato_id = $id ");
if ($sql["estado"]=='si'){
	$sql = $db->Execute("update pre_pla set estado='no' where plato_id=$id ");
                             }
    else{
	  $sql = $db->Execute("update pre_pla set estado='si' where plato_id=$id ");
	  }
header("location: ../pre_pla/index.php");
?>