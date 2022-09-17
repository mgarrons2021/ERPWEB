<?php
require_once '../config/conexion.inc.php';

$nombre=$_POST['nombre'];

$sql = $db->Getrow("insert into rol(nombre) 
  						VALUE ('$nombre')");
if ($sql=!null) {
	print "<script>alert(\"Agregado exitosamente.\");window.location='listar.php';</script>";
	# code...
}
else{
	print "<script>alert(\"No se pudo Registrar.\");window.location='listar.php';</script>";
}
?>