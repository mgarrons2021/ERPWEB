<?php
    require_once '../config/conexion.inc.php';
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];

$_producto = $_POST['idprod'];//se coloca idproducto para que capture de la lupita
$_cantidad = $_POST['cantidad'];
$_nro = $_POST['nro'];

$_sucursal=$_POST['sucursal_idtraspaso'];
$inventario = $_POST['nroinventario'];
$inventario_idinventario=$db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$_sucursal);
$fila['nro'] = $_nro;
$fila['cantidad'] = $_cantidad;
$fila['subtotal'] = $db->GetOne('SELECT precio_compra FROM producto where idproducto = '.$_producto)*$_cantidad;
$fila['producto_id'] = $_producto;
$fila['sucursal_id'] = $sucur;
$fila['sucursal_idtraspaso'] = $_sucursal;
$fila['inventario_id']=$inventario;
$fila['inventario_idinventario']=$inventario_idinventario;
$db->AutoExecute('detalletraspaso', $fila, 'INSERT');

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
  echo '<tr>
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
print "<script>
document.getElementById('idprod').value ='Seleccione producto';
document.getElementById('cantidad').value = '';
document.getElementById('stockactual').value = '';
document.getElementById('stock').value = '';
      </script>";
?>