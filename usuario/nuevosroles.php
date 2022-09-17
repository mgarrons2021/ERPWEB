<?php
require_once '../config/conexion.inc.php';

$permisos=$_POST["destino"];
$nro=$_POST["idperr"];
echo "esto es el numero del rol"."$nro";
$arrays[]=array();
$c=0;

$query = $db->Execute('select * from permisos where rol_id='.$nro); 
 foreach ($query as $r){
 $arrays[$c]=$r["idpermisos"];
 $c++;
 }
for ($i=0;$i<count($arrays);$i++)    
{
$sql = $db->Execute("DELETE * from permisos WHERE idpermisos=".$arrays["i"]);  
}
for ($i=0;$i<count($permisos);$i++)  
{     
$sql2= $db->GetRow("insert into permisos (nombre,rol_id)values('$permisos[$i]','$nro')");    
} 
if ($sql2=!null) {
print "<script>alert(\"Se asigno nuevos roles exitosamente.\");window.location='listar.php';</script>";
# code...
}
else{
  echo "no se puedo asignar nuevos roles";
}
?>