<?php
require_once '../config/conexion.inc.php';
$id=$_GET['id'];
$sql = $db->GetRow("select * from usuario where idusuario = $id ");
if ($sql["estado"]=='activo'){
	$sql = $db->Execute("update usuario set estado='inactive' where idusuario=$id ");
                             }
    else{
	  $sql = $db->Execute("update usuario set estado='activo' where idusuario=$id ");
	  }
header("location: ../usuario/listar.php");
?>