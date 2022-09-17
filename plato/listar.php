<?php
require_once '../config/conexion.inc.php';
session_start();

$_nro = $_POST['nro'];
$ventas = $db->Execute("SELECT * from detalleplato where nro = '$_nro'");

echo '
<div class="container">
<table class="table" border="1">
<tr>
<th>Insumo</th>
  <th>Cantidad</th>
  <th>Unidad Medida</th>
  <th>Opcion</th>
</tr>
</div>';
$total = 0;
foreach($ventas as $reg) {
  echo '<tr  >
  <td>'. $db->GetOne('SELECT nombre FROM producto where idproducto ='.$reg['producto_id']) .'</td>
  <td>'. $reg['cantidad'] .'</td>
  <td>'.$db->GetOne('SELECT u.nombre FROM unidad_medida u , producto p where  u.idunidad_medida =p.idunidad_medida and p.idproducto ='.$reg['producto_id']).' Bs</td>
  <td><a href="javascript:eliminar('. $reg['iddetalleplato'] .')">Eliminar</a></td>
  </tr>';
}
echo '</table>';
?>