<html>
  <head>
    <title>Inventario</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    </head>
    
<body class="body">
<?php include"../menu/menu.php";
$sucur=$_GET['sucursal_id'];
$inventario =$_GET['nro'];
$fecha =$_GET['fechas'];
$i =$_GET['cat'];
$turno =$_GET['turno'];
$usuario_id =$_GET['usuario_id'];
$nom_suc=$db->GetOne("select nombre from sucursal where idsucursal=$sucur");
$ventas= $db->GetAll("SELECT p.*,dc.*,dt.*,di.*,dtt.*,
     ifnull(di.totali, 0)as entrads,
	 ifnull(dc.total, 0)as entrad,
     ifnull(dpv.totalv, 0)as salidav,
     ifnull(de.totale, 0)as salidae,
     ifnull(dpro.totalpro, 0)as salidapro,
     ifnull(dtt.totalt, 0)as entradt,
     ifnull(dp.totalp, 0)as entradp,
     ifnull(dpp.totalpp, 0)as salidapp,
	 ifnull(dt.totalss, 0)as salidas,
	 ifnull(di.totali, 0)+ifnull(dc.total, 0)-ifnull(de.totale, 0)-ifnull(dpv.totalv, 0)-ifnull(dpro.totalpro, 0)+ifnull(dtt.totalt, 0)+ifnull(dp.totalp, 0)-ifnull(dpp.totalpp, 0)-ifnull(dt.totalss, 0)as stock
	 from producto p
     left join
	   (select producto_id,sum(cantidad) totali from detalleinventario where sucursal_id='$sucur' and nro='$inventario' group by producto_id) di on p.idproducto = di.producto_id
 	   left join
	   (select producto_id,sum(cantidad) total from detallecompra where sucursal_id='$sucur' and inventario_id='$inventario' group by producto_id) dc on p.idproducto = dc.producto_id
     left join
(select dv.plato_id,pro.nombre as insumo,dpv.producto_id ,sum(dv.cantidad*dpv.cantidad)as totalv
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
	   (select d.producto_id,sum(d.cantidad_envio) totalpp from detallepedido d,pedido p where d.nro=p.nro and p.sucursal_idsucursal='$sucur' and d.sucursal_id=p.sucursal_idsucursal   and p.inventario_idinventario='$inventario' group by d.producto_id) dpp on p.idproducto = dpp.producto_id 
     left join
	   (select d.producto_id,sum(d.cantidad) totalt from detalletraspaso d,traspaso t where d.nro=t.nro and d.sucursal_idtraspaso='$sucur' and d.sucursal_id=t.sucursal_id and t.inventario_idinventario='$inventario' group by d.producto_id) dtt on p.idproducto = dtt.producto_id
	   left join
	   (select d.producto_id,sum(d.cantidad) totalss from detalletraspaso d, traspaso t where d.nro=t.nro and d.sucursal_id='$sucur' and d.sucursal_id=t.sucursal_id and t.inventario_id='$inventario' group by d.producto_id) dt on p.idproducto = dt.producto_id
     ;");
$query = $ventas;
$nro=$inventario+1;
$inventario2=$db->GetAll("select * from detalleinventario where sucursal_id=$sucur and nro=$nro");
?>  
<div class="container">
  <div class="left-sidebar">
  <h2><?php echo "inventario de ".$nom_suc.'<br>'.$fecha;?></h2>
  <a href="cat_ajus.php?nro=<?php echo $inventario;?>&sucursal_id=<?php echo $sucur;?>&fechas=<?php echo $fecha;?>"><h4><-Atras</h4></a>
  <h4><?php echo "Personal: ".$db->GetOne("select nombre from usuario where idusuario=$usuario_id").'<br>'." Turno:";?><?php if($turno=="2"){echo "AM";}else{if($turno=="1"){echo "PM";}else{echo "Null";}};?></h4>
  </div><br>
<div class="table-responsive">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$(document).ready(function(){$('#usuario').DataTable({"language":{"sProcessing":"Procesando...","sLengthMenu":"Mostrar _MENU_ registros","sZeroRecords":"No se encontraron resultados","sEmptyTable":"Ningun dato disponible en esta tabla","sInfo":"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":"Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":"(filtrado de un total de _MAX_ registros)","sInfoPostFix":"","sSearch":"Buscar:","sUrl":"","sInfoThousands":",","sLoadingRecords":"Cargando...","oPaginate":{"sFirst":"Primero","sLast":"Ãšltimo","sNext":"Siguiente","sPrevious":"Anterior"},"oAria":{"sSortAscending":": Activar para ordenar la columna de manera ascendente","sSortDescending":": Activar para ordenar la columna de manera descendente"}}});});</script>
<table id="usuario" class="table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
               <th>Producto</th>
                 <th>Precio</th>
               <th>Inventario inicial</th>
             
               <th>Compras</th>
               <th>Ventas</th>
               <th>Eliminación</th>
               <!--<th>Insumos vendidos</th>-->
               <th>Pedidos Ingreso</th>
               <!--<th>Pedidos S</th>-->
               <th>Traspasos Egresos</th>
               <th>traspasos Ingresos</th>
               <th>Stock</th>
               <!--<th>Precio Unitario</th>
               <th>Subtotal</th>-->
               <th>Inventario final</th>
               <th>Ajuste</th>
               <th>Ajuste Bs</th>
            </tr> 
        </thead>
        <tbody>
<?php $total0=0; $total=0; $total2=0; $array=array();
foreach ($query as $r){ if($r["idcategoria"]==$i){
  $resta=0;
  $unidadmedida=$db->GetOne('SELECT u.nombre FROM unidad_medida u , producto p where  u.idunidad_medida =p.idunidad_medida and p.idproducto ='.$r['idproducto']);
if (!($r["stock"]==0)){
$subtotal=0;
?>
<tr  class=warning>
  <td><?php echo $r["nombre"]; ?></td>
 <td><?php echo number_format($r["precio_compra"],1)."Bs";// precio ?></td>
  <td><?php echo $r["entrads"]." "//.$unidadmedida;//inventario ?></td>
  <td><?php echo $r["entrad"]." "//.$unidadmedida; //compras?></td>
  <td><?php echo number_format($r["salidav"],1)." "//.$unidadmedida; //ventas salidas ?></td>
  <td><?php echo $r["salidae"]." "//.$unidadmedida; //eliminacion salida ?></td>
  <!--  <td><?php //echo $r["salidapro"]." ".$unidadmedida;//produccion  salida ?></td>-->
  <td><?php echo $r["entradp"]." "//.$unidadmedida; // pedidos entradas ?></td>
  <!-- <td><?php //echo $r["salidapp"]." ".$unidadmedida;//pedidos salidas ?></td>-->
  <td><?php echo $r["entradt"]." "//.$unidadmedida; //traspasos entradas ?></td>
  <td><?php echo $r["salidas"]." "//.$unidadmedida;// traspaos salidas ?></td>
  <td><?php echo number_format($r["stock"],2)." "//.$unidadmedida;// stock del sistema ?></td>
  <!--<td><?php //echo number_format($subtotal=$r["stock"]*$r["precio_compra"],2)," Bs"; $total=$total+$subtotal; //subtotal ?></td>-->
  <td><?php foreach ($inventario2 as $ri){
    if($r['idproducto']==$ri['producto_id']){
    echo number_format($ri["cantidad"],2);//.$unidadmedida // nuevo cantidad de insumo del 2do inventario
    $total0=$total0+($r["entrads"]*$r["precio_compra"]);//
    $resta=$ri["cantidad"]-$r["stock"];
    $total2=$total2+$ri["subtotal"]; 
    $array[]=$ri['producto_id'];
    break;}}
   if($resta==0){echo "0 ";//.$unidadmedida; /*$resta=0-$r["stock"];*/ 
   } ?></td>
  <td><?php echo number_format($resta,1)." ";//.$unidadmedida; ///ajuste ?></td>
  <td><?php echo number_format(($resta*$r["precio_compra"]),1)."Bs";//ajuste en bolivianos ?></td>
  </tr>
  <?php }}}
  foreach ($inventario2 as $rii){
    foreach ($array as $a){
  if($rii['producto_id']!=$a){
  }}}
  ?>
  </tbody>
  </table>
  <table id="usuario"  class="table-bordered" cellspacing="0" width="100%">
  <tbody>
  <tr class=warning>
  <td><h4>Inventario Inicial:</h4><h4><?php echo " ".number_format($total0,2)." Bs" ?></h4></td>
  <td><h4>Inventario Sistema:</h4><h4><?php echo " ".number_format($total,2)." Bs" ?></h4></td>
  <td><h4>Inventario Final :</h4><h4><?php echo " ".number_format($total2,2)." Bs" ?></h4></td>
  <td><h4>Ajuste de inventario :</h4> <h4><?php echo "".number_format(($total2-$total),2)." Bs" ?></h4></td>
  <td><?php //print_r($array)?></td>
  </tr>
  </tbody>
   </table>
    x
  </div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  </div>
</div>  <!-- Start WOWSlider.com BODY section -->
<!-- End WOWSlider.com 
  BODY section -->
  </body>
</html>