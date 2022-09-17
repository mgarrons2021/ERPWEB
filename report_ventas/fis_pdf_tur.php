<?php 
require_once '../data/fpdf/fpdf.php';
require_once '../config/conexion.inc.php';
$pdf = new fpdf();
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$id=$usuario['idusuario'];
$min = $_GET['min'];
$max = $_GET['max'];
$suc = $_GET['suc'];
//$total_cierre= $_POST['total_cierre'];
//$actualizar= $db->Execute("update turno set estado='no' where idturno='$idturno'");///
$sql = $db->GetAll("SELECT t.nro as turno, v.nro as transaccion, v.total , sum(dv.cantidad) cantidad , p.nombre as plato, p.precio_uni,sum(p.precio_uni*dv.cantidad)as subtotal
FROM turno t,venta v, detalleventa dv, plato p
WHERE  t.idturno='$idturno' and v.estado='V' and t.nro='$nro' and v.idturno=t.idturno and t.nro=v.turno and dv.nro=v.nro and dv.idturno=v.idturno and p.idplato=dv.plato_id GROUP by p.idplato");
$sql1=$db->GetRow("select * from turno where sucursal_id='$sucur' and idturno='$idturno' and nro='$nro'");
$sql2=$db->GetOne("select nombre from sucursal where idsucursal='$suc'");
$sql4=$db->GetOne("select nombre from usuario where idusuario ='$id'");
$categoria=$db->GetAll("SELECT v.nro_factura as turno, v.nro as transaccion, v.total , sum(dv.cantidad) cantidad , p.categoria, p.precio_uni,sum(dv.subtotal)as subtotal FROM venta v, detalleventa dv, plato p WHERE v.nro_factura!='0' and v.sucursal_id='$suc' and v.estado='V' and dv.nro=v.nro and dv.idturno=v.idturno and p.idplato=dv.plato_id and v.fecha between '$min' and '$max' GROUP by p.categoria");

$min2=date("Y-m-d",strtotime($min."-1 days"));
$max2=date("Y-m-d",strtotime($max."-1 days"));
$fac_min=$db->GetOne("select max(nro_factura+1)as minimo from venta where sucursal_id='$suc' and fecha between '$min2' and '$max2'");
if($fac_min==1){
 $min3=date("Y-m-d",strtotime($min."-2 days"));
$max3=date("Y-m-d",strtotime($max."-2 days"));   
    $fac_min=$db->GetOne("select max(nro_factura+1)as minimo from venta where sucursal_id='$suc' and fecha between '$min3' and '$max3'");
   if($fac_min==1){
    $min4=date("Y-m-d",strtotime($min."-3 days"));
$max4=date("Y-m-d",strtotime($max."-3 days"));   
    $fac_min=$db->GetOne("select max(nro_factura+1)as minimo from venta where sucursal_id='$suc' and fecha between '$min4' and '$max4'");   
   } 
}
    

$fac_max=$db->GetOne("select max(nro_factura)as max from venta where sucursal_id='$suc' and fecha between '$min' and '$max'");
if($fac_max==0){$fac_min=0;}
$s3=$db->GetRow("SELECT t.nro as turno, v.nro as transaccion,sum(v.total)as total
FROM turno t,venta v
WHERE v.lugar='DELIVERY' and  t.idturno='$idturno' and v.idturno=t.idturno and v.estado='V'");
$categoria2 = $db->GetAll("SELECT t.nro as turno, v.nro as transaccion, v.total ,dv.cantidad , p.categoria, p.precio_uni,sum(dv.subtotal)as subtotal
FROM turno t,venta v, detalleventa dv, plato p
WHERE  t.idturno='$idturno' and v.estado='V' and t.nro='$nro' and v.idturno=t.idturno and t.nro=v.turno and dv.nro=v.nro and dv.idturno=v.idturno and p.idplato=dv.plato_id");
$sql3=$db->GetOne("select count(nro) from venta where pago!='credito' and estado='V' and sucursal_id='$suc' and v.fecha between '$min' and '$max'");
$total_turno = $db->GetOne("SELECT sum(v.total)as total
FROM venta v
WHERE  v.idturno='$idturno' and v.estado='V'");
$pdf->addpage();
$pdf->setFont('Arial','B',12);
$pdf->Ln(3);
$pdf->Cell(45,0,'REPORTE CIERRE',0,0);
//$pdf->setFont('Arial','',12);
//$pdf->Ln(5);
$pdf->setFont('Arial','',10);
//$pdf->Cell(25,0,'T.T.: '.$sql3,0,0);
//$pdf->Cell(25,0,'T.P.: '.number_format(($total_turno/$sql3),2),0,0);
$pdf->Ln(5);
$pdf->setFont('Arial','',10);
$pdf->Cell(45,0,'Fecha inicial: '.$min,0,0);
$pdf->Ln(5);
$pdf->Cell(45,0,'Fecha Final: '.$max,0,0);
//$pdf->Ln(5);
//$pdf->setFont('Arial','',10);
//$pdf->Cell(30,0,'Hr. Inicio: '.$sql1['hora_ini'],0,0);
//$pdf->Cell(30,0,'Hr. Cierre: '.$sql1['hora_fin'],0,0);
//$pdf->Ln(5);
//$pdf->Cell(15,0,'Usuario:',0,0);
//$pdf->Ln(5);
//$pdf->Cell(15,0,''.$sql4,0,0);
$pdf->Ln(5);
$pdf->Cell(20,0,'Sucursal:',0,0);
$pdf->Ln(5);
$pdf->setFont('Arial','B',15);
$pdf->Cell(10,0,''.$sql2,0,0);
$pdf->Ln(5);
//$pdf->setFont('Arial','B',10);
//if($sql1['nro']=="1"){
//$pdf->Cell(45,0,'TURNO: '.AM,0,0);
//}else{
 //   $pdf->Cell(45,0,'TURNO: '.PM,0,0);
//}
/*
$pdf->Ln(5);
$pdf->setFont('arial','B',10);
$pdf->Cell(15,0,'Cant',0);
$pdf->Cell(30,0,'Descripcion',0);
$pdf->Cell(45,0,'Subtotal',0);
$pdf->Ln(5);
$pdf->setFont('arial','',10);
$total1=0;
foreach ($sql as $s2){
$pdf->Cell(15,0,''.number_format($s2['cantidad'],2),0);
$pdf->Cell(35,0,''.$s2['plato'],0);
$pdf->Cell(30,0,''.number_format($s2['subtotal'],2),0);	
$pdf->Ln(5);
}
$pdf->Cell(35,0,'Total: ',0);
$pdf->Cell(10,0,''.number_format($total_turno,2).' bs',0);
$pdf->Ln(5);
*/
$pdf->setFont('Arial','B',10);
$pdf->Cell(15,0,'POR CATEGORIA',0);
$pdf->Ln(5);
$pdf->setFont('Arial','B',15);
$pdf->setFont('arial','B',10);
$pdf->Cell(15,0,'Cant',0);
$pdf->Cell(30,0,'Descripcion',0);
$pdf->Cell(45,0,'Subtotal',0);
$pdf->Ln(5);
$pdf->setFont('arial','',10);
$total2=0;

foreach ($categoria as $s2){if($s2['nro_factura']>=0){
$pdf->Cell(15,0,''.number_format($s2['cantidad'],2),0);
$pdf->Cell(35,0,''.$s2['categoria'],0);
$pdf->Cell(30,0,''.number_format($s2['subtotal'],2),0);	
$pdf->Ln(5);
$total2=$total2+$s2['subtotal'];
}}/*
$pdf->Cell(15,0,''.number_format(0,2),0);
$pdf->Cell(35,0,''.'Delivery',0);
$pdf->Cell(30,0,''.number_format($s3['total'],2),0);*/	
//$pdf->Ln(5);
$pdf->Cell(35,0,'Total Venta: ',0);
$pdf->Cell(10,0,''.number_format($total2,2).' bs',0);
$pdf->Ln(5);
$pdf->Cell(45,0,'Factura Inicial: '.$fac_min,0,0);
$pdf->Ln(5);
$pdf->Cell(45,0,'Factura Final: '.$fac_max,0,0);
///$pdf->AutoPrint(true);
$pdf->Output();
 ?>