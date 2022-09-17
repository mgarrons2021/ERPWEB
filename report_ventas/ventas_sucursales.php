<html>
	<head>
		<title>Ventas</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="../js/jquery.js"></script>
   <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">	
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
  </head>
<body class="body">
<?php
include"../menu/menu.php";
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$suc==$db->GetOne("select nombre from sucursal where idsucursal=$sucur");
$sucursal= $db->GetAll('select * from sucursal');
?>
 <div class="container">
  <div class="left-sidebar">
   <h2>ventas realizadas <?php echo  " ".$suc; ?></h2>
 <h4><a href="nuevo.php">Atras</a></h4>
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
<select class="form-control select-md" name="selec_sucur" id="selec_sucur" >
     <option value="0">seleccione una surcursal</option>
     <?php foreach ($sucursal as $r){?>
                  <option value="<?php echo $r["idsucursal"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
 </select>
    <span class="input-group-addon"><strong>Fecha De:</strong> </span>
    <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" value="<?php if(isset($_GET["fechaini"])){echo $_GET["fechaini"];}?>"/>
    <span class="input-group-addon">A</span>
    <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" value="<?php if(isset($_GET["fechamax"])){echo $_GET["fechamax"];}?>"/>  
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
          $sucur=$_GET["selec_sucur"];
          $query = $db->GetAll("SELECT v.* ,v.fecha as fech_v,v.sucursal_id as sucursal,c.nombre as cliente,c.*
          FROM venta v, cliente c
          WHERE v.sucursal_id='$sucur' 
          and c.idcliente=v.cliente_id 
          and v.fecha between '$min' and '$max'");
          
          $total_personal = $db->GetAll("SELECT sum(total) as total FROM venta 
          WHERE pago = 'comida_personal' and sucursal_id = '$sucur' 
          AND fecha BETWEEN '$min' AND '$max' ORDER BY idventa DESC");
          
          $total_visa = $db->GetAll("SELECT sum(total) as total FROM venta 
          WHERE pago = 'visa' and lugar!='DELIVERY' and sucursal_id = '$sucur' and estado = 'V'
          AND fecha BETWEEN '$min' AND '$max' ORDER BY idventa DESC");


 	  $total_delivery = $db->GetAll("SELECT sum(total) as total FROM venta 
          WHERE lugar='DELIVERY' and estado = 'V' and sucursal_id = '$sucur' 
          AND fecha BETWEEN '$min' AND '$max' ORDER BY idventa DESC");
}
else{
          $min=date("Y-m-d");
          $max=date("Y-m-d");
          $query= $db->GetAll("SELECT v.*,v.fecha as fech_v ,v.sucursal_id as sucursal,c.nombre as cliente,c.*
          FROM venta v, cliente c
          WHERE v.sucursal_id='$sucur' 
          and c.idcliente=v.cliente_id and v.fecha between '$min' and '$max'");
  
          $total_personal = $db->GetAll("SELECT sum(total) as total FROM venta 
          WHERE pago = 'comida_personal' and sucursal_id = '$sucur' 
          AND fecha BETWEEN '$min' AND '$max' ORDER BY idventa DESC");
          
          $total_visa = $db->GetAll("SELECT sum(total) as total FROM venta 
          WHERE pago = 'visa' and lugar!='DELIVERY' and sucursal_id = '$sucur' AND estado = 'V'
          AND fecha BETWEEN '$min' AND '$max' ORDER BY idventa DESC");


 	  $total_delivery = $db->GetAll("SELECT sum(total) as total FROM venta 
          WHERE lugar = 'DELIVERY' and sucursal_id = '$sucur' 
          AND fecha BETWEEN '$min' AND '$max' ORDER BY idventa DESC");
  
}
        foreach ($total_personal as $t) {
          $tp = (int)$t['total'];
        }
        
        foreach ($total_visa as $v) {
          $tv = (int)$v['total'];
        }
        
	foreach ($total_delivery as $d) {
          $td = (int)$d['total'];
        }
        

  ?>
    <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nro. Factura</th>
                <th>T.T.</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Usuario</th>
                <th>De Sucursal</th>
                <th>Turno</th>
                <th>Lugar</th>
                <th>Pago</th>
                <th>Total</th>
                <th>Cliente</th>
                <th>Nit/Ci</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
<?php $nro=0; $total=0; $total_anulados=0; foreach ($query as $r){$nro=$nro+1;  ?>
<tr   class=warning>
  <td><?php echo $r["nro_factura"];?></td>
  <td><?php echo $r["nro"]; ?></td>
  <td><?php echo $r["fech_v"]; ?></td>
  <td><?php echo $r["hora"]; ?></td>
  <td><?php echo $db->GetOne('SELECT nombre FROM usuario where idusuario = '.$r['usuario_id']); ?></td>
     <td><?php echo $db->GetOne('SELECT nombre FROM sucursal where idsucursal = '.$r['sucursal']); ?></td>
      <td><?php if($r["turno"]==1){echo " AM";}else{echo " PM";}; ?></td>
      <td><?php echo $r["lugar"]; ?></td>
      <td><?php echo $r["pago"]; ?></td>
    <td><?php echo number_format($r["total"],2)." bs"; ?></td>
     <td><?php echo $r["cliente"]; ?></td>
    <td><?php echo $r["nit_ci"]; ?></td>
  <td style="width:210px;">
 <a href="#" data-toggle="modal" data-target="#ver<?php echo $r["nro"];echo $r["idturno"];?>"><img src="../images/ver.png" alt="" title="ver detalle">Ver Detalle</a>
 <?php echo "<a class='' href='../ventas/pdffactura.php?idturno=$r[idturno]&nro=$r[nro]' target='_blank' role='button'><img src='../images/pdf.png' alt=''>PDF</a>";?>
 <?php if ($r["estado"] == 'V'){ $total=$total+$r["total"];?>
   <a style="color:green;" href="#"><img src="../images/alta.png" alt="" title="">Activo</a>
  <?php } else { $total_anulados=$total_anulados+$r["total"]; ?>
  <a style="color:red;" href="#"><img src="../images/baja.png" alt="" title="">Anulado</a>
 <?php }?>
    <?php if($usuario['codigo_usuario']=='tania'||$usuario['codigo_usuario']=='ric12345'||$usuario['codigo_usuario']=='miguel123'){
    if ($r["estado"] == 'V'){ ?>
                    <a href="./estado.php?id=<?php echo $r["idventa"];?> "
                    onclick ="return confirm('&iquest;Esta Seguro de anular la factura?')" > Anular</a>
                       <?php
                       }else{
                       ?>
                    <a href="./estado.php?id=<?php echo $r["idventa"];?> "
                    onclick ="return confirm('&iquest;Esta Seguro de Reanudar la factura?')"> Activar</a>
  <?php }} ?>
  
 <!-- <a href="editar.php?nro=<?php // echo $r["nro"];?>&inve=<?php //echo $r["inventario_id"];?>"><img src="../images/edit.png" alt="" title="Modificar">Edit</a>-->
  
  </td>
  </tr>
 <div class="modal fade" id="ver<?php echo $r["nro"];echo $r["idturno"];?>" 
                 data-backdrop="static" data-keyboard="false"
                 draggable="modal-header"
                 tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel" 
                 aria-hidden="true">
                 <div class="modal-dialog">
                 <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Detalle ventas <?php echo $r["nro"]; ?></h4>
                  </div>
                 <div class="modal-body">
                  <div class="row panel panel-primary">
                     <div class="col-md-2">
                        codigo
                      </div>                   
                      <div class="col-md-4">
                        plato
                      </div>
                      <div class="col-md-2">
                        cantidad
                      </div>
                      <div class="col-md-2">
                        subtotal
                      </div>
                  </div>
                  <?php 
$consul = $db->GetAll("SELECT dv.*,p.nombre as plato
FROM detalleventa dv,plato p
WHERE dv.sucursal_id=$sucur and dv.nro=$r[nro] and dv.idturno=$r[idturno] and dv.plato_id=p.idplato");
                    foreach ($consul as $key) { ?>
                     <div class="row" >
                       <div class="col-md-2">
                         <?php echo $key["plato_id"]; ?>
                       </div>
                       <div class="col-md-4">
                         <?php echo $key["plato"];?>
                       </div>
                  
                       <div class="col-md-2" >
                         <?php echo $key["cantidad"]; ?>
                       </div>
                     
                       <div class="col-md-2">
                         <?php echo number_format($key["subtotal"],2). PHP_EOL ."Bs";?>
                       </div>
                    
                     </div>
                    <?php } ?>
                    <br>
                    <div class="row panel panel-primary" >
                    <div class="col-md-6">TOTAL</div>
                    <div class="col-md-2">
                      <?php echo number_format($r["total"],2). PHP_EOL ."Bs"; ?>
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
   <tr>
       <td><h4>Total anulados</h4></td><td><h4> <?php echo number_format($total_anulados,2)." bs"; ?></h4>
   </td>
   <td><h4>Total Turno </h4></td><td><h4> <?php echo number_format($total,2)." bs"; ?></h4>
   <td><h4>Comida Personal</h4></td><td><h4><h4><?php echo number_format($tp, 2) ?>Bs.</h4></h4>
   </td></tr>
   <tr>
            <td colspan="5">
              <h4>Total Venta</h4>
            </td>
            <td>
              <h4><?php $resultado = ($total - $tp);
                  echo  number_format($resultado, 2) ?> Bs.</h4>
            </td>
   </tr>
   <tr>
   	<td><h4>Total Visa</h4></td>
   	<td><h4><?php echo number_format($tv, 2) ?>Bs.</h4></td>
   	<td><h4>Total Delivery</h4></td>
   	<td><h4><?php echo number_format($td, 2) ?>Bs.</h4></td>
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