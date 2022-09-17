<html>
	<head>
		<title>Total Ventas</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
    </head>
<body class="body">
<?php 
require_once '../config/conexion.inc.php';
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
//$ids=$_GET["id"];
if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){
$min=$_GET["fechaini"];
$max=$_GET["fechamax"];
$query1= $db->GetAll("
select v.idturno,s.idsucursal, sum(v.total)as total, s.nombre as sucursal, COUNT(v.nro)as tt
from venta v, sucursal s
where v.estado='V' and v.sucursal_id=s.idsucursal and v.fecha
between '$min' and '$max' group by s.idsucursal 
");
}
else{
$min=date('Y-m-d');
$max=date('Y-m-d');
$query= $db->GetAll("
select v.idturno,s.idsucursal, sum(v.total)as total, s.nombre as sucursal, COUNT(v.nro)as tt
from venta v, sucursal s
where v.estado='V' and v.sucursal_id=s.idsucursal and v.fecha
between '$min' and '$max' group by s.idsucursal");
}
function am_t($s,$t,$min_f,$max_f){
$conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
$query2="select v.idturno,v.idturno,sum(v.total)as total
from venta v, sucursal s
where v.estado='V' and sucursal_id=$s and turno=$t and v.sucursal_id=s.idsucursal and v.fecha
between '$min_f' and '$max_f' group by s.idsucursal";
$resultado = $conexion->query($query2);
foreach ($resultado as $r){
$total=$r["total"];
}
return $total;
}
function pm_t_h($s,$t,$min_f,$max_f,$min_h,$max_h){
$conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
$query2="select v.idturno,v.idturno,sum(v.total)as total
from venta v, sucursal s
where v.estado='V' and sucursal_id=$s and turno=$t and v.sucursal_id=s.idsucursal and v.fecha
between '$min_f' and '$max_f' and v.hora between '$min_h' and '$max_h' group by s.idsucursal";
$resultado = $conexion->query($query2);
foreach ($resultado as $r){
$total=$r["total"];
}
return $total;
}
function am_t_i($s,$t,$min_f,$max_f){
$conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
$query2="select v.idturno,sum(v.total)as total
from venta v, sucursal s
where v.estado='V' and sucursal_id=$s and turno=$t and v.sucursal_id=s.idsucursal and v.fecha
between '$min_f' and '$max_f' group by s.idsucursal";
$resultado = $conexion->query($query2);
foreach ($resultado as $r){
$idturno=$r["idturno"];
}
return $idturno;
}
function pm_t($s,$t,$min_f,$max_f,$min_h,$max_h){
$conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
$query2="select v.idturno,sum(v.total)as total
from venta v, sucursal s
where v.estado='V' and sucursal_id=$s and turno=$t and v.sucursal_id=s.idsucursal and v.fecha
between '$min_f' and '$max_f' and v.hora between '$min_h' and '$max_h' group by s.idsucursal";
$resultado = $conexion->query($query2);
foreach ($resultado as $r){
$total=$r["total"];
}
return $total;
}
function pm_t_i($s,$t,$min_f,$max_f){
$conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
$query2="select v.idturno,sum(v.total)as total
from venta v, sucursal s
where v.estado='V' and sucursal_id=$s and turno=$t and v.sucursal_id=s.idsucursal and v.fecha
between '$min_f' and '$max_f' group by s.idsucursal";
$resultado = $conexion->query($query2);
foreach ($resultado as $r){
$idturno=$r["idturno"];
}
return $idturno;
}
?>
<div class="container">
  <div class="left-sidebar">
  <h2>COMPARACION VENTAS</h2>
 <!-- aqui es el bonton de atras -->
  <!-- <a class="glyphicon glyphicon-arrow-left" href="env_dir.php">ATRAS</a>-->
   <!-- termina el boton de atraz --> 
   <a class="glyphicon glyphicon-arrow-left" href="./sales_report.php"><< Ventas por Sucursal</a>
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
    <script type="text/javascript">
       $(document).ready(function(){$("#usuario").DataTable({
           aLengthMenu:[
               [25,50,100,-1],
               [25,50,100,"All"]],
            language:{
         sProcessing:"Procesando...",
           sLengthMenu:"Mostrar _MENU_ registros",
           sZeroRecords:"No se encontraron resultados",
           sEmptyTable:"Ningun dato disponible en esta tabla",
           sInfo:"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
           sInfoEmpty:"Mostrando registros del 0 al 0 de un total de 0 registros",
           sInfoFiltered:"(filtrado de un total de _MAX_ registros)",sInfoPostFix:"",
           sSearch:"Buscar:",
           sUrl:"",
           sInfoThousands:",",
           sLoadingRecords:"Cargando...",
           oPaginate:{sFirst:"Primero",
           sLast:"Ãšltimo",
           sNext:"Siguiente",
           sPrevious:"Anterior"},
           oAria:{sSortAscending:": Activar para ordenar la columna de manera ascendente",
           sSortDescending:": Activar para ordenar la columna de manera descendente"}
              }})});
      </script>
<form action="">  
<div class="row"> 
<div class="col-md-7">  
<div class="input-daterange input-group" id="datepicker">  
 <!--<select class="form-control select-md" name="fecha" id="fecha" value="1">
                  <option  value="1">Por fecha solicitada</option>
                  <option value="2">Por fecha de envio</option>
     </select>-->
    <span class="input-group-addon"><strong>Fecha De:</strong> </span>
    <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" value="<?php echo $min; ?>" />
    <span class="input-group-addon">A</span>
    <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" value="<?php echo $max; ?>" />  
    <input  type = "hidden" id = "form_sent" name = "form_sent" value = "true" >
    <input  type = "hidden" id = "ids" name = "ids" value = "<?php echo $ids;?>" >
</div>
</div>
<div class="col-md-2">
<input class="form-control btn-success" type="submit" value="filtrar" id="filtrar" name="filtrar">
</div>
</div>
</form>
    <table id="usuario" class="table-bordered" cellspacing="1" style="width:350px">
        <thead>
            <tr>
                <!--<th>Hora</th>
                <th>Cod</th>
                 <th>Fecha Ped</th>-->
                 <th>Sucursal</th>
                 <th><?php echo date("Y-m-d",strtotime(date('Y-m-d')."- 7 days"));?></th>
                 <th>Total AM</th>
                  <th><?php echo date("Y-m-d",strtotime(date('Y-m-d')."- 7 days"));?></th>
                 <th>Total PM</th>
                 <th>Total</th>
                 <th>T.T</th>
                 <th>Tick. Prom</th>  
            </tr>
        </thead>
        <tbody>
<?php 
$c=0;
$total=0;
$tt=0;
foreach ($query1 as $r){ $c=$c+1; $total=$total+$r["total"];$tt=$tt+$r["tt"]; ?>
<tr class=warning>
    <td><?php echo $r["sucursal"]; ?></td>
    
    <td><?php echo "";?></td>
    
    <td><?php $n1=1; $turno_am=number_format(am_t($r["idsucursal"],'1',$min,$max),2); $am_idturno=am_t_i($r["idsucursal"],1,$min,$max);
    echo "<a href='../turno/pdfturno.php?nro=$n1&idturno=$am_idturno'>$turno_am</a>"; ?></td>
    
    <td><?php $h_actual=date("H:i:s");  $pm_t_h=number_format(pm_t_h($r["idsucursal"],'2',$min,$max,"00:00:00",$h_actual),2); echo $pm_t_h;?></td>
    
    <td><?php $n2=2; 
    $fecha_anterior=date("Y-m-d",strtotime($min."- 7 days")); 
    $turno_pm=number_format(pm_t($r["idsucursal"],'2',$fecha_anterior,$fecha_anterior,"00:00:00",date("H:i:s")),2); 
    $pm_idturno=pm_t_i($r["idsucursal"],2,$min,$max);
       echo "<a href='../turno/pdfturno.php?nro=$n2&idturno=$pm_idturno'>$turno_pm</a>";   ?></td>
       
    <td><?php echo number_format($r["total"],2); ?></td>
    <td><?php echo $r["tt"]; ?></td>
    <td><?php echo number_format(($r["total"]/$r["tt"]),2); ?></td>
</tr>
<?php 
}?>
  </table>
 <table id="usuario" class="table-bordered" cellspacing="1" style="width:350px">
   <tr>
       
   <td>Total Ventas</td>
   <td><?php echo $total." bs"; ?></td>
   <td><?php echo $tt; ?> </td>
   <td><?php echo number_format(($total/$tt),2); ?> </td>   
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