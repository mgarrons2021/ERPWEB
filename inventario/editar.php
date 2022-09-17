<?php include"../menu/menu.php";
date_default_timezone_set('America/La_Paz');
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro=$_GET['nro'];
//echo"este es la sucursal mas 1:".$nro;
//$nro = $db->GetOne('SELECT max(nro)+1 FROM compra');
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$ventas= $db->GetAll('select * from proveedor');
$query = $ventas;
$productos= $db->GetAll('select * from producto');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>inventario</title>
    <link rel="stylesheet" href="../css/estiloyanbal.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/prettyPhoto.css" rel="stylesheet">
    <link href="../css/price-range.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
	<link href="../css/main.css" rel="stylesheet">
	<link href="../css/responsive.css" rel="stylesheet">
 	<link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../images/ico/apple-touch-icon-57-precomposed.png">
  <!--libreria  para el calendario-->
  <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
     <script src="../js/jquery.js"></script>
     <script src="../js/jquery-ui.min.js"></script>
     <link href="../css/jqueryui.css" type="text/css" rel="stylesheet"/>
     <link rel="stylesheet" href="../css/jquery-ui.css">
     <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
<script src="../data/librerias/calendario2/js/bootstrap-datepicker.min.js"></script>
<script src="../data/librerias/calendario2/locales/bootstrap-datepicker.es.min.js"></script>
<!--Funcion para script para el calendario-->
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
<script>
$(document).ready(function(){$("#enviarproveedor").click(function(){
  $.ajax({
    url:'proveedor.php',
    type:'POST',
    dataType:'json',
    data:{idproveedor:$('input:radio[name=radio]:checked').val()}
        }).done(
      function(respuesta){
        $("#idproveedor").val(respuesta.idproveedor);
        $("#codigoproveedor").val(respuesta.codigoproveedor);
        $("#nombreproveedor").val(respuesta.nombreproveedor);
                          });
                                                               });});
      </script>
<script>$(document).ready(function(){
  $('#bp').click(function(){
  var np=$('#nombreprod').val();
  if(np==''){alert('Codigo de producto inexistente');
  $('#productocod').focus();};});});
</script>

<script>
$(document).ready(function(){$("#enviarproduc").click(function(){
  $.ajax({
    url:'buscarproducto.php',
    type:'POST',
    dataType:'json',
    data:{idproducto:$(document.getElementById("idprod")).val()}
        }).done(
      function(respuesta){
        $("#idproducto").val(respuesta.idproducto);
        //$("#nombreproducto").val(respuesta.nombreproducto);
         $("#punitario").val(respuesta.precio_compra);
                          });
                                                                   });});
</script>



<script>
function multiplicar(){
  m1=document.getElementById("cantidad").value;
  m2=document.getElementById("punitario").value;
  r=m1*m2;
  document.getElementById("subtotal").value=r;}
</script>

<script>$(document).ready(function(){$("#reg").click(function(){var ci=$("#ci").val();var n=$("#name").val();var ap=$("#ap").val();var t=$("#telf").val();$.post("ajax.php",{ci:ci,name:n,ap:ap,telf:t},function(datos){$("#resultado").html(datos);document.getElementById('ci').value='';document.getElementById('name').value='';document.getElementById('ap').value='';document.getElementById('telf').value='';document.getElementById('ci').focus();});});});</script>



<script language="javascript">
function nro_factura(){$.post('nro_factura.php',function(valor){
  $('#nro_factura').val(valor);}
  );} function listar(){
    $('#listado').load('listar.php',{"nro":$('#nro').val()
    });} 

    //verificar datos vacios 
