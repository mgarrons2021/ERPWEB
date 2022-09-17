<?php
require_once '../config/conexion.inc.php';
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$_nro = $_POST['nro'];
$ventas = $db->Execute("SELECT * from detalleinventario where nro = '$_nro'and sucursal_id= '$sucur'");
echo '
<div class="container">
<table class="table" border="1">
<tr>
   <th>Insumos</th>
  <th>Cantidad</th>
  <th>U. Medida</th>
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
  <td>' .$db->GetOne('SELECT u.nombre FROM unidad_medida u , producto p where  u.idunidad_medida =p.idunidad_medida and p.idproducto ='.$reg['producto_id']).'</td>
  <td>'. $reg['precio_compra'].'</td>
  <td>'. $reg['subtotal'] .'</td>
  <td><a href="javascript:eliminar('. $reg['iddetalleinventario'] .')">Eliminar</a></td>
  </tr>';
  $total += $reg['subtotal'];
}
echo '<tr>
<th colspan="4">TOTAL INVENTARIO:</th>
<th>'. $total . ' Bs</th>
<th>&nbsp;</th>
</tr>
</table>';
?>