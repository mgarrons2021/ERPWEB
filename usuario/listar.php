<html>
  <head>
    <title>LISTADO DE USUARIOS</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- Start WOWSlider.com HEAD section -->
<!-- End WOWSlider.com HEAD section -->
</head>
<body class="body">
  
<?php include"../menu/menu.php"; 
require_once '../config/conexion.inc.php';
$ventas= $db->GetAll("
SELECT u.idusuario, u.codigo_usuario, u.nombre ,u.celular, u.direccion ,u.correo, u.estado, u.fecha, 
r.nombre as nombrerol, 
s.nombre as nombresucursal

FROM usuario u, rol r, sucursal s
where u.rol_id=r.idrol and
      u.sucursal_id=s.idsucursal
order by u.idusuario desc ");                   
$query = $ventas;

?>  
<div class="container">
  <div class="left-sidebar">
  <div class="row">
    <div class="col-md-1">
    <a href="nuevo.php" class="btn btn-primary" role="button"><strong>Nuevo Usuario</strong><span class="glyphicon glyphicon-plus"></span></a>
     
    </div>
    <div class="col-md-10" align="center">
    
     <h2>Listado de Usuarios Registrados</h2>
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
              <th>codigo</th>
              <th>Nombre</th>
                <th>Celular</th>
                <th>Direccion</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>fecha de Registro</th>
                
                <th>Rol</th>
                <th>Sucursal</th>
               <th>Opciones</th>
            </tr>
        </thead>
        <tbody>

<?php foreach ($query as $r){?>
  <tr class=warning>
   <td><?php echo $r["codigo_usuario"];?></td>
  <td><?php echo $r["nombre"];?></td>
  <td><?php echo $r["celular"];?></td>
  <td><?php echo $r["direccion"];?></td>
  <td><?php echo $r["correo"];?></td>
  <td><?php echo $r["estado"];?></td>
  <td><?php echo $r["fecha"];?></td>
 
  <td><?php echo $r["nombrerol"];?></td>
  <td><?php echo $r["nombresucursal"];?></td>
  <td style="width:210px;">
    <a href="#" data-toggle="modal"
                data-target="#verModal<?php echo $r["idusuario"];?>"><img src="../images/ver.png" alt="" title="ver detalle">Ver</a>
    <a href="editar.php?ids=<?php echo $r["idusuario"];?>"><img src="../images/edit.png" alt="" title="Modificar">Edit</a>
    <?php if ($r["estado"] == 'activo') { ?>
                    <a href="./estado.php?id=<?php echo $r["idusuario"];?>"
                    onclick ="return confirm('&iquest;Esta Seguro Dar de Baja?')" >
                        <img src="../images/alta.png" alt="" title="DAR DE BAJA">Baja
                     </a>
                       <?php
                   } else {
                       ?>
                    <a href="./estado.php?id=<?php echo $r["idusuario"];?> "
                    onclick ="return confirm('&iquest;Esta Seguro Dar de Alta?')">
                    <img src="../images/baja.png" alt="" title="DAR DE ALTA">Alta
                    </a>
       <?php } ?>

    <script>
    $("#del-"+<?php echo $r["idusuario"];?>).click(function(e){
      e.preventDefault();
      p = confirm("Estas seguro?");
      if(p){
        window.location="eliminar.php?idusuario="+<?php echo $r["idusuario"];?>;
      }
    });
    </script>
  </td>
  </tr>

  <div class="modal fade" id="verModal<?php echo $r["idusuario"];?>"

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
                          <div class="col-xs-8"><?php echo $r["nombre"]; ?></div>                          
                      </div> 
                      <div class="row">
                          <div class="col-xs-4">Usuario: </div>
                          <div class="col-xs-8"><?php echo $r["codigo_usuario"];?></div>
                      </div>
                      <div class="row">
                          <div class="col-xs-4">Celular: </div>
                          <div class="col-xs-8"><?php echo "celular";?> &nbsp;</div>                          
                      </div>
                      <div class="row">
                          <div class="col-xs-4">Direccion: </div>
                          <div class="col-xs-8"><?php echo "direccion";?> &nbsp;</div>                          
                      </div>
                        <div class="row">
                          <div class="col-xs-4">estado: </div>
                          <div class="col-xs-8"><?php echo $r["estado"];?></div>                          
                      </div>

                      <div class="row">
                          <div class="col-xs-4">Rol: </div>
                          <div class="col-xs-8"><?php echo $r["nombrerol"]; ?></div>                          
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