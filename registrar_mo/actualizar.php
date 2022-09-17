<?php
require_once '../config/conexion.inc.php';
$idcliente=$_POST['idcliente'];
$nombre=$_POST['nombre'];
$celular=$_POST['celular'];
$negocio=$_POST['negocio'];
$direccion=$_POST['direccion'];
$gps=$_POST['gps'];
$observacion=$_POST['observacion'];
$idzona=$_POST['zona'];
$idtipo_negocio=$_POST['tnegocio'];
$estado= $_POST['estado'];
$fecha = date('Y-m-d');

$sql= mysqli_query($enlaces,"update cliente set nombre='$nombre',celular='$celular',
							negocio='$negocio',direccion='$direccion',gps='$gps',observaciones='$observacion', idzona='$idzona',idtipo_negocio='$idtipo_negocio' where idcliente= '$idcliente'");	
$result= mysqli_num_rows($sql);
if ($result>0) {

	print "<script>alert(\"Actualizado exitosamente.\");window.location='listar.php';</script>";
	# code...
}
else{
	print "<script>alert(\"No se pudo Actualizar.\");window.location='listar.php';</script>";
}
?>