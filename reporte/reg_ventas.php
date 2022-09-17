<html>
	<head>
		<title>ventas</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="../js/jquery.js"></script>
   <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">	
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
  </head>
<body class="body">
<?php include "../menu/menu.php"; 
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id']; 
?>
 <div class="container">
 <div class="col-md-1">
    <a href="det_reg_ventas.php" class="btn btn-primary" role="button"><strong>Detalles </strong><span class="glyphicon glyphicon-plus"></span></a>
    </div>
  <div class="left-sidebar">
   <h2>listado de ventas por sucursal</h2>
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
<?php 
function suc_am($sucur){
  $total=0;
  $conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');

   if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
    $min=$_GET["fechaini"];
    $max=$_GET["fechamax"];
    $query="SELECT sum(total)as total
    FROM reg_ventas 
    where  sucursal_id='$sucur' and turno='AM' and
    fecha between '$min' and '$max'"; 
    }
    else{
    $min=date("Y-m-d");
    $max=date("Y-m-d");
    $query="SELECT sum(total)as total
    FROM reg_ventas 
    where  sucursal_id='$sucur' and turno='AM' and
    fecha between '$min' and '$max'";  
    }
    $resultado = $conexion->query($query);
   foreach ($resultado as $r){
    $total=$r["total"];
    }
    //echo number_format($total,2)." bs.";
    return $total;
  }

  function suc_pm($sucur){
    $total=0;
    $conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
     if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
      $min=$_GET["fechaini"];
      $max=$_GET["fechamax"];
      $query="SELECT sum(total)as total
      FROM reg_ventas 
      where  sucursal_id='$sucur' and turno='PM' and
      fecha between '$min' and '$max'"; 
      }
      else{
    $min=date("Y-m-d");
    $max=date("Y-m-d");
      $query="SELECT sum(total)as total
      FROM reg_ventas 
      where  sucursal_id='$sucur' and turno='PM' and
      fecha between '$min' and '$max'";  
      }
      $resultado = $conexion->query($query);
      foreach ($resultado as $r){
      $total=$r["total"];
      }
      //echo number_format($total,2)." bs.";
      return $total;
      } 
  ?>
    <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>sucursal</th>
                <th>Turno AM</th>
                <th>Turno PM</th>
                <th>Total</th>   
           </tr>
        </thead>
        <tbody>
        <?php 
    $total_am=0;
    $total_pm=0;
    ?>
