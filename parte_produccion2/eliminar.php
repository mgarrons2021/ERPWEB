<?php
require_once '../config/conexion.inc.php';

$_venta = $_POST['nro'];

$consulta = $db->Execute('DELETE FROM detalle_parte_produccion WHERE iddetalle_parte_produccion = '. $_venta);

?>