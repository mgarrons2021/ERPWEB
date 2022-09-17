<html>
	<head>
	<title>Reporte de Pedidos Automáticos</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
    <!-- Bootstrap CSS -->
    <!--font awesome con CDN--> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  
<script>
var f = new Date();
</script>
</head>
<body class="body">
<?php include"../menu/menu.php";
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true"){
$min=$_GET["fechaini"];
$max=$_GET["fechamax"];
$sucur=$_GET['selec_sucur'];
$stock_ideal= $db->GetAll("SELECT * FROM inv_ideal where sucursal_id=$suc");
$max_ids=$db->GetAll("(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=15 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=2 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=13 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=14 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=16 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=4 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=12 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=11 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=7 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=3 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=5 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=6 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=10 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=8 and s.idsucursal=inventario.sucursal_id)
UNION(SELECT s.nombre ,inventario.sucursal_id ,max(nro)as nro FROM inventario, sucursal s where sucursal_id=9 and s.idsucursal=inventario.sucursal_id)");
//$ventas= $db->GetAll("SELECT * FROM inv_ideal where sucursal_id=$suc");
$max_id=$db->GetOne("SELECT max(nro)as nro FROM inventario where sucursal_id=$sucur");
//$inv= $db->GetAll("SELECT di.* FROM inventario i , detalleinventario di where i.nro=di.nro and i.sucursal_id=di.sucursal_id and i.sucursal_id=$suc and i.fecha BETWEEN $min and $max and i.idinventario=$max_id");
//$idautorizacion=$db->GetOne("SELECT max(idautorizacion)as idautorizacion FROM auntorizacion  WHERE sucursal_id=$sucur and estado='si'");
//$n_auto=$db->GetOne("SELECT n_auto FROM auntorizacion WHERE sucursal_id=$sucur and estado='si' and idautorizacion=$idautorizacion");
$query= $db->GetAll("SELECT p.*,di.*,
     ifnull(di.totali, 0)as entrads,
      ifnull(dc.total, 0)as entrad,
     ifnull(dpv.totalv, 0)as salidav,
     ifnull(dpro.totalpro, 0)as salidapro,
	 ifnull(di.totali, 0)-ifnull(dpv.totalv, 0)as stock
	 from producto p left join
	   (select producto_id,sum(cantidad) totali from detalleinventario where sucursal_id='$sucur' and nro='$max_id' group by producto_id) di on p.idproducto = di.producto_id
 	  
	   left join(select producto_id,sum(cantidad) total from inv_ideal where sucursal_id='$sucur' group by producto_id) dc on p.idproducto = dc.producto_id
	    left join(select producto_id,sum(d.cantidad) totalpro from detalleproduccion d, produccion pro where d.sucursal_id='$sucur' and d.sucursal_id=pro.sucursal_id and pro.fecha='$min' and pro.nro=d.nro group by producto_id) dpro on p.idproducto = dpro.producto_id 
	   left join(select dv.plato_id,pro.nombre as insumo,dpv.producto_id ,sum(dv.cantidad*dpv.cantidad)as totalv
from detalleventa dv,venta v,plato pla,detalleplato dpv, producto pro
where dv.sucursal_id='$sucur' and  v.fecha='$min' and
v.sucursal_id=dv.sucursal_id and 
v.idturno=dv.idturno and dv.nro=v.nro and 
dv.plato_id=pla.idplato and pla.nro=dpv.nro 
and dpv.producto_id=pro.idproducto
GROUP BY producto_id
) dpv on p.idproducto = dpv.producto_id
     ;");


     $s_nombre =$db->GetOne("SELECT nombre FROM sucursal WHERE idsucursal = $sucur");
}


/*else{
$min=date("Y-m-d");
$max=date('Y-m-d');
$ventas= $db->GetAll("SELECT v.*, c.* FROM venta v, cliente c WHERE v.sucursal_id='1' and v.cliente_id=c.idcliente and v.fecha between '$min' and '$max' order by v.fecha desc");
$dat_sucur= $db->GetRow("SELECT * FROM `auntorizacion` WHERE sucursal_id='1' and estado='si'");
}*/
if(isset($_POST["export_data"])){
 if(!empty($libros)){
 $filename = "libros.xls";
 header("Content-Type: application/vnd.ms-excel");
 header("Content-Disposition: attachment; filename=".$filename);
 $mostrar_columnas = false;
 foreach($ventas as $libro){
 if(!$mostrar_columnas){
 echo implode("\t", array_keys($libro)) . "\n";
 $mostrar_columnas = true;
 }
 echo implode("\t", array_values($libro)) . "\n";
 }
 }else{
 echo 'No hay datos a exportar';
 }
exit;
}
$sucursal= $db->GetAll('select * from sucursal');
$producto= $db->GetAll('select * from producto');
?>
<div class="container">
<div class="left-sidebar">
<h2>Pedidos Automaticos<br><?php echo "De: ".$db->GetOne("SELECT nombre FROM sucursal WHERE idsucursal=$sucur");?><br><h4><?php echo "Desde: ".$min." hasta ".$max;?></h4></h2>
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
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js">
    </script>
  <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
  <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
  <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript">
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = Date.parse( $('#min').val(), 10 );
        var max = Date.parse( $('#max').val(), 10 );
        var age = Date.parse( data[0] ) || 0; // use data for the age column

        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && age <= max ) ||
             ( min <= age   && isNaN( max ) ) ||
             ( min <= age   && age <= max ) )
        {
            return true;
        }
        return false;
    }
);

 $(document).ready(function() {
                    $('#example').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'print'
                        ]
                    });
                });
