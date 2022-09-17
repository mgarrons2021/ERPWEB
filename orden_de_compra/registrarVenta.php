<?php
    require_once '../config/conexion.inc.php';
   session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$_producto = $_POST['idproducto'];
$_cantidad = $_POST['cantidad'];
$_nro = $_POST['nro'];
$_punitario = $_POST['punitario'];
$_subtotal=floatval($_punitario)*floatval($_cantidad);

$sql = $db->Execute("update producto set precio_compra='$_punitario' where idproducto = '$_producto'");
//$_pventa = $_POST['pventa'];

$fila['nro'] =$_nro;
$fila['cantidad'] =$_cantidad;
$fila['subtotal'] =$_subtotal;
$fila['precio_compra'] =$_punitario;
$fila['producto_id'] =$_producto;
$fila['sucursal_id']=$sucur;
$db->AutoExecute('detalle_orden_de_compa',$fila, 'INSERT');

$ventas = $db->Execute("SELECT * from detalle_orden_de_compa where nro = '$_nro'and sucursal_id= '$sucur'");

echo '
<div class="container">
<table class="table" border="1">
<tr>
  <th>Producto</th>
  <th>Cantidad</th>
  <th>U.Medida</th>
  <th>Costo Unitario</th>
  <th>Sub Total</th>
  <th>Opcion</th>
</tr>
</div>';
$total = 0;
foreach($ventas as $reg) {
  echo '<tr>
  <td>'.$db->GetOne('SELECT nombre FROM producto where idproducto = '.$reg['producto_id']).'</td>
  <td>'. $reg['cantidad'] .'</td>
  <td>'.$db->GetOne('SELECT u.nombre FROM unidad_medida u , producto p where  u.idunidad_medida =p.idunidad_medida and p.idproducto ='.$reg['producto_id']).'</td>
  <td>'. number_format($reg['precio_compra'],2).' Bs</td>
   <td>'. number_format($reg['subtotal'],2) . ' Bs</td>
  
  <td><a href="javascript:eliminar('. $reg['iddetalleordencompra'] .')">Eliminar</a></td>
  </tr>';
  $total += $reg['subtotal'];
}
echo '<tr>
  <th colspan="4">TOTAL</th>
  <th>'. $total .'</th>
  <th>&nbsp;</th>
</tr>
</table>';

print "<script>
document.getElementById('idprod').value ='Seleccione producto';
document.getElementById('cantidad').value = '';
document.getElementById('punitario').value = '';
document.getElementById('subtotal').value = '';
      </script>";
?>