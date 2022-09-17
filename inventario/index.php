<html>
	<head>
		<title>Inventario</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
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
$query = $db->GetAll("select i.turno,i.nro,i.total,i.estado,i.idinventario, i.nro,i.hora ,i.total, date_format(i.fecha,'%d-%m-%Y') as fecha,u.nombre as usuario, s.nombre as sucursal
from inventario i,usuario u, sucursal s
where i.usuario_id=u.idusuario and
i.sucursal_id = s.idsucursal  and 
i.sucursal_id ='$sucur' and i.fecha between '$min' and '$max' and i.fecha between '$min' and '$max' ORDER BY i.idinventario desc");
}
else{
$max=date("Y-m-d");
$min=date("Y-m-d",strtotime($max."-10 days"));
$query= $db->GetAll("select i.turno,i.nro,i.total,i.estado,i.idinventario, i.nro,i.hora ,i.total, date_format(i.fecha,'%d-%m-%Y') as fecha,u.nombre as usuario, s.nombre as sucursal
from inventario i,usuario u, sucursal s
where i.usuario_id=u.idusuario and
i.sucursal_id = s.idsucursal  and 
i.sucursal_id ='$sucur' and i.fecha between '$min' and '$max' and i.fecha between '$min' and '$max' ORDER BY i.idinventario desc");
}

?>
<div class="container">
  <div class="left-sidebar">
  <h2> Listado de Inventario</h2>
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
                <th>Sucursal</th>
                <th>Turno</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Total</th>
                <th>Tipo</th>
                <th>Opciones</th>
           </tr>
        </thead>
        <tbody>
<?php $nro=0; foreach ($query as $r){ $nro=$nro+1; ?>
<tr   class=warning>
    <td><?php echo $r["nro"]; ?></td>
    <td><?php echo $r["sucursal"]; ?></td>
    <td><?php if($r["turno"]=='1'){echo "AM";}else{if($r["turno"]=='2'){echo "PM";}else{echo "null";}}; ?></td>
    <td><?php echo $r["usuario"]; ?></td>
    <td><?php echo $r["fecha"]; ?></td>
    <td><?php echo $r["hora"]; ?></td>
    <td><?php echo number_format($r["total"],2); ?></td>
    <td><?php if($r["estado"]!="semanal"){echo "diario";}else{echo $r["estado"];}; ?></td>
    <td style="width:210px;">
    <a href="#" data-toggle="modal"
                  data-target="#ver<?php echo $r["nro"];?>"><img src="../images/ver.png" alt="" title="ver detalle">Ver Detalle</a>
       <?php if($usuario['codigo_usuario']=='2304'||$usuario['codigo_usuario']=='0077GS') {?>           
   <a href="editar.php?nro=<?php echo $r["nro"];?>"><img src="../images/edit.png" alt="" title="Modificar">Edit</a>
         <?php }?>
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
where u.idunidad_medida=p.idunidad_medida and di.nro = $r[nro] and p.idproducto = di.producto_id and di.sucursal_id=".$sucur);

                    foreach ($consul as $key) { ?>
                     <div class="row" >
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
                    <div class="col-md-8">TOTAL</div>
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
  
  </div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    

    
  </div>
</div>  <!-- Start WOWSlider.com BODY section -->
<!-- End WOWSlider.com 
  BODY section -->
  </body>
</html>