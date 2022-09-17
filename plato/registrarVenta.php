<?php
    require_once '../config/conexion.inc.php';
   session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];

$_producto = $_POST['idprod'];
$_cantidad = $_POST['cantidad'];
$_nro = $_POST['nro'];

//$_pventa = $_POST['pventa'];

$fila['nro'] =$_nro;
$fila['cantidad'] =$_cantidad;
$fila['producto_id'] =$_producto;
$db->AutoExecute('detalleplato',$fila, 'INSERT');

$ventas = $db->Execute("SELECT * from detalleplato where nro = '$_nro'");

echo '
<div class="container">
<table class="table" border="1">
<tr>
  <th>Producto</th>
  <th>Cantidad</th>
  <th>U.Medida</th>
  <th>Opcion</th>
</tr>
</div>';
$total = 0;
foreach($ventas as $reg) {
  echo '<tr>
  <td>'.$db->GetOne('SELECT nombre FROM producto where idproducto = '.$reg['producto_id']).'</td>
  <td>'. $reg['cantidad'] .'</td>
  <td>'.$db->GetOne('SELECT u.nombre FROM unidad_medida u , producto p where  u.idunidad_medida =p.idunidad_medida and p.idproducto ='.$reg['producto_id']).'</td>
  <td><a href="javascript:eliminar('. $reg['iddetalleplato'] .')">Eliminar</a></td>
  </tr>';
}
echo '</table>';
print "<script>
document.getElementById('idprod').value ='Seleccione producto';
document.getElementById('cantidad').value = '';
      </script>";
?>