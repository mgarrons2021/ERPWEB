<?php 
require('WriteHTML.php');
require('phpqrcode/qrlib.php');
require_once '../config/conexion.inc.php';
$pdf = new fpdf();
if(isset($_GET['nro']) && isset($_GET['idturno'])){
  session_start();
  $nro     = $_GET['nro'];
  $idturno = $_GET['idturno'];
  $usuario = $_SESSION['usuario'];
  $sucur   = $usuario['sucursal_id'];
}

$usuario = $_SESSION['usuario'];
$sucur   = $usuario['sucursal_id'];

$sql      = $db->GetAll("SELECT dv.*,p.idplato,v.hora, v.fecha,p.nombre AS plato,dv.cantidad,p.precio_uni,dv.subtotal
FROM  venta v,detalleventa dv,plato p
WHERE v.nro   = dv.nro 
AND v.estado != 'A'        AND dv.sucursal_id = v.sucursal_id 
AND v.idturno = '$idturno' AND v.nro ='$nro' 
AND v.idturno = dv.idturno AND p.idplato = dv.plato_id 
AND dv.sucursal_id = '$sucur'");

$sql1 = $db->GetOne("SELECT DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha FROM venta 
WHERE sucursal_id = '$sucur' 
AND idturno='$idturno' AND nro='$nro'");

$d_s = $db->GetRow("SELECT * FROM sucursal WHERE idsucursal= '$sucur'");

$sql3 = $db->GetRow("SELECT * FROM venta WHERE sucursal_id = '$sucur' AND idturno='$idturno' AND nro='$nro'");

$sql4 = $db->GetOne("SELECT lugar FROM venta WHERE sucursal_id = '$sucur' AND idturno='$idturno' AND nro='$nro'");

$cliente = $db->getRow("SELECT * FROM cliente WHERE idcliente= '$sql3[cliente_id]'");

$d_e = $db->GetRow("SELECT * FROM datos_empresa");

$idautorizacion = $db->GetOne("SELECT max(idautorizacion) AS idautorizacion FROM auntorizacion  WHERE sucursal_id = $sucur AND estado='si'");

$nro_auto = $db->GetOne("SELECT n_auto FROM auntorizacion WHERE sucursal_id = $sucur AND estado='si' AND idautorizacion = $sql3[autorizacion_id]");

$d_a = $db->GetRow("SELECT fech_fin FROM auntorizacion WHERE sucursal_id = $sucur AND estado ='si' AND idautorizacion ='$idautorizacion'");

$filename = '';
$dir = 'temp/';
//pregunatar si existe la carpeta dir y ! si no existe crear 
if (!file_exists($dir)) {
  mkdir($dir);
  //variables 
  $cod = $sql3['qr']; //dato a generar qr
  $tam = 30; //tamaño de la imagen qr
  $niv = 5; //nivel de seguridad
  $filename = $dir . 'test.png'; //archivo qr donde se guardara
  $frameSize = 3; // marco
  //clase Qr:: funcion png
  QRcode::png($cod, $filename, $niv, $tam, $frameSize);
}else{
  $cod = $sql3['qr']; //dato a generar qr
  $tam = 30; //tamaño de la imagen qr
  $niv = 5; //nivel de seguridad
  $filename = $dir . 'test.png'; //archivo qr donde se guardara
  $frameSize = 3; // marco
  //clase Qr:: funcion png
  QRcode::png($cod, $filename, $niv, $tam, $frameSize);
}

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
$pdf->Cell(58,0,'FACTURA ORIGINAL',0,0,"R");
$pdf->Ln(4);
$pdf->Ln(4);
$pdf->Cell(10,0,'---------------------------------------------------',0,0);//52 lineas
$pdf->Ln(4);
$pdf->setFont('Arial','',10);
$pdf->Cell(30,0,'NIT: '.$d_e['nit'],0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'FACTURA: '.$sql3['nro_factura'],0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'AUTORIZACION: '.$nro_auto,0,0);
$pdf->Ln(4);
$pdf->Cell(10,0,'-------------------------------------------------------------',0,0);//52 lineas
$pdf->Ln(4);
$pdf->Cell(30,0,'Actividad Economica: Restaurante',0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'Fecha: '.$sql1,0,0);
$pdf->Ln(4);
$pdf->setFont('Arial','',10);
$pdf->Cell(30,0,'Hora: '.$sql3['hora'],0,0);
$pdf->Ln(4);
$pdf->Cell(13,0,'Cliente: ',0,0);
if($cliente['nit_ci']=="0"){
  $pdf->Cell(10,0,''.'Sin Nombre',0,0);
}
else{
  $pdf->Cell(10,0,''.utf8_decode($cliente['nombre']),0,0);
}
$pdf->Ln(4);
$pdf->Cell(11,0,'NIT/CI:  ',0,0);
if($cliente['nit_ci']=="0"){
  $pdf->Cell(10,0,''.'0',0,0);
}
else{
  $pdf->Cell(10,0,''.$cliente['nit_ci'],0,0);
}
$pdf->Ln(4);
$pdf->Cell(10,0,'-------------------------------------------------------------',0,0);//52 lineas
$pdf->Ln(4);
$pdf->setFont('arial','B',10);
$pdf->Cell(10,0,'Cant',0);
$pdf->Cell(42,0,'Concepto',0);
$pdf->Cell(12,0,'P.Unit',0);
$pdf->Cell(10,0,'Total',0);
$pdf->Ln(4);
$pdf->setFont('arial','',10);
//$total=0;
$c=110;
    foreach ($sql as $s2){
    $c=$c+3;
    $pdf->Cell(10,0,''.number_format($s2['cantidad'],2),0);
    $pdf->Cell(42,0,''.utf8_decode($s2['plato']),0);
    $pdf->Cell(12,0,''.number_format($s2['precio'],2),0);
    $pdf->Cell(10,0,''.number_format($s2['subtotal'],2),0);
    //$pdf->Ln(5);
    //$pdf->Cell(10,0,'-------------------------------------------------------------',0,0);//62 lineas
    //$total=$total+$s2['subtotal'];
    $pdf->Ln(4);    
}
$pdf->Cell(10,0,'-------------------------------------------------------------',0,0);//62 lineas
$pdf->Ln(3);
$pdf->Cell(60,0,'Total Bs: ',0);
$total=number_format($sql3['total'],1);
$cadena=(string)$total;
$total=intval($total);
$ultimo=substr($cadena, -1);
if($ultimo==5){
  $decimal="50";
}else{
  $decimal="00";
}

$pdf->Cell(10,0,''.number_format($sql3['total'],2).'',0);
$formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
$pdf->Ln(5);
$pdf->setFont('arial','',8);
$pdf->Cell(35,0,'Son Bs.  '.utf8_decode($formatterES->format($total)).'   '.$decimal.'/100 Bolivianos');
$pdf->Ln(4);
$pdf->Cell(10,0,'-------------------------------------------------------------------------',0,0);//60 lineas
$pdf->Ln(4);
$pdf->setFont('Arial','',8);
$pdf->Cell(30,0,'Codigo de control: '.$sql3['cod_control'],0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'Fecha limite de emision:'.$d_a['fech_fin'],0,0);
$pdf->Ln(30);
$pdf->Image($filename,30,$c,25,25,'png');
$pdf->Ln(4);
$pdf->setFont('Arial','',8.5);
$pdf->Cell(30,0,'"ESTA FACTURA CONTRIBUYE AL DESARROLLO',0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'        DEL PAIS EL USO ILICITO DE ESTA SERA',0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'           SANCIONADO DE ACUERDO A LEY"',0,0);
$pdf->Ln(4);
$pdf->setFont('Arial','',8);
$pdf->Cell(30,0,'  Ley No. 453. El proveedor de servicios debe habilitar',0,0);
$pdf->Ln(4);
$pdf->Cell(30,0,'     medios e instrumentos para efectural consultas.',0,0);
$pdf->Ln(4);
$pdf->setFont('Arial','B',12);
$pdf->Cell(30,0,'Orden: '.$nro,0,0);
$pdf->Output();
?>