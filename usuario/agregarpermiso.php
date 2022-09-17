<?php
require_once '../config/conexion.inc.php';
$nombre=$_POST['rol'];
$permisos=$_POST["destino"];

$sql = $db->GetRow("insert into rol (nombre) values('$nombre')");

$nro = $db->GetOne('SELECT max(id) FROM usuario');

  foreach ($permisos as $r){
  $a=$r["nombre"];
  $sql2= $db->GetRow("insert into permisos (nombre,usuario_id)value('$a','$nro')"); 
                  }
//$sql2= $db->GetRow("insert into permisos (nombre,usuario_id)value('$permisos[$c]','$nro')");  

 

if ($sql2=!null) {
print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
# code...
}
else{
	echo "incorrecto";
}
?>