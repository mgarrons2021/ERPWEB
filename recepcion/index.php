<html>
	<head>
		<title>Recepcion</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">	
    
    </head>
<body class="body">
  
<?php include"../menu/menu.php"; 
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id']; 
$ventas= $db->GetAll("select t.*, date_format(t.fecha,'%d-%m-%Y') as fecha, u.nombre as usuario
from traspaso t,usuario u 
where t.usuario_id=u.idusuario and t.sucursal_idtraspaso ='$sucur'
");
$query = $ventas;
?>	
<div class="container">
  <div class="left-sidebar">
  <h2>Listado de Recepcion</h2>

    <div class="table-responsive">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">

       $(document).ready(function(){$("#usuario").DataTable({language:{sProcessing:"Procesando...",sLengthMenu:"Mostrar _MENU_ registros",sZeroRecords:"No se encontraron resultados",sEmptyTable:"Ningun dato disponible en esta tabla",sInfo:"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",sInfoEmpty:"Mostrando registros del 0 al 0 de un total de 0 registros",sInfoFiltered:"(filtrado de un total de _MAX_ registros)",sInfoPostFix:"",sSearch:"Buscar:",sUrl:"",sInfoThousands:",",sLoadingRecords:"Cargando...",oPaginate:{sFirst:"Primero",sLast:"Ãšltimo",sNext:"Siguiente",sPrevious:"Anterior"},oAria:{sSortAscending:": Activar para ordenar la columna de manera ascendente",sSortDescending:": Activar para ordenar la columna de manera descendente"}}})});
      </script>

    <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nro</th>
                 <th>Fecha</th>
                 <th>Usuario</th>
                <th>De Sucursal</th>
                <th>Descripcion</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($query as $r){?>
<tr   class=warning>
  <td><?php echo $r["nro"]; ?></td>
  <td><?php echo $r["fecha"]; ?></td>
    <td><?php echo $r["usuario"]; ?></td>
     <td><?php echo $db->GetOne('SELECT nombre FROM sucursal where idsucursal = '.$r['sucursal_id']); ?></td>
 
    <td><?php echo $r["descripcion"]; ?></td>
    
  <td style="width:210px;">
    <a href="#" data-toggle="modal"
                  data-target="#ver<?php echo $r["nro"];?>"><img src="../images/ver.png" alt="" title="ver detalle">Ver Detalle</a>
    <?php 
    echo "<a class='' href='#?nro=$r[nro]' 
   target='_blank' role='button'><img src='#' alt=''><!--PDF--></a>";
     ?>
       <?php if ($r["estado"] == 'si') { ?>
                    <a href="#" style="color:#31C23F"
                     >
                        <img src="../images/alta.png" alt="" title="Aceptado">Aceptado
                     </a>
                       <?php
                   }else{
                       ?>
                    <a href="./estado.php?id=<?php echo $r["idtraspaso"];?> " style="color:#ff8000"
                    onclick ="return confirm('&iquest;Esta Seguro de aceptar los envios?')">
                    <img src="../images/baja.png" alt=""  title="Aceptar" >Aceptar
                    </a>
       <?php } ?>

  </td>
  </tr>

 <div class="modal fade" id="ver<?php echo $r["nro"]; echo $r['sucursal_id'];?>"
                 data-backdrop="static" data-keyboard="false"
                 draggable="modal-header"
                 tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel" 
                 aria-hidden="true">
                
                 <div class="modal-dialog">
                 <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Detalle traspasos <?php echo $r["nro"]; ?></h4>
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
select p.idproducto, p.codigo_producto, p.nombre, dt.cantidad, p.precio_compra, dt.subtotal
from detalletraspaso dt,producto p 
where dt.nro = $r[nro] and  p.idproducto = dt.producto_id and dt.sucursal_id=$r[sucursal_id] and dt.sucursal_idtraspaso=$usuario[sucursal_id]");
?>
                   <?php  foreach ($consul as $key) { ?>
                    
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
                         <?php echo $key["precio_compra"]; ?>
                       </div>
                       <div class="col-md-2">
                         <?php echo $key["subtotal"]; ?>
                       </div>
                     </div>  
                    <?php } ?>
                    <br>
                    <div class="row panel panel-primary" >
                    <div class="col-md-10">TOTAL</div>
                    <div class="col-md-2">
                      <?php echo $r["total"]; ?>
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