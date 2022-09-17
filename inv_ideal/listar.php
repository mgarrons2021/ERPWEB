<?php
require_once '../config/conexion.inc.php';
session_start();
$usuario =$_SESSION['usuario'];
//$sucur=$usuario['sucursal_id'];
$sucur = $_POST['sucur'];
$traspasos = $db->Execute("SELECT dp.* ,p.nombre as nombre,u.nombre as unidad, p.precio_compra, p.idcategoria
from inv_ideal dp,producto p,unidad_medida u
where p.idunidad_medida=u.idunidad_medida and dp.producto_id=p.idproducto and sucursal_id= '$sucur'");
echo '
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
echo '</table>';
?>