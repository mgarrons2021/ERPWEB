<?php
    require_once '../config/conexion.inc.php';
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$_producto = $_POST['idprod'];
$_cantidad = $_POST['cantidad'];
$_nro = $_POST['nro'];
$precio_unitario=$db->GetOne('SELECT precio_compra FROM producto where idproducto = '.$_producto);
$_estado = 'si';
$fila['nro'] = $_nro;
$fila['cantidad'] = $_cantidad;
$fila['precio_compra'] =$precio_unitario;
$fila['subtotal'] = $precio_unitario*$_cantidad;
$fila['producto_id'] = $_producto;
$fila['sucursal_id'] = $sucur;
$db->AutoExecute('detalleinventario', $fila, 'INSERT');
$ventas = $db->Execute("SELECT * from detalleinventario where nro = '$_nro'and sucursal_id= '$sucur'");
echo'
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
  <td>'. $db->GetOne('SELECT nombre FROM producto where idproducto = '.$reg['producto_id']).'</td>
  <td>'. $reg['cantidad'] .'</td>
  <td>'. $db->GetOne('SELECT u.nombre FROM unidad_medida u , producto p where  u.idunidad_medida =p.idunidad_medida and p.idproducto ='.$reg['producto_id']).'</td>
  <td>'. $reg['precio_compra'].' Bs</td>
  <td>'. $reg['subtotal'] .' Bs</td>
  <td><a href="javascript:eliminar('. $reg['iddetalleinventario'] .')">Eliminar</a></td>
  </tr>';
  $total += $reg['subtotal'];
}
echo '<tr>
<th colspan="4">TOTAL</th>
<th>'. $total . ' Bs</th>
<th>&nbsp;</th>
</tr>
</table>';
print "<script>
document.getElementById('idprod').value ='Seleccione producto';
document.getElementById('cantidad').value = '';
document.getElementById('punitario').value = '';
document.getElementById('subtotal').value = '';
document.getElementById('um').value = ''
      </script>";
?>