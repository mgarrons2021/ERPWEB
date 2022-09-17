<?php include"../menu/menu.php";
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$nro=$db->GetOne("select count(sucursal_id)+1 from  pedido where sucursal_id='$sucur'");
 if ($nro == ''){ $nro = 0;$nro++; } 
$inventario=$db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=".$sucur);
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$productos= $db->GetAll("select * from producto where estado like 'activo' ORDER BY nombre ASC;");
$usuario1= $db->GetAll('select * from usuario');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Registro de MAno de Obra</title>
    <link rel="stylesheet" href="../css/estiloyanbal.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/prettyPhoto.css" rel="stylesheet">
    <link href="../css/price-range.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
	<link href="../css/main.css" rel="stylesheet">
	<link href="../css/responsive.css" rel="stylesheet">
 	<link rel="shortcut icon" href="../images/favicon.ico">
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
<!--libreria  para busqueda-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<option src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></option>
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
<script>$(document).ready(function(){
  $('#bp').click(function(){
  var np=$('#nombreprod').val();
  if(np==''){alert('Codigo de producto inexistente');
  $('#productocod').focus();};});});
</script>
<script>
$(document).ready(function(){$("#enviaid").click(function(){
  $.ajax({
    url:'verstock.php',
    type:'POST',
    dataType:'json',
    data:{idproducto:$(document.getElementById("idprod")).val(),
          inventario:$(document.getElementById("nroinventario")).val()}
        }).done(
      function(respuesta){
         $("#idproducto").val(respuesta.idproducto);
         //$("#nombreproducto").val(respuesta.nombreproducto);
         $("#stockactual").val(respuesta.stockactual);
                          });
                                                                });});
</script>
<script>
function restar(){
  m2=parseFloat(document.getElementById("stockactual").value);
 if(m2>0){
   alert("tiene: "+m2+"  de cantidad");
 }
  }
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
  valor3=$("#pventa").val();
  if(np==''){
    alert("codigo de producto inexistente");$("#codigoproducto").focus();return false;} 
    else if(valor==null||isNaN(valor)||/^s+$/.test(valor)||valor==0){
      alert("ingrese cantidad valida");$("#cantidad").focus();return false;}
             alertify.set('notifier','position','bottom-right');
             alertify.success('Producto Agregado Exitosamente');
               $('#listado').load('registrarprestamo.php',
               {"idprod":$('#idprod').val(), //se cambio idproducto por idprod
                "cantidad":$('#cantidad').val(),
                "stockactual":$('#stockactual').val(),
                "sucursal_idtraspaso":$('#sucursal_idtraspaso').val(),
                "nro":$('#nro').val(),
                "total1":$('#total1').val(),
                "total2":$('#total2').val(),
                "nroinventario":$('#nroinventario').val()
               });
               return true;
              }
function eliminar(id){$.post('eliminar.php',{"nro":id},
function(){
  listar();
}
  );}
</script>
<style type="text/css">
option.one {background-color: #FF7400;
font: 20px "Comic Sans MS", cursive; 
font-weight: bold;
 }
</style>
</head><!--/head-->
<body onLoad="listar();">
<div class="container">
  <div class="left-sidebar">
    <h2>Registro MO</h2>
	<div class="">
<form method="post" action="agregar.php">
          <div class="row">
              <div class="col-md-1">
                <label for="">Registro</label>
               <input type="text" name="nro" id="nro" class="alert alert-info"
                 value="<?php echo "$nro"; ?>" disabled>
                 <input type="hidden" name="nro" id="nro" 
                 value="<?php echo "$nro"; ?>">
                <input type="hidden" name="idproducto" id="idproducto" >
                <input type="hidden" name="nroinventario" id="nroinventario" value="<?php echo "$inventario"; ?>" >
              </div>
               
                  <div class="col-md-2">
              <label>Fecha a Registro:</label>
              <input type="date" name="fecha_a_entregar" id="fecha_a_entregar" class="form-control" required>
            </div> 
            </div> 
           <div class="col-md-4">
              <div class="input-group">
               <select class="btn btn-info" name="turno" id="turno">
                <option value="0">SELEC TURNO</option>   
                <option value="1">AM</option>
                <option value="2">PM</option>
               </select>
             </div>
             </div> 
             </div> 
           <div class="row">
       <div class="col-md-3">
        <div class="input-group">
         <label>Registre Trabajador:</label> 
               <select  name="sucursal_idtraspaso" id="sucursal_idtraspaso" class="form-control">
               <option value="">Funcionario</option>
               <?php foreach ($usuario1 as $r){?>
                  <option value="<?php echo $r["idusuario"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
               </select>
		     </div>
        </div>
                  <div class="col-md-2">
              <label>Horas Trabajadas:</label>
              <input type="number"  name="cantidad" id="cantidad" class="form-control"
              onkeypress="return validar(event)" value="" onChange="restar();"> 
            </div>
            </div>
            <div class="col-md-12">
        <label>Ventas:</label>
             <div class="col-md-2">
    <input  id="ventas" name="ventas" placeholder="Bs."  class="form-control input-md" type="decimal" />
         </div>
         </div>
            <div class="col-md-2">
            <label style="color: transparent !important;">.</label>
           <input class="form-control btn-success" type="button" value="Agregar"
            onClick="agregar();">
            </div>
            </div>
            
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
					<center><p class="pull-center">Copyright © SISTEMA DONESCO S.R.L.</p></center>	
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