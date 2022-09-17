<?php
require_once '../config/conexion.inc.php';
//date_default_timezone_set('America/La_Paz');
session_start();
//$date = date('Y-m-d'); 
$usuario = $_SESSION['usuario'];
$ids=$_POST['idplato'];
$date = date('Y-m-d'); 
$nombre=$_POST['nombreplato'];
$p_uni=$_POST['p_uni'];
$p_delivery=$_POST['p_delivery'];
$categoria=$_POST['categoria'];
$costo=$_POST['costo'];
$nombreimg=$_FILES['imagen']['name'];
$archivo=$_FILES['imagen']['tmp_name'];//contiene el archivo 
$ruta="../images/".$nombreimg;//../images/nombre.jpg
move_uploaded_file($archivo,$ruta);

$actualizar= $db->Execute("update plato set fecha='$date',nombre='$nombre',precio_uni='$p_uni',precio_dely='$p_delivery',costo='$costo',categoria='$categoria',imagen='$ruta' where idplato='$ids'");

if($actualizar!= null){
print "<script>alert(\"Actualizado exitosamente.\");window.location='index.php';</script>";
}
else{
print "<script>alert(\"No se puedo Actualizar.\");window.location='index.php';</script>";
}
?>