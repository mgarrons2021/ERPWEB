<?php
require_once '../config/conexion.inc.php';
$idd=$_GET['id'];
$c2=$_GET['c2'];
session_start();
$date = date('Y-m-d'); 
$nro=$_POST['nro'];
$usuario = $_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$sql=$db->GetRow("select * from detallepedido where iddetallepedido = $idd ");
$subtotal=$sql["precio_unitario"]*$c2;
$subtotal
if ($sql["estado"]=='no'){
  $insertar = $db->Execute("insert into detallepedido2(nro,catidad,precio_unitario,subtotal,estado,producto_id,sucursal_id)
	VALUE ('$nro','$c2','$sql[precio_unitario]',$subtotal,'si','$sql[producto_id]','$sucur')");
				$sql2 = $db->Execute("update detallepedido set estado='si' where iddetallepedido=$id");
                         }
    else{
		$sql = $db->Execute("update detallepedido set estado='no' where iddetallepedido=$id ");
		}
?>