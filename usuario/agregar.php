<?php
require_once '../config/conexion.inc.php';
$codigo_usuario=$_POST['codigo'];
$nombre=$_POST['nombre'];
$celular=$_POST['celular'];
$direccion=$_POST['direccion'];
$cargo=$_POST['cargo'];
$correo=$_POST['correo'];
$estado=$_POST['estado'];
$fecha=date('Y-m-d');
$rol=$_POST['rol'];
$sucursal= $_POST['sucursal'];

$sql = $db->Execute("insert into usuario(codigo_usuario,nombre,celular,direccion,cargo,correo,estado,fecha,rol_id,sucursal_id)
VALUE ('$codigo_usuario','$nombre','$celular','$direccion','$cargo','$correo','$estado','$fecha','$rol','$sucursal')");

if ($sql=!null) {
 print	"<script>alert(\"Agregado exitosamente.\");window.location='listar.php';</script>";
# code...
}
else{
print	"<script>alert(\"Ne pudo agregar.\");window.location='listar.php';</script>";
}

	# code...






?>