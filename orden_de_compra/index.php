<html>
	<head>
		<title>ORDEN DE COMPRA</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">	
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
    </head>
<body class="body">
<?php include"../menu/menu.php"; 
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id']; 
?>
  <div class="container">
  <div class="left-sidebar">
  <h2>listado de Compras</h2>
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
<?php
if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){
$min=$_GET["fechaini"];
$max=$_GET["fechamax"];
$ventas= $db->GetAll("select odc.nro,odc.proveedor_id, odc.total, odc.fecha_o,u.nombre as usuario, p.empreza as proveedor, s.nombre as sucursal
from orden_de_compra odc,proveedor p,usuario u, sucursal s
where odc.usuario_id = u.idusuario and
odc.proveedor_id = p.idproveedor and
odc.sucursal_id = s.idsucursal and
odc.sucursal_id = u.sucursal_id and
odc.sucursal_id = '$sucur' and odc.Fecha_o between '$min' and '$max' ORDER BY odc.idorden DESC");
}else{
$min=date("Y-m-d",strtotime(date("Y-m-d")."- 1 days"));
$max=date("Y-m-d");
$ventas= $db->GetAll("select odc.nro,odc.proveedor_id, odc.total, odc.fecha_o,u.nombre as usuario, p.empreza as proveedor, s.nombre as sucursal
from orden_de_compra odc,proveedor p,usuario u, sucursal s
where odc.usuario_id = u.idusuario and
odc.proveedor_id = p.idproveedor and
odc.sucursal_id = s.idsucursal and
odc.sucursal_id = u.sucursal_id and
odc.sucursal_id = '$sucur' and odc.Fecha_o between '$min' and '$max' ORDER BY odc.idorden DESC");
}
$query = $ventas;
?>
    <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Fecha compra</th>
                <th>Sucursal</th>
                <th>Usuario</th>
                <th>Proveedor</th>
                <th>Total</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
<?php $nro=0; $total=0; $total2=0;
foreach ($query as $r){ $nro=$nro+1; if($r["proveedor_id"]==7||$r["proveedor_id"]==28){$total2=$total2+$r["total"];}
else{$total=$total+$r["total"];}?>
<tr   class=warning>
  <td><?php echo $r["nro"]; ?></td>
  <td><?php echo $r["fecha_o"]; ?></td>
  <td><?php echo $r["sucursal"]; ?></td>
    <td><?php echo $r["usuario"]; ?></td>
  <td><?php echo $r["proveedor"]; ?></td>
   <td><?php echo number_format($r["total"],2)." bs"; ?></td>
  <td style="width:210px;">
    <a href="#" data-toggle="modal"
                  data-target="#ver<?php echo $r["nro"];?>"><img src="../images/ver.png" alt="" title="ver detalle">Ver Detalle</a>
    <?php
    echo "<a class='' href='pdfcompra.php?nro=$r[nro]' 
   target='_blank' role='button'><img src='../images/pdf.png' alt=''>PDF</a>";
     ?>
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
                    <h4 class="modal-title" id="myModalLabel">Detalle Compra <?php echo $r["nro"]; ?></h4>
                  </div>
                  <div class="modal-body">
                  <div class="row panel panel-primary">
                      <div class="col-md-2">
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
select p.codigo_producto,p.nombre,doc.cantidad,doc.precio_compra,doc.subtotal
from detalle_orden_de_compa doc,producto p 
where doc.nro = $r[nro] and p.idproducto = doc.producto_id and doc.sucursal_id=".$usuario['sucursal_id']);
                    foreach ($consul as $key) { ?>
                     <div class="row" >
                       <div class="col-md-2">
                         <?php echo $key["codigo_producto"]; ?>
                       </div>
                       <div class="col-md-4">
                         <?php echo $key["nombre"];?>
                       </div>
                       <div class="col-md-2">
                         <?php echo $key["cantidad"]; ?>
                       </div>
                       <div class="col-md-2">
                         <?php echo $key["precio_compra"], ' Bs'; ?>
                       </div>
                       <div class="col-md-2">
                         <?php echo $key["subtotal"], ' Bs'; ?>
                       </div>
                     </div>  
                    <?php }?>
                    <br>
                    <div class="row panel panel-primary" >
                    <div class="col-md-10">TOTAL</div>
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
 <?php }?>
  </table>
    </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
   <tr>
   <td><h4>Total Compras de Insumos</h4></td><td><h4> <?php echo number_format($total,2)." bs"; ?></h4>
   </td></tr>
   </table>
  </div>
  </div>
</div>  <!-- Start WOWSlider.com BODY section -->
<!-- End WOWSlider.com 
  BODY section -->
  </body>
</html>