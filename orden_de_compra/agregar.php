<?php
require_once '../config/conexion.inc.php';
session_start();
$date = date('Y-m-d'); 
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nv='1'; 
$nro=$_POST['nro']; 
$idprovedor=$_POST['idproveedor'];

$total_compra = $db->GetOne("select sum(subtotal) from detalle_orden_de_compa
							 where nro = '$nro' and sucursal_id='$sucur'");
							 
	if($idprovedor=="")	{
		print "<script>alert(\"Seleccione proveedor.\");window.location='nuevo.php';</script>";
	}
	else{
$insertar = $db->Execute("insert into orden_de_compra(nro,total,fecha_o,usuario_id,sucursal_id,proveedor_id)
VALUE ('$nro','$total_compra','$date','$usuario[idusuario]','$usuario[sucursal_id]','$idprovedor')");
                          
if($insertar != null) {
print "<script>alert(\"Agregado exitosamente.\");window.location='nuevo.php';</script>";
$db->Execute("update detalle_orden_de_compa set estado = 'si' where nro = '$nro'");
}
else{
print "<script>alert(\"No se puedo Guardar.\");window.location='nuevo.php';</script>";

}
}


?>