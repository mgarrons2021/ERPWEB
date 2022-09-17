<?php
require_once '../config/conexion.inc.php';
date_default_timezone_set('America/La_Paz');
session_start();
$date = date('Y-m-d'); 
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$hora=date("H:i:s");
$fecha_a_entregar = $_POST['fecha_a_entregar'];
$nro=$_POST['nro'];
$traspasos = $db->Execute("SELECT dp.* ,p.nombre ,u.nombre as unidad, p.precio_compra, p.idcategoria from detallepedido dp,producto p,unidad_medida u where p.idunidad_medida=u.idunidad_medida and dp.producto_id=p.idproducto and nro = '$nro' and sucursal_id= '$sucur'");
$total1 = 0;$total2 = 0;
$nroo=$db->GetOne("select max(nro)as nro from pedido where sucursal_id='$sucur'");

foreach($traspasos as $reg){
if($reg['idcategoria']!=2){$total1 += $reg['subtotal'];}
else{$total2 += $reg['subtotal'];}
}
if($nroo==$nro){
    print "<script>alert(\"Registrado.\");window.location='nuevo.php';</script>";
}else{
$insertar = $db->Execute("insert into pedido(nro,hora_solicitud,fecha_p, fecha_a_entregar,fecha_e,total,total2,total_envio,estado,usuario_id,sucursal_id,sucursal_idsucursal,inventario_id,inventario_idinventario, estado_impresion)
VALUE ('$nro','$hora','$date','$fecha_a_entregar','','$total1','$total2',0,'no','$usuario[idusuario]','$sucur',1,0,0,0)");
if($insertar != null){
print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
}
else{
print "<script>alert(\"No se puedo Guardar.\");window.location='nuevo.php';</script>";
}
    }
?>