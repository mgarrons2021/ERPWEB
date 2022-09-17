<?php
require_once '../config/conexion.inc.php';
$_venta = $_POST['nro'];
$consulta = $db->Execute('DELETE FROM inv_ideal WHERE idinv_ideal = '. $_venta);
?>