function agregar(){
  np=$("#nombreproducto").val();
  valor=$("#cantidad").val();
  valor2=$("#punitario").val();
  
  valor3=$("#pventa").val();if(np==''){alert("codigo de producto inexistente");$("#codigoproducto").focus();return false;} 
    else if(valor==null||isNaN(valor)||/^s+$/.test(valor)||valor==0){
      alert("ingrese cantidad valida");$("#cantidad").focus();return false;}

       else if(valor2==null||isNaN(valor2)||/^s+$/.test(valor2)||valor2==0){
         alert("Precione en buscar para insetar precio");$("#punitario").focus();return false;}
 
       

             alertify.set('notifier','position','bottom-right');
             alertify.success('Producto Agregado Exitosamente');
               $('#listado').load('registrarVenta.php',
              {"idproducto":$('#idproducto').val(),
                "idproveedor":$('#idproveedor').val(),
                "cantidad":$('#cantidad').val(),
                "pventa":$('#pventa').val(),
                "punitario":$('#punitario').val(),
                "fechaentrega":$('#fechaentrega').val(),
                "nro":$('#nro').val()
              });
               return true;
              } 

function eliminar(id){$.post('eliminar.php',{"nro":id},

function(){
  listar();
}
  );}
</script>


<script type="text/javascript">$(document).ready(function(){$('#usuario').DataTable({"language":{"sProcessing":"Procesando...","sLengthMenu":"Mostrar _MENU_ registros","sZeroRecords":"No se encontraron resultados","sEmptyTable":"Ningun dato disponible en esta tabla","sInfo":"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros","sInfoEmpty":"Mostrando registros del 0 al 0 de un total de 0 registros","sInfoFiltered":"(filtrado de un total de _MAX_ registros)","sInfoPostFix":"","sSearch":"Buscar:","sUrl":"","sInfoThousands":",","sLoadingRecords":"Cargando...","oPaginate":{"sFirst":"Primero","sLast":"Ãšltimo","sNext":"Siguiente","sPrevious":"Anterior"},"oAria":{"sSortAscending":": Activar para ordenar la columna de manera ascendente","sSortDescending":": Activar para ordenar la columna de manera descendente"}}});});</script>
<style type="text/css">
option.one {background-color: #FF7400;
font: 20px "Comic Sans MS", cursive; 
font-weight: bold;}
</style>
</head><!--/head-->
    <body onLoad="listar();">
    <div class="container">
    <div class="left-sidebar">
    <h2>editar Inventario</h2>
	  <div class="">
    <form method="post" action="actualizar.php">
           <div class="row">
              <div class="col-md-1">
                <label for="">inventario:</label>
               <input type="text" name="nro" id="nro" class="alert alert-success"
                 value="<?php echo "$nro"; ?>" disabled>
                 <input type="hidden" name="nro" id="nro" class="form-control"
                 value="<?php echo "$nro"; ?>">
                 <input type="hidden" name="idproveedor" id="idproveedor" class="form-control">
                 <input type="hidden" name="idproducto" id="idproducto" class="form-control">
                 </div>
                 <div class="col-md-4">
                 <label>Fecha:</label>
                 <div class="alert alert-success">
                 <?php echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ?>
                 </div>
                </div>
          </div>
