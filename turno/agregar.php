<?php
require_once '../config/conexion.inc.php';
date_default_timezone_set('America/La_Paz');
session_start();
$date = date('Y-m-d');
$hora=date("H:m:s");
$usuario = $_SESSION['usuario'];
$usu=$usuario['idusuario'];
$sucur=$usuario['sucursal_id'];

$nro=$db->GetOne("select count(sucursal_id)+1 from  turno where sucursal_id='$sucur' and fecha='$date'");
if ($nro == ''){$nro = 0;$nro++;}

$insertar = $db->Execute("insert into turno(nro,fecha,estado,hora_ini,hora_fin,total,usuario_id,sucursal_id)
VALUE ('$nro','$date','si','$hora','','0','$usu','$sucur')");

if($insertar!=null){
print "<script>alert(\"Inicio de turno exitoso.\");window.location='../ventas/nuevo.php';</script>";
}
else{
print "<script>alert(\"No se pudo iniciar turno.\");window.location='turno.php';</script>";
}

?>