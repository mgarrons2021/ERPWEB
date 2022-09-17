<?php 
require_once '../data/fpdf/fpdf.php';
require_once '../config/conexion.inc.php';
$pdf = new fpdf();
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$_GET['sucur'];
$nro = $_GET['nro'];

$update = $db->Execute("UPDATE pedido SET estado_impresion = 1 WHERE sucursal_id='$sucur' AND nro='$nro'"); 

$sql = $db->GetAll("select p.hora_solicitud,pro.idproducto, p.fecha_p,pro.codigo_producto,pro.nombre as nombre,dp.cantidad,pro.precio_compra,dp.subtotal,u.nombre as umedida
from  pedido p,detallepedido dp,producto pro ,unidad_medida u
where p.nro=dp.nro and dp.sucursal_id=p.sucursal_id and dp.nro = '$nro' and pro.idunidad_medida=u.idunidad_medida and pro.idproducto = dp.producto_id and dp.sucursal_id='$sucur'");

$sql1=$db->GetOne("select date_format(fecha_P,'%d-%m-%Y') as fecha from pedido where sucursal_id='$sucur' and nro='$nro'");
$hora=$db->GetOne("select hora_solicitud from pedido where sucursal_id='$sucur' and nro='$nro'");
$sql2=$db->GetOne("select nombre from sucursal where idsucursal='$sucur'");
$pdf->addpage();
$pdf->setFont('Arial','B',12);
//$pdf->Image('../images/logofactura.jpg',10,5,80,30,'jpg');
$pdf->Ln(3);
$pdf->Cell(45,0,'LISTADO DE PEDIDOS ',0,0);
$pdf->setFont('Arial','',12);
//$pdf->Ln(5);
//$pdf->Cell(0,0,'Nro # '.$nro ,0,0);
$pdf->Ln(5);
$pdf->setFont('Arial','',9);
$pdf->Cell(28,0,'Fecha: '.$sql1,0,0);
$pdf->Cell(45,0,'Hora Solicitado: '.$hora,0,0);
$pdf->Ln(5);
$pdf->setFont('Arial','B',12);
$pdf->Cell(20,0,'Codigo:',0,0);
$pdf->Cell(28,0,$nro.'-'.$sucur,0,0);
$pdf->Ln(5);
$pdf->setFont('Arial','B',15);
$pdf->Cell(45,0,''.$sql2,0,0);
$pdf->Ln(5);
$pdf->setFont('Arial','B',10);
$pdf->Cell(0,0,'INSUMOS SOLICITADOS',0,0);
$pdf->Ln(5);
$pdf->setFont('arial','B',10);
$pdf->Cell(45,0,'Insumo',0);
$pdf->Cell(20,0,'Cantidad',0);
$pdf->Ln(5);
$pdf->setFont('Arial','',10);
$c = 0;
foreach ($sql as $s2){
/*	$c = $c+1;
if(strlen($s2['nombre'])>10){
$longitud=strlen($s2['nombre'])-10;
$pdf->Cell(40,0,''.substr($s2['nombre'],0,-6),0);
$pdf->Ln(5);
$pdf->Cell(40,0,''.substr($s2['nombre'],-$longitud).'.................',0);
}else{
$pdf->Cell(40,0,''.$s2['nombre'].'.................',0);
}*/
$pdf->Cell(50,0,''.substr(utf8_decode($s2['nombre']),0,20).'',0);
$pdf->Cell(11,0,''.number_format($s2['cantidad'],2),0);
$pdf->Cell(11,0,''.$s2['umedida'],0);
//$pdf->Cell(5,0,''.'O',0);	
$pdf->Ln(5);# code...
}
//$pdf->Ln(5);
//$pdf->Cell(0,0,'TOTAL A PAGAR:'.$sql['total_envio'],0);                                           
$pdf->Output();
# c</dode...
// datos de venta
 ?>