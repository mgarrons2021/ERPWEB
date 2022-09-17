<?php
require_once '../config/conexion.inc.php';
date_default_timezone_set('America/La_Paz');
echo'<pre>';
$idpe=$_POST["idp"];
$date = date('Y-m-d');
echo "este es la nueva fecha: ".$date;
$ide = $db->GetRow("select * from pedido where idpedido=$idpe");
$inventario1=$db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$ide['sucursal_id']);
$inventario2=$db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=1");
$total=0;
for($i=0; $i <=count($_POST['p_compra'])-1 ;$i++){
  $p_compra=$_POST['p_compra'][$i];
  $cantidad=$_POST['cantidad'][$i];
  $id=$_POST['iddetallepedido'][$i];
  $estado=$_POST['estado'][$i];
  $subtotal=$p_compra*$cantidad;
  $total=$total+$subtotal;
$sql1 = $db->Execute("update detallepedido set cantidad_envio=$cantidad, subtotal_envio=$subtotal, estado=$estado where iddetallepedido=$id");
}
$total2=0;
for($i=0; $i <=count($_POST['p_compra2'])-1; $i++){
  $p_compra=$_POST['p_compra2'][$i];
  $cantidad=$_POST['cantidad2'][$i];
  $id=$_POST['iddetallepedido2'][$i];
  $estado2=$_POST['estado2'][$i];
  $subtotal=$p_compra*$cantidad;
  $total2=$total2+$subtotal;
$sql1 = $db->Execute("update detallepedido set cantidad_envio=$cantidad, subtotal_envio=$subtotal, estado=$estado2  where iddetallepedido=$id");
}

$sql2 = $db->Execute("update pedido set total_envio=$total,total_envio2=$total2,fecha_e=concat('$date'),inventario_id=$inventario1,inventario_idinventario=$inventario2 where idpedido=$idpe");
$esto= $db->GetOne("select estado from pedido where idpedido=$idpe");
if($esto!=="si"){
$sql3 = $db->Execute("update pedido set estado='ok' where idpedido=$idpe");
}
if ($sql1=!null && $sql2=!null && $sql3=!null){
print "<script>alert(\"Se envio Exitosamente.\");window.location='index.php';</script>";
}
else{
print "<script>alert(\"No se pudo Realizar los envios.\");window.location='index.php';</script>";
}
?>