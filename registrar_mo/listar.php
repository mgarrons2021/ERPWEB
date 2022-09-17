<html>
  <head>
    <title>Indicadores de eficiencia en linea</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css"> 
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- Start WOWSlider.com HEAD section -->
<!-- End WOWSlider.com HEAD section -->
</head>
<body class="body">
<div class="container">
  <div class="left-sidebar">
  <div class="row">
    <div class="col-md-1">
    <a href="nuevo.php" class="btn btn-primary" role="button"><strong>Nuevo</strong><span class="glyphicon glyphicon-plus"></span></a>
    </div>
    <div class="col-md-10" align="center">
     <h2>Indicadores de eficiencia en linea</h2>
     
    <div class="table-responsive"  style="overflow-x: hidden;">
    <br />
    <div class="row">
     <div class="input-daterange">
      <div class="col-md-4">
       <input type="text" name="start_date" id="start_date" class="form-control" />
      </div>
      <div class="col-md-4">
       <input type="text" name="end_date" id="end_date" class="form-control" />
      </div>      
     </div>
     <div class="col-md-4">
      <input type="button" name="search" id="search" value="Buscar" class="btn btn-info active" />
     </div>
    </div>
    </div>
      <br>    
   
    <div class="col-md-1">
    </div>
  </div>
  <br>
<div class="table-responsive">
<script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
   <script type="text/javascript">
   
       $(document).ready(function() {
    $('#usuario1').DataTable( {
        
        "language": {
            "sProcessing":     "Procesando...",
  "sLengthMenu":     "Mostrar _MENU_ registros",
  "sZeroRecords":    "No se encontraron resultados",
  "sEmptyTable":     "Ningun dato disponible en esta tabla",
  "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
  "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
  "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
  "sInfoPostFix":    "",
  "sSearch":         "Buscar:",
  "sUrl":            "",
  "sInfoThousands":  ",",
  "sLoadingRecords": "Cargando...",
  "oPaginate": {
    "sFirst":    "Primero",
    "sLast":     "Ãšltimo",
    "sNext":     "Siguiente",
    "sPrevious": "Anterior"
  },
  "oAria": {
    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
  }
        }
     } );
} );
    </script>
    <table id="usuario1" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
              <th>Fecha</th>
              <th>Ventas</th>
              <th>Horas Trabajadas</th>
              <th>Total Bs Hrs Trab</th>
              <th>% M.O.</th>
              </tr>
        </thead>
        <tbody>
        
            

<?php 

require_once '../config/conexion.inc.php';
$query="select r.* ,s.nombre
from registrar r,sucursal s where r.sucursal_id=s.idsucursal  ";   

foreach (mysqli_query($query) as $r){?>
  <tr class=warning>
  <td><?php echo $r["fecha"];?></td>
  <td><?php echo $r["ventas"]." Bs";?></td>
  <td><?php echo $r["horas"];?></td>
  <td><?php echo $r["totalhoras"]." Bs";?></td>
  <td><?php echo $r["porcentaje"]." %";?></td>
  </tr>

  <div class="modal fade" id="verModal<?php echo $r["id"];?>"

                 data-backdrop="static" data-keyboard="false"
                 draggable="modal-header"
                 tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel" 
                 aria-hidden="true">
                
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">DETALLE DE USUARIO</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                          <div class="col-xs-4">Nombre </div>
                          <div class="col-xs-8"><?php echo $r["per"]; ?></div>                          
                      </div> 
                      <div class="row">
                          <div class="col-xs-4">Usuario: </div>
                          <div class="col-xs-8"><?php echo $r["usuario"];?></div>
                      </div>
                      <div class="row">
                          <div class="col-xs-4">Clave: </div>
                          <div class="col-xs-8"><?php echo "******";?> &nbsp;</div>                          
                      </div>
                        <div class="row">
                          <div class="col-xs-4">estado: </div>
                          <div class="col-xs-8"><?php echo $r["estado"];?></div>                          
                      </div>

                      <div class="row">
                          <div class="col-xs-4">Rol: </div>
                          <div class="col-xs-8"><?php echo $r["rol"]; ?></div>                          
                      </div>

                         <div class="row">
                          <div class="col-xs-4">fecha: </div>
                          <div class="col-xs-8"><?php echo $r["fecha"]; ?></div>                          
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