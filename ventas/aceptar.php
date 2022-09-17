<?php
include"../menu/menu_venta.php";
require_once '../data/fpdf/fpdf.php';
require_once '../config/conexion.inc.php';
//date_default_timezone_set('America/La_Paz');
session_start();
/*function SumaHoras( $hora, $minutos_sumar ) 
{
   $minutoAnadir=$minutos_sumar;
   $segundos_horaInicial=strtotime($hora);
   $segundos_minutoAnadir=$minutoAnadir*60;
   $nuevaHora=date("H:i:s",$segundos_horaInicial+$segundos_minutoAnadir);
   return $nuevaHora;
}*/
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$hora=date('H:i:s');

//$minutos_sumarle  = 1;
//EJECUTO LA FUNCIÓN y asigno resultado a una variable
//$resultado = SumaHoras( $hora , $minutos_sumarle );
$date = date('Y-m-d');
//$hora = strtotime ( '+30 second' ,$hora) ;
//$hora->modify('+30 second'); 
//$hora = strtotime ( '+30 hour' , strtotime ($hora) ) ;
$nro=$_POST['nro'];
$cliente=$_POST['cliente'];
$nit=$_POST['nit'];
$celular=$_POST['celular'];
$fecha=$_POST['fecha'];
$lugar=$_POST['lugar'];
$pago=$_POST['pago'];
$turno=$_POST['turno'];
$idturno=$_POST['idturno'];
$total=$_POST['total'];
$inventario=$db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sucur);
/////////ultimo numero de autorizacion
$idautorizacion=$db->GetOne("SELECT max(idautorizacion)as idautorizacion FROM auntorizacion  WHERE sucursal_id=$sucur and estado='si'");
$n_factura=$db->GetOne("SELECT n_factura FROM auntorizacion WHERE sucursal_id=$sucur and estado='si' and idautorizacion=$idautorizacion")+1;
$nit_empresa=$db->GetOne("SELECT nit_suc FROM auntorizacion WHERE sucursal_id=$sucur and estado='si' and idautorizacion=$idautorizacion");
//$nro_autorizacion=$db->GetOne("SELECT autorizacion_id FROM auntorizacion WHERE sucursal_id=$sucur and estado='si' and idautorizacion=$idautorizacion");
/*/$fech_fin_auto=$db->GetOne("SELECT fech_fin FROM auntorizacion WHERE idautorizacion=$idautorizacion");
/*if($n_factura==0){
     $n_f=1;
}else{
     $n_f=$db->GetOne("SELECT max(nro_factura)as nro_factura FROM venta WHERE sucursal_id=$sucur")+1;
}*/
/////////insertar cliente o editar cliente
$query=$db->GetAll("SELECT * FROM cliente WHERE nit_ci LIKE '$nit'");
if($query==null ||$query==""){
  $sql2=$db->Execute("insert into cliente(nit_ci,nombre,celular,fecha,hubicacion,sucursal_id)value('$nit','$cliente','$celular','$fecha','','$sucur')");
  }else{
    $sql2 = $db->Execute("update cliente set nombre=$cliente, celular=$celular,fecha=$fecha where nit_ci=$nit");
  }
$idcliente=$db->GetRow("select * from cliente where nit_ci=$nit");
$idc=$idcliente["idcliente"];
//////////////////// fin de cliente
//////////////// modificar cantidades y subtotales de detalle venta
for($i=0; $i <=count($_POST['cantidad'])-1 ; $i++){
  $subtotal=0;
  $id=$_POST['iddetalleventa'][$i];
  $precio=$_POST['precio'][$i];
  $cantidad=$_POST['cantidad'][$i];
  $subtotal=$_POST['subtotal'][$i];
 // $total=$total+$subtotal;
$sql1 = $db->Execute("update detalleventa set cantidad='$cantidad', subtotal='$subtotal'  where iddetalleventa='$id'");
}//fin de detalle venta
/*$total=number_format($total,1);
$cadena=(string)$total;
$string_decimal=substr($cadena,-1);
$entero_decimal=intval($string_decimal);
if($entero_decimal>=6){$total=number_format($total);}else{$total=substr($cadena,0,-2).".5";}*/
//////generar codigo de control 
$aut=$db->GetRow("SELECT * FROM auntorizacion WHERE sucursal_id=$sucur and estado='si' and idautorizacion=$idautorizacion");
require("../librerias/codigo_control/CodigoControl.php");
$codigoControl="";
    $authorizationNumber=$aut['n_auto'];
    $invoiceNumber=$n_factura;
    $nitci=$nit;
    $dateOfTransaction=$date; //20210409
    $transactionAmount=$total; //0.76 = 1
    $dosageKey=$aut['llave'];
    $fecha_compra = str_replace("-", "", $dateOfTransaction);
    $monto_compra = round($transactionAmount);
    $codigoControl = CodigoControl::generar($authorizationNumber, $invoiceNumber, $nitci, str_replace("-", "", strval($fecha_compra)), strval(round($monto_compra)), $dosageKey);
//////////fin codigo de control
////variable para codigo qr
$qr=$nit_empresa."|".$n_factura."|".$aut['n_auto']."|".$date."|".$total."|".$total."|".$codigoControl."|"."0"."|"."0"."|"."0"."|"."0"."|"."0";
/////insertar venta
////////////limpiar localstorage
print "<script>localStorage.clear();</script>";
/////////////
/////////verifica duplicacion 
$idventa=$db->GetOne("select max(idventa) from  venta where sucursal_id='$sucur'");
$nro1=$db->GetOne("select (nro) from  venta where idventa='$idventa'");
if ($nro != $nro1){
////////
$insertar = $db->Execute("insert into venta(nro_factura,nro,fecha,hora,total,lugar,pago,turno,idturno,estado,cod_control,cliente_id,usuario_id,sucursal_id,inventario_id,autorizacion_id,qr)
VALUE ('$n_factura','$nro','$date','$hora','$total','$lugar','$pago','$turno','$idturno','V','$codigoControl','$idc','$usuario[idusuario]','$sucur','$inventario','$idautorizacion','$qr')");
}
$nroo=$db->Execute("update auntorizacion set n_factura=$n_factura where idautorizacion=$idautorizacion");
if($insertar == null){
  print "<script>alert(\"No se pudo realizar la venta.\");window.location='nuevo.php';</script>";
}
/////////fin de insercion
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container">
<div class="jumbotron">
  <h2 class="display-3">Venta Registrado Exitosamente</h2>
  <hr class="m-y-2">
  <p></p>
  <p class="lead">
  <?php
   echo "<a class='btn btn-primary btn-lg' href='pdfventa.php?idturno=$idturno&nro=$nro' target='_blank' role='button'>Imprimir a PDF</a>";
   echo " ";
   echo "<a class='btn btn-primary btn-lg' href='nuevo.php' role='button'>Nueva venta</a>";
   echo " ";
   echo "<a class='btn btn-primary btn-lg' href='pdffactura.php?idturno=$idturno&nro=$nro' target='_blank' role='button'>Imprimir Factura</a>";
   ?>
  </p>
</div>
</div>
</body>
</html>