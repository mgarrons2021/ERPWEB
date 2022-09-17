<html>
  <head>
    <title>listado de insumos</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css"> 
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
</head>
<body class="body">
<?php 
require_once '../config/conexion.inc.php';
session_start();
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
<script >
  function mostrar(){
      contador=document.getElementsByName('c1[]');
      contador2=document.getElementsByName('cantidad[]');
        for(let index = 0; index < document.getElementsByName('c1[]').length; index++){
         contador2[index].value=contador[index].value;    
        }
      console.log("esto es el tamaño de lo sitem:"+contador);
}
  function mostrar2(){
      contador=document.getElementsByName('c1[]');
      contador2=document.getElementsByName('cantidad[]');
        for(let index = 0; index < document.getElementsByName('c1[]').length; index++){
         contador2[index].value=0;    
        }
      console.log("esto es el tamaño de lo sitem:"+contador);
}
  function mostrar3(){
      contador=document.getElementsByName('c2[]');
      contador3=document.getElementsByName('cantidad2[]');
        for(let index = 0; index < document.getElementsByName('c2[]').length; index++){
         contador3[index].value="";    
        }
      console.log("esto no hace nada:"+contador);
}
function obtener(dato){
      contador=document.getElementsByName('c[]');
      contador2=document.getElementsByName('cantidad[]');
       for(let index = 0; index < document.getElementsByName('c1[]').length; index++){
        if(index==dato){
           // if(contador2==0||contador2==null){
                    contador2[index].value=contador[index].value;
            //}else{
              // contador2[index].value=0;
                // }
            }
      }
    if(!empty($_POST['check'])){console.log("se dio check"); }else{console.log("se quito el check");}  
   
}
</script>
<form class="form-horizontal" data-toggle="validator" name="elformulario"  role="" action="obtener2.php" method="post">
<div class="container">
  <div class="left-sidebar">
   <div class="row">
    <div class="col-md-1">
     </div>
     <div class="col-md-10" align="center">
       <h4><?php echo "Listado de Insumos y Produccion Solicitados "?></h4>  
      <h2><?php echo $nom_suc; ?></h2>
      <button type="button" class="btn btn-success" onClick="mostrar2();"> << </button>  
       <button type="button" class="btn btn-success" onClick="mostrar();"> >> </button>  
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
<div class="container">
<table class="table table-striped table-hover table-bordered" border="0" style="width:350px">
        <thead>
            <tr>
            <th>Insumo</th>
            <th>Cant Solicitado</th>
            <th>Cant Enviar</th>
            <th>Opc</th>
            </tr>
        </thead>
        </div>
        <tbody> 
<?php $fila=0; $fila2=0; $cant_ins=0;
foreach ($query as $key){ if($key["idcategoria"]!=2){  
  ?>
    <tr id="filass" class=warning>
    <div class="col-md-%">
    <input type="hidden" name="iddetallepedido[]" class="form-control" value="<?php echo $key["iddetallepedido"];?>"> 
    </div>
    <td><?php echo $key["nombre"];?></td>
    <div class="col-md-%">
     <input class="form-control"  name="p_compra[]" type="hidden" value="<?php echo $key["precio_compra"];?>" >
     </div>
    <td>
    <div class="col-md-%">
    <input class="form-control" style="width : 60px; heigth : 60px" name="c1[]"  type="text" value="<?php echo $key["cantidad"]; ?>" disabled> 
    </div> 
    </td>  
    <td>
    <div class="col-md-%">
    <input type="text" style="width : 60px; heigth : 60px"  name="cantidad[]"  class="form-control" value="<?php echo $key["cantidad_envio"];?>"> 
    </div>
    </td>
    <td>
    <div class="col-md-%">
        <div class="checkbox">
        <?php if($key["cantidad_envio"]==0){?>
        <input type="checkbox" name="check"  onChange="obtener(<?php echo $fila;?>);">
        <?php }else{?>               
        <input type="checkbox" name="check"  onChange="obtener(<?php echo $fila;?>);" checked>
        <?php }?>
        </div>
   </div>
    </td>
     
  </tr>
  <?php $fila=$fila+1; }} ?> 
  <tr>
  <td><h4>Totales</h4></td>

  <td><?php echo number_format($key["total"],2)." bs"; ?></td>

  <td><?php echo number_format($key["total_envio"],2)." bs"; ?></td>
  </tr>
    <tr>
      <th>producion</th>
      <th>cant Solicidato</th>
      <th>cant Enviar</th>
    </tr>
    <?php $fila=0; $fila2=0; $cant_pro=0;
foreach ($query as $key){ if($key["idcategoria"]==2){ $fila=$fila+1;
  ?>
    <tr id="filass" class=warning>
    <div class="col-md-%">
    <input type="hidden"  name="iddetallepedido2[]"  class="form-control" value="<?php echo $key["iddetallepedido"];?>"> 
    </div>

    <td><?php echo $key["nombre"];?></td>
 <div class="col-md-%">
     <input class="form-control"  name="p_compra2[]" type="hidden" value="<?php echo $key["precio_compra"];?>" >
     </div>
    <td>
    <div class="col-md-%">
    <input class="form-control" style="width : 60px; heigth : 60px" name="c2[]"  type="text" value="<?php echo $key["cantidad"]; ?>" disabled> 
    </div>
    </td>
    <td>
    <div class="col-md-%">
    <input type="text" style="width : 60px; heigth : 60px"  name="cantidad2[]"  class="form-control" value="<?php echo $key["cantidad_envio"];?>"> 
    </div>
    </td>
  </tr>
  <?php }} ?> 
  <tr>
  <td><h4>Totales</h4></td>
  <td><?php echo number_format($key["total2"],2)." bs"; ?></td>
  <td><?php echo number_format($key["total_envio2"],2)." bs"; ?></td>
  </tbody>
         <div class="row">
           <div class="form-group">
             <table width="" border="0" cellspacing="" cellpadding="" align="center">
               <tr>
                <td>  <a href="env_dir.php" class="btn btn-primary"> Atras </a></td>
                <td> <button type="reset" onClick="mostrar3();" class="btn btn-warning">LIMPIAR</button></td>
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