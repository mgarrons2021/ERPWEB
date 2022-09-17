<?php
require_once '../config/conexion.inc.php';

$_venta = $_POST['nro'];

$consulta = $db->Execute('DELETE FROM detalle_orden_de_compa WHERE iddetalleordencompra = '.$_venta);

?>