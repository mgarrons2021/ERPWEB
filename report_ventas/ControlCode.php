<?php

require("../librerias/codigo_control/CodigoControl.php");

$authorizationNumber=$_POST['autorizacion'];
$invoiceNumber=$_POST['factura'];
$nitci=$_POST['nit'];
$dateOfTransaction=$_POST['fecha']; //20210409
$transactionAmount=$_POST['monto']; //0.76 = 1
$dosageKey=$_POST['llave'];

$fecha_compra = str_replace("-", "", $dateOfTransaction);
$monto_compra = round($transactionAmount);

$codigoControl = CodigoControl::generar($authorizationNumber, $invoiceNumber, $nitci, str_replace("-", "", strval($fecha_compra)), strval(round($monto_compra)), $dosageKey);

?>