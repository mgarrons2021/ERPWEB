<?php require_once '../config/conexion.inc.php';
$nro             = $_POST['nro_compra'];
$fecha_actual    = date('Y-m-d H:i:s');
$deuda           = $_POST['deuda'];
$banco           = $_POST['banco'];
$nro_cuenta      = $_POST['nro_cuenta'];
$nro_comprobante = $_POST['nro_comprobante'];
$nro_cheque      = $_POST['nro_cheque'];
$monto           = $_POST['monto'];
$operacion       = ( $deuda - $monto );
$deuda_actual    = number_format($operacion, 2);

// ATRAPAR LOS DATOS PARA INGRESAR AL PAGO
$fecha_actual = date('Y-m-d H:i:s');
$tipo_pago         = $_POST['tipo_pago'];
$nro_cheque        = $_POST['nro_cheque'];
$fecha_vencimiento = $_POST['fecha_vencimiento'];
$nit			   = $_POST['nit'];
$nro_autorizacion  = $_POST['nro_autorizacion'];
$codigo_control    = $_POST['codigo_control'];
$emite_factura     = $_POST['emite_factura'];
$recibo            = $_POST['recibo'];
$nro_factura = $_POST['nro_factura'];
$nro_recibo  = $_POST['nro_recibo'];
print "<script>alert($emite_factura );</script>";
if($emite_factura == "si"){
    $nro_factura  = $_POST['nro_factura'];
    if($nro_factura == ''){
        echo '<script>alert("Seleccionaste con Factura - Introduce el nro de factura obligatoriamente")</script>';
    }
}

if($recibo == "si"){
    $nro_recibo = $_POST['nro_recibo'];
    if($nro_recibo == ''){
        echo '<script>alert("Seleccionaste con recibo - Introduce el nro de recibo obligatoriamente")</script>';
    }
}


// var_dump($emite_factura);
// var_dump($nro_factura);
// die();
$insert_pago = $db->Execute("INSERT INTO pago(
    compra_id, 
    fecha, 
    monto,
    tipo_pago,
    deuda,
    emite_factura,
    recibo,
    nro_recibo,
    nro_factura,
    nit, 
    fecha_vencimiento,
    banco,
    nro_cuenta, 
    nro_comprobante, 
    nro_cheque,
	nro_autorizacion, 
	cod_control) 
VALUES(
    '$nro', 
    '$fecha_actual', 
    '$monto', 
    '$tipo_pago', 
    '$deuda_actual',
    '$emite_factura',
    '$recibo',
    '$nro_recibo',
    '$nro_factura',
    '$nit',
    '$fecha_vencimiento', 
    '$banco', 
    '$nro_cuenta',
    '$nro_comprobante', 
    '$nro_cheque',
	'$nro_autorizacion', 
	'$codigo_control')");


//Consulta para actualizar la deuda en compra
$update_compra = $db->Execute("UPDATE compra c SET c.deuda = '$deuda_actual' WHERE  c.nro = '$nro'");

//Verificar el estado
$verify_estado = $db->Execute("SELECT * FROM compra WHERE nro = '$nro'");
foreach($verify_estado as $r){
    $deuda = $r['deuda'];
}

//Actualizar estado de la compra
if($deuda == 0){
    $update_estado_compra = $db->Execute("UPDATE compra c SET c.estado = 'Pagada' WHERE c.nro = '$nro'");
}


if($insert_pago != null && $update_compra){
    echo "<script>alert('pago agregado correctamente'); 
            window.location = 'index.php?nro=$nro';
        </script>";
}else{
    echo "<script>alert('error al agregar el pago, Introduce los datos correctamente'); 
            window.location = 'index.php?nro=$nro';
        </script>";
}
?>