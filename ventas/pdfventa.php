<?php 
require_once '../data/fpdf/fpdf.php';
require_once '../config/conexion.inc.php';
$pdf = new fpdf();
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro = $_GET['nro'];
$idturno = $_GET['idturno'];
$sql = $db->GetAll("select p.idplato,v.hora, v.fecha,p.nombre as plato,dv.cantidad,p.precio_uni,dv.subtotal
from  venta v,detalleventa dv,plato p
where v.nro=dv.nro and dv.sucursal_id=v.sucursal_id and v.idturno='$idturno' and v.nro='$nro' and v.idturno=dv.idturno and p.idplato = dv.plato_id and dv.sucursal_id='$sucur'");
$sql1=$db->GetOne("select date_format(fecha,'%d-%m-%Y') as fecha from venta where sucursal_id='$sucur' and idturno='$idturno' and nro='$nro'");
$sql2=$db->GetOne("select nombre from sucursal where idsucursal='$sucur'");
$sql3=$db->GetOne("select hora from venta where sucursal_id='$sucur' and idturno='$idturno' and nro='$nro'");
$sql4=$db->GetOne("select lugar from venta where sucursal_id='$sucur' and idturno='$idturno' and nro='$nro'");
$pdf->addpage();
$pdf->setFont('Arial','B',12);
//$pdf->Image('../images/logofactura.jpg',10,5,80,30,'jpg');
$pdf->Ln(3);
$pdf->Cell(45,0,'VENTA ',0,0);
$pdf->setFont('Arial','',12);
$pdf->Ln(5);
$pdf->setFont('Arial','',15);
$pdf->Cell(45,0,'Lugar: '.$sql4,0,0);
//$pdf->Ln(5);
//$pdf->Cell(0,0,'Nro # '.$nro ,0,0);
$pdf->Ln(5);
$pdf->setFont('Arial','',10);
$pdf->Cell(45,0,'Fecha: '.$sql1,0,0);
$pdf->Ln(5);
$pdf->setFont('Arial','',10);
$pdf->Cell(45,0,'Hora: '.$sql3,0,0);
$pdf->Ln(5);
$pdf->Cell(45,0,'SUCURSAL:',0,0);

$pdf->Ln(5);
$pdf->setFont('Arial','B',10);
$pdf->Cell(45,0,''.$sql2,0,0);
$pdf->Ln(5);
$pdf->setFont('Arial','B',10);
$pdf->Cell(45,0,'Orden: '.$nro,0,0);

$pdf->Ln(5);
$pdf->setFont('arial','B',10);
$pdf->Cell(20,0,'Cant',0);
$pdf->Cell(35,0,'Descripcion',0);

$pdf->Ln(5);
$pdf->setFont('arial','',10);
$total=0;
foreach ($sql as $s2){
//$pdf->Cell(28,0,''.$s2['cod'],0);
$pdf->Cell(20,0,''.number_format($s2['cantidad'],2),0);
$pdf->Cell(35,0,''.$s2['plato'],0);

//$pdf->Cell(30,0,''.$s2['precio_compra'],0);
//$pdf->Cell(30,0,''.$s2['precio_venta'],0);
//$pdf->Cell(30,0,''.$s2['subtotal'],0);	
$total=$total+$s2['subtotal'];
$pdf->Ln(5);# code...
}
$pdf->Cell(35,0,'Total: ',0);
$pdf->Cell(10,0,''.$total.' bs',0);
//$pdf->Ln(5);
//$pdf->Cell(0,0,'TOTAL A PAGAR:'.$sql['total_envio'],0);                                           
$pdf->Output();
# c</dode...
// datos de venta
 ?>