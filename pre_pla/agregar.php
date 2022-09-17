<?php
require_once '../config/conexion.inc.php';
$fecha=$_POST['fecha'];
$nro=$_POST['nro']; 
$precio=$_POST['precio'];
$precio_d=$_POST['precio_d'];
$categoria=$_POST['categoria'];
$sucursal=$_POST['sucursal'];
$plato=$_POST['plato'];
/*  echo $nro;
 echo $precio;
 echo $precio_d;
 echo $categoria;
 echo $sucursal;
 echo $plato;

 exit; */
	$sql = $db->Execute("insert into pre_pla (nro,fecha,precio,precio_d,categoria,plato_id,sucursal_id)VALUE ('$nro','$fecha','$precio','$precio_d','$categoria','$plato','$sucursal')");
if ($sql=!null) {
	print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
}
else{
	print "<script>alert(\"No se pudo Registrar.\");window.location='nuevo.php';</script>";
}

?>