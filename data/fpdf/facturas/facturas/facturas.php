<?php
if ($_POST["generar_factura"] == "true")
{

//Recibir detalles de factura
$id_factura = $_POST["id_factura"];
$fecha_factura = $_POST["fecha_factura"];

//Recibir los datos de la empresa
$nombre_tienda = $_POST["nombre_tienda"];
$direccion_tienda = $_POST["direccion_tienda"];
$poblacion_tienda = $_POST["poblacion_tienda"];
$provincia_tienda = $_POST["provincia_tienda"];
$codigo_postal_tienda = $_POST["codigo_postal_tienda"];
$telefono_tienda = $_POST["telefono_tienda"];
$fax_tienda = $_POST["fax_tienda"];
$identificacion_fiscal_tienda = $_POST["identificacion_fiscal_tienda"];

//Recibir los datos del cliente
$nombre_cliente = $_POST["nombre_cliente"];
$apellidos_cliente = $_POST["apellidos_cliente"];
$direccion_cliente = $_POST["direccion_cliente"];
$poblacion_cliente = $_POST["poblacion_cliente"];
$provincia_cliente = $_POST["provincia_cliente"];
$codigo_postal_cliente = $_POST["codigo_postal_cliente"];
$identificacion_fiscal_cliente = $_POST["identificacion_fiscal_cliente"];

//Recibir los datos de los productos
$iva = $_POST["iva"];
$gastos_de_envio = $_POST["gastos_de_envio"];
$unidades = $_POST["unidades"];
$productos = $_POST["productos"];
$precio_unidad = $_POST["precio_unidad"];

//variable que guarda el nombre del archivo PDF
$archivo="factura-$id_factura.pdf";

//Llamada al script fpdf
require('fpdf.php');


$archivo_de_salida=$archivo;

$pdf=new FPDF();  //crea el objeto
$pdf->AddPage();  //a�adimos una p�gina. Origen coordenadas, esquina superior izquierda, posici�n por defeto a 1 cm de los bordes.


//logo de la tienda
$pdf->Image('../empresa.jpg' , 0 ,0, 40 , 40,'JPG', 'http://php-estudios.blogspot.com');

// Encabezado de la factura
$pdf->SetFont('Arial','B',14);
$pdf->Cell(190, 10, "FACTURA", 0, 2, "C");
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(190,5, "N�mero de factura: $id_factura"."\n"."Fecha: $fecha_factura", 0, "C", false);
$pdf->Ln(2);

// Datos de la tienda
$pdf->SetFont('Arial','B',12);
$top_datos=45;
$pdf->SetXY(40, $top_datos);
$pdf->Cell(190, 10, "Datos de la tienda:", 0, 2, "J");
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(190, //posici�n X
5, //posici�n Y
$nombre_tienda."\n".
"Direcci�n: ".$direccion_tienda."\n".
"Poblaci�n: ".$poblacion_tienda."\n".
"Provincia: ".$provincia_tienda."\n".
"C�digo Postal: ".$codigo_postal_tienda."\n".
"Tel�fono: ".$telefono_tienda."\n".
"Fax: ".$fax_tienda."\n".
"Indentificaci�n Fiscal: ".$identificacion_fiscal_tienda,
 0, // bordes 0 = no | 1 = si
 "J", // texto justificado 
 false);


// Datos del cliente
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(125, $top_datos);
$pdf->Cell(190, 10, "Datos del cliente:", 0, 2, "J");
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(
190, //posici�n X
5, //posicion Y
"Nombre: ".$nombre_cliente."\n".
"Apellidos: ".$apellidos_cliente."\n".
"Direcci�n: ".$direccion_cliente."\n".
"Poblaci�n: ".$poblacion_cliente."\n".
"Provincia: ".$provincia_cliente."\n".
"C�digo Postal: ".$codigo_postal_cliente."\n".
"Identificaci�n Fiscal: ".$identificacion_fiscal_cliente, 
0, // bordes 0 = no | 1 = si
"J", // texto justificado
false);

//Salto de l�nea
$pdf->Ln(2);



// extracci�n de los datos de los productos a trav�s de la funci�n explode
$e_productos = explode(",", $productos);
$e_unidades = explode(",", $unidades);
$e_precio_unidad = explode(",", $precio_unidad);

//Creaci�n de la tabla de los detalles de los productos productos
$top_productos = 110;
    $pdf->SetXY(45, $top_productos);
    $pdf->Cell(40, 5, 'UNIDADES', 0, 1, 'C');
    $pdf->SetXY(80, $top_productos);
    $pdf->Cell(40, 5, 'PRODUCTOS', 0, 1, 'C');
    $pdf->SetXY(115, $top_productos);
    $pdf->Cell(40, 5, 'PRECIO UNIDAD', 0, 1, 'C');    
 
$precio_subtotal = 0; // variable para almacenar el subtotal
$y = 115; // variable para la posici�n top desde la cual se empezar�n a agregar los datos
$x=0;
while($x <= count($e_productos) - 1)
{
$pdf->SetFont('Arial','',8);
       
   $pdf->SetXY(45, $y);
    $pdf->Cell(40, 5, $e_unidades[$x], 0, 1, 'C');
    $pdf->SetXY(80, $y);
    $pdf->Cell(40, 5, $e_productos[$x], 0, 1, 'C');
    $pdf->SetXY(115, $y);
    $pdf->Cell(40, 5, $e_precio_unidad[$x]." �", 0, 1, 'C');

//C�lculo del subtotal 	
$precio_subtotal += $e_precio_unidad[$x] * $e_unidades[$x];
$x++;

// aumento del top 5 cm
$y = $y + 5;
}

//C�lculo del Impuesto
$add_iva = $precio_subtotal * $iva / 100;

//C�lculo del precio total
$total_mas_iva = round($precio_subtotal + $add_iva + $gastos_de_envio, 2);

$pdf->Ln(2);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190, 5, "Gastos de env�o: $gastos_de_envio �", 0, 1, "C");
$pdf->Cell(190, 5, "I.V.A: $iva %", 0, 1, "C");
$pdf->Cell(190, 5, "Subtotal: $precio_subtotal �", 0, 1, "C");
$pdf->Cell(190, 5, "TOTAL: ".$total_mas_iva." �", 0, 1, "C");


$pdf->Output($archivo_de_salida);//cierra el objeto pdf

//Creacion de las cabeceras que generar�n el archivo pdf
header ("Content-Type: application/download");
header ("Content-Disposition: attachment; filename=$archivo");
header("Content-Length: " . filesize("$archivo"));
$fp = fopen($archivo, "r");
fpassthru($fp);
fclose($fp);

//Eliminaci�n del archivo en el servidor
unlink($archivo);
}