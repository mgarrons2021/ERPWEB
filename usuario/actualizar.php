<?php
require_once '../config/conexion.inc.php';
$idusuario=$_POST['idusuario'];
$codigo_usuario=$_POST['codigo_usuario'];
$nombre=$_POST['nombre'];
$celular=$_POST['celular'];
$direccion=$_POST['direccion'];
$correo=$_POST['correo'];
$estado=$_POST['estado'];
$fecha=date('Y-m-d');
$rol=$_POST['rol'];
$sucursal= $_POST['sucursal'];


$sql = $db->Execute("update usuario set codigo_usuario='$codigo_usuario', nombre='$nombre',celular='$celular', 
							direccion='$direccion',correo='$correo',estado='$estado' ,rol_id='$rol',sucursal_id='$sucursal' where idusuario= '$idusuario'");

if ($sql=!null) {
	print "<script>alert(\"Actualizado exitosamente.\");window.location='listar.php';</script>";
	# code...
}
else{
	print "<script>alert(\"No se pudo Actualizar.\");window.location='listar.php';</script>";
}
?>