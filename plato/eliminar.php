<?php
require_once '../config/conexion.inc.php';

$_venta = $_POST['nro'];

$consulta = $db->Execute('DELETE FROM detalleplato WHERE iddetalleplato = '.$_venta);

?>