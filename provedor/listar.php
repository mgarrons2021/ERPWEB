
 <html>
  <head>
    <title>LISTADO DE PROVEEDOR</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <link rel="stylesheet" href="../css/bootstrap.min.css"> 
<!--    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />

-->


    <!-- Start WOWSlider.com HEAD section -->
<!-- End WOWSlider.com HEAD section -->
    
   
   

    </head>
<body class="body">
  
<?php include"../menu/menu.php"; 
require_once '../config/conexion.inc.php';
   
    $ventas= $db->GetAll('select * from proveedor order by idproveedor desc');
    
$query = $ventas;
?>  
<div class="container">
  <div class="left-sidebar">
  <div class="row">
    <div class="col-md-1">
    <a href="nuevo.php" class="btn btn-primary" role="button"><strong>Nuevo Proveedor</strong><span class="glyphicon glyphicon-plus"></span></a>
     
    </div>
    <div class="col-md-10" align="center">
    
     <h2>Listado de Provedores Registrados</h2>
    </div>
    <div class="col-md-1">
      
    </div>
  </div>
  <br>

    <div class="table-responsive">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
<!--    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js">
    </script>
  <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
  <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
  <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

-->
    <script type="text/javascript">

       $(document).ready(function() {
    $('#usuario').DataTable( {
       /* dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'print',
            {
                extend: 'pdfHtml5',
                title: 'Reporte de ventas',
                message: 'listado de reporte de ventas',
                image: '404.png'
            }
        ],
        */
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

<table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
            <th>Nro</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Celular</th>
                 <th>Empreza</th>
                 <th>Nit</th>
               <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($query as $r){?>
<tr class=warning>
<td><?php echo $r["idproveedor"]; ?></td>
 <td><?php echo $r["codigo"]; ?></td>
  <td><?php echo $r["nombre"]; ?></td>
  <td><?php echo $r["celular"]; ?></td>
  <td><?php echo $r["empreza"]?></td>
  <td><?php echo $r["nit"]?></td>
  <td style="width:210px;">
    <a href="#" data-toggle="modal"
                  data-target="#verModal<?php echo $r["idproveedor"];?>"><img src="../images/ver.png" alt="" title="ver detalle">Ver</a>
    <a href="editar.php?idproveedor=<?php echo $r["idproveedor"];?>"><img src="../images/edit.png" alt="" title="Modificar">Edit</a>
    <a href="eliminar.php" id="del-<?php echo $r["idproveedor"];?>"><img src="../images/eliminar.jpg" alt="" title="eliminar"> eliminar</a>
    <script>
    $("#del-"+<?php echo $r["idproveedor"];?>).click(function(e){
      e.preventDefault();
      p = confirm("Estas seguro?");
      if(p){
        window.location="eliminar.php?idproveedor="+<?php echo $r["idproveedor"];?>;

      }

    });
    </script>
  </td>
    
 </tr>
 <div class="modal fade" id="verModal<?php echo $r["idproveedor"];?>"
                 data-backdrop="static" data-keyboard="false"
                 draggable="modal-header"
                 tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel" 
                 aria-hidden="true">
                
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">PROVEEDOR</h4>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-xs-4">Codigo: </div>
                          <div class="col-xs-8"><?php echo $r["codigo"];?></div>
                      </div>
                      <div class="row">
                          <div class="col-xs-4">Nombre: </div>
                          <div class="col-xs-8"> <?php echo $r["nombre"];?> &nbsp;</div> 
                          </div>                         
                      <div class="row">
                          <div class="col-xs-4">Celular: </div>
                          <div class="col-xs-8"><?php echo $r["celular"]; ?></div>                          
                      </div> 
                       <div class="row">
                          <div class="col-xs-4">Nombre Empreza: </div>
                          <div class="col-xs-8"><?php echo $r["empreza"]; ?></div>                          
                      </div> 
                      <div class="row">
                          <div class="col-xs-4">Nit: </div>
                          <div class="col-xs-8"><?php echo $r["nit"]; ?></div>                          
                      </div> 
                      <div class="row">
                          <div class="col-xs-4">Tipo de Categoria: </div>
                          <div class="col-xs-8"><?php echo $r["tipo_categoria"]; ?></div>                          
                      </div> 
                      <div class="row">
                          <div class="col-xs-4">Tipo de Credito : </div>
                          <div class="col-xs-8"><?php echo $r["tipo_credito"]; ?></div>                          
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