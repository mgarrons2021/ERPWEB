<html>
	<head>
		<title>USUARIOS</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">

<script>
var f = new Date();

</script>
    </head>
<body class="body">

<?php 
include"../menu/menu.php";

    $ventas= $db->GetAll("SELECT u.idusuario, u.codigo_usuario, u.nombre ,u.celular, u.direccion ,u.correo, u.estado, u.fecha, 
r.nombre as nombrerol, 
s.nombre as nombresucursal

FROM usuario u, rol r, sucursal s
where u.rol_id=r.idrol and
      u.sucursal_id=s.idsucursal
order by u.idusuario desc");
 
$query = $ventas;
?>
<div class="container">
  <div class="left-sidebar">
  <h2>Reportes de Usuarios</h2>
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
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js">
    </script>
  <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
  <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
  <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript">
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = Date.parse( $('#min').val(), 10 );
        var max = Date.parse( $('#max').val(), 10 );
        var age = Date.parse( data[0] ) || 0; // use data for the age column

        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && age <= max ) ||
             ( min <= age   && isNaN( max ) ) ||
             ( min <= age   && age <= max ) )
        {
            return true;
        }
        return false;
    }
);

$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#usuario2 tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    } );
    // DataTable
    var table = $('#usuario2').DataTable(
       {
        dom: 'Bfrtip',
        buttons: [
             'print',
            {
                extend: 'pdfHtml5',
                title: 'Reporte de usuarios',
                message: ''

            }
        ],
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
    "sPrevious": "Anterior",

  },
  "oAria": {
    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
  }
        }
    }
    ); // Apply the search
    table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );

} );

</script>
<div class="row">
<div class="col-md-6">
<div class="input-daterange input-group" id="datepicker">

    <span class="input-group-addon"><strong>Fecha De:</strong></span>
    <input type="text" id="min" class="input-sm form-control" name="start" />
    <span class="input-group-addon">A</span>
    <input type="text" id="max" class="input-sm form-control" name="end" />

</div>

</div>
</div>

<br>
<div class="table-responsive">
<table id="usuario2" class="table table-responsive table-striped table-bordered table-hover" cellspacing="" width="100px">
        <thead>
            <tr>
           <th>Fecha</th>  
              <th>Nombre y apellido</th>
                <th>Celular</th>
                <th>Direccion</th>
               <th>Rol</th>
               <th>Sucursal</th>
            </tr>
        </thead>
        <tfoot>
              <tr>
              <th>Fecha</th>
              <th>Nombre y apellido</th>
                <th>Celular</th>
                <th>Direccion</th>
               <th>Rol</th>
               <th>Sucursal</th>
            </tr>
            </tfoot>
        <tbody>
<?php foreach ($query as $r){?>
  <tr class=warning>
  <td><?php echo $r["fecha"];?></td>
  <td><?php echo $r["nombre"];?></td>
  <td><?php echo $r["celular"];?></td>
  <td><?php echo $r["direccion"];?></td>
  <td><?php echo $r["nombrerol"];?></td>
   <td><?php echo $r["nombresucursal"];?></td>
  </tr>
  <?php }?>
  </table>
  </div>
  </div>
</div>
</body>
</html>