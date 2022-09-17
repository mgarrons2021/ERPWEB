<html>
	<head>
		<title>USUARIOS</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">	
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    </head>
<body class="body">
  
<?php include"../menu/menu.php"; 
   
    $ventas= $db->GetAll("select                          v.nro, 
                                                          v.fecha, 
                         concat(c.nombre,' ',c.apellido) as cliente, 
                                                          v.total,
                          concat(p.nombre,' ',p.ap_pat) as vendedor
                            from ventas v, cliente c, usuario u,persona p
                            where c.id = v.cliente_id and
                               p.id = u.persona_id and
                               u.id = v.usuario_id");
    
$query = $ventas;
?>	
<div class="container">
  <div class="left-sidebar">
  <h2>listado de ventas</h2>

<div class="table-responsive">
<script src="../js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../data/librerias/calendario/css/calendario.css">
  <script type="text/javascript" src="../data/librerias/calendario/js/jquery.js"></script>
  <script type="text/javascript" src="../data/librerias/calendario/js/calendario.js"></script>
  <script type="text/javascript">
  $(function(){
      $("#min").datepicker({dateFormat:"yy-mm-dd"});
    })
  
    $(function(){
      $("#max").datepicker({dateFormat:"yy-mm-dd"});
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
    $('#usuario tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    } );
    // DataTable
    var table = $('#usuario').DataTable(
       {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'print',
            {
                extend: 'pdfHtml5',
                title: 'Reporte de ventas',
                message: 'listado de reporte de ventas',
                image: '404.png'
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
    "sPrevious": "Anterior"
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
<table border="0" cellspacing="5" cellpadding="5">
        <tbody><tr>
            <td>Minimum age:</td>
            <td><input type="text" id="min" name="min"></td>
        </tr>
        <tr>
            <td>Maximum age:</td>
            <td><input type="text" id="max" name="max"></td>
        </tr>
    </tbody></table>

<table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Recibo</th>
                <th>fecha</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>vendedor</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Recibo</th>
                <th>fecha</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>vendedor</th>
            </tr>
        </tfoot>
        <tbody>
<tr>
  <td>2016-09-28</td>
  <td>hjhjhj </td>
  <td>rider</td>
  <td>jhjhjhj</td>
  <td>klkkkl</td>
</tr> 
<tr>
  <td>2016-09-27</td>
  <td>hjhjhj </td>
  <td>rider</td>
  <td>jhjhjhj</td>
  <td>klkkkl</td>
</tr> 
<tr>
  <td>2016-09-26</td>
  <td>hjhjhj </td>
  <td>kjkjkj</td>
  <td>jhjhjhj</td>
  <td>klkkkl</td>
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