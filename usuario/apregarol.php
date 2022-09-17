<?php
require_once '../config/conexion.inc.php';
$id=$_GET['id'];
$sql = $db->GetRow("select * from permisos where id = $id ");

$nro = $db->GetOne('SELECT max(idpermisos)+1 FROM rol');
      if ($nro == '') {
        $nro = 0;
        $nro++;   # code...$
      }
if ($sql["estado"]=='activo') {
	$sql = $db->Execute("update permisos set estado='inactivo' where id=$id ");
	# code...
}
else{
	$sql = $db->Execute("update permisos set estado='activo' where id=$id ");
	}
header("location: ../usuario/nuevo.php");

?>