<html>
  <head>
    <title>transacciones</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css"> 
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- Start WOWSlider.com HEAD section -->
<!-- End WOWSlider.com HEAD section -->
</head>
<body class="body">
  
<?php include"../menu/menu.php"; 
require_once '../config/conexion.inc.php';
$usuario =$_SESSION['usuario'];
$idusuario=$usuario['idusuario'];
$sucursal=$usuario['nombresucursal'];
$sucursal_id=$usuario['sucursal_id'];
$ventas= $db->GetAll("
SELECT reg.*, u.nombre as usuario,s.nombre as sucursal
FROM transacciones reg,usuario u, sucursal s
where reg.sucursal_id=s.idsucursal and reg.usuario_id=u.idusuario and reg.sucursal_id='$sucursal_id'
order by reg.fecha desc");                   
$query = $ventas;
$usuario =$_SESSION['usuario'];
$idusuario=$usuario['idusuario'];
$sucursal=$usuario['nombresucursal'];
$sucursal_id=$usuario['sucursal_id'];
?>  
<div class="container">
  <div class="left-sidebar">
  <div class="row">
    <div class="col-md-1">
    <a href="nuevo.php" class="btn btn-primary" role="button"><strong>Nuevo</strong><span class="glyphicon glyphicon-plus"></span></a>
     
    </div>
    <div class="col-md-10" align="center">
    
     <h2>transacciones <br><?php echo $sucursal;?></h2>
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
              <th>Fecha</th>
               <th>Sucursal</th>
                <th>Usuario</th>
                <th>Turno</th>
                <th>Total transacciones</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>

<?php foreach ($query as $r){?>
  <tr class=warning>
  <td><?php echo $r["fecha"];?></td>
   <td><?php echo $r["sucursal"];?></td>
   <td><?php echo $r["usuario"];?></td>
  <td><?php echo $r["turno"];?></td>
  <td><?php echo $r["total"];?></td>
   <td style="width:210px;">
    <a href="#" data-toggle="modal"
    data-target="#verModal<?php echo $r["idusuario"];?>"><img src="../images/ver.png" alt="" title="ver detalle">Ver</a>
    <a href="editar.php?id_v=<?php echo $r["idtransacciones"];?>"><img src="../images/edit.png" alt="" title="Modificar">Edit</a>
    <a href="eliminar.php?id=<?php echo $r["idtransacciones"];?>"><img src="../images/eliminar.jpg" alt="" title="eliminar"> eliminar</a>
  </td>
  </tr>
 <?php }?>       
  </table>
  </div>  
  </div>
</div>  <!-- Start WOWSlider.com BODY section -->
<!-- End WOWSlider.com 
  BODY section -->
  </body>
</html>