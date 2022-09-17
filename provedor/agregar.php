<?php
require_once '../config/conexion.inc.php';
$codigo=$_POST['codigo'];
$nombre=$_POST['nombre'];
$celular=$_POST['celular'];
$empreza=$_POST['empreza'];
$nit=$_POST['nit'];
$tipo_categoria=$_POST['tipo_categoria'];
$tipo_credito=$_POST['tipo_credito'];

$sql = $db->Execute("insert into proveedor (codigo,nombre,celular,empreza,nit,tipo_categoria,tipo_credito) 
  						VALUE ('$codigo','$nombre','$celular','$empreza','$nit','$tipo_categoria','$tipo_credito')");
if ($sql=!null) {
	print "<script>alert(\"Agregado exitosamente.\");window.location='listar.php';</script>";
	# code...
}
else{
	print "<script>alert(\"No se pudo Registrar.\");window.location='listar.php';</script>";
}
?>





