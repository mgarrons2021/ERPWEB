<?php
    require_once '../config/conexion.inc.php';
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$_POST['sucur'];

$_producto = $_POST['idprod'];
$_cantidad = $_POST['cantidad'];

//$precio_unitario=$db->GetOne('SELECT precio_compra FROM producto where idproducto = '.$_producto);

$fila['cantidad'] = $_cantidad;
$fila['producto_id'] = $_producto;
$fila['sucursal_id'] = $sucur;
$db->AutoExecute('inv_ideal', $fila, 'INSERT');
$traspasos = $db->Execute("SELECT dp.* ,p.nombre ,u.nombre as unidad, p.precio_compra, p.idcategoria
      from inv_ideal dp,producto p,unidad_medida u where p.idunidad_medida=u.idunidad_medida and dp.producto_id=p.idproducto and sucursal_id= '$sucur'");
echo'
<div class="container">
<table class="table" border="1">
<tr>

  <th>Insumos</th>
  <th>Cantidad</th>
   <th>U. Medida</th>
  <th>Opcion</th>
</tr>
</div>';
$total = 0;
foreach($traspasos as $reg) {
  echo '<tr>
  <td>'. $reg['nombre'] .'</td>
  <td>'. $reg['cantidad'] .'</td>
  <td>'.$reg['unidad'].'</td>
  <td><a href="javascript:eliminar('. $reg['idinv_ideal'] .')">Eliminar</a></td>
  </tr>';
}
echo'</table>';
?>