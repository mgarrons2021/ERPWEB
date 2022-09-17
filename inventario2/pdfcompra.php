<?php 
require_once '../data/fpdf/fpdf.php';
require_once '../config/conexion.inc.php';	
$nro = $_GET['nro'];	
	$sql = $db ->GetRow("select p.*,c.*,date_format(c.fecha,'%d-%m-%Y') as fecha from provedor p,compra c 
							where p.id = c.provedor_id and c.nro = '$nro'");
$pdf = new fpdf();

$pdf->addpage();
$pdf->setFont('Arial','B',12);
$pdf->Image('../images/logofactura.jpg',10,5,80,30,'jpg');
$pdf->Ln(3);
$pdf->Cell(0,0,'NOTA DE COMPRA',0,0,'R');
$pdf->setFont('Arial','',12);
$pdf->Ln(5);
$pdf->Cell(0,0,'Nro # '.$sql['nro'] ,0,0,'R');
$pdf->Ln(5);
$pdf->setFont('Arial','',10);
$pdf->Cell(0,0,'Fecha: '.$sql['fecha'],0,0,'R');
$pdf->Ln(17);

//datos de la tienda
$pdf->setFont('Arial','B',10);

$pdf->Cell(0,0,'DATOS DEL PROVEDOR',0,1,'R');
$pdf->setFont('Arial','',10);
$pdf->Ln(5);

$pdf->Cell(0,0,'Nombre y apellidos:',0,1,'R');
$pdf->Ln(5);

$pdf->Cell(0,0,''.$sql['nombre'],0,1,'R');
$pdf->Ln(5);

$pdf->Cell(0,0,'Cedula:',0,1,'R');
$pdf->Ln(5);

$pdf->Cell(0,0,''.$sql['ci'],0,1,'R');
$pdf->Ln(5);

$pdf->Cell(0,0,'Telefono:',0,1,'R');
$pdf->Ln(5);

$pdf->Cell(0,0,''.$sql['telefono'],0,1,'R');
$pdf->Ln(5);
$pdf->setFont('Arial','B',10);
$pdf->Cell(0,0,'DETALLE DE COMPRA',0,0,'C');
$pdf->Ln(15);
$pdf->setFont('arial','B',10);
$pdf->Cell(15,0,'item',0);
$pdf->Cell(28,0,'Cod',0);
$pdf->Cell(45,0,'Producto',0);
$pdf->Cell(30,0,'Cantidad',0);
$pdf->Cell(30,0,'Precio compra',0);
$pdf->Cell(30,0,'Precio venta',0);
$pdf->Cell(30,0,'Subtotal',0);
$pdf->Ln(5);
$pdf->setFont('arial','',10);
$dv = $db ->GetAll("select p.*,dc.* from detallecompra dc,producto p
where p.id = dc.producto_id and dc.nro = '$nro'");
$c = 0;
foreach ($dv as $s2) {
	$c = $c+1;
$pdf->Cell(15,0,''.$c,0);
$pdf->Cell(28,0,''.$s2['cod'],0);
$pdf->Cell(45,0,''.$s2['nombre'],0);
$pdf->Cell(30,0,''.$s2['cantidad'],0);
$pdf->Cell(30,0,''.$s2['precio_compra'],0);
$pdf->Cell(30,0,''.$s2['precio_venta'],0);
$pdf->Cell(30,0,''.$s2['subtotal'],0);	
$pdf->Ln(5);# code...
}
$pdf->Ln(5);
$pdf->Cell(0,0,'TOTAL A PAGAR:                                                                                              
	                                                           '.$sql['total'],0);                                           
$pdf->Output();

# c</dode...



// datos de venta






 ?>