<?php include"../menu/menu.php";
date_default_timezone_set('America/La_Paz');
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro=$db->GetOne("select max(nro)+1 from pedido where sucursal_id='$sucur'");
      if ($nro == ''){
        $nro = 0;
        $nro++;
        }
$inventario=$db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sucur);
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$productos= $db->GetAll('select * from producto ORDER BY nombre ASC');
$sucursal= $db->GetAll('select * from sucursal');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Insumos</title>
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
  valor2=$("#stockactual").val();
       if(valor==null||isNaN(valor)||/^s+$/.test(valor)||valor==0){
      alert("ingrese cantidad valida");$("#cantidad").focus();return false;}
       else{      
             alertify.set('notifier','position','bottom-right');
             alertify.success('Producto Agregado Exitosamente');
               $('#listado').load('registrarprestamo.php',
               {"idproducto":$('#idproducto').val(),
                "cantidad":$('#cantidad').val(),
                "nro":$('#nro').val(),
               });
               return true;
              }}
function eliminar(id){$.post('eliminar.php',{"nro":id},
function(){
  listar();
}
  );}
</script>
</head><!--/head-->
<body onLoad="listar();">
<div class="container">
  <div class="left-sidebar">
    <h2>Solicitud de Insumos</h2>
	<div class="">
<form method="post" action="agregar.php">
          <div class="row">
              <div class="col-md-1">
                <label for="">Traspaso:</label>
               <input type="text" name="nro" id="nro" class="alert alert-info"
                 value="<?php echo "$nro"; ?>" disabled>
                 <input type="hidden" name="nro" id="nro" 
                 value="<?php echo "$nro"; ?>">
                <input type="hidden" name="nroinventario" id="nroinventario" value="<?php echo "$inventario"; ?>" >
              </div>
               <div class="col-md-4">
                <label>Fecha:</label>
                <div class="alert alert-info">
                <?php echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ?>
                </div>
              </div>
          </div>
          <div class="row">
             <div class="col-md-3">
              <div class="input-group">
              <label>Producto:</label>
               <select class="form-control" name="idproducto" id="idproducto">
                <option value="0">Seleccione producto</option>
                <?php foreach ($productos as $r){?>
                  <option value="<?php echo $r["idproducto"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
               </select>
             </div>
            </div>
            <div class="col-md-2">
              <label>Cantidad solicitar:</label>
              <input type="number"  name="cantidad" id="cantidad" class="form-control"
              onkeypress="return validar(event)" value="" onChange="restar();"> 
            </div>
            <!-- boton agregar al carrito de compras-->
            <div class="col-md-2">
            <label>.</label>
            <input class="form-control " type="button" value="Agregar"
            onClick="agregar();">
            </div>
            </div>
            <br>
            <!--aqui esta el listado del carrito de compras-->
          <div class="row">
              <div id="listado"></div>
            </div>
          </div>
         <div class="row">
           <div class="form-group">
             <table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
            <tr>
              <td>  <button type="submit" id="btn" class="btn btn-primary">Aceptar</button></td>
              <td> <button type="reset" class="btn btn-primary">limpiar</button></td>
           </tr>
             </table>
          </div>
        </div>
        </form>
<br><br><br>
<br><br><br>
<br><br><br>
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
<script>
 var boton=document.getElementById("enviaid").addEventListener("click",ver);
 function ver(){
   console.log(document.getElementById("sucursal_idtraspaso").value);
}
</script>