<?php
require_once '../config/conexion.inc.php';
date_default_timezone_set('America/La_Paz');
$nro=$_POST['nro']; 
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
$insertar = $db->Execute("insert into plato(nro,fecha,nombre,precio_uni,precio_dely,costo,imagen,estado,categoria)
VALUE ('$nro','$date','$nombre','$p_uni','$p_delivery','$costo','$ruta','si','$categoria')");                  
if($insertar){
print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";}
else{
print "<script>alert(\"No se puedo Guardar.\");window.location='nuevo.php';</script>";
}
?>