<!--fin de proveedor-->
<div class="row">
             <div class="col-md-5">
              <div class="input-group">
               <select class="btn btn-success" name="ids" id="ids">
                <option value="diario">DIARIO</option>
                <option value="semanal">SEMANAL</option>
               </select>
             </div>
            </div>
          </div>
  <div class="row">
             <div class="col-md-3">
              <div class="input-group">
              <label>Producto:</label>
               <select class="form-control" name="idprod" id="idprod">
                <?php for ($i=2; $i <= 15 ; $i++){?> 
                <option class="one" value="0"><h2>
                <?php if($i==2){echo "-----PRODUCCION-----";}    
                          if($i==3){echo "**********---ABARROTES---*********";}
          if($i==4){echo "**********---ALIMENTOS---*********";}
          if($i==5){echo "**********---BEBIDAS---*********";}
          if($i==6){echo "**********---MATERIAL DE LIMPIEZA---*********";}
          if($i==7){echo "**********---PLASTICOS---*********";}
          if($i==8){echo "**********---ZUMOS---*********";}
          if($i==13){echo "**********---INSUMOS PROCESADOS---*********";}
          if($i==9){echo "**********---VERDURAS---*********";}
          if($i==12){echo "**********---CARNES---*********";}
          if($i==14){echo "**********---LACTEOS/FIAMBRES---*********";}
          if($i==11){echo "**********---POLLOS---*********";}
          if($i==15){echo "**********---SALSAS---*********";}
                
                ?></h2></option>
                <?php foreach ($productos as $r){
                if($r["idcategoria"]==$i){?>
                <option value="<?php echo $r["idproducto"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }}}?>
               </select>
             </div>
            </div>
            <div class="col-md-3">
              <label>Precio Actual:</label>
             <div class="input-group">
              <input type="number" step="0.001" name="punitario" id="punitario" placeholder="Bs." class="form-control"
              onkeypress="return validar(event)" value=""onChange="multiplicar();" disabled>
               <span class="input-group-btn">
                    <a data-toggle="modal" href="#" >
                      <button  class="btn btn-default" type="button" id="enviarproduc"><span class="glyphicon glyphicon-search"></span></button>
                     </a>
                 </span>
                 </div>
            </div>


            <div class="col-md-2">
              <label>Cantidad:</label>
              <input type="number" step="0.001" name="cantidad" id="cantidad" class="form-control"
              onkeypress="return validar(event)" value=""onChange="multiplicar();">
            </div>
           
            <!--
            <div class="col-md-2">
              <label>Precio de compra:</label>
              <input type="number" step="0.001" name="pventa" id="pventa" placeholder="Bs." class="form-control"
              onkeypress="return validar(event)" value="">
            </div>
            -->
            <div class="col-md-2">
            <label>Subtotal:</label>
            <input type="number" step="0.001" name="subtotal" id="subtotal" placeholder="Bs." class="form-control"
            value=""disabled>
            </div>
            <!-- boton agregar al carrito de compras-->
            <div class="col-md-1">
            <label>.</label>
            <input class="form-control " type="button" value="Agregar"
            onClick="agregar();">
            </div>
            </div>
            <br>
            
            <!--aqui esta el listado del carrito de compras-->
            
             
            </script>
          <div class="row">
              <div id="listado"></div>
            </div>
          </div>
         <div class="row">
           <div class="form-group">
             <table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
            <tr>
             <td><a href="index.php" id="btn" class="btn btn-primary">Cancelar</a></td>
            <td><button type="submit" id="btn" class="btn btn-primary">Actualizar</button></td>  
           </tr>
             </table>
          </div>
        </div>
        </form>
<br><br><br>
<br><br><br>
<br><br><br>

<!--tablas modales-->
<!-- modal del proveedor-->
<div class="modal fade" id="Modalproveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" align="center">listado de provedores</h4>
        </div>
        <div class="modal-body">    
<table id="usuario" class="table table-striped table-hover table-bordered"
        cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nro:</th>
                <th>codigo</th>
                <th>Nombre</th>
                <th>Selec</th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($query as $r){?>
<tr>
<td><?php echo $r["idproveedor"]; ?></td>
 <td><?php echo $r["codigo"]; ?></td>
  <td><?php echo $r["nombre"]; ?></td>
    <td>
    <input type="radio" id="radio" name="radio" value="<?php echo $r["idproveedor"]?>">
  </td>
 </tr>
 <?php }?>
</table>
        <div align="right">
        <input type="submit" id="enviarproveedor" class="btn btn-primary"
        value="Insertar" class="close" data-dismiss="modal" aria-hidden="true">
        </div>
        </div>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>



    <footer id="footer">
		 </div>
		 </div>
		 <div class="footer-bottom">
			<div class="container">
				<div class="row">
					<center><p class="pull-center">Copyright © SISTEMA DONESCO.</p></center>	
				</div>
			</div>
		 </div>
		</footer>		
</div>
</div>
</div>

</body>
</html>
