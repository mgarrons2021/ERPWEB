<html>
	<head>
      <title>INSUMOS SOLICITADOS</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
      <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
      <link rel="shortcut icon" href="../images/favicon.ico">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
    </head>
<body class="body">
<?php include"../menu/menu.php";
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
$min=$_GET["fechaini"];
$max=$_GET["fechamax"];
$query = $db->GetAll("select t.*, t.fecha_p, u.nombre as usuario, t.idpedido, t.total, t.total_envio
from pedido t,usuario u
where t.usuario_id=u.idusuario and t.sucursal_id ='$sucur' and t.fecha_p between '$min' and '$max' ORDER BY t.idpedido DESC");
}
else{
    $max=date("Y-m-d");
$min=date("Y-m-d",strtotime($max."-10 days"));
  $query= $db->GetAll("select t.*, t.fecha_p, u.nombre as usuario, t.idpedido, t.total, t.total_envio
from pedido t,usuario u
where t.usuario_id=u.idusuario and t.sucursal_id ='$sucur' and t.fecha_p between '$min' and '$max' ORDER BY t.idpedido DESC");
}


?>
 <div class="container">
  <div class="left-sidebar">
   <h2>listado de Insumos Solicitados</h2>
    <div class="table-responsive">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
 <script type="text/javascript">
       $(document).ready(function(){$("#usuario").DataTable({language:{sProcessing:"Procesando...",sLengthMenu:"Mostrar _MENU_ registros",sZeroRecords:"No se encontraron resultados",sEmptyTable:"Ningun dato disponible en esta tabla",sInfo:"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",sInfoEmpty:"Mostrando registros del 0 al 0 de un total de 0 registros",sInfoFiltered:"(filtrado de un total de _MAX_ registros)",sInfoPostFix:"",sSearch:"Buscar:",sUrl:"",sInfoThousands:",",sLoadingRecords:"Cargando...",oPaginate:{sFirst:"Primero",sLast:"Ãšltimo",sNext:"Siguiente",sPrevious:"Anterior"},oAria:{sSortAscending:": Activar para ordenar la columna de manera ascendente",sSortDescending:": Activar para ordenar la columna de manera descendente"}}})});
</script>
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
        <form action="">  
<div class="row"> 
<div class="col-md-6">  
<div class="input-daterange input-group" id="datepicker">  
    <span class="input-group-addon"><strong>Fecha De:</strong> </span>
    <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" />
    <span class="input-group-addon">A</span>
    <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" />  
    <input  type = "hidden" id = "form_sent" name = "form_sent" value = "true" >
</div>
</div>
<div class="col-md-2">
<input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
</div>
</div>
</form> 
    <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Codigo</th>
                <th>Hora</th>
                 <th>Fecha</th>
                 <th>Usuario</th>
                 <th>Sucursal</th>
                 <th>Total Insumos</th>
                 <th>Total Insumos Enviados</th>
                 <th>Total Produccion</th>
                 <th>Total Produccion Enviada</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
<?php $c=0; $total=0; $total2=0; foreach ($query as $r){ $c=$c+1; $total=$total+$r["total_envio"]; $total2=$total2+$r["total_envio2"];?>
<tr   class=warning>
  <td><?php echo $c; ?></td>
    <td><?php echo $r["nro"]."-".$r["sucursal_id"]; ?></td>
    <td><?php echo $r["hora_solicitud"]; ?></td>
  <td><?php echo $r["fecha_p"]; ?></td>
    <td><?php echo $r["usuario"]; ?></td>
     <td><?php echo $db->GetOne('SELECT nombre FROM sucursal where idsucursal = '.$r['sucursal_id']); ?></td>
  <td><?php echo number_format($r["total"],2); ?></td>
  <td><?php echo number_format($r["total_envio"],2); ?></td>
  <td><?php echo number_format($r["total2"],2); ?></td>
  <td><?php echo number_format($r["total_envio2"],2); ?></td>
  <td style="width:210px;">
    <a href="#" data-toggle="modal"
                  data-target="#ver<?php echo $r["nro"];?>"><img src="../images/ver.png" alt="" title="ver detalle">Ver Detalle</a>
    <?php if($usuario['codigo_usuario']=='1807'||$usuario['codigo_usuario']=='74444'||$usuario['codigo_usuario']=='0077GS'){?>
    <a href="editar.php?nro=<?php echo $r["nro"];?>"><img src="../images/edit.png" alt="" title="Modificar">Edit</a>
   <?php }?>

    <?php
    echo "<!--<a class='' href='#?nro=$r[nro]' 
   target='_blank' role='button'><img src='../images/pdf.png' alt=''>PDF</a>-->";
     ?>
           <?php if ($r["estado"] == 'si') { ?>
                    <a href="#" >
                        <img src="" alt="" title="ACEPTADO"><p style="color:#008f39"> Aceptado </p>
                     </a>
          <?php  } else { if($r["estado"] == 'no'){ ?>
                    <a href="">
                    <img src="" alt="" title="PENDIENTE"> <p style="color:#FF0000"> Pendiente </p>
                    </a>
          <?php }else { if($r["estado"] == 'ok') ?>
            <a href="./estado.php?id=<?php echo $r["idpedido"];?> "
                    onclick ="return confirm('&iquest;Esta Seguro de aceptar los envios ?')">
                    <img src="" alt="" title="ENVIADO"> <p style="color:#ff8000">Aceptar pedido </p>
                    </a>
         <?php } 
        }  ?>
  </td>
  </tr>
 <div class="modal fade" id="ver<?php echo $r["nro"];?>"
                 data-backdrop="static" data-keyboard="false"
                 draggable="modal-header"
                 tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel" 
                 aria-hidden="true">
                 <div class="modal-dialog">
                 <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Detalle pedidos <?php echo $r["nro"]." "; ?> Inventario Nro:<?php echo $r["inventario_id"]." "; ?> </h4>
                  </div>
                 <div class="modal-body">
                  <div class="row panel panel-primary">              
                      <div class="col-md-3">
                        Insumo
                      </div>
                       <div class="col-md-2">
                        Cantidad Solicitada
                      </div>
                       <div class="col-md-2">
                        Cantidad Enviada
                      </div>
                        <div class="col-md-2">
                       Subtotal
                      </div>
                      <div class="col-md-2">
                        Observacion
                      </div>
                  </div>
                  <?php 
$consul = $db->GetAll("select p.idproducto, p.idcategoria,p.nombre,dt.cantidad,p.precio_compra,dt.subtotal, u.nombre as umedida,dt.cantidad_envio, dt.subtotal_envio,dt.estado
from detallepedido dt,producto p, unidad_medida u
where dt.nro = $r[nro] and p.idunidad_medida=u.idunidad_medida and p.idproducto = dt.producto_id and dt.sucursal_id=".$usuario['sucursal_id']);
                    foreach ($consul as $key) { if($key["idcategoria"]!=2){ ?>
                     <div class="row" > 
                       <div class="col-md-3">
                         <?php echo $key["nombre"];?>
                       </div>
                         <div class="col-md-2">
                         <?php echo $key["cantidad"]." ".$key["umedida"]; ?>
                       </div>
                      <div class="col-md-2">
                         <?php echo number_format($key["cantidad_envio"],2)." ".$key["umedida"]; ?>
                       </div>
                        <div class="col-md-2">
                         <?php echo number_format($key["subtotal_envio"],2)." bs"; ?>
                       </div>
                       <div class="col-md-2">
                         <?php if($key["estado"]==1){echo "Sin Observacion";}else{if($key["estado"]==2){echo "Observado";}else{echo "Falta de stock";}}; ?>
                       </div>
                       </div>
                    <?php } } ?>
                       <br>
                    <div class="row panel panel-primary" >
                    <div class="col-md-7">TOTAL INSUMOS</div>
                      <div class="col-md-2">
                      <?php echo number_format($r["total_envio"],2). PHP_EOL ."Bs"; ?>
                      </div>
                    </div>
                  
                    <br>
                   <div class="row panel panel-primary">              
                      <div class="col-md-3">
                        Produccion
                      </div>
                    
                       <div class="col-md-2">
                        Cantidad Solicitada
                      </div>
                       <div class="col-md-2">
                        Cantidad Enviada
                      </div>
                         <div class="col-md-2">
                       Subtotal
                      </div>
                      <div class="col-md-2">
                        Observacion
                      </div>
                  </div>
                 <?php foreach ($consul as $key) { if($key["idcategoria"]==2){ ?>
                     <div class="row" > 
                       <div class="col-md-3">
                         <?php echo $key["nombre"];?>
                       </div>
                         <div class="col-md-2">
                         <?php echo $key["cantidad"]." ".$key["umedida"]; ?>
                       </div>
                      <div class="col-md-2">
                         <?php echo $key["cantidad_envio"]." ".$key["umedida"]; ?>
                       </div>
                         <div class="col-md-2">
                         <?php echo number_format($key["subtotal_envio"],2)." bs"; ?>
                       </div>
                       <div class="col-md-2">
                         <?php if($key["estado"]==1){echo "Sin Observacion";}else{if($key["estado"]==2){echo "Observado";}else{echo "Falta de stock";}}; ?>
                       </div>
                       </div>
                    <?php }}?>
                    <br>
                    <div class="row panel panel-primary" >
                    <div class="col-md-7">TOTAL PRODUCCION</div>
                      <div class="col-md-2">
                      <?php echo number_format($r["total_envio2"],2). PHP_EOL ."Bs"; ?>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
             </div>
 <?php }?>
  </table>
  <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
   <tr>
   <td><h4>Total insumos enviados</h4></td><td><h4> <?php echo number_format($total,2)." bs"; ?></h4></td>
   <td><h4>Total produccion enviado</h4></td><td><h4> <?php echo number_format($total2,2)." bs"; ?></h4></td>
   </tr>
   </table>
  </div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  </div>
</div>  <!-- Start WOWSlider.com BODY section -->
<!-- End WOWSlider.com 
  BODY section -->
  </body>
</html>