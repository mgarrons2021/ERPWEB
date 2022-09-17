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
     ifnull(dpv.totalv, 0)as salidav,
     ifnull(de.totale, 0)as salidae,
     ifnull(dpro.totalpro, 0)as salidapro,
     ifnull(dtt.totalt, 0)as entradt,
     ifnull(dp.totalp, 0)as entradp,
     ifnull(dpart.totalpart, 0)as salidapart,
     ifnull(dpp.totalpp, 0)as salidapp,
	   ifnull(dt.totalss, 0)as salidas,
	   ifnull(di.totali, 0)+ifnull(dc.total, 0)-ifnull(de.totale, 0)-ifnull(dpv.totalv, 0)-ifnull(dpro.totalpro, 0)+ifnull(dtt.totalt, 0)+ifnull(dp.totalp, 0)-ifnull(dpp.totalpp, 0)-ifnull(dpart.totalpart, 0)-ifnull(dt.totalss, 0)as stock
	   from producto p
     left join
	   (select producto_id,sum(cantidad) totali from detalleinventario where sucursal_id='$sucur' and nro='$inventario' group by producto_id) di on p.idproducto = di.producto_id
 	   left join
	   (select producto_id,sum(cantidad) total from detallecompra where sucursal_id='$sucur' and inventario_id='$inventario' group by producto_id) dc on p.idproducto = dc.producto_id
     left join
	   (select dv.plato_id,pro.nombre as insumo,dpv.producto_id ,sum(dpv.cantidad)as totalv
from detalleventa dv,venta v,plato pla,detalleplato dpv, producto pro
where dv.sucursal_id='$sucur' and 
v.inventario_id='$inventario' and 
v.sucursal_id=dv.sucursal_id and 
v.idturno=dv.idturno and dv.nro=v.nro and 
dv.plato_id=pla.idplato and pla.nro=dpv.nro 
and dpv.producto_id=pro.idproducto
GROUP BY producto_id
) dpv on p.idproducto = dpv.producto_id
       left join
	   (select producto_id,sum(d.cantidad) totale from detalleeliminacion d, eliminacion e where d.sucursal_id='$sucur' and d.sucursal_id=e.sucursal_id and e.inventario_id='$inventario' and e.nro=d.nro group by producto_id) de on p.idproducto = de.producto_id 
       left join
	   (select producto_id,sum(d.cantidad) totalpro from detalleproduccion d, produccion pro where d.sucursal_id='$sucur' and d.sucursal_id=pro.sucursal_id and pro.inventario_id='$inventario' and pro.nro=d.nro group by producto_id) dpro on p.idproducto = dpro.producto_id 
       left join
	   (select d.producto_id,sum(d.cantidad_envio) totalp from detallepedido d,pedido p where d.nro=p.nro and d.sucursal_id='$sucur' and d.sucursal_id=p.sucursal_id  and p.inventario_id='$inventario' group by d.producto_id) dp on p.idproducto = dp.producto_id
       left join
	   (select d.producto_id,sum(d.cantidad_envio) totalpp from detallepedido d,pedido p where d.nro=p.nro and p.sucursal_idsucursal='$sucur' and p.estado='si' and d.sucursal_id=p.sucursal_id and p.inventario_idinventario='$inventario' group by d.producto_id) dpp on p.idproducto = dpp.producto_id 
	 left join
	   (select d.producto_id,sum(d.cantidad) totalpart from detalle_parte_produccion d,parte_produccion p where d.nro=p.nro and p.sucursal_id='$sucur' and d.sucursal_id=p.sucursal_id and p.inventario_id='$inventario' group by d.producto_id) dpart on p.idproducto = dpart.producto_id
     left join
	   (select d.producto_id,sum(d.cantidad) totalt from detalletraspaso d,traspaso t where d.nro=t.nro and d.sucursal_idtraspaso='$sucur' and t.estado='si'  and d.sucursal_id=t.sucursal_id and t.inventario_idinventario='$inventario' group by d.producto_id) dtt on p.idproducto = dtt.producto_id
	   left join
	   (select d.producto_id,sum(d.cantidad) totalss from detalletraspaso d, traspaso t where d.nro=t.nro and d.sucursal_id='$sucur' and t.estado='si'  and d.sucursal_id=t.sucursal_id and t.inventario_id='$inventario' group by d.producto_id) dt on p.idproducto = dt.producto_id order by p.nombre 
     ;");
