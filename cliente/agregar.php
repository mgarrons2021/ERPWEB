<?php
require_once '../config/conexion.inc.php';
//$codigo=$_POST['codigo'];
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nombre=$_POST['nombre'];
$celular=$_POST['celular'];
//$empreza=$_POST['empreza'];
//$nit=$_POST['nit'];
//$tipo_categoria=$_POST['tipo_categoria'];
//$tipo_credito=$_POST['tipo_credito'];
$sql = $db->Execute("insert into cliente (nit_ci,nombre,celular,fecha,hubicacion,sucursal_id) 
  						VALUE ('','$nombre','$celular','','','$sucur')");
if ($sql=!null) {
	print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
	# code...
}
else{
	print "<script>alert(\"No se pudo Registrar cliente.\");window.location='nuevo.php';</script>";
}
?>