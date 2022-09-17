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
  <h2>listado de Compras</h2>
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

$ventas = $db->GetAll("SELECT c.*, u.nombre as 'usuario', pro.empreza AS 'proveedor', s.nombre as 'sucursal' from compra c 
INNER JOIN usuario u ON u.idusuario = c.usuario_id  
INNER JOIN proveedor pro ON c.proveedor_id = pro.idproveedor
INNER JOIN sucursal s ON s.idsucursal = c.sucursal_id
WHERE c.fecha BETWEEN '$min' AND '$max' ORDER BY c.idcompra DESC");


        
}else{
$min=date("Y-m-d");
$max=date("Y-m-d");


$ventas = $db->GetAll("SELECT c.*, u.nombre as 'usuario', pro.empreza AS 'proveedor', s.nombre as 'sucursal' from compra c 
INNER JOIN usuario u ON u.idusuario = c.usuario_id  
INNER JOIN proveedor pro ON c.proveedor_id = pro.idproveedor
INNER JOIN sucursal s ON s.idsucursal = c.sucursal_id

WHERE c.fecha BETWEEN '$min' AND '$max' ORDER BY c.idcompra DESC");
}
$query = $ventas;
?>
    <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Fecha compra</th>
                <th>Sucursal</th>
                <th>Usuario</th>
                <th>Proveedor</th>
                <th>Estado</th>
                <th>Pagado</th>
                <th>Deuda</th>
                <th>Total</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
<?php $nro=0; $total=0; $total2=0; $suma_pago = 0;
  foreach ($query as $r){
    $compra_id = $r['nro'];
    $deuda     = $r['deuda'];
    //SACAR EL MONTO PAGADO POR CADA COMPRA
    $
    s_realizados = $db->Execute("SELECT SUM(monto) as monto FROM 
     p WHERE p.compra_id = '$compra_id'"); //sacar los montos pagados
    foreach($
    s_realizados as $i){
      $
            = $i['monto'];
      $suma_
       = ($suma_
        + $
        ); 
    }

    $nro=$nro+1; 
    if($r["proveedor_id"]==7||$r["proveedor_id"]==28){
      $total2=$total2+$r["total"];
    }else{
      $total=$total+$r["total"];
    }                                                   
?>
<trclass=warning>
  <td><?php echo $r["nro"]; ?></td>
  <td><?php echo $r["fecha"]; ?></td>
  <td><?php echo $r["sucursal"]; ?></td>
  <td><?php echo $r["usuario"]; ?></td>
  <td><?php echo $r["proveedor"]; ?></td>
    <?php if(number_format($r["total"],2) == number_format($
    ,2)) {?>
      <td style="color: green">Pagada</td>
    <?php }else{?>
      <td style="color: red;"><?php echo $r["estado"]; ?></td>
    <?php }?>
  <td><?php echo number_format($
  ,2);  ?></td>
  <td><?php echo number_format($deuda,2); ?></td>
  <td><?php echo number_format($r["total"],2)."bs"; ?></td>
  <td style="width:210px;">
    <a href="#" data-toggle="modal" data-target="#ver<?php echo $r["nro"];?>"><img src="../images/ver.png" alt="" title="ver detalle">Detalle</a>
    <?php
    echo "<a class='' href='pdfcompra.php?nro=$r[nro]&sucursal=$r[sucursal_id]' target='_blank' role='button'><img src='../images/pdf.png' alt=''>PDF</a>"; 
    echo "&nbsp; <a href='../pago2/index.php?nro=$r[nro]' class='' role='button'><img src='../images/pago.jpg' alt=''>Pagos</a>";
    ?>
  </td>
  </tr>
 <div class="modal fade" id="ver<?php echo $r["nro"];?>"
                 data-backdrop="static" data-keyboard="false"
                 draggable="modal-header"
                 tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel" 
                 aria-hidden="true">
                 <div class="modal-dialog">
                 <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Detalle Compra <?php echo $r["nro"]; ?></h4>
                  </div>
                  <div class="modal-body">
                  <div class="row panel panel-primary">                  
                      <div class="col-md-4">
                        producto
                      </div>
                      <div class="col-md-2">
                        cantidad
                      </div>
                      <div class="col-md-2">
                        precio
                      </div>                    
                      <div class="col-md-2">
                        subtotal
                      </div>
                  </div>
                  <?php 
                  $consul = $db->GetAll("select p.codigo_producto,p.nombre,dc.cantidad,dc.precio_compra,dc.subtotal
                    from detallecompra dc,producto p 
                    where dc.nro = $r[nro] and p.idproducto = dc.producto_id and dc.sucursal_id=".$r['sucursal_id']);
                    foreach ($consul as $key) { ?>
                     <div class="row" >
                       
                       <div class="col-md-4">
                          <?php echo $key["nombre"];?>
                       </div>
                       <div class="col-md-2">
                         <?php echo $key["cantidad"]; ?>
                       </div>
                       <div class="col-md-2">
                         <?php echo $key["precio_compra"], ' Bs'; ?>
                       </div>
                       <div class="col-md-2">
                         <?php echo $key["subtotal"], ' Bs'; ?>
                       </div>
                     </div>  
                    <?php }?>
                    <br>
                    <div class="row panel panel-primary" >
                    <div class="col-md-8">TOTAL</div>
                    <div class="col-md-2">
                      <?php echo number_format($r["total"],2), ' Bs'; ?>
                      </div>
                    </div>         
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
<?php }?>
  </table>
    </table>
  <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
  <tr>
  <td><h4>Total de Pagos realizados</h4></td><td><h4> <?php echo  number_format($suma_pago,2) ." bs"; ?></h4><td><h4>Total Compras de Insumos</h4></td><td><h4> <?php echo number_format($total,2)." bs"; ?></h4>
  </td></tr>
  </table>
  </div>
  </div>
</div>  <!-- Start WOWSlider.com BODY section -->
<!-- End WOWSlider.com 
  BODY section -->
  </body>
</html>