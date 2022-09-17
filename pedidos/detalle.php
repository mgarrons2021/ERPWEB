<html>
  <head>
    <title>listado de insumos</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css"> 
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
</head>
<body class="body">
<?php include"../menu/menu.php"; 
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro=$_GET['id'];
$sucursalid=$_GET['sucursalid'];
$idped=$_GET['idped'];
$nom_suc=$db->GetOne("select nombre from sucursal where idsucursal=$sucursalid");

$query= $db->GetAll("select p.idproducto,p.idunidad_medida,dt.estado, p.idcategoria,p.nombre,dt.cantidad,p.precio_compra,dt.subtotal, dt.iddetallepedido,dt.producto_id,dt.cantidad_envio,dt.subtotal_envio,pe.total,pe.total2,pe.total_envio,pe.total_envio2
from detallepedido dt,producto p, pedido pe
where  dt.nro = $nro and pe.nro=dt.nro and pe.sucursal_id=$sucursalid and p.idproducto = dt.producto_id and dt.sucursal_id=$sucursalid");
$inventario = $db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sucur);
$ventas= $db->GetAll("SELECT p.*,dc.*,dt.*,di.*,dtt.*,
     ifnull(di.totali, 0)as entrads,
	   ifnull(dc.total, 0)as entrad,
     ifnull(dtt.totalt, 0)as entradt,
	   ifnull(dt.totalss, 0)as salidas,
	   ifnull(di.totali, 0)+ifnull(dc.total, 0)+ifnull(dtt.totalt, 0)-ifnull(dt.totalss, 0)as stock
	   from producto p
     left join
	   (select producto_id,sum(cantidad) totali from detalleinventario where sucursal_id=1 and nro='$inventario' group by producto_id) di on p.idproducto = di.producto_id
 	   left join
	   (select producto_id,sum(cantidad) total from detallecompra where sucursal_id=1 and inventario_id='$inventario' group by producto_id) dc on p.idproducto = dc.producto_id 
     left join
	   (select d.producto_id,sum(d.cantidad) totalt from detalletraspaso d,traspaso t where d.nro=t.nro and d.sucursal_idtraspaso=1 and t.estado='si' and t.inventario_idinventario='$inventario' group by d.producto_id) dtt on p.idproducto = dtt.producto_id  
	   left join 
	   (select d.producto_id,sum(d.cantidad) totalss from detalletraspaso d, traspaso t where d.nro=t.nro and d.sucursal_id=1 and t.estado='si' and t.inventario_id='$inventario' group by d.producto_id) dt on p.idproducto = dt.producto_id
     ;");
$query2 = $ventas;

$query3= $db->GetAll("select * from unidad_medida");
?>
<form class="form-horizontal" data-toggle="validator" name="elformulario"  role="" action="obtener.php" method="post">
<div class="container">
  <div class="left-sidebar">
   <div class="row">
    <div class="col-md-1">
     </div>
     <div class="col-md-10" align="center">
      <h2><?php echo "Listado de Insumos y Produccion Solicitados ".$nom_suc?></h2>
     </div>
     <div class="col-md-1">
    </div>
   </div>
 <br>
<div class="table-responsive">
<script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
<input type="hidden" name="idpedido" id="idpedido" value="<?php echo "$nro"; ?>" >
<input type="hidden" name="idsucursal" id="idsucursal" value="<?php echo "$sucursalid"; ?>" >
<input type="hidden" name="idp" id="idp" value="<?php echo "$idped"; ?>" >
<table id="tabladetalle" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
            <th>Nro</th>
            <th>insumo</th>
            <th>precio</th>
            <th>stock Actual</th>
            <th>cantidad Solicitada</th>
            <th>subtotal</th>
            <th>Opciones</th>
            <th>cantidad a Enviar</th>
            <th>Subtotal a Enviar</th>
            <th>cantidad %</th>
            </tr>
        </thead>
        <tbody> 
<?php $fila=0; $fila2=0; $cant_ins=0;
foreach ($query as $key){ if($key["idcategoria"]!=2){ $fila=$fila+1;
  ?>
    <tr id="filass" class=warning>
    <div class="col-md-%">
    <input type="hidden"  name="iddetallepedido[]"  class="form-control" value="<?php echo $key["iddetallepedido"];?>"> 
    </div>
    <td><?php echo $fila?></td>
    <td><?php echo $key["nombre"];?></td>
     <td>
     <div class="col-md-%">
     <input class="form-control"  name="p_compra[]"  type="text" value="<?php echo $key["precio_compra"];?>" >
     </div>
     </td>
     <td>
    <div class="col-md-%">
    <div class="input-group">
  <?php foreach ($query2 as $d){
    if($key["idproducto"]==$d["idproducto"]){
      echo number_format($d["stock"],2);}
      }
        foreach($query3 as $um){
        if($um["idunidad_medida"]==$key["idunidad_medida"]){echo " ".$um["nombre"];}
                               }
    ?>
     </div>  
  </div> 
  </td> 
    <td>
    <div class="col-md-%">
    <input class="form-control" id="c"  type="text" value="<?php echo $key["cantidad"]; ?>" disabled> 
    </div> 
    </td>  
   <td> 
     <div class="col-md-%">
     <input class="form-control"  id="s"  type="text" value="<?php echo $key["subtotal"];?>" disabled>
     </div> 
     </td> 
      <td> 
     <div class="col-md-%">
     <select class="form-control select-md" name="estado[]">
     <option  value="<?php echo $key["estado"];?>"><?php if($key["estado"]==1){echo "Sin Observacion";}else{if($key["estado"]==2){echo "Observado";}else{echo "Falta de stock";}}?></option>
                  <option  value="1">Sin Observacion</option>
                  <option  value="2">Observado</option>
                  <option value="3">Falta de stock</option>
     </select>
     </div> 
     </td> 
    <td>
    <div class="col-md-%">
    <input type="text"  name="cantidad[]"  class="form-control" value="<?php echo $key["cantidad_envio"];?>"> 
    </div>
    </td>
 <td>
    <div class="col-md-%">
    <input type="text"  name="subtotal[]"  class="form-control" value="<?php echo $key["subtotal_envio"];?>" disabled> 
    </div>
    </td>
     <td><?php $cant=($key["cantidad_envio"]/$key["cantidad"])*100; echo $cant." %"; $cant_ins=$cant_ins+$cant; if($key["cantidad_envio"]!=0){$fila2=$fila2+1;} ?></td>
  </tr>
  <?php }} ?> 
  <tr>
  <td><h2>Totales</h2></td>
  <td></td>
  <td>Cumplimiento x items</td>
  <td><?php echo number_format(($fila2/$fila)*100)." %"; ?></td>
  <td><?php echo $fila." items"; ?></td>
  <td><?php echo number_format($key["total"],2)." bs"; ?></td>
  <td></td>
  <td><?php echo $fila2." items"; ?></td>
  <td><?php echo number_format($key["total_envio"],2)." bs"; ?></td>
  <td><?php echo number_format(($cant_ins/$fila),2)." %";?></td>
  </tr>
    <tr>
      <th>Nro</th>
      <th>producion</th>
      <th>precio</th>
      <th>stock Actual</th>
      <th>cantidad Solicitada</th>
      <th>subtotal</th>
      <th>Opciones</th>
      <th>cantidad a Enviar</th>
      <th>Subtotal a Enviar</th>
      <th>cantidad %</th>
    </tr>
    <?php $fila=0; $fila2=0; $cant_pro=0;
foreach ($query as $key){ if($key["idcategoria"]==2){ $fila=$fila+1;
  ?>
    <tr id="filass" class=warning>
    <div class="col-md-%">
    <input type="hidden"  name="iddetallepedido2[]"  class="form-control" value="<?php echo $key["iddetallepedido"];?>"> 
    </div>
    <td><?php echo $fila?></td>
    <td><?php echo $key["nombre"];?></td>
     <td> 
     <div class="col-md-%">
     <input class="form-control"  name="p_compra2[]"  type="text" value="<?php echo $key["precio_compra"];?>" >
     </div> 
     </td> 
     <td> 
    <div class="col-md-%">
    <div class="input-group">
  <?php foreach ($query2 as $d){if($key["idproducto"]==$d["idproducto"]){echo number_format($d["stock"],2);}}
 foreach($query3 as $um){
        if($um["idunidad_medida"]==$d["idunidad_medida"]){
          echo " ".$um["nombre"];} }?>
     </div>  
  </div> 
  </td>
    <td>
    <div class="col-md-%">
    <input class="form-control" id="c"  type="text" value="<?php echo $key["cantidad"]; ?>" disabled> 
    </div>
    </td>
   <td>
     <div class="col-md-%">
     <input class="form-control"  id="s"  type="text" value="<?php echo $key["subtotal"];?>" disabled>
     </div> 
     </td> 
       <td> 
     <div class="col-md-%">
     <select class="form-control select-md" name="estado2[]">
     <?php if($key["estado"]==""||$key["estado"]==null){?>
     <option  value="<?php echo $key["estado"];?>"><?php if($key["estado"]==1){echo "Sin Observacion";}else{if($key["estado"]==2){echo "Observado";}else{echo "Falta de stock";}}?></option>
     <?php }?>
                  <option  value="1">Sin Observacion</option>
                  <option  value="2">Observado</option>
                  <option value="3">Falta de stock</option>
     </select>
     </div> 
     </td> 
    <td>
    <div class="col-md-%">
    <input type="text"  name="cantidad2[]"  class="form-control" value="<?php echo $key["cantidad_envio"];?>"> 
    </div>
    </td>
    <td>
    <div class="col-md-%">
    <input type="text"  name="subtotal2[]"  class="form-control" value="<?php echo $key["subtotal_envio"];?>" disabled> 
    </div>
    </td>
   <td><?php $cant=($key["cantidad_envio"]/$key["cantidad"])*100; echo $cant." %"; $cant_pro=$cant_pro+$cant; if($key["cantidad_envio"]!=0){$fila2=$fila2+1;}?></td>
  </tr>
  <?php }} ?> 
  <tr>
  <td><h2>Totales</h2></td>
  <td></td>
 <td>Cumplimiento x items</td>
  <td><?php echo number_format(($fila2/$fila)*100)." %"; ?></td>
  <td><?php echo $fila." items"; ?></td>
  <td><?php echo number_format($key["total2"],2)." bs"; ?></td>
 

  <td></td>
 <td><?php echo $fila2." items"; ?></td>
  <td><?php echo number_format($key["total_envio2"],2)." bs"; ?></td>
   <td><?php echo number_format(($cant_pro/$fila),2)." %";?></td>
  </tbody>
         <div class="row">
           <div class="form-group">
             <table width="" border="0" cellspacing="" cellpadding="" align="center">
               <tr>
                <td>  <a href="index.php" class="btn btn-primary"> Atras </a></td>
                <td>  <input  type="submit"   class="btn btn-primary" value="Enviar"></td>
              </tr>
            </div>
          </div>
        </table>
  </div>
  </div>
</div> 
</form>
  </body>
</html>