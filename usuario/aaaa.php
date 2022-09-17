<?php
require_once '../config/conexion.inc.php';

$permisos=$_POST["destino"];
//$sql = $db->GetRow("insert into rol (nombre) values('$nombre')");
echo "esto son los permisos"; print_r($permisos);

$nro = $db->GetOne('SELECT max(id) FROM usuario');
  
                        echo "eso es el maximo id:"."$nro";



 for($j = 0; $j <count($permisos); $j++)
 {
 
//traigo los elementos de la lista y se los asigno a la variable idtienda
 $nombre = $permisos[$j];
 
 
 //consulta mysql que insertara una vez por cada elemento
 $sql2 = $db->GetRow( "INSERT INTO permisos (nombre ,usuario_id) VALUES ('$nombre' , '$nro')" );
 
 }
/*
for ($i=0;$i<count($permisos);$i++)    
{    
$sql2= $db->GetRow("insert into permisos (nombre,usuario_id)value('$permisos[$i]','$nro')");    
}
*/

if ($sql2=!null) {
print "<script>alert(\"Agregado exitosamente.\");window.location='listar.php';</script>";
}
else{
	echo "no se pudo agregar los items";
}
?>