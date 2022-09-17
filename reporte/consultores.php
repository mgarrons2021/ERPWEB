<html>
	<head>
		<title>consultores</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">

    <!-- Start WOWSlider.com HEAD section -->
<!-- End WOWSlider.com HEAD section -->


<script>
var f = new Date();

</script>
    </head>
<body class="body">

<?php include"../menu/menu.php";

    $ventas= $db->GetAll("select u.id as id,u.cod as cod, concat(p.nombre,' ',p.ap_pat,' ',p.ap_mat) as per,date_format(u.fecha,'%d-%m-%Y') as fecha,p.ci,
                    u.usuario, u.clave, u.estado, u.cod, r.nombre as rol ,pe.saldo
                    from usuario u, persona p, rol r ,pedido pe
                    where p.id = u.persona_id and
                          r.id = u.rol_id and
                          pe.usuario_id=u.id and
                          r.id = 3 order by u.id desc");
    
$query = $ventas;
?>
<div class="container">
  <div class="left-sidebar">
  <h2>Reportes de consultores</h2>


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
                title: 'Reporte de Consultores',
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
<table id="usuario2" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
            <th>Fecha de Registro</th>
              <th>Ci</th>
              <th>Nombre y apellido</th>
                <th>Usuario</th>
                <th>Saldo</th>
                <th>Codigo</th>
                <th>Estado</th>




            </tr>

        </thead>
        <tfoot>
              <tr>
              <th>fecha</th>
               <th>Ci</th>
              <th>Nombre y apellido</th>
                <th>usuario</th>
                <th>Saldo</th>
                <th>Codigo</th>
                <th>estado</th>




            </tr>
            </tfoot>
        <tbody>

<?php foreach ($query as $r){?>
  <tr class=warning>
  <td><?php echo $r["fecha"];?></td>
  <td><?php echo $r["ci"];?></td>
  <td><?php echo $r["per"];?></td>
  <td><?php echo $r["usuario"];?></td>
   <td><?php  if ($r["saldo"]>0)
                    {
                  echo  $r["saldo"]."  Deudor";
                    }
                    else{
                   echo  $r["saldo"];
                    }
                     ?></td>
  <td><?php echo $r["cod"];?></td>
  <td><?php echo $r["estado"];?></td>



  </tr>
  <?php }?>

  </table>
  </div>
  </div>
</div>  <!-- Start WOWSlider.com BODY section -->
<!-- End WOWSlider.com  BODY section -->
  </body>
</html>