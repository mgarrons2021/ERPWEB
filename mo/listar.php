<?php
require_once '../config/conexion.inc.php';
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$sucursal=$usuario['nombresucursal'];
$_nro = $_POST['nro'];
$manoobra = $db->Execute("SELECT dm.* ,u.nombre , s.idsucursal from detallemo dm,  where nro = '$_nro' and sucursal_id= '$sucur'");
echo '
<div class="container">
<table class="table" border="1">
<tr>
     <th>Nombre</th>
     <th>Sucursal</th>
     <th>Monto</th>
     <th>Horas Traba.</th>
</tr>
</div>';
$total = 0;
foreach ($manoobra as $reg) {
  echo '<tr>
  <td>' . $reg['nombre'] . '</td>
  <td>' . $reg['sucursal'] . '</td>
  <td>' . $reg['monto'] . '</td>
  <td>' . $reg['horast'] . '</td>
  </tr>';
  $total += $reg['subtotal'];
}

?>