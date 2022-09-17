<?php 
require_once '../data/fpdf/fpdf.php';
require_once '../config/conexion.inc.php';
$pdf = new fpdf();
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$id=$usuario['idusuario'];
$nro = $_GET['nro'];
$idturno = $_GET['idturno'];

//SACAR EL TOTAL DE LAS VENTAS REALIDAS POR TURNO Y SUCURSAL CON SU DETALLE MAS
$sql = $db->GetAll("SELECT t.nro AS turno, v.nro AS transaccion, v.total , 
sum(dv.cantidad) cantidad , p.nombre AS plato, 
sum(dv.subtotal) as subtotal
FROM turno t, venta v, detalleventa dv, plato p
WHERE pago != 'comida_personal' AND t.idturno ='$idturno' 
AND v.estado = 'V' AND t.nro = '$nro' 
AND v.idturno = t.idturno AND t.nro = v.turno 
AND dv.nro = v.nro AND dv.idturno = v.idturno 
AND p.idplato = dv.plato_id GROUP BY p.idplato");


$sql1 = $db->GetRow("SELECT * FROM turno 
WHERE sucursal_id = '$sucur' 
AND idturno = '$idturno' AND nro = '$nro'");

//Sacar el nombre de la sucursal logeada
$sql2 = $db->GetOne("SELECT nombre FROM sucursal 
WHERE idsucursal = '$sucur'");

$sql4 = $db->GetOne("SELECT nombre FROM usuario WHERE idusuario = '$id' ");

$categoria = $db->GetAll("SELECT t.nro AS turno, v.nro AS transaccion, v.total , sum(dv.cantidad) cantidad , p.categoria, p.precio_uni,sum(dv.subtotal) AS subtotal
FROM turno t,venta v, detalleventa dv, plato p
WHERE v.lugar != 'DELIVERY' AND t.idturno = '$idturno' 
AND v.estado   = 'V' AND t.nro = '$nro' 
AND v.idturno  = t.idturno AND t.nro = v.turno AND dv.nro = v.nro 
AND dv.idturno = v.idturno AND p.idplato = dv.plato_id GROUP by p.categoria");

//Consulta para sacar el total ventas con delivery
$s3 = $db->GetRow("SELECT t.nro as turno, v.nro as transaccion,sum(v.total)as total
FROM turno t,venta v
WHERE v.lugar = 'DELIVERY' AND  t.idturno = '$idturno' 
AND v.idturno = t.idturno  AND v.estado = 'V'");

//Consulta para sacar la categoria
$categoria2 = $db->GetAll("SELECT t.nro AS turno, v.nro AS transaccion, v.total ,dv.cantidad , p.categoria, p.precio_uni,sum(dv.subtotal)as subtotal
FROM turno t,venta v, detalleventa dv, plato p
WHERE  t.idturno = '$idturno'  AND v.estado = 'V' AND t.nro = '$nro' 
AND v.idturno = t.idturno AND t.nro = v.turno 
AND dv.nro = v.nro AND dv.idturno = v.idturno AND p.idplato = dv.plato_id");


//CONSULTA PARA SACAR LA CANTIDAD DE VENTAS CON DELIVERY
$delivery = (int)$db->GetOne("SELECT COUNT(idventa) FROM venta where lugar = 'DELIVERY' AND turno = '$nro' AND idturno = '$idturno'"); 

$sql3 = $db->GetOne("SELECT count(nro) FROM venta WHERE pago != 'comida_personal' 
AND estado = 'V' AND sucursal_id = '$sucur' 
AND idturno = '$idturno' AND turno = '$nro'");

//Sacar el total del turno 
$total_turno = $db->GetOne("SELECT  sum(total) AS total
FROM venta  WHERE idturno = '$idturno' AND estado = 'V' AND pago != 'comida_personal' ");

//Sacar el total de las ventas anuladas
$total_anuladas = $db->GetOne("SELECT sum(v.total) AS total FROM venta v WHERE v.idturno = '$idturno' AND v.estado = 'A'");

$total_cp = $db->GetOne("SELECT sum(v.total) AS total FROM venta v WHERE v.idturno = '$idturno' AND pago = 'comida_personal'");

//Total Sin filtros
$total_venta = $db->GetOne("SELECT sum(v.total) AS total FROM venta v WHERE v.idturno = '$idturno'");

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
if($sql1['nro'] == "1"){
$pdf->Cell(45,0,'TURNO: '.'AM',0,0);
}else{
    $pdf->Cell(45,0,'TURNO: '.'PM',0,0);
}
$pdf->Ln(5);
$pdf->setFont('arial','B',10);
$pdf->Cell(15,0,'Cant',0);
$pdf->Cell(30,0,'Descripcion',0);
$pdf->Cell(45,0,'Subtotal',0);
$pdf->Ln(5);
$pdf->setFont('arial','',10);
$total1 = 0;
foreach ($sql as $s2){
$pdf->Cell(15,0,''.number_format($s2['cantidad'],2),0);
$pdf->Cell(35,0,''.$s2['plato'],0);
$pdf->Cell(30,0,''.number_format($s2['subtotal'],2),0);	
$pdf->Ln(5);
}
$pdf->Cell(50,0,'Total: ',0);
$pdf->Cell(20,0,''.number_format($total_turno,2).' bs',0);
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
    if($s2['cantidad'] == 0){
        $pdf->Cell(15,0,''.number_format($delivery,2),0);
    }else{

        $pdf->Cell(15,0,''.number_format($s2['cantidad'],2),0);
    }
$pdf->Cell(35,0,''.$s2['categoria'],0);
$pdf->Cell(30,0,''.number_format($s2['subtotal'],2),0);	
$pdf->Ln(5);

}
$pdf->Cell(15,0,''.number_format($delivery,2),0);
$pdf->Cell(35,0,''.'Delivery',0);
$pdf->Cell(30,0,''.number_format($s3['total'],2),0);	
$pdf->Ln(5);
$pdf->Cell(50,0,'Total: ',0);
$pdf->Cell(10,0,''.number_format($total_turno,2).' bs',0);
$pdf->Ln(7);



//Mostrar el total de las ventas anuladas
$pdf->setFont('Arial','B',10);
$pdf->Cell(15,0,'VENTAS ANULADAS',0);
$pdf->Ln(5);
$pdf->setFont('arial','',10);
$pdf->Cell(50,0,'Total: ',0);
$pdf->Cell(12,0,''.number_format($total_anuladas,2).' bs',0);
$pdf->Ln(7);


//Mostrar el total de las comida del personal
$pdf->setFont('Arial','B',10);
$pdf->Cell(50,0,'TOTAL COMIDA PERSONAL',0);
$pdf->Ln(5);
$pdf->setFont('arial','',10);
$pdf->Cell(50,0,'Total: ',0);
$pdf->Cell(10,0,''.number_format($total_cp,2).' bs',0);
$pdf->Ln(7);

$pdf->Output()
?>