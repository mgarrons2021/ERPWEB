<?php 
require_once '../data/fpdf/fpdf.php';
require_once '../config/conexion.inc.php';
$pdf = new fpdf();
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$_GET['sucur'];
$id=$usuario['idusuario'];
$nro = $_GET['nro'];
$idturno = $_GET['idturno'];
//$total_cierre= $_POST['total_cierre'];
//$actualizar= $db->Execute("update turno set estado='no' where idturno='$idturno'");///
$sql = $db->GetAll("SELECT t.nro as turno, v.nro as transaccion, v.total , sum(dv.cantidad) cantidad , p.nombre as plato, p.precio_uni,sum(p.precio_uni*dv.cantidad)as subtotal
FROM turno t,venta v, detalleventa dv, plato p
WHERE  t.idturno='$idturno' and v.estado='V' and t.nro='$nro' and v.idturno=t.idturno and t.nro=v.turno and dv.nro=v.nro and dv.idturno=v.idturno and p.idplato=dv.plato_id GROUP by p.idplato");
$sql1=$db->GetRow("select * from turno where sucursal_id='$sucur' and idturno='$idturno' and nro='$nro'");
$sql2=$db->GetOne("select nombre from sucursal where idsucursal='$sucur'");
$sql4=$db->GetOne("select nombre from usuario where idusuario ='$id'");
$categoria=$db->GetAll("SELECT t.nro as turno, v.nro as transaccion, v.total , sum(dv.cantidad) cantidad , p.categoria, p.precio_uni,sum(dv.subtotal)as subtotal
FROM turno t,venta v, detalleventa dv, plato p
WHERE v.lugar!='DELIVERY' and t.idturno='$idturno'and v.estado='V' and t.nro='$nro' and v.idturno=t.idturno and t.nro=v.turno and dv.nro=v.nro and dv.idturno=v.idturno and p.idplato=dv.plato_id GROUP by p.categoria");
$s3=$db->GetRow("SELECT t.nro as turno, v.nro as transaccion,sum(v.total)as total
FROM turno t,venta v
WHERE v.lugar='DELIVERY' and  t.idturno='$idturno' and v.idturno=t.idturno and v.estado='V'");
$categoria2 = $db->GetAll("SELECT t.nro as turno, v.nro as transaccion, v.total ,dv.cantidad , p.categoria, p.precio_uni,sum(dv.subtotal)as subtotal
FROM turno t,venta v, detalleventa dv, plato p
WHERE  t.idturno='$idturno' and v.estado='V' and t.nro='$nro' and v.idturno=t.idturno and t.nro=v.turno and dv.nro=v.nro and dv.idturno=v.idturno and p.idplato=dv.plato_id");
$sql3=$db->GetOne("select count(nro) from venta where pago!='credito' and estado='V' and idturno='$idturno' and turno='$nro'");
$total_turno = $db->GetOne("SELECT sum(v.total)as total
FROM venta v
WHERE  v.idturno='$idturno' and v.estado='V'");
$pdf->addpage();
$pdf->setFont('Arial','B',12);
$pdf->Ln(3);
$pdf->Cell(45,0,'REPORTE CIERRE',0,0);
$pdf->setFont('Arial','',12);
$pdf->Ln(5);
$pdf->setFont('Arial','',10);
$pdf->Cell(25,0,'T.T.: '.$sql3,0,0);
$pdf->Cell(25,0,'T.P.: '.number_format(($total_turno/$sql3),2),0,0);
$pdf->Ln(5);
$pdf->setFont('Arial','',10);
$pdf->Cell(45,0,'Fecha: '.$sql1['fecha'],0,0);
$pdf->Ln(5);
$pdf->setFont('Arial','',10);
$pdf->Cell(30,0,'Hr. Inicio: '.$sql1['hora_ini'],0,0);
$pdf->Cell(30,0,'Hr. Cierre: '.$sql1['hora_fin'],0,0);
$pdf->Ln(5);
$pdf->Cell(15,0,'Usuario:',0,0);
$pdf->Ln(5);
$pdf->Cell(15,0,''.$sql4,0,0);
$pdf->Ln(5);
$pdf->Cell(20,0,'Sucursal:',0,0);
$pdf->Ln(5);
$pdf->setFont('Arial','B',15);
$pdf->Cell(10,0,''.$sql2,0,0);
$pdf->Ln(5);
$pdf->setFont('Arial','B',10);
if($sql1['nro']=="1"){
$pdf->Cell(45,0,'TURNO: '.AM,0,0);
}else{
    $pdf->Cell(45,0,'TURNO: '.PM,0,0);
}
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

foreach ($categoria as $s2){

$pdf->Cell(15,0,''.number_format($s2['cantidad'],2),0);
$pdf->Cell(35,0,''.$s2['categoria'],0);
$pdf->Cell(30,0,''.number_format($s2['subtotal'],2),0);	
$pdf->Ln(5);

}
$pdf->Cell(15,0,''.number_format(0,2),0);
$pdf->Cell(35,0,''.'Delivery',0);
$pdf->Cell(30,0,''.number_format($s3['total'],2),0);	
$pdf->Ln(5);
$pdf->Cell(35,0,'Total: ',0);
$pdf->Cell(10,0,''.number_format($total_turno,2).' bs',0);
///$pdf->AutoPrint(true);
$pdf->Output();
 ?>