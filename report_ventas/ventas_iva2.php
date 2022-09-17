<html>
	<head>
	<title>reporte ventas</title>
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
$suc=$_GET['selec_sucur'];
$ventas= $db->GetAll("SELECT v.*,v.fecha as fecha_v, c.* FROM venta v, cliente c WHERE v.sucursal_id='$suc' and nro_factura!='0' and v.cliente_id=c.idcliente and v.fecha between '$min' and '$max' order by v.fecha desc"); 
$idautorizacion=$db->GetOne("SELECT max(idautorizacion)as idautorizacion FROM auntorizacion  WHERE sucursal_id=$sucur and estado='si'");
$n_auto=$db->GetOne("SELECT n_auto FROM auntorizacion WHERE sucursal_id=$sucur and estado='si' and idautorizacion=$idautorizacion");
}
/*else{
$min=date("Y-m-d");
$max=date('Y-m-d');
$ventas= $db->GetAll("SELECT v.*, c.* FROM venta v, cliente c WHERE v.sucursal_id='1' and v.cliente_id=c.idcliente and v.fecha between '$min' and '$max' order by v.fecha desc");
$dat_sucur= $db->GetRow("SELECT * FROM `auntorizacion` WHERE sucursal_id='1' and estado='si'");
}*/
if(isset($_POST["export_data"])) {
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
}exit;}
$query = $ventas;
$sucursal= $db->GetAll('select * from sucursal');
?>
<div class="container">
<div class="left-sidebar">
<h2>Reportes de ventas <br><?php echo "De: ".$db->GetOne("SELECT nombre FROM sucursal WHERE idsucursal=$suc");?><br><h4><?php echo "Desde: ".$min." hasta ".$max;?></h4></h2>
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
 <select class="form-control select-md" name="selec_sucur" id="selec_sucur" >
     <option value="0">seleccione una surcursal</option>
     <?php foreach ($sucursal as $r){?>
                  <option value="<?php echo $r["idsucursal"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
 </select>
    <span class="input-group-addon"><strong>Fecha De:</strong> </span>
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
value="Exportar" class="btn btn-info">Exportar Baucher</a>-->
<a href="fis_pdf_tur.php?suc=<?php echo $suc;?>&max=<?php echo $max;?>&min=<?php echo $min;?>">Exportar Baucher</a>
</div>
</div>
</form> 


<div class="table-responsive">
<table id="example" class="table table-responsive table-striped table-bordered table-hover" cellspacing="" width="100px">
        <thead>
            <tr>
           <th>Especi-<br>ficacion</th>  
           <th>Nro</th>
           <th>Fecha</th>
           <th>No. de factura</th>
           <th>No. de autorizacion</th>
               <th>Estado</th>
               <th>No. Nit/Ci del cliente</th>
               <th>Nombre o razon social</th>
               <th>Importe total venta (factura)</th>
               <th>IMPTE, ICE ,IEHD, TASAS Y/O CONT. INCLUIDAS EN VENTAS</th>
               <th>Exportac. y Operaciones Excentos</th>
               <th>Ventas Gravadas a tasa cero</th>
               <th>Sub Total</th>
               <th>Desctos, Bonific, y Rebajas Otorgadas</th>
               <th>Importe base para Debito fiscal</th>
               <th>Debito Fiscal Iva 13%</th>
               <th>codigo de control</th>
            </tr>
        </thead>
      <!--  <tfoot>
              <tr>
            </tr>
        </tfoot> -->
        <tbody>
<?php $c=0; $total=0;  $total2=0;foreach ($query as $r){ $c=$c+1; if($r["estado"]!="A"){$total=$total+$r["total"];}else{$total2=$total2+$r["total"];}?>
  <tr class=warning>
      <td><?php echo "3"; ?></td>
      <td><?php echo $c; ?></td>
    <td><?php echo $r["fecha_v"];?></td> 
    <td><?php echo $r["nro_factura"];?></td>
      <td><?php echo $db->GetOne("SELECT n_auto FROM auntorizacion WHERE idautorizacion=$r[autorizacion_id]");?></td>
    <td><?php echo $r["estado"];  ?></td>
  <td><?php echo $r["nit_ci"];?></td>
  <td><?php if($r["nit_ci"] == '0'){echo "Sin nombre"; }{ echo $r["nombre"];}?></td>
  <td><?php echo number_format($r["total"],2);?></td>
  <td><?php echo "0,00";?></td>
  <td><?php echo "0,00";?></td>
  <td><?php echo "0,00";?></td>
  <td><?php echo number_format($r["total"],2);?></td>
  <td><?php echo "0,00";?></td>
   <td><?php echo number_format($r["total"],2);?></td>
  <td><?php echo number_format((($r["total"]*13)/100),2);?></td>
   <td><?php echo $r["cod_control"];?></td>
  </tr>
  <?php }?>
  </table>
  <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
   <tr>
   <td><h4>Total anulados</h4></td><td><h4> <?php echo number_format($total2,2)." bs"; ?></h4>
   </td>
   <td><h4>Total ventas fiscales</h4></td><td><h4> <?php echo number_format($total,2)." bs"; ?></h4>
   </td>
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