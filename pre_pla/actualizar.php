<?php

require_once '../config/conexion.inc.php';
session_start();
$usuario = $_SESSION['usuario'];
$ids=$_POST['plato_id'];
$date = date('Y-m-d'); 
$precio=$_POST['precio'];
$precio_d=$_POST['precio_d'];
$categoria=$_POST['categoria'];
$plato=$_POST['plato_id'];
$sucursal=$_POST['sucursal_id'];
/* echo $usuario;
echo $ids;
echo $date;
echo $precio;
echo $precio_d;

exit; */

$actualizar= $db->Execute("update pre_pla set fecha='$date', precio='$precio', precio_d='$precio_d', categoria='$categoria', sucursal_id='$sucursal', plato_id='$plato' where plato_id='$ids'");

if($actualizar!= null) {
print "<script>alert(\"Actualizado exitosamente.\");window.location='index.php';</script>";
}
else{
print "<script>alert(\"No se puedo Actualizar.\");window.location='index.php';</script>";
}

?>