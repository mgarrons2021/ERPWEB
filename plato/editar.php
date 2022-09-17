<?php include"../menu/menu.php";
date_default_timezone_set('America/La_Paz');
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro=$_GET['nro'];
$idplato=$_GET['idplato'];
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$ventas= $db->GetAll('select * from proveedor');
$query = $ventas;
$produtos= $db->GetAll('select * from producto');
$query2 = $produtos;
$query3= $db->GetRow("select * from plato where idplato='$idplato'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Editar Platos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
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
  valor3=$("#pventa").val();if(np==''){alert("codigo de producto inexistente");$("#codigoproducto").focus();return false;} 
    else if(valor==null||isNaN(valor)||/^s+$/.test(valor)||valor==0){
      alert("ingrese cantidad valida");$("#cantidad").focus();return false;}
             alertify.set('notifier','position','bottom-right');
             alertify.success('Producto Agregado Exitosamente');
               $('#listado').load('registrarinsumo.php',
              {"idprod":$('#idprod').val(),
                "cantidad":$('#cantidad').val(),
                "nro":$('#nro').val(),
                "imagen":$('#imagen').val()
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
<script type="text/javascript">

$(document).ready(function(){
  var colores=["rojo","amarillo","azul","verde","rosado","blanco","negro"];
 $('#color').autocomplete({
surce: colores
     });
   });
});
</script>
</head><!--/head-->
    <body onLoad="listar();">
    <div class="container">
    <div class="left-sidebar">
    <h2>registro de nuevo plato</h2>
	  <div class="">
    <form method="post" action="actualizar.php" enctype="multipart/form-data">
          <div class="row">
              <div class="col-md-1">
                <label for="">Plato:</label>
               <input type="text" name="nro" id="nro" class="alert alert-success"
                 value="<?php echo "$nro"; ?>" disabled>
                 <input type="hidden" name="nro" id="nro" class="form-control"
                 value="<?php echo "$nro"; ?>">
                 <input type="hidden" name="idplato" id="idplato" class="form-control"
                 value="<?php echo "$idplato"; ?>">
              </div>
                 <div class="col-md-4">
                 <label>Fecha:</label>
                 <div class="alert alert-success">
                 <?php echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ?>
                 </div>
                </div>
          </div>
<!--<div class="row"> 
<div class="col-md-3">  
<div class="input-daterange input-group" id="datepicker">
    <span class="input-group-addon"><strong>Fecha De Entrega:</strong> </span>
    <input type="text" id="fechaentrega" class="input-sm form-control" name="fechaentrega" />
</div>
</div>
</div>-->
<br>
<!--proveedor-->
          <div class="row">
            <div class="" id="mensaje"></div>
            <div class="col-md-2">
              <label>Nombre Del Plato:</label>
              <input type="text" name="nombreplato" id="nombreplato" class="form-control" placeholder="Nombre del nuevo plato" value="<?php echo $query3["nombre"]; ?>">
            </div>
             <div class="col-md-2">
              <label>Precio del Plato:</label>
             <div class="input-group">
              <input type="text" step="0.001" name="p_uni" id="p_uni" placeholder="Bs." class="form-control" onkeypress="return validar(event)" value="<?php echo $query3["precio_uni"]; ?>">
                 </div>
            </div>  
            <div class="col-md-2">
              <label>Precio Delivery:</label>
             <div class="input-group">
              <input type="text" step="0.001" name="p_delivery" id="p_delivery" placeholder="Bs." class="form-control" onkeypress="return validar(event)" value="<?php echo $query3["precio_dely"]; ?>">
                 </div>
            </div>
            <div class="col-md-2">
              <label>Categoria:</label>
              <div class="input-group"> 
               <div class="input-form">
              <!--<input type="text" class="form-control"
               placeholder="Buscar por nombre" id="color" >
               </div>-->
               <select class="form-control  " name="categoria" id="categoria" >
               <option value="<?php echo $query3["categoria"]; ?>"><?php echo $query3["categoria"]; ?></option>
                <option value="sopa">Sopas</option>
               <option value="hamburguesas">Hamburguesas</option>
               <option value="especiales">Especiales</option>
               <option value="postres">Postres</option>
               <option value="refrescos">Refrescos</option>
               <option value="combos">Combos</option>
               <option value="parrilla">A la Parrilla</option>
               <option value="porciones">Porciones</option>
               <option value="gaseosas">Gaseosas</option>
               <option value="platos servidos">Platos Servidos</option>
               <option value="pollos">Pollos</option>
               <option value="por kilo">Por kilo</option>
               <option value="menu ejecutivo">menu ejecutivo</option>
               <option value="platos ejecutivo">platos ejecutivo</option>
               <option value="Venta Externa">Venta Externa</option>
               <option value="menu corporativo">Menu Corporativo</option>
               <option value="platos a la carta">Platos a la Carta</option>
               <option value="comida personal">Comida Personal</option>
               </select>
               </div>
            </div>
            </div>
            <div class="col-md-2">
              <label>Costo:</label>
             <div class="input-group">
              <input type="text" step="0.001" name="costo" id="costo" placeholder="Bs." class="form-control" onkeypress="return validar(event)" value="<?php echo $query3["costo"]; ?>">
                 </div>
            </div>
              <div class="col-md-2">
              <label class="col-md-2 control-label">Imagen:</label>  
              <div class="input-group">
              <input type="file" class="btn btn-default" name="imagen" id="imagen">
            </div>
           </div>
          </div>  
<!--fin de proveedor-->
          <div class="row">
             <div class="col-md-3">
              <label>Insumos:</label>
              <div class="input-group"> 
               <div class="input-form">
              <!--<input type="text" class="form-control"
               placeholder="Buscar por nombre" id="color" >
               </div>-->
               <select class="form-control  " name="idprod" id="idprod">
               <option value="0">Seleccione Insumo</option>
               <?php foreach ($query2 as $r){?>
               <option value="<?php echo $r["idproducto"]?>"><?php echo $r["nombre"]; ?></option>
               <?php }?>
               </select>
               </div>
            </div>
            </div>
            <div class="col-md-2">
              <label>Cantidad Insumo por Plato :</label>
              <input type="text" step="0.001" name="cantidad" id="cantidad" class="form-control"
              onkeypress="return validar(event)" value="" onChange="multiplicar();">
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
             <td> <button type="submit" id="btn" class="btn btn-primary">Actualizar</button></td>
              
           </tr>
             </table>
          </div>
        </div>
        </form>
<br><br><br>
<br><br><br>
<br><br><br>

<!--tablas modales-->
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