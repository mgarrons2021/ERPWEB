<?php
require_once '../data/fpdf/fpdf.php';
require('WriteHTML.php');
require_once '../config/conexion.inc.php';
require ('phpqrcode/qrlib.php');
$pdf = new fpdf();
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro = $_GET['nro'];
$idturno = $_GET['idturno'];
$sql = $db->GetAll("select dv.*,p.idplato,v.hora, v.fecha,p.nombre as plato,dv.cantidad,p.precio_uni,dv.subtotal
from  venta v,detalleventa dv,plato p
where v.nro=dv.nro and dv.sucursal_id=v.sucursal_id and v.idturno='$idturno' and v.nro='$nro' and v.idturno=dv.idturno and p.idplato = dv.plato_id and dv.sucursal_id='$sucur'");
$sql1=$db->GetOne("select date_format(fecha,'%d/%m/%Y') as fecha from venta where sucursal_id='$sucur' and idturno='$idturno' and nro='$nro'");
$d_s=$db->GetRow("select * from sucursal where idsucursal='$sucur'");
$sql3=$db->GetRow("select * from venta where sucursal_id='$sucur' and idturno='$idturno' and nro='$nro'");
$sql4=$db->GetOne("select lugar from venta where sucursal_id='$sucur' and idturno='$idturno' and nro='$nro'");
$cliente=$db->getRow("select * from cliente where idcliente='$sql3[cliente_id]'");
$d_e=$db->GetRow("select * from datos_empresa");
$idautorizacion=$db->GetOne("SELECT max(idautorizacion)as idautorizacion FROM auntorizacion  WHERE sucursal_id=$sucur and estado='si'");
$nro_auto=$db->GetOne("SELECT n_auto FROM auntorizacion WHERE sucursal_id=$sucur and estado='si' and idautorizacion=$sql3[autorizacion_id]");
$d_a=$db->GetRow("select fech_fin from auntorizacion where sucursal_id=$sucur and estado='si' and idautorizacion='$idautorizacion'");
/*$textqr=$_POST['textqr'];//Recibo la variable pasada por post
//$sizeqr=$_POST['sizeqr'];//Recibo la variable pasada por post
include('vendor/autoload.php');//Llamare el autoload de la clase que genera el QR
use Endroid\QrCode\QrCode;
$qrCode = new QrCode($d_e['autorizacion']);//Creo una nueva instancia de la clase
$qrCode->setSize(50);//Establece el tamano del qr
//header('Content-Type: '.$qrCode->getContentType());
$image= $qrCode->writeString();//Salida en formato de texto 
$imageData = base64_encode($image);//Codifico la imagen usando base64_encode
//echo '<img src="data:image/png;base64,'.$imageData.'">';*/
  $dir = 'temp/';
  //pregunatar si existe la carpeta dir y ! si no existe crear 
  if(!file_exists($dir))
		mkdir($dir);
  //variables 
  $cod = $sql3['qr']; //dato a generar qr
  $tam = 30; //tama単o de la imagen qr
  $niv = 5; //nivel de seguridad
  $filename = $dir.'test.png'; //archivo qr donde se guardara
  $frameSize = 3; // marco
  //clase Qr:: funcion png
         QRcode::png($cod,$filename, $niv, $tam, $frameSize);
//echo '<img src="'.$filename.'"align="left"/>';

$pdf->addpage();
$pdf->setFont('Arial','',10);
$pdf->Cell(50,0,''.$d_e['nombre'],0,0,"R");
$pdf->Ln(4);
$pdf->Cell(46,0,''.$d_s['nombre'],0,0,"R");
$pdf->Ln(4);
$pdf->setFont('Arial','',8);
$pdf->Cell(47,0,''.'Celular: '.$d_e['celular'],0,0,"R");
$pdf->Ln(4);
$pdf->Cell(60,0,''.$d_s['direccion'],0,0,"R");
$pdf->Ln(4);
$pdf->Cell(47,0,'Santa Cruz-Bolivia',0,0,"R");
$pdf->Ln(4);
$pdf->Cell(40,0,'SCF 1',0,0,"R");
$pdf->Ln(4);
$pdf->setFont('Arial','B',12);
$pdf->Cell(45,0,'CUENTA',0,0,"R");
$pdf->Ln(4);
$pdf->Ln(4);
$pdf->Cell(10,0,'-------------------------------------------------',0,0);//50 lineas
$pdf->Ln(4);
$pdf->setFont('Arial','',10);
$pdf->Cell(30,0,'NIT: '.$d_e['nit'],0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'CUENTA: '.$nro,0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'AUTORIZACION: '.$nro_auto,0,0);
$pdf->Ln(4);
$pdf->Cell(10,0,'-----------------------------------------------------------',0,0);//50 lineas
$pdf->Ln(4);
$pdf->Cell(30,0,'Actividad Economica: Restaurante',0,0);
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
$pdf->Cell(11,0,'NIT/CI:  ',0,0);
if($cliente['nit_ci']=="0"){$pdf->Cell(10,0,''.'0',0,0);}
else{$pdf->Cell(10,0,''.$cliente['nit_ci'],0,0);}
$pdf->Ln(4);
$pdf->Cell(10,0,'-----------------------------------------------------------',0,0);//50 lineas
$pdf->Ln(4);
$pdf->setFont('arial','B',10);
$pdf->Cell(10,0,'Cant',0);
$pdf->Cell(35,0,'Concepto',0);
$pdf->Cell(15,0,'P.Unit',0);
$pdf->Cell(20,0,'Total',0);
$pdf->Ln(4);
$pdf->setFont('arial','',10);
//$total=0;
$c=110;
    foreach ($sql as $s2){
    $c=$c+3;
    $pdf->Cell(10,0,''.number_format($s2['cantidad'],2),0);
    $pdf->Cell(35,0,''.utf8_decode($s2['plato']),0);
    $pdf->Cell(15,0,''.number_format($s2['precio'],2),0);
    $pdf->Cell(20,0,''.number_format($s2['subtotal'],2),0);
    //$pdf->Ln(5);
    //$pdf->Cell(10,0,'-----------------------------------------------------------',0,0);//60 lineas
    //$total=$total+$s2['subtotal'];
    $pdf->Ln(4);    
}
$pdf->Cell(10,0,'-----------------------------------------------------------',0,0);//60 lineas
$pdf->Ln(3);
$pdf->Cell(60,0,'Total Bs: ',0);
$total=number_format($sql3['total'],1);
$cadena=(string)$total;
$total=intval($total);
$ultimo=substr($cadena, -1);
if($ultimo==5){$decimal="50";}else{$decimal="00";}

$pdf->Cell(10,0,''.number_format($sql3['total'],2).'',0);
//$formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);//
$formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
$pdf->Ln(5);
$pdf->setFont('arial','',8);
$pdf->Cell(35,0,'Son Bs.  '.utf8_decode($formatterES->format($total).$float[1]).'   '.$decimal.'/100 Bolivianos');
$pdf->Ln(4);
$pdf->Cell(10,0,'-------------------------------------------------------------------------',0,0);//60 lineas
$pdf->Ln(4);
$pdf->setFont('Arial','',8);
//$pdf->Cell(30,0,'Codigo de control: '.$sql3['cod_control'],0,0);
$pdf->Cell(30,0,utf8_decode('No valido para crédito fiscal'),0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'Fecha limite de emision:'.$d_a['fech_fin'],0,0);
$pdf->Ln(30);
//$pdf->WriteHTML('<h1>hola</h1>');
//$pdf->Cell(30,0,echo '<img src="data:image/png;base64,'.$imageData.'">',0,0);
//$pdf->Image("'data:image/png;base64,'.$imageData.'",80,22,35, 38,'png','');
//$pdf->Image("data:image/png;base64,'.$imageData.'",60,30,90,0,'PNG');
//$pdf->Image('leon.jpg' , 80 ,22, 35 , 38,'png','http://www.desarrolloweb.com');
//$pdf->Image("data:image/png;base64,'.$imageData.'",10,5,30,30,"png");
$pdf->Image($filename,30,$c,25,25,'png');
$pdf->Ln(4);
$pdf->setFont('Arial','',8);
$pdf->Cell(30,0,'  Ley No. 453. El proveedor de servicios debe habilitar',0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'     medios e instrumentos para efectural consultas.',0,0);
$pdf->Ln(4);
$pdf->setFont('Arial','B',12);
$pdf->Cell(30,0,'Orden: '.$nro,0,0);
//echo '<img src="data:image/png;base64,'.$imageData.'">';
$pdf->Output();
 ?>