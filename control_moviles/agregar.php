<?php
require_once '../config/conexion.inc.php';
date_default_timezone_set('America/La_Paz');
session_start();
$usuario = $_SESSION['usuario'];
$sucur=$_POST['sucursal'];
$date = $_POST['fecha'];
$input_hora = $_POST['inputhora'];
$cantidad_bolsas = $_POST['cantidad_bolsas'];
$taxi = $_POST['taxi_id'];
$cdp = $_POST['cdp'];
$insertar = $db->Execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`,`taxi_id`, `cantidad_bolsas`) 
VALUES (NULL, '$date', '$input_hora', '$sucur', '$cdp', '$taxi', '$cantidad_bolsas')");
if($insertar != null){
print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
}
else{
print "<script>alert(\"No se pudo Guardar.\");;</script>";
}
?>