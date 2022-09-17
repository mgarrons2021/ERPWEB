<html>
	<head>
		<title>Listados de compra</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">	
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
  </head>
<body class="body">
<?php include"../menu/menu.php"; 
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id']; 
$user = $usuario['idusuario'];
?>
  <div class="container">
  <div class="left-sidebar">
  <h2>listado de Compras2</h2>
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
      $(document).ready(function(){
        $("#usuario").DataTable({
          language:{
            sProcessing:"Procesando...",
            sLengthMenu:"Mostrar _MENU_ registros",
            sZeroRecords:"No se encontraron resultados",
            sEmptyTable:"Ningun dato disponible en esta tabla",
            sInfo:"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty:"Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered:"(filtrado de un total de _MAX_ registros)",
            sInfoPostFix:"",
            sSearch:"Buscar:",
            sUrl:"",
            sInfoThousands:",",
            sLoadingRecords:"Cargando...",
            oPaginate:{
              sFirst:"Primero",
              sLast:"Ãšltimo",
              sNext:"Siguiente",
              sPrevious:"Anterior"
            },
            oAria:{
              sSortAscending:": Activar para ordenar la columna de manera ascendente",
              sSortDescending:": Activar para ordenar la columna de manera descendente"}}})});
      </script>
    <form action="index.php" method="POST">  
        <div class="row"> 


          <div class="col-md-6">  
          <div class="input-daterange input-group" id="datepicker">  
              <span class="input-group-addon"><strong>Fecha De:</strong> </span>
              <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" value="<?php if(isset($_POST['fechaini'])){echo $_POST['fechaini'];} ?>" />
              <span class="input-group-addon">A</span>
              <input type="text" id="fechamax" class="input-sm form-control" name="fechamax"  value="<?php if(isset($_POST['fechamax'])){echo $_POST['fechamax'];} ?>" />
        </div>
        </div>
          <div class="col-md-2">
            <input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
          </div>
      </div>
    </form>  
  <br>
<?php
if (isset($_POST['fechaini']) &&  isset($_POST['fechamax'])){
$min=$_POST["fechaini"];
$max=$_POST["fechamax"];

$ventas = $db->GetAll("SELECT DISTINCT  c.proveedor_id as idproveedor, pro.empreza as nombre, suc.nombre as nombresucursal , c.sucursal_id as idsucursal FROM compra c
INNER JOIN proveedor pro on c.proveedor_id = pro.idproveedor
INNER JOIN sucursal suc on c.sucursal_id = suc.idsucursal
WHERE fecha  BETWEEN '$min' and '$max';");      
}else{
$min=date("Y-m-d");
$max=date("Y-m-d");
$ventas = $db->GetAll("SELECT DISTINCT  c.proveedor_id as idproveedor, pro.empreza as nombre, suc.nombre as nombresucursal , c.sucursal_id as idsucursal FROM compra c
INNER JOIN proveedor pro on c.proveedor_id = pro.idproveedor
INNER JOIN sucursal suc on c.sucursal_id = suc.idsucursal
WHERE fecha  BETWEEN '$min' and '$max';");
}
$query = $ventas;
?>
    <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
    <a href='../pago2/proveedor.php?sucursal=<?php echo $sucur; ?>'  class="btn btn-success" role='button'>Deudas Proveedores</a>
    <a href='../pago2/proveedormes.php?sucursal=<?php echo $sucur; ?>'  class="btn btn-success" role='button'>Deudas Proveedores MENSUAL</a>

    <br>
    <br>
    
    
    <thead>
            <tr>
                <th>Proveedor</th>
                <th>Sucursal</th>
                <th>Opcion</th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($query as $r){?>
<trclass=warning>
  <td><?php echo $r["nombre"]; ?></td>
  <td><?php echo $r["nombresucursal"]; ?></td>
  <td >
  <form action="../pago2/index2.php" method="post"  data-toggle="validator" name="elformulario"  role="">
    <input type="hidden" name="fechaa" value="<?php echo $min ?>" />
    <input type="hidden" name="fechap" value="<?php echo $max ?>" />
    <input type="hidden" name="suc_id" value="<?php echo $r['idsucursal'] ?>" />
    <input type="hidden" name="nro" value="<?php echo $r['idproveedor'] ?>" />
    <input type="submit" class="btn btn-success" value="Pagar" />
	</form>
    <?php
   // echo " <a href='../pago/index2.php?nro=$r[idproveedor], fechaa=$min, fechap=$max, suc_id=$r[idsucursal]',  class='' role='button'><img src='../images/pago.jpg' alt=''>Pagos</a>";
    ?>
  </td>
  </tr>
  <!--Modal -->
<?php }?>
  </table>
    </table>
  </div>
  </div>
</div>  <!-- Start WOWSlider.com BODY section -->
<!-- End WOWSlider.com 
  BODY section -->
  </body>
</html>