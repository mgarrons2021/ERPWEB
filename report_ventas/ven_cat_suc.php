<html>
	<head>
	<title>ventas cat</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
         <!-- Bootstrap CSS -->
    <!--font awesome con CDN-->  
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  
<script>
var f = new Date();
</script>
</head>
<body class="body">
<?php include"../menu/menu.php";
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$min=0;
$max=0;
if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){
$min=$_GET["fechaini"];
$max=$_GET["fechamax"];
$turno=$_GET['turn'];
}

function cat($sucur,$cat,$tur,$min,$max){
$total=0;
$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
$query="
SELECT  sum(dv.cantidad)as cantidad,sum(dv.subtotal)as subtotal,pre.categoria
FROM venta v, detalleventa dv,pre_pla pre
WHERE v.lugar!='DELIVERY' and v.estado='V' and dv.nro=v.nro and dv.idturno=v.idturno and dv.sucursal_id=pre.sucursal_id and dv.plato_id=pre.plato_id and dv.sucursal_id='$sucur' and pre.categoria='$cat' and v.turno='$tur' and v.fecha BETWEEN '$min' AND '$max' GROUP by pre.categoria
";
$resultado = $conexion->query($query);
foreach ($resultado as $r){
$total=$r["subtotal"];
}
return $total;
}

$categorias=$db->GetAll("SELECT * FROM `pre_pla` GROUP BY categoria");
if(isset($_POST["export_data"])){
 if(!empty($libros)){
 $filename = "libros.xls";
 header("Content-Type: application/vnd.ms-excel");
 header("Content-Disposition: attachment; filename=".$filename);
 $mostrar_columnas = false;
 
 foreach($ventas as $libro){
 if(!$mostrar_columnas){
 echo implode("\t", array_keys($libro)) . "\n";
 $mostrar_columnas = true;
 }
 echo implode("\t", array_values($libro)) . "\n";
 }
 }else{
 echo 'No hay datos a exportar';
 }
exit;
}
$query = $ventas;
$sucursal= $db->GetAll('select * from sucursal');
?>
<div class="container">
<div class="left-sidebar">
<h2>VENTAS POR CATEGORIA<br><?php echo "TURNO: "; if($_GET['turn']=='1'){echo "AM";}if($_GET['turn']=='2'){echo "PM";};?><br><h4><?php echo "Desde: ".$min." hasta ".$max;?></h4></h2>
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
<form action="">  
<div class="row"> 
<div class="col-md-7">  
<div class="input-daterange input-group" id="datepicker">  
 <select class="form-control select-md" name="turn" id="turn" >
     <option value="0"><?php if($_GET['turn']=='1'){echo "AM";}
     if($_GET['turn']=='2'){echo "PM";}if($_GET['turn']==''){echo "Seleccione Turno";}
      ?></option>
                  <option value="1">AM</option>
                  <option value="2">PM</option>
 </select>
    <span class="input-group-addon"><strong>De Fecha:</strong></span>
    <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" value="<?php if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){ echo $min ; }else{ echo date("Y-m-d");} ?>"/>
    <span class="input-group-addon">A</span>
    <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" value="<?php if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){ echo $max ; }else{ echo date("Y-m-d");} ?>"/>
    <input  type = "hidden" id = "form_sent" name = "form_sent" value = "true" >
</div>
</div>
<div class="col-md-1">
<input class="form-control btn-info" type="submit" value="Filtrar" id="filtrar" name="filtrar">
</div>
<!--<a type="buuton" id="expor_baucher" href="fis_pdf_tur.php" name='expor_baucher'
value="Exportar" class="btn btn-info">Exportar Baucher</a>
<a href="fis_pdf_tur.php?suc=<?php //echo $suc;?>&max=<?php //echo $max;?>&min=<?php //echo $min;?>">Exportar Baucher</a>-->
</div>
</div>
</form>
<div class="table-responsive">
<table id="example" class="table table-responsive table-striped table-bordered table-hover" cellspacing="" width="100px">
        <thead>
            <tr>
           <th>SUCURSAL</th>
                 <?php $contador=0; foreach ($categorias as $key ) {$contador=$contador+1; ?>
                 <th> <?php echo $key['categoria']; ?>  </th>  
                 <?php } ?>
            </tr>
        </thead>
      <!--  <tfoot>
              <tr>
            </tr>
        </tfoot> -->
        <tbody>
  <tr class=warning>
      <td><?php echo $contador;?><td>
      
  </tr>
  </table>
  </div>
  </div>
</div>
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="jquery/jquery-3.3.1.min.js"></script>
    <script src="popper/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- datatables JS -->
    <script type="text/javascript" src="datatables/datatables.min.js"></script>
    <!-- para usar botones en datatables JS -->  
    <script src="datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>  
    <script src="datatables/JSZip-2.5.0/jszip.min.js"></script>    
    <script src="datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
    <script src="datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
     
    <!-- código JS propìo-->    
    <script type="text/javascript" src="main.js"></script>  
</body>
</html>