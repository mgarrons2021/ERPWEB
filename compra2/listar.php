<?php
require_once '../config/conexion.inc.php';
session_start();
$usuario=$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$_nro = $_POST['nro'];
$ventas = $db->Execute("SELECT * from detallecompra where nro = '$_nro'and sucursal_id= '$sucur'");
echo'<div class="container">
<table class="table" border="1">
<tr>
<th>Producto</th>
  <th>Cantidad</th>
  <th>Costo Unitario</th>
  <th>Sub Total</th>
  <th>Opcion</th>
</tr>
</div>';
$total = 0;
foreach($ventas as $reg) {
  echo '<tr>
  <td>'. $db->GetOne('SELECT nombre FROM producto where idproducto ='.$reg['producto_id']) .'</td>
  <td>'. $reg['cantidad'] .'</td>
  <td>'. number_format($reg['precio_compra'],2).' Bs</td>
  <td>'. number_format($reg['subtotal'],2) . ' Bs</td>

  <td><a href="javascript:eliminar('. $reg['iddetallecompra'] .')">Eliminar</a></td>
  </tr>';
  $total += $reg['subtotal'];
}
echo '<tr>
  <th colspan="4">TOTAL A CANCELAR:</th>
  <th>'. $total . ' Bs</th>
  <th>&nbsp;</th>
</tr>
</table>';
?>