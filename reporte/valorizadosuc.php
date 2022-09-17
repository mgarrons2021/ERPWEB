<html>
	<head>
		<title>Inventarios</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="../js/jquery.js"></script>
   <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">	
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
</head>
<body class="body">
<?php include"../menu/menu.php"; 
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id']; 
?>
 <div class="container">
  <div class="left-sidebar">
   <h2>listado de inventarios</h2>
<div class="table-responsive">
<script src="../js/jquery.js"></script>
<script src="../data/librerias/calendario2/js/bootstrap-datepicker.min.js"></script>
<script src="../data/librerias/calendario2/locales/bootstrap-datepicker.es.min.js"></script>
<script type="text/javascript">
  $(function(){
  $('.input-daterange').datepicker({
    format: "yyyy-mm-dd",
    language: "es",
    orientation: "bottom auto",
    todayHighlight: true
});
  })
  </script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
       $(document).ready(function(){$("#usuario").DataTable({language:{sProcessing:"Procesando...",sLengthMenu:"Mostrar _MENU_ registros",sZeroRecords:"No se encontraron resultados",sEmptyTable:"Ningun dato disponible en esta tabla",sInfo:"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",sInfoEmpty:"Mostrando registros del 0 al 0 de un total de 0 registros",sInfoFiltered:"(filtrado de un total de _MAX_ registros)",sInfoPostFix:"",sSearch:"Buscar:",sUrl:"",sInfoThousands:",",sLoadingRecords:"Cargando...",oPaginate:{sFirst:"Primero",sLast:"Ãšltimo",sNext:"Siguiente",sPrevious:"Anterior"},oAria:{sSortAscending:": Activar para ordenar la columna de manera ascendente",sSortDescending:": Activar para ordenar la columna de manera descendente"}}})});
    </script>
  <form action="">  
<div class="row"> 
<div class="col-md-6">
<div class="input-daterange input-group" id="datepicker"> 
 <select class="form-control select-md" name="fecha" id="fecha" value="1">
                  <option  value="1">DIARIO</option>
                  <option value="2">SEMANAL</option>
     </select>
    <span class="input-group-addon"><strong>Fecha De:</strong> </span>
    <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" />
    <span class="input-group-addon">A</span>
    <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" />  
    <input  type = "hidden" id = "form_sent" name = "form_sent" value ="true" >