</script>
<form action="">  
<div class="row"> 
<div class="col-md-7">  
<div class="input-daterange input-group" id="datepicker">  
 <select class="form-control select-md" name="selec_sucur" id="selec_sucur" >
     <option value="0">seleccione una surcursal</option>
     <?php foreach ($sucursal as $r){?>
                  <option value="<?php echo $r["idsucursal"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
     </select>
    <span class="input-group-addon"><strong>Fecha De:</strong> </span>
    <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" value="<?php echo date("Y-m-d"); ?>"/>
    <span class="input-group-addon">A</span>
    <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" value="<?php echo date("Y-m-d");?>"/>  
    <input  type = "hidden" id = "form_sent" name = "form_sent" value = "true" >
</div>
</div>
<div class="col-md-1">"
<input class="form-control btn-info" type="submit" value="Filtrar" id="filtrar name="filtrar">
</div>
<!--<button type="submit" id="export_data" name='export_data'
value="Export to excel" class="btn btn-info">Exporta ra Excel</button>-->
<button class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalForm">
    Todas las sucursales
</button>
<div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">PEDIDOS AUTOMATICOS DE: TODAS LAS SUCURSALES</h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                <div class="table-responsive">
<table id="example" class="table table-responsive table-striped table-bordered table-hover" cellspacing="" width="560px">
        <thead>
           <tr>
           	<th>PRODUCTO</th>
                <th>ENVIAR</th>
                <th>SUCURSAL</th>
                
           </tr>
        </thead>
      <!--  <tfoot>
              <tr>
            </tr>
        </tfoot> -->
        <tbody>
<?php $c=0; $total=0;  $total2=0;foreach ($max_ids as $a){
     $sucur2 = $a['sucursal_id'];
     $max_id2 = $a['nro'];
     $nombre2     = $a['nombre'];
    $query2= $db->GetAll("SELECT p.*,di.*,
    ifnull(di.totali, 0)as entrads,
     ifnull(dc.total, 0)as entrad,
    ifnull(dpv.totalv, 0)as salidav,
    ifnull(dpro.totalpro, 0)as salidapro,
    ifnull(di.totali, 0)-ifnull(dpv.totalv, 0)as stock
    from producto p left join
      (select producto_id,sum(cantidad) totali from detalleinventario where sucursal_id= '$sucur2' and nro='$max_id2' group by producto_id) di on p.idproducto = di.producto_id
      
      left join(select producto_id,sum(cantidad) total from inv_ideal where sucursal_id='$sucur2' group by producto_id) dc on p.idproducto = dc.producto_id
       left join(select producto_id,sum(d.cantidad) totalpro from detalleproduccion d, produccion pro where d.sucursal_id='$sucur2' and d.sucursal_id=pro.sucursal_id and pro.fecha='$min' and pro.nro=d.nro group by producto_id) dpro on p.idproducto = dpro.producto_id 
      left join(select dv.plato_id,pro.nombre as insumo,dpv.producto_id ,sum(dv.cantidad*dpv.cantidad)as totalv
from detalleventa dv,venta v,plato pla,detalleplato dpv, producto pro
where dv.sucursal_id='$sucur2' and  v.fecha='$min' and
v.sucursal_id=dv.sucursal_id and 
v.idturno=dv.idturno and dv.nro=v.nro and 
dv.plato_id=pla.idplato and pla.nro=dpv.nro 
and dpv.producto_id=pro.idproducto
GROUP BY producto_id
) dpv on p.idproducto = dpv.producto_id
    ;");
    foreach ($query2 as $r){if($r['entrad']!=0){?>
  <tr class=warning>
       <td><?php echo $r['nombre']; ?></td>
                                <td><?php
                                if (($r['entrad'] - $r["entrads"])<0)
                                {
                                    echo 0;

                                }
                                else echo $r['entrad'] - $r["entrads"]; ?></td>
                                <td><?php echo $nombre2?></td>
                                
  </tr>
  <?php }}}?>
  </table>
  </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</form>
<div class="table-responsive">
<table id="example" class="table table-responsive table-striped table-bordered table-hover" cellspacing="" width="100px">
        <thead>
           <tr>
           	<th>PRODUCTO</th>
                <th>REQUERIMIENTO SEGUN INVENTARIO</th>
                <th>SUCURSAL</th>
                <th>STOCK IDEAL</th>
                <th>VENTA</th>
                <th>INVENTARIO FINAL</th>
                <th>REQUERIMIENTO SEGUN VENTAS</th>
           </tr>
        </thead>
      <!--  <tfoot>
              <tr>
            </tr>
        </tfoot> -->
        <tbody>
<?php $c=0; $total=0;  $total2=0;foreach ($query as $r){if($r['entrad']!=0){?>
  <tr class=warning>
       <td><?php echo $r['nombre']; ?></td>
                                <td><?php echo $r['entrad'] - $r["entrads"]; ?></td>
                                <td><?php echo $s_nombre?></td>
                                <td><?php echo $r['entrad']; ?></td>
                                <td><?php echo $r['salidav'] + $r['salidapro']; ?></td>
                                <td><?php echo $r["entrads"] . " " //.$unidadmedida;//inventario 
                                    ?></td>
                                <td><?php echo $r['salidav'] + $r['salidapro']; ?></td>
  </tr>
  <?php }}?>
  </table>
  </div>
  </div>
</div>
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="jquery/jquery-3.3.1.min.js"></script>
    <script src="popper/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- datatables JS -->
    <script type="text/javascript" src="datatables/datatables.min.js"></script> 
    <!-- para usar botones en datatables JS -->  
    <script src="datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="datatables/JSZip-2.5.0/jszip.min.js"></script>    
    <script src="datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
    <script src="datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
    <!-- código JS propìo-->    
    <script type="text/javascript" src="main.js"></script>  
</body>
</html>