<tr class=warning>
    <td><?php echo "SUC. SUR"; ?></td>
    <td><?php echo number_format(suc_am("2"),2);$total_am=$total_am+suc_am("2");?></td>
    <td><?php echo number_format(suc_pm("2"),2);$total_pm=$total_pm+suc_pm("2");?></td>
    <td><?php echo number_format((suc_am("2")+suc_pm("2")),2);?></td>
  </tr>  
  <tr class=warning>
    <td><?php echo "SUC. PARAGUA"; ?></td>
    <td><?php echo number_format(suc_am("3"),2); $total_am=$total_am+suc_am("3");?></td>
    <td><?php echo number_format(suc_pm("3"),2);$total_pm=$total_pm+suc_pm("3");?></td>
    <td><?php echo number_format((suc_am("3")+suc_pm("3")),2);?></td>
  </tr>  
  <tr class=warning>
    <td><?php echo "SUC. PALMAS"; ?></td>
    <td><?php echo number_format(suc_am("4"),2);$total_am=$total_am+suc_am("4");?></td>
    <td><?php echo number_format(suc_pm("4"),2);$total_pm=$total_pm+suc_pm("4");?></td>
    <td><?php echo number_format((suc_am("4")+suc_pm("4")),2);?></td>
  </tr> 
  <tr class=warning>
    <td><?php echo "SUC. TRES PASOS"; ?></td>
    <td><?php echo number_format(suc_am("5"),2);$total_am=$total_am+suc_am("5");?></td>
    <td><?php echo number_format(suc_pm("5"),2);$total_pm=$total_pm+suc_pm("5");?></td>
    <td><?php echo number_format((suc_am("5")+suc_pm("5")),2);?></td>
  </tr> 
  <tr class=warning>
    <td><?php echo "SUC. PAMPA"; ?></td>
    <td><?php echo number_format(suc_am("6"),2);$total_am=$total_am+suc_am("6");?></td>
    <td><?php echo number_format(suc_pm("6"),2);$total_pm=$total_pm+suc_pm("6");?></td>
    <td><?php echo number_format((suc_am("6")+suc_pm("6")),2);?></td>
  </tr> 
  <tr class=warning>
    <td><?php echo "SUC. RADIAL 26"; ?></td>
    <td><?php echo number_format(suc_am("7"),2);$total_am=$total_am+suc_am("7");?></td>
    <td><?php echo number_format(suc_pm("7"),2);$total_pm=$total_pm+suc_pm("7");?></td>
    <td><?php echo number_format((suc_am("7")+suc_pm("7")),2);?></td>
  </tr> 
  <tr class=warning>
    <td><?php echo "SUC. QDELI VILLA"; ?></td>
    <td><?php echo number_format(suc_am("8"),2);$total_am=$total_am+suc_am("8");?></td>
    <td><?php echo number_format(suc_pm("8"),2);$total_pm=$total_pm+suc_pm("8");?></td>
    <td><?php echo number_format((suc_am("8")+suc_pm("8")),2);?></td>
  </tr> 
  <tr class=warning>
    <td><?php echo "SUC. BAJIO"; ?></td>
    <td><?php echo number_format(suc_am("9"),2);$total_am=$total_am+suc_am("9");?></td>
    <td><?php echo number_format(suc_pm("9"),2);$total_pm=$total_pm+suc_pm("9");?></td>
    <td><?php echo number_format((suc_am("9")+suc_pm("9")),2);?></td>
  </tr> 
  <tr class=warning>
    <td><?php echo "SUC. ARENAL"; ?></td>
    <td><?php echo number_format(suc_am("10"),2);$total_am=$total_am+suc_am("10");?></td>
    <td><?php echo number_format(suc_pm("10"),2);$total_pm=$total_pm+suc_pm("10");?></td>
    <td><?php echo number_format((suc_am("10")+suc_pm("10")),2);?></td>
  </tr> 
  <tr class=warning>
    <td><?php echo "SUC. PLAN 3000"; ?></td>
    <td><?php echo number_format(suc_am("11"),2);$total_am=$total_am+suc_am("11");?></td>
    <td><?php echo number_format(suc_pm("11"),2);$total_pm=$total_pm+suc_pm("11");?></td>
    <td><?php echo number_format((suc_am("11")+suc_pm("11")),2);?></td>
  </tr> 
  <tr class=warning>
    <td><?php echo "SUC. ROCA"; ?></td>
    <td><?php echo number_format(suc_am("12"),2);$total_am=$total_am+suc_am("12");?></td>
    <td><?php echo number_format(suc_pm("12"),2);$total_pm=$total_pm+suc_pm("12");?></td>
    <td><?php echo number_format((suc_am("12")+suc_pm("12")),2);?></td>
  </tr>
  <tr class=warning>
    <td><?php echo "SUC. VILLA"; ?></td>
    <td><?php echo number_format(suc_am("13"),2);$total_am=$total_am+suc_am("13");?></td>
    <td><?php echo number_format(suc_pm("13"),2);$total_pm=$total_pm+suc_pm("13");?></td>
    <td><?php echo number_format((suc_am("13")+suc_pm("13")),2);?></td>
  </tr>
  <tr class=warning>
    <td><?php echo "SUC. MUTUALISTA"; ?></td>
    <td><?php echo number_format(suc_am("14"),2);$total_am=$total_am+suc_am("14");?></td>
    <td><?php echo number_format(suc_pm("14"),2);$total_pm=$total_pm+suc_pm("14");?></td>
    <td><?php echo number_format((suc_am("14")+suc_pm("14")),2);?></td>
  </tr>
  <tr class=warning>
    <td><?php echo "SUC. CINE CENTER"; ?></td>
    <td><?php echo number_format(suc_am("15"),2);$total_am=$total_am+suc_am("15");?></td>
    <td><?php echo number_format(suc_pm("15"),2);$total_pm=$total_pm+suc_pm("15");?></td>
    <td><?php echo number_format((suc_am("15")+suc_pm("15")),2);?></td>
  </tr>

  <tr class=warning>
    <td><?php echo "SUC. BOULEVARD"; ?></td>
    <td><?php echo number_format(suc_am("16"),2); $total_am=$total_am+suc_am("16");?></td>
    <td><?php echo number_format(suc_pm("16"),2);$total_pm=$total_pm+suc_pm("16");?></td>
    <td><?php echo number_format((suc_am("16")+suc_pm("16")),2);?></td>
  </tr>
  <tr class=warning>
    <td><?php echo "SUC. QDELI VILLA 3"; ?></td>
    <td><?php echo number_format(suc_am("18"),2); $total_am=$total_am+suc_am("18");?></td>
    <td><?php echo number_format(suc_pm("18"),2); $total_pm=$total_pm+suc_pm("18");?></td>
    <td><?php echo number_format((suc_am("18")+suc_pm("18")),2);?></td>
  </tr>
  </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
   <tr>
   <td><h4>Total ventas</h4></td>
   <td><h4><?php echo number_format($total_am,2)." bs";?></h4></td>
   <td><h4><?php echo number_format($total_pm,2)." bs";?></h4></td>
   <td><h4><?php echo ($total_am+$total_pm)." bs";?></h4></td>
   </tr>
   </table>
  </div>
  </div>
</div>
  </body>
</html>
<script type="text/javascript">
$("#filtrar").on("click",function(){
fechainicio=document.getElementById("fechaini").value;
fechamax=document.getElementById("fechamax").value;
console.log("esta es la fecha:"+fechainicio+" y la fecha max:"+fechamax);
});
</script>