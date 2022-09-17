<html>
  <head>
    <title>Inventario</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    </head>
<body class="body">
<?php include"../menu/menu.php";
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$inventario = $db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sucur);
$ventas= $db->GetAll("SELECT p.*,dc.*,dt.*,di.*,dtt.*,
     ifnull(di.totali, 0)as entrads,
	   ifnull(dc.total, 0)as entrad,
     ifnull(de.totale, 0)as salidae,
     ifnull(dpro.totalpro, 0)as salidapro,
     ifnull(dtt.totalt, 0)as entradt,
     ifnull(dp.totalp, 0)as entradp,
     ifnull(dpp.totalpp, 0)as salidapp,
	   ifnull(dt.totalss, 0)as salidas,
	   ifnull(di.totali, 0)+ifnull(dc.total, 0)-ifnull(de.totale, 0)-ifnull(dpro.totalpro, 0)+ifnull(dtt.totalt, 0)+ifnull(dp.totalp, 0)-ifnull(dpp.totalpp, 0)-ifnull(dt.totalss, 0)as stock
	   from producto p
     left join
	   (select producto_id,sum(cantidad) totali from detalleinventario where sucursal_id='$sucur' and nro='$inventario' group by producto_id) di on p.idproducto = di.producto_id
 	   left join
	   (select producto_id,sum(cantidad) total from detallecompra where sucursal_id='$sucur' and inventario_id='$inventario' group by producto_id) dc on p.idproducto = dc.producto_id
       left join
	   (select producto_id,sum(d.cantidad) totale from detalleeliminacion d, eliminacion e where d.sucursal_id='$sucur' and d.sucursal_id=e.sucursal_id and e.inventario_id='$inventario' and e.nro=d.nro group by producto_id) de on p.idproducto = de.producto_id 
       left join
	   (select producto_id,sum(d.cantidad) totalpro from detalleproduccion d, produccion pro where d.sucursal_id='$sucur' and d.sucursal_id=pro.sucursal_id and pro.inventario_id='$inventario' and pro.nro=d.nro group by producto_id) dpro on p.idproducto = dpro.producto_id 
       left join
	   (select d.producto_id,sum(d.cantidad_envio) totalp from detallepedido d,pedido p where d.nro=p.nro and d.sucursal_id='$sucur' and p.estado='si' and d.sucursal_id=p.sucursal_id  and p.inventario_id='$inventario' group by d.producto_id) dp on p.idproducto = dp.producto_id
       left join
	   (select d.producto_id,sum(d.cantidad_envio) totalpp from detallepedido d,pedido p where d.nro=p.nro and p.sucursal_idsucursal='$sucur' and p.estado='si' and d.sucursal_id=p.sucursal_idsucursal   and p.inventario_idinventario='$inventario' group by d.producto_id) dpp on p.idproducto = dpp.producto_id 
     left join
	   (select d.producto_id,sum(d.cantidad) totalt from detalletraspaso d,traspaso t where d.nro=t.nro and d.sucursal_idtraspaso='$sucur' and t.estado='si'  and d.sucursal_id=t.sucursal_id and t.inventario_idinventario='$inventario' group by d.producto_id) dtt on p.idproducto = dtt.producto_id
	   left join
	   (select d.producto_id,sum(d.cantidad) totalss from detalletraspaso d, traspaso t where d.nro=t.nro and d.sucursal_id='$sucur' and t.estado='si'  and d.sucursal_id=t.sucursal_id and t.inventario_id='$inventario' group by d.producto_id) dt on p.idproducto = dt.producto_id
     ;");
$query = $ventas;
?>  
<div class="container">
  <div class="left-sidebar">
  <h2>listado de produccion</h2>
<div class="table-responsive">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$(document).ready(function(){$('#usuario').DataTable({"language":{"sProcessing":"Procesando...","sLengthMenu":"Mostrar _MENU_ registros","sZeroRecords":"No se encontraron resultados","sEmptyTable":"Ningun dato disponible en esta tabla","sInfo":"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":"Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":"(filtrado de un total de _MAX_ registros)","sInfoPostFix":"","sSearch":"Buscar:","sUrl":"","sInfoThousands":",","sLoadingRecords":"Cargando...","oPaginate":{"sFirst":"Primero","sLast":"Ãšltimo","sNext":"Siguiente","sPrevious":"Anterior"},"oAria":{"sSortAscending":": Activar para ordenar la columna de manera ascendente","sSortDescending":": Activar para ordenar la columna de manera descendente"}}});});</script>
<table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
               <th>producto</th>
               <th>Inventario</th>
               <th>C(Entradas)</th>
               <th>E(Salidas)</th>
               <th>PRO(Salidas)</th>
               <th>P(Entradas)</th>
               <th>P(Salidas)</th>
               <th>T(Entradas)</th>
               <th>T(salidas)</th>
               <th>Stock</th>
               <th>Precio Unitario</th>
               <th>Subtotal</th>
            </tr> 
        </thead>
        <tbody>
<?php $total=0; $total2=0;  foreach ($query as $r){if($r["idcategoria"]==2){
  $unidadmedida=$db->GetOne('SELECT u.nombre FROM unidad_medida u , producto p where  u.idunidad_medida =p.idunidad_medida and p.idproducto ='.$r['idproducto']);
if (!($r["stock"]==0)){
$subtotal=0;
?>
<tr  class=warning>
  <td><?php echo $r["nombre"]; ?></td>
  <td><?php echo number_format($r["entrads"],2)." ".$unidadmedida; ?></td>
  <td><?php echo number_format($r["entrad"],2)." ".$unidadmedida; ?></td>
  <td><?php echo number_format($r["salidae"],2)." ".$unidadmedida; ?></td>
  <td><?php echo number_format($r["salidapro"],2)." ".$unidadmedida;?></td>
  <td><?php echo number_format($r["entradp"],2)." ".$unidadmedida; ?></td>
  <td><?php echo number_format($r["salidapp"],2)." ".$unidadmedida; ?></td>
  <td><?php echo number_format($r["entradt"],2)." ".$unidadmedida; ?></td>
  <td><?php echo number_format($r["salidas"],2)." ".$unidadmedida; ?></td>
  <td><?php echo number_format($r["stock"],2)." ".$unidadmedida; ?></td>
  <td><?php echo $r["precio_compra"]." Bs"; ?></td>
  <td><?php echo number_format($subtotal=$r["stock"]*$r["precio_compra"],2), " Bs";?>
  </td><?php $total2=$total2+$subtotal;?></td>
  </tr>
  <?php }}}?>
  </tbody>
  </table>
  <table id="usuario"  class="table table-striped table-hover table-bordered" cellspacing="0" width="10%">
  <tbody>
  <tr class=warning>
  <td><?php echo "Total produccion: ".$total2." Bs" ?></td>
  </tr>
  </tbody>
   </table>
  </div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  </div>
</div>  <!-- Start WOWSlider.com BODY section -->
<!-- End WOWSlider.com 
  BODY section -->
  </body>
</html>