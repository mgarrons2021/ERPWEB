<?php
require_once '../config/conexion.inc.php';

  session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$_nro = $_POST['nro'];
$traspasos = $db->Execute("SELECT * from detalletraspaso where nro = '$_nro'and sucursal_id= '$sucur'");

echo '
<div class="container">
<table class="table" border="1">
<tr>
 <th>De Sucursal</th>
  <th>Producto</th>

  <th>Cantidad</th>
    <th>U. Medida</th>
    <th>Costo Unitario</th>
     <th>Sub Total</th>
  <th>A Sucursal</th>
  <th>Opcion</th>
</tr>
</div>';
$total = 0;
foreach($traspasos as $reg) {
  echo '<tr  >
  <td>'. $db->GetOne('SELECT nombre FROM sucursal where idsucursal = '.$reg['sucursal_id']) .'</td>
  <td>'. $db->GetOne('SELECT nombre FROM producto where idproducto = '.$reg['producto_id']) .'</td>
 
   <td>'. $reg['cantidad'] .'</td>

    <td>'.$db->GetOne('SELECT u.nombre FROM unidad_medida u , producto p where  u.idunidad_medida =p.idunidad_medida and p.idproducto ='.$reg['producto_id']).'</td>

    <td>'.$db->GetOne('SELECT precio_compra FROM producto where idproducto = '.$reg['producto_id']).'</td>

    <td>'. $reg['subtotal'] .'</td>

   <td>'. $db->GetOne('SELECT nombre FROM sucursal where idsucursal = '.$reg['sucursal_idtraspaso']) .'</td>

  <td><a href="javascript:eliminar('. $reg['iddetalletraspaso'] .')">Eliminar</a></td>
  </tr>';
   $total += $reg['subtotal'];
}
echo '<tr>
  <th colspan="5">TOTAL</th>
  <th>'. $total .'</th>
  <th>&nbsp;</th>
</tr>
</table>';
?>