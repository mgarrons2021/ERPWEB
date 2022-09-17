<?php
require_once '../config/conexion.inc.php';
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$_producto = $_POST['idproducto'];
$_cantidad = $_POST['cantidad'];
$_nro = $_POST['nro'];
// $_proveedorid = $_POST['idproveedor'];
$punitario = $_POST['punitario'];
$operacion=floatval($punitario)*floatval($_cantidad);


//Coloco el subtotal con 2 decimales
$_subtotal  = $operacion;
$_punitario = number_format($punitario, 2);

$sql = $db->Execute("UPDATE producto SET precio_compra = '$_punitario' WHERE idproducto = '$_producto' "); //ACTUALIZAR EL PRECIO DEL PRODUCTO
//$_pventa = $_POST['pventa'];
$_estado               = 'si';
$inventario            = $db->GetOne("SELECT max(nro) FROM inventario WHERE sucursal_id=".$sucur);
$fila['nro']           = $_nro;
$fila['cantidad']      = $_cantidad;
$fila['subtotal']      = $_subtotal;
$fila['precio_compra'] = $_punitario;
$fila['precio_venta']  = $_punitario;
$fila['estado']        = $_estado;
$fila['producto_id']   = $_producto;
// $fila['idproveedor']   = $_proveedorid;

// var_dump($_proveedorid);
// die();
$fila['sucursal_id']   = $sucur;
$fila['inventario_id'] = $inventario;
$db->AutoExecute('detallecompra',$fila, 'INSERT'); // INSERTA AL DETALLE DE LA COMPRA

$ventas = $db->Execute("SELECT * FROM detallecompra WHERE nro = '$_nro'AND sucursal_id= '$sucur'"); //CONSULTA PARA SACAR EL DETALLE QUE TENGAN EL MISMO NUMERO (nro id de comnpra)

echo '<div class="container">
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
          <td>'.$db->GetOne('SELECT nombre FROM producto WHERE idproducto = '.$reg['producto_id']).'</td>
          <td>'. $reg['cantidad'] .'</td>
          <td>'.$db->GetOne('SELECT u.nombre FROM unidad_medida u , producto p WHERE  u.idunidad_medida =p.idunidad_medida AND p.idproducto ='.$reg['producto_id']).'</td>
          <td>'. number_format($reg['precio_compra'],2).' Bs</td>
          <td>'. number_format($reg['subtotal'],2) . ' Bs</td>
          <td><a href="javascript:eliminar('. $reg['iddetallecompra'] .')">Eliminar</a></td>
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
          document.getElementById('idprod').value    ='Seleccione producto';
          document.getElementById('cantidad').value  = '';
          document.getElementById('punitario').value = '';
          document.getElementById('subtotal').value  = '';
      </script>";
?>