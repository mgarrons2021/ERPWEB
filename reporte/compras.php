<html>
	<head>
		<title>compras</title>
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
   
     $ventas= $db->GetAll("select c.nro, c.total, c.fecha,u.nombre as usuario, p.empreza as proveedor, s.nombre as sucursal

from compra c,proveedor p,usuario u, sucursal s

where c.usuario_id = u.idusuario and 
c.proveedor_id = p.idproveedor and 
c.sucursal_id = s.idsucursal and 
c.sucursal_id = u.sucursal_id and 
c.sucursal_id = ".$usuario['sucursal_id']);

    $dc = $db->GetAll("select dc.*,p.nombre as producto 
                        from detallecompra dc,producto p 
                        where p.idproducto = dc.producto_id");

$query = $ventas;

?>	
<div class="container">
  <div class="left-sidebar">
  <h2>Reportes de compras</h2>


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
                title: 'Reporte de Compras',
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
   
    <span class="input-group-addon"><strong>Fecha De:</strong> </span>
    <input type="text" id="min" class="input-sm form-control" name="start" />
   <span class="input-group-addon">A</span>
    <input type="text" id="max" class="input-sm form-control" name="end" />
    
</div>

</div>
</div> 

<br>
<div class="table-responsive">
<table  id="usuario2" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
            
            <th>Fecha</th>
            <th>Sucursal</th>
             <th>Usuario</th>
              <th >Proveedor</th>
              <th>Productos </th>
                <th>Total</th>
                
               
                
                 
            </tr>
            
        </thead>
        <tfoot>
              <tr>
              
              <th>fecha</th>
                <th>Sucursal</th>
              <th>Usuario</th>
             <th>Proveedor</th>
             <th>Producto</th>
                <th>Total</th>
                
                
               
               
               
            </tr>
            </tfoot>
        <tbody>

<?php $total=0; foreach ($query as $r){?>
  <tr class=warning>
  
  <td><?php echo $r["fecha"];?></td>
  <td><?php echo $r["sucursal"];?></td>
  <td><?php echo $r["usuario"];?></td>
  <td><?php echo $r["proveedor"];?></td>
  <td><?php
  foreach ($dc as $d) {
  if ($r["nro"]==$d["nro"]) {
    echo "- ";
    echo $d["producto"];
    echo '</br>';# code...
  }}?>
  </td>
  <td><?php echo $r["total"]." bs."; $total=$total+$r["total"];  ?></td> 
   
  

  </tr>
  <?php }?>  
      
  </table>

  </div> 

<div class="table-responsive">
<table  id="usuario2" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
<td> <h4> Total Compras</h4></td><td> <h4><?php echo $total." bs."; ?></h4></td></tr>
</table>
</div>  
  </div>

</div>  <!-- Start WOWSlider.com BODY section -->
<!-- End WOWSlider.com  BODY section -->
  </body>
</html>