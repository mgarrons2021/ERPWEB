<?php
require_once '../data/fpdf/fpdf.php';
require('WriteHTML.php');
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
$d_s=$db->GetRow("select * from sucursal where idsucursal='$sucur'");
$sql3=$db->GetRow("select * from venta where sucursal_id='$sucur' and idturno='$idturno' and nro='$nro'");
$sql4=$db->GetOne("select lugar from venta where sucursal_id='$sucur' and idturno='$idturno' and nro='$nro'");
$cliente=$db->getRow("select * from cliente where idcliente='$sql3[cliente_id]'");
$d_e=$db->GetRow("select * from datos_empresa");
//$textqr=$_POST['textqr'];//Recibo la variable pasada por post
//$sizeqr=$_POST['sizeqr'];//Recibo la variable pasada por post
include('vendor/autoload.php');//Llamare el autoload de la clase que genera el QR
use Endroid\QrCode\QrCode;
$qrCode = new QrCode($d_e['autorizacion']);//Creo una nueva instancia de la clase
$qrCode->setSize(100);//Establece el tama単o del qr
//header('Content-Type: '.$qrCode->getContentType());
$image= $qrCode->writeString();//Salida en formato de texto 
$imageData = base64_encode($image);//Codifico la imagen usando base64_encode
//echo '<img src="data:image/png;base64,'.$imageData.'">';
$pdf->addpage();
$pdf->setFont('Arial','',10);
$pdf->Cell(30,0,'               '.$d_e['nombre'],0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'           '.$d_s['nombre'],0,0);
$pdf->Ln(4);
$pdf->setFont('Arial','',8);
$pdf->Cell(30,0,'                    '.'Celular: '.$d_e['celular'],0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'      '.$d_s['direccion'],0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'                     Santa Cruz-Bolivia',0,0);
$pdf->Ln(4);
$pdf->setFont('Arial','B',12);
$pdf->Cell(30,0,'CUENTA',0,0);
$pdf->Ln(4);
$pdf->setFont('Arial','',10);
$pdf->Cell(30,0,'Nit: '.$d_e['nit'],0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'CUENTA: '.$nro,0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'AUTORIZACION: '.$d_e['autorizacion'],0,0);
$pdf->Ln(6);
$pdf->Cell(30,0,'Actividad Economica: RESTAURANTES',0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'Fecha: '.$sql1,0,0);
$pdf->Ln(4);
$pdf->setFont('Arial','',10);
$pdf->Cell(30,0,'Hora: '.$sql3['hora'],0,0);
$pdf->Ln(4);
$pdf->Cell(13,0,'Cliente: ',0,0);
if($cliente['nombre']=="0"){$pdf->Cell(10,0,''.'Sin Nombre',0,0);}
else{$pdf->Cell(10,0,''.$cliente['nombre'],0,0);}
$pdf->Ln(4);
$pdf->Cell(11,0,'Nit/Ci: ',0,0);
if($cliente['nit_ci']=="0"){$pdf->Cell(10,0,''.'Sin Nit/Ci',0,0);}
else{$pdf->Cell(10,0,''.$cliente['nit_ci'],0,0);}
$pdf->Ln(4);
$pdf->setFont('Arial','B',12);
$pdf->Cell(30,0,'Orden: '.$nro,0,0);
$pdf->Ln(4);
$pdf->setFont('arial','B',10);
$pdf->Cell(10,0,'Cant',0);
$pdf->Cell(30,0,'Concepto',0);
$pdf->Cell(45,0,'Subtotal',0);
$pdf->Ln(4);
$pdf->setFont('arial','',10);
$total=0;
    foreach ($sql as $s2){
    $pdf->Cell(10,0,''.number_format($s2['cantidad'],2),0);
    $pdf->Cell(30,0,''.$s2['plato'],0);
    $pdf->Cell(45,0,''.number_format($s2['subtotal'],2).' bs',0);
    $total=$total+$s2['subtotal'];
    $pdf->Ln(5);
}
$pdf->Cell(40,0,'Total: ',0);
$pdf->Cell(10,0,''.number_format($total,2).' bs',0);
$formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
$pdf->Ln(5);
$pdf->Cell(30,0,'Son Bs.  '.$formatterES->format($total),0,0);
$pdf->Ln(4);
$pdf->setFont('Arial','',8);
$pdf->Cell(30,0,'No valido para credito fiscal',0,0);
$pdf->Ln(28);
//$pdf->WriteHTML('<h1>hola</h1>');
//$pdf->Cell(30,0,echo '<img src="data:image/png;base64,'.$imageData.'">',0,0);
//$pdf->Image("'data:image/png;base64,'.$imageData.'",80,22,35, 38,'png','');
//$pdf->Image("data:image/png;base64,'.$imageData.'",60,30,90,0,'PNG');
//$pdf->Image('leon.jpg' , 80 ,22, 35 , 38,'png','http://www.desarrolloweb.com');
//$pdf->Image("data:image/png;base64,'.$imageData.'",10,5,30,30,"png");
$pdf->Image("../images/qr.png",10,98,25,25,'png');
$pdf->Ln(4);
$pdf->setFont('Arial','',8);
$pdf->Cell(30,0,'Ley No. 453. El proveedor de servicios',0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'debe habilitar medios e instrumentos para',0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'efectural consultas',0,0);
//echo '<img src="data:image/png;base64,'.$imageData.'">';
$pdf->Output();
 ?>