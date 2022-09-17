<html>
	<head>
		<title>Pedidos Acumulados</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="../js/jquery.js"></script>
   <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">	
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
  </head>
<body class="body">
<?php include"../menu/menu.php"; 
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
?>
 <div class="container">
  <div class="left-sidebar">
   <h2>listado de pedidos enviados acumulados</h2>
 <h4><?php if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){echo "Fecha de envio: ".$_GET["fechaini"]." a ".$_GET["fechamax"];}else{echo "De: ".date("Y-m-d")." a ".date("Y-m-d");}?></h4>
<div class="table-responsive">
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
    <script type="text/javascript">
       $(document).ready(function(){$("#usuario").DataTable({language:{sProcessing:"Procesando...",sLengthMenu:"Mostrar _MENU_ registros",sZeroRecords:"No se encontraron resultados",sEmptyTable:"Ningun dato disponible en esta tabla",sInfo:"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",sInfoEmpty:"Mostrando registros del 0 al 0 de un total de 0 registros",sInfoFiltered:"(filtrado de un total de _MAX_ registros)",sInfoPostFix:"",sSearch:"Buscar:",sUrl:"",sInfoThousands:",",sLoadingRecords:"Cargando...",oPaginate:{sFirst:"Primero",sLast:"Ãšltimo",sNext:"Siguiente",sPrevious:"Anterior"},oAria:{sSortAscending:": Activar para ordenar la columna de manera ascendente",sSortDescending:": Activar para ordenar la columna de manera descendente"}}})});
      </script>
  <form action="">  
<div class="row"> 
<div class="col-md-6">  
<div class="input-daterange input-group" id="datepicker">  
    <span class="input-group-addon"><strong>Fecha De:</strong> </span>
    <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" />
    <span class="input-group-addon">A</span>
    <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" />  
    <input  type = "hidden" id = "form_sent" name = "form_sent" value = "true" >
</div>
</div>
<div class="col-md-2">
<input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
</div>
</div>
</form>  
<br>
<?php if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){
$min=$_GET["fechaini"];
$max=$_GET["fechamax"];
$query = $db->GetAll("SELECT s.nombre as sucursal, sum(ROUND(p.total_envio,2))as total_insumos, sum(ROUND(p.total_envio2,2))as total_produccion 
FROM pedido p,sucursal s 
WHERE p.sucursal_id=s.idsucursal and p.Fecha_e between '$min' and '$max' GROUP BY p.sucursal_id");
}
else{
$min=date("Y-m-d");
$max=date("Y-m-d");
$query= $db->GetAll("SELECT s.nombre as sucursal, sum(ROUND(p.total_envio,2))as total_insumos, sum(ROUND(p.total_envio2,2))as total_produccion 
FROM pedido p,sucursal s 
WHERE p.sucursal_id=s.idsucursal and p.Fecha_e between '$min' and '$max' GROUP BY p.sucursal_id");
}
  ?>
    <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Sucursal</th>
                <th>Total Insumos</th>
                <th>Total Produccion</th>
            </tr>
        </thead>
    <tbody>
<?php $nro=0; $total=0; $total2=0; foreach ($query as $r){$nro=$nro+1; $total=$total+$r["total_insumos"]; $total2=$total2+$r["total_produccion"];?>
<tr   class=warning>
    <td><?php echo $r['sucursal']; ?></td>
    <td><?php echo $r["total_insumos"]." bs"; ?></td>  
    <td><?php echo $r["total_produccion"]." bs"; ?></td> 
  </tr>
 <?php }?>
  </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
   <tr>
   <td><h4>Total Insumos</h4></td><td><h4> <?php echo number_format($total,2)." bs"; ?></h4>
   </td>
    <td><h4>Total Produccion</h4></td><td><h4> <?php echo number_format($total2,2)." bs"; ?></h4>
   </td>
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
<script type="text/javascript">
$("#filtrar").on("click",function(){
fechainicio=document.getElementById("fechaini").value;
fechamax=document.getElementById("fechamax").value;
console.log("esta es la fecha:"+fechainicio+" y la fecha max:"+fechamax);
});
</script>