</div>
</div>
<div class="col-md-2">
<input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
</div>
</div>
</form>
<br>
<?php if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){
$min=$_GET["fechaini"];
$max=$_GET["fechamax"];
if($_GET["fecha"]==1){
$query= $db->GetAll("select i.*, s.nombre as sucursal
from
inventario i,sucursal s
where
i.estado='diario' and i.sucursal_id = s.idsucursal and i.Fecha between '$min' and '$max' ORDER BY i.idinventario DESC");
}else{
$query= $db->GetAll("select i.*, s.nombre as sucursal 
from
inventario i,sucursal s
where
i.estado='semanal' and i.sucursal_id = s.idsucursal and i.Fecha between '$min' and '$max' ORDER BY i.idinventario DESC"); 
}
}
else{
$min=date("Y-m-d",strtotime(date("Y-m-d")."- 1 days"));
$max=date("Y-m-d",strtotime(date("Y-m-d")."- 1 days"));
$query= $db->GetAll("select i.*, s.nombre as sucursal 
from
inventario i,sucursal s
where
i.estado='diario' and i.sucursal_id = s.idsucursal and i.Fecha between '$min' and '$max' ORDER BY i.idinventario DESC");
}

function ni($nro,$sucur){
  $total=0;
$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
$query3="select i.* from inventario i where i.nro = $nro and i.sucursal_id = $sucur ";
 $resultado = $conexion->query($query3);
  foreach ($resultado as $r){
  $total=$r["total"];
  }
  return $total;
}
function ts($inventario,$sucur){
$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
  $query2="SELECT p.*,dc.*,dt.*,di.*,dtt.*,
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
	   (select d.producto_id,sum(d.cantidad_envio) totalp from detallepedido d,pedido p where d.nro=p.nro and d.sucursal_id='$sucur' and d.sucursal_id=p.sucursal_id  and p.inventario_id='$inventario' group by d.producto_id) dp on p.idproducto = dp.producto_id
       left join
	   (select d.producto_id,sum(d.cantidad_envio) totalpp from detallepedido d,pedido p where d.nro=p.nro and p.sucursal_idsucursal='$sucur' and d.sucursal_id=p.sucursal_id and p.inventario_idinventario='$inventario' group by d.producto_id) dpp on p.idproducto = dpp.producto_id 
     left join
	   (select d.producto_id,sum(d.cantidad) totalt from detalletraspaso d,traspaso t where d.nro=t.nro and d.sucursal_idtraspaso='$sucur' and d.sucursal_id=t.sucursal_id and t.inventario_idinventario='$inventario' group by d.producto_id) dtt on p.idproducto = dtt.producto_id
	   left join
	   (select d.producto_id,sum(d.cantidad) totalss from detalletraspaso d, traspaso t where d.nro=t.nro and d.sucursal_id='$sucur' and t.estado='si' and d.sucursal_id=t.sucursal_id and t.inventario_id='$inventario' group by d.producto_id) dt on p.idproducto = dt.producto_id
     ;";
  $result = $conexion->query($query2);
    $total=0;
	foreach ($result as $r){
    if(!($r["idcategoria"]==2)){
      if (!($r["stock"]==0)){
  $total=$total+($r["stock"]*$r["precio_compra"]);
    }
   }
  }
 return  $total;
}
function com($inventario,$sucur){
$total=0;
$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
$query="select d.producto_id,sum(d.cantidad) total,pro.precio_compra,pro.idcategoria from detallecompra d, producto pro where d.producto_id=pro.idproducto and d.sucursal_id='$sucur' and d.inventario_id='$inventario' group by d.producto_id";
 $resultado = $conexion->query($query);
  foreach ($resultado as $r){
    if(!($r["idcategoria"]==2)){
  $total=$total+($r["total"]*$r["precio_compra"]);
    }
  }
  //echo number_format($total,2)." bs.";
  return $total;
}
function el($inventario,$sucur){
$total=0;
$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
$query="select producto_id,sum(d.cantidad) totale,d.precio_compra,pro.idcategoria from detalleeliminacion d, eliminacion e , producto pro where d.producto_id=pro.idproducto and d.sucursal_id='$sucur' and d.sucursal_id=e.sucursal_id and e.inventario_id='$inventario' and e.nro=d.nro group by producto_id";
 $resultado = $conexion->query($query);
  foreach ($resultado as $r){
    if(!($r["idcategoria"]==2)){
  $total=$total+($r["totale"]*$r["precio_compra"]);
    }
  }
 // echo number_format($total,2)." bs.";
 return $total;
}

function prod($inventario,$sucur){
$total=0;
$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
$query="select producto_id,sum(d.cantidad) totalpro, d.precio_compra,p.idcategoria from detalleproduccion d, produccion pro, producto p where d.producto_id=p.idproducto and d.sucursal_id='$sucur' and d.sucursal_id=pro.sucursal_id and pro.inventario_id='$inventario' and pro.nro=d.nro group by producto_id";
 $resultado = $conexion->query($query);
  foreach ($resultado as $r){
    if(!($r["idcategoria"]==2)){
  $total=$total+($r["totalpro"]*$r["precio_compra"]);}
  }
 // echo number_format($total,2)." bs.";
 return $total;
}
function pe_en($inventario,$sucur){
$total=0;
$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
$query="select d.producto_id,sum(d.cantidad_envio) totalp,pro.precio_compra,pro.idcategoria from detallepedido d,pedido p , producto pro where d.producto_id=pro.idproducto and d.nro=p.nro and d.sucursal_id='$sucur' and d.sucursal_id=p.sucursal_id and p.estado='si' and p.inventario_id='$inventario' group by d.producto_id";
 $resultado = $conexion->query($query);
 foreach ($resultado as $r){
   if(!($r["idcategoria"]==2)){
 $total=$total+($r["totalp"]*$r["precio_compra"]);
   }
 }
  //echo number_format($total,2)." bs.";
  return $total;
}
function pe_sa($inventario,$sucur){
$total=0;
$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
$query="select sum(d.subtotal_envio) totalp from detallepedido d ,pedido p, producto pro where p.nro=d.nro and p.sucursal_id=d.sucursal_id and d.producto_id=pro.idproducto and p.sucursal_idsucursal='$sucur' and p.inventario_idinventario='$inventario' and pro.idcategoria!=2";
$resultado = $conexion->query($query);
foreach ($resultado as $r){
$total=$total+$r["totalp"];
}
return $total;
}
function tra_en($inventario,$sucur){
$total=0;
$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
$query="select d.producto_id,sum(d.cantidad) totalt,p.precio_compra, p.idcategoria from detalletraspaso d,traspaso t,producto p where d.producto_id=p.idproducto and d.nro=t.nro and d.sucursal_idtraspaso='$sucur' and t.estado='si' and d.sucursal_id=t.sucursal_id and t.inventario_idinventario='$inventario' group by d.producto_id";
 $resultado = $conexion->query($query);
 foreach ($resultado as $r){
   if(!($r["idcategoria"]==2)){
 $total=$total+($r["totalt"]*$r["precio_compra"]);
   }
 }
 // echo number_format($total,2)." bs.";
 return $total;
}
function tra_sa($inventario,$sucur){
$total=0;
$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
$query="select d.producto_id,sum(d.cantidad) totalss,p.precio_compra,p.idcategoria from detalletraspaso d, traspaso t,producto p where d.producto_id=p.idproducto and d.nro=t.nro and d.sucursal_id='$sucur' and d.sucursal_id=t.sucursal_id and t.inventario_id='$inventario' group by d.producto_id";
 $resultado = $conexion->query($query);
 foreach ($resultado as $r){
     if(!($r["idcategoria"]==2)){
 $total=$total+($r["totalss"]*$r["precio_compra"]);
     }
 }
 // echo number_format($total,2)." bs.";
 return $total;
}
  ?>
    <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
            <th>Nro</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Sucursal</th>
            <th>Turno</th>
            <th>Tipo</th>
            <th>Total Inventario</th>
            <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
<?php
$nr=0; 
$total=0;
$total_sis=0;
$total_nue=0;
$total_aju=0;
$compra=0;
$eliminacion=0;
$produccion=0;
$pedido_en=0;
$pedido_sa=0;
$traspaso_en=0;
$traspaso_sa=0;
foreach ($query as $r){
$nr=$nr+1;
$total=$total+$r["total"];
$_ts=ts($r["nro"],$r["sucursal_id"]);$total_sis=$total_sis+$_ts;
$_ni=ni($r["nro"]+1,$r["sucursal_id"]);$total_nue=$total_nue+$_ni;
$ajuste=($_ni-$_ts); $total_aju=$total_aju+$ajuste;
$com=com($r["nro"],$r["sucursal_id"]);$compra=$compra+$com;
$eli=el($r["nro"],$r["sucursal_id"]);$eliminacion=$eliminacion+$eli;
$prod=prod($r["nro"],$r["sucursal_id"]);$produccion=$produccion+$prod;
$pe_en=pe_en($r["nro"],$r["sucursal_id"]);$pedido_en=$pedido_en+$pe_en;
$pe_sa=pe_sa($r["nro"],$r["sucursal_id"]);$pedido_sa=$pedido_sa+$pe_sa;
$tra_en=tra_en($r["nro"],$r["sucursal_id"]);$traspaso_en=$traspaso_en+$tra_en;
$tra_sa=tra_sa($r["nro"],$r["sucursal_id"]);$traspaso_sa=$traspaso_sa+$tra_sa;
  ?>
  <tr class=warning>
  <td> <?php  echo $nr;?></td>
  <td><?php echo $r["fecha"];?></td>
  <td><?php echo $r["hora"];?></td>
  <td><?php echo $r["sucursal"];?></td>
  <td><?php if($r["turno"]=='1'){echo "AM";}else{if($r["turno"]=='2'){echo "PM";}else{echo "Null";}};?></td>
   <td><?php if($r["estado"]!="semanal"){echo "diario";}else{echo $r["estado"];}; ?></td>
  <td><?php echo number_format($r["total"],2)." bs.";////?></td>
  <td> <a href="#" data-toggle="modal" data-target="#ver<?php echo $r["nro"];echo $r["sucursal_id"];?>"><img src="../images/ver.png" alt="" title="ver detalle">Ver Detalle</a></td>
  <!--<td><?php //echo number_format($_ts,2)." bs."; ////?></td>
  <td><?php //if($_ni==""){echo"no hay inventario nuevo";}else{echo number_format($_ni,2)." bs.";}; ///?></td>
  <td><?php //if ($_ni==null||$_ni==""){echo "no se realizo ajuste";}else {echo number_format($ajuste,2)." bs.";} ?>
  </td>-->
  </tr>

  </td>
  </tr>
   <div class="modal fade" id="ver<?php echo $r["nro"];echo $r["sucursal_id"];?>"
                 data-backdrop="static" data-keyboard="false"
                 draggable="modal-header"
                 tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel" 
                 aria-hidden="true">
                 <div class="modal-dialog">
                 <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Detalle inventario <?php echo $r["sucursal"]; ?></h4>
                  </div>
                  <div class="modal-body">
                  <div class="row panel panel-primary">
                      <div class="col-md-1">
                        codigo
                      </div>                    
                      <div class="col-md-4">
                        producto
                      </div>
                      <div class="col-md-2">
                        cantidad
                      </div>
                      <div class="col-md-2">
                        precio
                      </div>                    
                      <div class="col-md-2">
                        subtotal
                      </div>
                  </div>
                  <?php 
                  
$consul = $db->GetAll("
select p.codigo_producto,p.idproducto,p.nombre,di.cantidad,di.precio_compra,di.subtotal,di.producto_id,u.nombre as um
from detalleinventario di,producto p,unidad_medida u
where u.idunidad_medida=p.idunidad_medida and di.nro = $r[nro] and p.idproducto = di.producto_id and di.sucursal_id=".$r["sucursal_id"]);
                    foreach ($consul as $key) { ?>
                     <div class="row">
                       <div class="col-md-1">
                         <?php echo $key["idproducto"]; ?>
                       </div>
                       <div class="col-md-4">
                         <?php echo $key["nombre"];?>
                       </div>
                       <div class="col-md-2">
                         <?php echo $key["cantidad"]; ?><?php echo " ".$key["um"]; ?>
                       </div>
                       <div class="col-md-2">
                         <?php echo number_format($key["precio_compra"],2), ' Bs'; ?>
                       </div>
                       <div class="col-md-2">
                         <?php echo number_format($key["subtotal"],2), ' Bs'; ?>
                       </div>
                     </div>  
                    <?php } ?>
                    <br>
                    <div class="row panel panel-primary" >
                    <div class="col-md-9">TOTAL</div>
                    <div class="col-md-2">
                      <?php echo number_format($r["total"],2), ' Bs'; ?>
                      </div>
                    </div>         
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
             </div>
               <?php } ?> 
  </table>
 </tbody>
<div class="">

   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="80%">
   <thead>
    <tr>
            <th> </th>
            <th>Total-Inventario (+)</th>
            <!--<th>Total-Inventario-Sistema</th>
            <th>Total-Inventario-Nuevo </th>
            <th>Total-Ajuste-Inventario </th>-->
            </tr>
</thead>
<tbody>
<tr>
<td><h4> Total InventarioDonesco</h4></td> <td><h2><?php echo number_format($total,2)." bs."; ?></h2></td>
<!--<td><h4><?php //echo number_format($total_sis,2)." bs."; ?></h4></td>
<td><h2><?php //echo number_format($total_nue,2)." bs."; ?></h2></td>
<td><h4><?php //echo number_format($total_aju,2)." bs."; ?></h4></td>-->
</tr>
</tbody>
   </table>

  </div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  </div>
</div><!-- Start WOWSlider.com BODY section -->
<!-- End WOWSlider.com 
  BODY section -->
  </body>
</html>