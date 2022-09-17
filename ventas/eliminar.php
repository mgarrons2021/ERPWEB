<?php
require_once '../config/conexion.inc.php';
$_venta = $_POST['nro'];
$cant = $_POST['cant'];
$consulta = $db->Execute('DELETE FROM detalleventa WHERE iddetalleventa = '. $_venta);
?>
