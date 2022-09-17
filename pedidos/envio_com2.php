<html>
	<head>
		<title>Pedidos Produccion </title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
    </head>
<body class="body">
<?php include"../menu/menu.php";
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){
$min=$_GET["fechaini"];
$max=$_GET["fechamax"];
$query2= $db->GetAll("select s.idsucursal,p.idproducto,p.nombre as produccion, sum(dt.cantidad)as kG
from detallepedido dt,pedido t, sucursal s,producto p
where p.idcategoria=2 and p.idproducto=dt.producto_id
and t.sucursal_id=dt.sucursal_id and dt.nro=t.nro
and t.sucursal_id=s.idsucursal and t.fecha_p between '$min'
and '$max' GROUP BY p.idproducto");
$query3= $db->GetAll("select s.idsucursal,s.nombre as sucursal,p.idproducto,p.nombre as produccion, sum(dt.cantidad)as kG
from detallepedido dt,pedido t, sucursal s,producto p
where p.idcategoria=2 and p.idproducto=dt.producto_id
and t.sucursal_id=dt.sucursal_id and dt.nro=t.nro
and t.sucursal_id=s.idsucursal and t.fecha_p between '$min'
and '$max' GROUP BY s.idsucursal");
}
else{
$min=date("Y-m-d",strtotime(date('Y-m-d')."- 1 days"));
$max=date("Y-m-d",strtotime(date('Y-m-d')."- 1 days"));
$query2= $db->GetAll("select s.idsucursal,p.idproducto,p.nombre as produccion, sum(dt.cantidad)as kG
from detallepedido dt,pedido t, sucursal s,producto p
where p.idcategoria=2 and p.idproducto=dt.producto_id
and t.sucursal_id=dt.sucursal_id and dt.nro=t.nro
and t.sucursal_id=s.idsucursal and t.fecha_p between '$min'
and '$max' GROUP BY p.idproducto");
$query3= $db->GetAll("select s.idsucursal,s.nombre as sucursal,p.idproducto,p.nombre as produccion, sum(dt.cantidad)as kG
from detallepedido dt,pedido t, sucursal s,producto p
where p.idcategoria=2 and p.idproducto=dt.producto_id
and t.sucursal_id=dt.sucursal_id and dt.nro=t.nro
and t.sucursal_id=s.idsucursal and t.fecha_p between '$min'
and '$max' GROUP BY s.idsucursal");
}
function verificar($sucur,$idproducto){
$conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
  $cantidad=0;
  if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){
    $min=$_GET["fechaini"];
    $max=$_GET["fechamax"];
$query3="select p.idproducto,u.nombre as um,dt.cantidad ,p.nombre as producto from unidad_medida u,detallepedido dt,pedido t,producto p where p.idunidad_medida=u.idunidad_medida and dt.sucursal_id=t.sucursal_id and dt.nro=t.nro and dt.producto_id=p.idproducto and dt.producto_id=$idproducto and dt.sucursal_id=$sucur and t.fecha_p between '$min' and '$max'";
$resultado = $conexion->query($query3);
foreach ($resultado as $r){
  $cantidad=$r["cantidad"]." ".$r["um"];}
}
else{
$min=date("Y-m-d",strtotime(date('Y-m-d')."- 1 days"));
$max=date("Y-m-d",strtotime(date('Y-m-d')."- 1 days"));
$query3="select p.idproducto,u.nombre as um,dt.cantidad ,p.nombre as producto from unidad_medida u,detallepedido dt,pedido t,producto p where p.idunidad_medida=u.idunidad_medida and dt.sucursal_id=t.sucursal_id and dt.nro=t.nro and dt.producto_id=p.idproducto and dt.producto_id=$idproducto and dt.sucursal_id=$sucur and t.fecha_p between '$min' and '$max'";
$resultado = $conexion->query($query3);
foreach ($resultado as $r){
$cantidad=$r["cantidad"]." ".$r["um"];}
}
return $cantidad;
}

?>
<div class="container">
  <div class="left-sidebar">
  <h2>Programacion de envios de comida CDP a tiendas cabernet</h2>
  <h2><?php if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){
   echo "De: ".$_GET["fechaini"]." a ".$_GET["fechamax"];
  }else{
    echo "De: ".date("Y-m-d",strtotime(date('Y-m-d')."- 1 days"))." a ".date("Y-m-d",strtotime(date('Y-m-d')."- 1 days"));
  }?></h2>
    <div class="table-responsive">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
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
       $(document).ready(function(){$("#usuario").DataTable({language:{sProcessing:"Procesando...",sLengthMenu:"Mostrar _MENU_ registros",sZeroRecords:"No se encontraron resultados",sEmptyTable:"Ningun dato disponible en esta tabla",sInfo:"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",sInfoEmpty:"Mostrando registros del 0 al 0 de un total de 0 registros",sInfoFiltered:"(filtrado de un total de _MAX_ registros)",sInfoPostFix:"",sSearch:"Buscar:",sUrl:"",sInfoThousands:",",sLoadingRecords:"Cargando...",oPaginate:{sFirst:"Primero",sLast:"Ãšltimo",sNext:"Siguiente",sPrevious:"Anterior"},oAria:{sSortAscending:": Activar para ordenar la columna de manera ascendente",sSortDescending:": Activar para ordenar la columna de manera descendente"}}})});
      </script>
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
                title: 'Envio de produccion',
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
    <span class="input-group-addon"><strong>Fecha De:</strong> </span>
    <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" />
    <span class="input-group-addon">A</span>
    <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" />  
    <input  type = "hidden" id = "form_sent" name = "form_sent" value = "true" >
</div>
</div>
<div class="col-md-2">
<input class="form-control btn-success" type="submit" value="filtrar" id="filtrar" name="filtrar">
</div>
</div>
</form>  
<div class="table-responsive">
    <table id="usuario2" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                 <th>SUCURSAL</th>
                 <?php foreach ($query2 as $key ) {?>
                 <th> <?php echo $key['produccion']; ?>  </th>  
                 <?php } ?>
            </tr>
        </thead>
        <tbody>
<?php
foreach ($query3 as $suc ) {
?>
<tr class=warning>
     <td><?php echo $suc['sucursal']; ?></td>
    <?php foreach ($query2 as $key) {?>
  <td><?php echo verificar($suc['idsucursal'],$key['idproducto']); ?></td>
    <?php } ?> 
</tr>
<?php } ?>
<tr class=warning>
<td><h2><?php echo "Total"; ?></h2></td>
<?php foreach ($query2 as $key) { ?>
  <td><h4><?php echo number_format($key['kG'],2); ?></h4></td>
    <?php } ?> 
</tr>
  </table>
  </div>
  </div>
  </div>
</div>  
  </body>
</html>