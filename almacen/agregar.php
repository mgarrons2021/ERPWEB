<?php
require_once '../config/conexion.inc.php';
$ci=$_POST['ci'];
$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$telefono=$_POST['telefono'];

$sql = $db->Execute("insert into cliente (ci,nombre,apellido,telefono) 
  						VALUE ('$ci','$nombre','$apellido','$telefono')");
if ($sql=!null) {
	print "<script>alert(\"Agregado exitosamente.\");window.location='listar.php';</script>";
	# code...
}
else{
	print "<script>alert(\"No se pudo Registrar.\");window.location='listar.php';</script>";
}
?>