$query = $ventas;
?>
<div class="container">
<div class="left-sidebar">
<h2>listado de insumos en Inventario</h2>
<div class="table-responsive">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$(document).ready(function(){$('#usuario').DataTable({"language":{"sProcessing":"Procesando...","sLengthMenu":"Mostrar _MENU_ registros","sZeroRecords":"No se encontraron resultados","sEmptyTable":"Ningun dato disponible en esta tabla","sInfo":"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":"Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":"(filtrado de un total de _MAX_ registros)","sInfoPostFix":"","sSearch":"Buscar:","sUrl":"","sInfoThousands":",","sLoadingRecords":"Cargando...","oPaginate":{"sFirst":"Primero","sLast":"Ãšltimo","sNext":"Siguiente","sPrevious":"Anterior"},"oAria":{"sSortAscending":": Activar para ordenar la columna de manera ascendente","sSortDescending":": Activar para ordenar la columna de manera descendente"}}});});</script>
<table id="usuario" class="" cellspacing="0" border="1" width="100%">
     <?php $total_gen=0; $sub_tot=0;  for ($i=3; $i <= 7 ; $i++){ $sub_tot=0; ?>
       <thead>
            <tr>
            <th>
            <h2><?php
if($i==3){echo "Abarrotes";}
if($i==4){echo "Alimentos";}
if($i==5){echo "Bebidas";}
if($i==6){echo "Material de Limpieza";}
if($i==7){echo "Plasticos";}?></h2>
            </th>
               <th>Inventario</th>
               <th>UM</th>
               <th>Precio Unitario</th>
               <th>Compras</th>
               <th>Ing traspasos</th>
               <th>Ventas</th>
               <th>Traspasos Sucursales</th>
              <th>Part Produccion</th>
               <th>Eliminacion</th>
               <!--<th>Mix</th>
               <th>Pedidos E</th>
               <th>Traspasos S</th>-->
               <th>Stock Inventario</th>
               <th>Subtotal</th>
            </tr> 
        </thead>
     <tbody>
<?php
foreach ($query as $r){
if($r["idcategoria"]==$i){
$unidadmedida=$db->GetOne('SELECT u.nombre FROM unidad_medida u , producto p where  u.idunidad_medida =p.idunidad_medida and p.idproducto ='.$r['idproducto']);
if (!($r["stock"]==0)){
$subtotal=0;
?>
<tr class=warning>
  <td><?php echo $r["nombre"]; ?></td>
  <td><?php echo number_format($r["entrads"],2);//inventario ?></td>
  <td><?php echo $unidadmedida;?></td>
  <td><?php echo number_format($r["precio_compra"],2)." Bs";// precio ?></td>
  <td><?php echo number_format($r["entrad"],2); //compras?></td>
  <td><?php echo number_format(($r["entradt"]+$r["entradp"]),2); //traspasos entradas ?></td>
  <td><?php  echo number_format($r["salidav"],2); //ventas salidas ?></td>
  <td><?php echo number_format(($r["salidapp"]+$r["salidas"]),2);//pedidos salidas ?></td>
  <td><?php echo number_format($r["salidapart"],2); //parte produccion salida ?></td>
    <td><?php echo number_format($r["salidae"],2); //eliminacion salida ?></td>
  <!--<td><?php //echo $r["salidapro"];//produccion  salida ?></td>
  <td><?php //echo $r["entradp"]; // pedidos entradas ?></td>
  <td><?php //echo $r["salidas"];// traspaos salidas ?></td>-->
  <td><?php echo number_format($r["stock"],2);// stock del sistema ?></td>
  <td><?php echo number_format($subtotal=$r["stock"]*$r["precio_compra"],2)," Bs"; $total=$total+$subtotal; //subtotal ?>
  </td><?php $total_gen=$total_gen+$subtotal; $sub_tot=$sub_tot+$subtotal; ?></td>
  </tr>
  <?php }}}?>
  <tr><td colspan="11"><h2> Sub Total:</h2></td><td><h2><?php echo number_format($sub_tot,2);?></h2></td></tr>
<?php }?>
  </tbody>
  </table>
  <table id="usuario"  class="table table-striped table-hover table-bordered" cellspacing="0" width="10%">
  <tbody>
  <tr class=warning>
  <td><h2><?php echo "Total inventario de insumos: ".number_format($total_gen,2)." Bs"?></h2></td>
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