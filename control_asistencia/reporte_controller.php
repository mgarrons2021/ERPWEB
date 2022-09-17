<?php include "../menu/menu.php";
$sucursal_id = $_POST["sucursal_id"];
$fecha_inicial = $_POST["fechainicial"];
$fecha_final = $_POST["fechafinal"];

echo $sucursal_id;
$query = $db->query("
select r.id,u.nombre nombre_usuario, u.cargo nombre_cargo,u.horario hora_ingreso,s.nombre nombre_sucursal,r.fecha,r.hora_entrada , r.hora_salida 
from registro_ingreso r, usuario u,sucursal s
where u.codigo_usuario=r.usuario_id and u.nombre_cargo=r.cargo and r.sucursal_id=s.idsucursal and r.sucursal_id=$sucursal_id and r.fecha between '$fecha_inicial' and '$fecha_final'
");


echo $query;
?>