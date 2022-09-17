<?php
    require_once '../config/conexion.inc.php';
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];

$_producto = $_POST['idproducto'];
$_cantidad = $_POST['cantidad'];
$_nro = $_POST['nro'];

$precio=$db->GetOne('SELECT precio_compra FROM producto where idproducto = '.$_producto);
$fila['nro'] = $_nro;
$fila['precio']=$precio;
$fila['cantidad'] = $_cantidad;
$fila['subtotal'] = floatval($precio)*floatval($_cantidad);
$fila['producto_id'] = $_producto;
$fila['sucursal_id'] = $sucur;
$db->AutoExecute('detalle_parte_produccion', $fila, 'INSERT');
$produccion = $db->Execute("SELECT * from detalle_parte_produccion where nro = '$_nro'and sucursal_id= '$sucur'");
echo'
<div class="container">
<table class="table" border="1">
<tr>
<th>De Sucursal</th>
  <th>Producto</th>
  <th>Cantidad</th>
    <th>U. Medida</th>
    <th>Costo Unitario</th>
    <th>Sub Total</th>

  <th>Opcion</th>
</tr>
</div>';
$total = 0;
foreach($produccion as $reg) {
  echo '<tr>
  <td>'. $db->GetOne('SELECT nombre FROM sucursal where idsucursal = '.$reg['sucursal_id']) .'</td>

  <td>'. $db->GetOne('SELECT nombre FROM producto where idproducto = '.$reg['producto_id']) .'</td>
 
   <td>'. $reg['cantidad'] .'</td>

    <td>'.$db->GetOne('SELECT u.nombre FROM unidad_medida u , producto p where  u.idunidad_medida =p.idunidad_medida and p.idproducto ='.$reg['producto_id']).'</td>

   <td>'.$db->GetOne('SELECT precio_compra FROM producto where idproducto = '.$reg['producto_id']).'</td>

    <td>'. $reg['subtotal'] .'</td>

  <td><a href="javascript:eliminar('. $reg['iddetalle_parte_produccion'] .')">Eliminar</a></td>
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


