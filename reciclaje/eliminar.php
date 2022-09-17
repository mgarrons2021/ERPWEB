<?php
require_once '../config/conexion.inc.php';

$_venta = $_POST['nro'];

$consulta = $db->Execute('DELETE FROM detallereciclaje WHERE iddetallereciclaje = '. $_venta);

?>