<?php
require_once '../config/conexion.inc.php';

$permisos=$_POST["destino"];
//$sql = $db->GetRow("insert into rol (nombre) values('$nombre')");
echo "esto son los permisos"; print_r($permisos);

$nro = $db->GetOne('SELECT max(id) FROM usuario');
  
                        echo "eso es el maximo id:"."$nro";



 for($j = 0; $j <count($permisos); $j++)
 {
 
 $nombre = $_POST['destino'][$j];
 $query1 = $db->GetRow( "INSERT INTO permisos (nombre ,usuario_id) VALUES ('$nombre' , '$nro')" );
 
 }


if ($sql2=!null) {
print "<script>alert(\"Agregado exitosamente.\");window.location='listar.php';</script>";
}
else{
	echo "no se pudo agregar los items";
}
?>