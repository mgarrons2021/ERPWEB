<?php
require_once '../config/conexion.inc.php';
$id=$_GET['idcliente'];
$sql=mysqli_query($enlace,"select * from cliente where idcliente = $id ");
$data=mysqli_fetch_array($sql);
if ($data["estado"]=='activo'){
mysqli_query($enlace,"update cliente set estado='inactivo' where idcliente=$id ");
	# code...
}
else{
	mysqli_query($enlace,"update cliente set estado='activo' where idcliente=$id ");
	}

header("location: ../cliente/listar.php");

?>