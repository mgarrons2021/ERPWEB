<html>
	<head>
		<title>Eliminacion</title>
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
   <h2>pedidos en Kg. por sucursal <br><?php echo "fecha:"." ".$min;?> </h2>
   
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
$query = $db->GetAll("SELECT  p.sucursal_id,p.nro,s.nombre, sum(dp.cantidad_envio)as envio, p.sucursal_id, p.fecha_e
FROM pedido p,detallepedido dp,producto pro,sucursal s
WHERE s.idsucursal=p.sucursal_id and p.nro=dp.nro and p.sucursal_id=dp.sucursal_id and pro.idproducto=dp.producto_id and pro.idcategoria=2 and p.fecha_e BETWEEN '$min' and '$max' GROUP BY p.sucursal_id");
}
else{
$min=date("Y-m-d",strtotime(date("Y-m-d")."- 1 days"));
$max=date("Y-m-d",strtotime(date("Y-m-d")."- 1 days"));
$query= $db->GetAll("SELECT  p.sucursal_id,p.nro,s.nombre, sum(dp.cantidad_envio)as envio, p.sucursal_id, p.fecha_e
FROM pedido p,detallepedido dp,producto pro,sucursal s
WHERE s.idsucursal=p.sucursal_id and p.nro=dp.nro and p.sucursal_id=dp.sucursal_id and pro.idproducto=dp.producto_id and pro.idcategoria=2 and p.fecha_e BETWEEN '$min' and '$max' GROUP BY p.sucursal_id");
}
function eli($sucur,$min,$max){
$total=0;
$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
$query="select sum(de.cantidad)as cantidad
from eliminacion t,detalleeliminacion de, producto pro
where t.sucursal_id=$sucur and de.nro=t.nro and de.sucursal_id=t.sucursal_id and pro.idproducto=de.producto_id and pro.idcategoria=2 and t.fecha between '$min' and '$max' group by t.sucursal_id";
$resultado = $conexion->query($query);
foreach ($resultado as $r){
$total=$r["cantidad"];
}
return $total;
}
function res($sucur,$min,$max){
$total=0;
$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
$query="select t.*, t.fecha, u.nombre as usuario,sum(de.cantidad)as cantidad
from reciclaje t,detallereciclaje de,usuario u
where t.sucursal_id=$sucur and de.nro=t.nro and de.sucursal_id=t.sucursal_id and t.usuario_id=u.idusuario  and t.fecha between '$min' and '$max' group by t.sucursal_id";
$resultado = $conexion->query($query);
foreach ($resultado as $r){
$total=$r["cantidad"];
}
return $total;
}
function p_sol($sucur,$min,$max){
$total=0;
$conexion = new mysqli('localhost','donesco_sistemas','cb*2020*sis.','donesco_erpwebdonesco');
$query="SELECT sum(dp.cantidad)as envio
FROM pedido p,detallepedido dp,producto pro
WHERE  p.nro=dp.nro and p.sucursal_id=dp.sucursal_id and p.sucursal_id=$sucur and pro.idproducto=dp.producto_id and pro.idcategoria=2 and p.fecha_e BETWEEN '$min' and '$max' GROUP BY p.sucursal_id";
$resultado = $conexion->query($query);
foreach ($resultado as $r){
$total=$r["envio"];
}
return $total;
}
  ?>
    <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Fecha_envio</th>
               <!--<th>Usuario</th>-->
                <th>De Sucursal</th>
                <th>pedidos solicitud</th>
                <th>pedidos enviados</th>
                <th>eliminacion</th>
                <th>%</th>
                <th>resiclaje</th>
                 <th>%</th>
                <th>Opciones</th>
           </tr>
        </thead>
        <tbody>
<?php 
$nro=0; 
$t_K_so=0; 
$t_K_en=0;
$t_K_el=0;
$t_K_re=0;
foreach($query as $r){
  $nro=$nro+1;
  $p_sol=p_sol($r['sucursal_id'],$min,$max);$t_K_so=$t_K_so+$p_sol;
  $t_K_en=$t_K_en+$r["envio"];
  $eli=eli($r['sucursal_id'],$min,$max);$t_K_el=$t_K_el+$eli;
  $res=res($r['sucursal_id'],$min,$max);$t_K_re=$t_K_re+$res;
?>
<tr class=warning>
  <td><?php echo $nro; ?></td>
  <td><?php echo $r["fecha_e"]; ?></td>
     <!--<td><?php //echo $r["usuario"]; ?></td>-->
     <td><?php echo $r["nombre"]; ?></td>
     <td><?php echo number_format($p_sol,3)." Kg."; ?></td> 
     <td><?php echo number_format($r['envio'],3)." Kg"; ?></td>
    <td><?php echo number_format($eli,3)." Kg."; ?></td>  
    <td><?php echo number_format(($eli/$r['envio'])*100,1)." %."; ?></td>
    <td><?php echo number_format($res,3)." Kg."; ?></td>
    <td><?php echo number_format(($res/$r['envio'])*100,1)." %."; ?></td>
  <td style="width:210px;">
    <a href="#" data-toggle="modal" data-target="#ver<?php echo $r["nro"];echo $r["sucursal_id"];echo $max;echo $min;?>"><img src="../images/ver.png" alt="" title="ver detalle">Ver Detalle</a>
    <?php
   // echo "<a class='' href='./pdftraspaso.php?nro=$r[nro]' 
   //target='_blank' role='button'><img src='../images/pdf.png' alt=''>PDF</a>";
     ?>
  </td>
  </tr>
 <div class="modal fade" id="ver<?php echo $r["nro"];echo $r["sucursal_id"];echo $max;echo $min;?>" 
                 data-backdrop="static" data-keyboard="false"
                 draggable="modal-header"
                 tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel" 
                 aria-hidden="true">
                 <div class="modal-dialog">
                 <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Detalle Eliminacion <?php //echo $r["nro"]; ?></h4>
                  </div>
                 <div class="modal-body">
                  <div class="row panel panel-primary">
                     <!-- <div class="col-md-2">
                        codigo
                      </div>   -->                 
                 <div class="col-md-4">
                        producto
                      </div>
                       <div class="col-md-2">
                        cant solicitado
                      </div>
                      <div class="col-md-2">
                        cant envio
                      </div>
                        
                      <div class="col-md-2">
                        cant Eliminado
                      </div>                    
                      <div class="col-md-2">
                        cant Reciclado
                      </div>
                  </div>
                  <?php
$consul = $db->GetAll("select sum(dt.cantidad)as cant,sum(dt.cantidad_envio)as cant_env,p.nombre as producto,dt.producto_id,dt.nro,dt.sucursal_id
from pedido pe,detallepedido dt,producto p 
where pe.nro=dt.nro and pe.sucursal_id=dt.sucursal_id and p.idproducto=dt.producto_id and dt.sucursal_id='$r[sucursal_id]' and p.idcategoria='2' and pe.fecha_e BETWEEN '$min' and '$max' group by dt.producto_id");
        foreach ($consul as $key){
                    ?>
                     <div class="row">
                       <!--<div class="col-md-2">
                       <?php //echo $key["codigo_producto"];?>
                       </div>-->
                       <div class="col-md-4">
                         <?php echo $key["producto"];?>
                       </div>
                       <div class="col-md-2">
                         <?php echo number_format($key["cant"],2). PHP_EOL ." kg";?>
                       </div>
                       <div class="col-md-2" >
                         <?php echo number_format($key["cant_env"],2). PHP_EOL ." kg"; ?>
                       </div>
                       <div class="col-md-2">
                         <?php $eli; ?>
                       </div>
                       <div class="col-md-2">
                          <?php echo $res;?>
                       </div>
                     </div> 
                    <?php }?>
                    <br>
                    <div class="row panel panel-primary" >
                    <div class="col-md-4">TOTAL</div>
                    <div class="col-md-2">
                      <?php echo number_format($p_sol,2). PHP_EOL ."kg"; ?>
                      </div>
                    <div class="col-md-2">
                      <?php echo number_format($r['envio'],2). PHP_EOL ."kg"; ?>
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
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
           <thead>
            <tr>
                <th>Nro</th>
                <th>Fecha</th>
               <!--<th>Usuario</th>-->
                <th>De Sucursal</th>
                <th>pedidos solicitud</th>
                <th>pedidos enviados</th>
                <th>eliminacion</th>
                <th>%</th>
                <th>resiclaje</th>
                 <th>%</th>
                <th>Opciones</th>
           </tr>
        </thead>
   <tr>
   <td></td>
   <td></td>
   <td></td>
   <td><h4> <?php echo number_format($t_K_so,2)." kg"; ?></h4></td>
   <td><h4> <?php echo number_format($t_K_en,2)." kg"; ?></h4></td>
   <td><h4> <?php echo number_format($t_K_el,2)." kg"; ?></h4></td>
   <td><h4> <?php echo number_format(($t_K_el/$t_K_en)*100,1)." %"; ?></h4></td>
    <td><h4> <?php echo number_format($t_K_re,2)." kg"; ?></h4></td>
     <td><h4> <?php echo number_format(($t_K_re/$t_K_en)*100,1)." %"; ?></h4></td>
   <td></td>
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