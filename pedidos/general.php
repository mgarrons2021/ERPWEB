<html>
	<head>
		<title>General</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="../js/jquery.js"></script>
   <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
    <style>

    </style>
  </head>
<body class="body">
<?php include"../menu/menu.php";
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];


 function eliminacion($idproducto,$min,$max){
$total=0;
$conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
$query="SELECT  p.nombre as producto,sum(de.cantidad)as cantidad
FROM eliminacion e, detalleeliminacion de, producto p
WHERE p.idproducto='$idproducto' and e.nro=de.nro and e.sucursal_id=de.sucursal_id and de.producto_id=p.idproducto and e.fecha BETWEEN '$min' and '$max' GROUP by de.producto_id";
 $resultado = $conexion->query($query);
 foreach ($resultado as $r){
$total=$r["cantidad"];
 }
 return $total;
} 
?>
 <div class="container">
  <div class="left-sidebar">
   <h2>Listado General de solicitud de insumos</h2>
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
<?php $min=0; $max=0; if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){
$min=$_GET["fechaini"];
$max=$_GET["fechamax"];
$query = $db->GetAll("SELECT pro.idproducto,pro.idunidad_medida, pro.nombre, s.nombre as sucursal, pro.idcategoria,sum(d.cantidad) as total, sum(d.cantidad_envio) as envio FROM detallepedido d, pedido p, producto pro, sucursal s
where s.idsucursal=d.sucursal_id and d.producto_id=pro.idproducto and d.nro=p.nro and d.sucursal_id = p.sucursal_id and p.Fecha_p between '$min' and '$max' group by pro.idproducto ORDER BY pro.nombre ASC");}
else{
$min=date("Y-m-d",strtotime(date('Y-m-d')."- 1 days"));
$max=date('Y-m-d');
$query= $db->GetAll("SELECT pro.idproducto,pro.idunidad_medida, pro.nombre, s.nombre as sucursal, pro.idcategoria,sum(d.cantidad) as total , sum(d.cantidad_envio) as envio FROM detallepedido d, pedido p, producto pro, sucursal s
where s.idsucursal=d.sucursal_id and d.producto_id=pro.idproducto and d.nro=p.nro and d.sucursal_id = p.sucursal_id and p.Fecha_p between '$min' and '$max' group by pro.idproducto ORDER BY pro.nombre ASC");}
  ?>
  <h2><?php if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){
      echo "De: ".$min." a ".$max ; } else{
    echo "De: ".$min." a".$max;
  }?></h2>
<table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
<thead>
<?php 
$nro=0;
$total=0;
for($i=2; $i <= 15 ; $i++){ ?>
<tr>
<th><h2><?php
if($i==2){echo "Produccion";}
if($i==3){echo "Abarrotes";}
if($i==4){echo "Alimentos";}
if($i==5){echo "Bebidas";}
if($i==6){echo "Material de Limpieza";}
if($i==7){echo "Plasticos";}
if($i==8){echo "Zumos";}
if($i==9){echo "Verduras";}
if($i==10){echo "Insumos para Refresco";}
if($i==11){echo "Pollos";}
if($i==12){echo "Carnes";}
if($i==13){echo "Insumos Procesados";}
if($i==14){echo "Lacteos/Fiambres";}
if($i==15){echo "salsas";}
?></h2></th>
</tr>
            <tr>
                <th>Insumo</th>
                <th>Cantidad Solisitada</th>
                <th>Cantidad Enviada</th>
                <th>Cantidad restante</th>
                <th>% Efectividad</th>
                 <th>Eliminacion</th>
                 <th>%</th>
                <th>Opciones</th> 
            </tr>
        </thead>
        <tbody>
<?php foreach ($query as $r){
  if($r["idcategoria"]==$i){
    $um=$db->GetOne("select nombre from unidad_medida where idunidad_medida=$r[idunidad_medida]");
    
  $eliminacion=eliminacion($r["idproducto"],$min,$max);
  ?>
<tr class=warning>
  <td><?php echo $r["nombre"]; ?></td>
  <td><?php echo number_format($r["total"],2)." ".$um; ?></td>
  <td><?php echo number_format($r["envio"],2)." ".$um; ?></td>
   <td><?php echo number_format(($r["total"]-$r["envio"]),2)." ".$um; ?></td>
   <td><?php echo number_format(($r["envio"]/$r["total"]*100),2)." %"; ?></td>
  <td><?php echo number_format($eliminacion,2)." ".$um; ?></td>
  <td><?php echo number_format(($r["envio"]/$eliminacion),2)." %"; ?></td>
<td style="width:210px;">
    <a href="#" data-toggle="modal" data-target="#ver<?php echo $min;echo $max;echo $r['idproducto']?>"><img src="../images/ver.png" alt="" title="ver detalle">Ver Detalle</a>
  </tr>
  </tbody>
  <div class="modal fade" id="ver<?php echo $min;echo $max;echo $r['idproducto']; ?>" 
                 data-backdrop="static" data-keyboard="false"
                 draggable="modal-header"
                 tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel" 
                 aria-hidden="true">
                 <div class="modal-dialog">
                 <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Detalle de<?php echo $r["nombre"];?> por sucursal <br> <?php echo "De: ".$min." a ".$max;?></h4>
                  </div>
                 <div class="modal-body">
                  <div class="row panel panel-primary">
                     <!-- <div class="col-md-2">
                        codigo
                      </div>   -->                 
                      <div class="col-md-2 " >
                        Sucursal
                      </div>
                       <div class="col-md-4">
                        Insumo
                      </div>
                      <div class="col-md-2">
                        cantidad Solicitada
                      </div>
                      <div class="col-md-2">
                        cantidad Enviada
                      </div>
                      <div class="col-md-2">
                        % efec
                      </div>
                      
                  </div>
                  <?php
$consul = $db->GetAll("SELECT pro.idproducto, pro.nombre,s.idsucursal, s.nombre as sucursal, pro.idcategoria,sum(d.cantidad) as cantidad , sum(d.cantidad_envio) as cantidad_envio FROM detallepedido d, pedido p, producto pro, sucursal s
where s.idsucursal=d.sucursal_id and d.producto_id=pro.idproducto and d.nro=p.nro and d.sucursal_id = p.sucursal_id and pro.idproducto=$r[idproducto] and p.Fecha_p between '$min' and '$max' group by s.idsucursal");
$u_m=$db->GetOne("select nombre from unidad_medida where idunidad_medida=$r[idunidad_medida]");
                    foreach ($consul as $key) {?>
                     <div class="row panel panel-success">
                       <!--<div class="col-md-2">
                         <?php //echo $key["codigo_producto"]; ?>
                       </div>-->
                       
                    <div class="col-md-2">
                         <?php echo $key["sucursal"];?>
                       </div>
                       <div class="col-md-4">
                         <?php echo $key["nombre"];?>
                       </div>
                       <div class="col-md-2">
                         <?php echo $key["cantidad"]." ".$u_m; ?>
                       </div>
                       <div class="col-md-2">
                         <?php echo $key["cantidad_envio"]." ".$u_m;?>
                       </div>
                       <div class="col-md-2">
                         <?php echo number_format(($key["cantidad_envio"]/$key["cantidad"])*100,2);?>
                       </div>
                     </div>  
                    <?php }  ?>
                    <br>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
             </div>
 <?php }}}
?>
  </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
   <tr>
   <td><h4>Totales insumos</h4></td><td><h4> <?php echo number_format($total,2)." bs"; ?></h4>
   </td></tr>
   </table>
  </div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  </div>
</div>  <!-- Start WOWSlider.com BODY section -->
<!-- End WOWSlider.com 
  BODY section -->
  </body>
</html>