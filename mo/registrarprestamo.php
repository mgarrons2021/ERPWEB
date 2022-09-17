<?php
require_once '../config/conexion.inc.php';
session_start();
$usuario = $_SESSION['usuario'];
$sucur = $usuario['sucursal_id'];
$sucursal = $usuario['nombresucursal'];
$horas=$_POST['horas'];
$_nro = $_POST['nro'];
$fila['idusuario'] = $usuario;
$fila['sucursal'] = $sucur;
$fila['monto'] = $horas*8.84;
$fila['horast'] = $horas;;
$db->AutoExecute('detallemo', $fila, 'INSERT');
$manoobra = $db->Execute("SELECT dm.* ,u.nombre , s.idsucursal from detallemo dm, u where nro = '$_nro' and sucursal_id= '$sucur'");
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
