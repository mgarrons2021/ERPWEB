<?php
require_once '../config/conexion.inc.php';
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$sucursal=$usuario['nombresucursal'];
$_nro = $_POST['nro'];
$traspasos = $db->Execute("SELECT dp.* ,p.nombre as nombre,u.nombre as unidad, p.precio_compra, p.idcategoria from detallepedido dp,producto p,unidad_medida u where p.idunidad_medida=u.idunidad_medida and dp.producto_id=p.idproducto and nro = '$_nro' and sucursal_id= '$sucur'");
echo '
<div class="container">
<table class="table" border="1">
<tr>
 <th>De Sucursal</th>
  <th>Insumos</th>
  <th>Cantidad</th>
    <th>U. Medida</th>
    <th>Costo Unitario</th>
     <th>Sub Total</th>
  <th>A Sucursal</th>
  <th>Opcion</th>
</tr>
</div>';
$total = 0;
foreach($traspasos as $reg) {if($reg['idcategoria']!=2){
  echo '<tr>
  <td>'. $sucursal .'</td>
  <td>'. $reg['nombre'] .'</td>
  <td>'. $reg['cantidad'] .'</td>
  <td>'.$reg['unidad'].'</td>
  <td>'.$reg['precio_compra'].'</td>
  <td>'. $reg['subtotal'] .'</td>
  <td>Centro de produccion</td>
  <td><a href="javascript:eliminar('. $reg['iddetallepedido'] .')">Eliminar</a></td>
  </tr>';
  $total += $reg['subtotal'];
}}
echo '<tr>
  <th colspan="5">TOTAL</th>
  <th><input id="total1" name="total1" value="'.$total.'" disabled></th>
  <th>&nbsp;</th>
</tr>
<tr>
 <th>De Sucursal</th>
  <th>Produccion</th>
  <th>Cantidad</th>
    <th>U. Medida</th>
    <th>Costo Unitario</th>
     <th>Sub Total</th>
  <th>A Sucursal</th>
  <th>Opcion</th>
</tr>';
$total2 = 0;
foreach($traspasos as $reg){if($reg['idcategoria']==2){
  echo '<tr>
  <td>'.$sucursal .'</td>
  <td>'.$reg['nombre'] .'</td>
  <td>'.$reg['cantidad'] .'</td>
  <td>'.$reg['unidad'].'</td>
  <td>'.$reg['precio_compra'].'</td>
  <td>'.$reg['subtotal'] .'</td>
  <td>Centro de produccion</td>
  <td><a href="javascript:eliminar('.$reg['iddetallepedido'].')">Eliminar</a></td>
  </tr>';
  $total2 += $reg['subtotal'];
}}
echo'<tr>
  <th colspan="5">TOTAL</th>
   <th><input id="total2" name="total2" value="'.$total2.'" disabled></th>
  <th>&nbsp;</th>
</tr>
</table>';
?>