<?php require_once '../config/conexion.inc.php';

$usuario =$_SESSION['usuario'];
$idusuario=$usuario['idusuario'];
$sucursal=$usuario['nombresucursal'];
$sucursal_id=$usuario['sucursal_id'];
//$idreg_ventas=$_POST['idreg_ventas'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Envios a Sucursales</title>
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
    <link rel="stylesheet" href="../css/intlTelInput.css"> 
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <script>
function sumar(){
  m1=parseFloat(document.getElementById("gaseosas").value);
  m2=parseFloat(document.getElementById("plato_servido").value);
  m3=parseFloat(document.getElementById("hamburguesas").value); 
  m4=parseFloat(document.getElementById("delivery").value);
  m5=parseFloat(document.getElementById("platos").value);
  m6=parseFloat(document.getElementById("kl").value);
  m7=parseFloat(document.getElementById("porciones").value);
  m8=parseFloat(document.getElementById("refrescos").value);
  m9=parseFloat(document.getElementById("venta_externa").value);
   if(isNaN(m1)){m1=0;}
   if(isNaN(m2)){m2=0;}
   if(isNaN(m3)){m3=0;}
   if(isNaN(m4)){m4=0;}
   if(isNaN(m5)){m5=0;}
   if(isNaN(m6)){m6=0;}
   if(isNaN(m7)){m7=0;}
   if(isNaN(m8)){m8=0;}
   if(isNaN(m9)){m9=0;}
   suma=m1+m2+m3+m4+m5+m6+m7+m8+m9;
   document.getElementById("total").value=suma;
   console.log(m1);
  }
</script>
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
<div class="container">
	<div class="left-sidebar">
<form class="form-horizontal" data-toggle="validator" name="elformulario"  role="" action="agregar.php" method="post">
    <h2>Pedidos sucursales</h2>
    
          </div><tr><td>
        <div class="row">
           <div class="form-group">
             <table width="201" border="1" cellspacing="1" cellpadding="4" align="center">  
         </td><tr>
          <div class="col-md-12">
            <div class="col-md-2">
            <a href="index2.php?id=1" type="button" class="btn btn-success">SUC. BODEGA PRINCIPAL</a>
            </div>
            </div>
         </tr>
         <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=2" type="button" class="btn btn-info">SUC. SUR</a>
            </div>
          </div>
          
          <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=3" type="button" class="btn btn-success">SUC. PARAGUA</a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=4" type="button" class="btn btn-info">SUC. PALMAS</a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=5" type="button" class="btn btn-success">SUC. TRES PASOS</a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=6" type="button" class="btn btn-info">SUC. PAMPA</a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=7" type="button" class="btn btn-success">SUC. RADIAL 26</a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=8" type="button" class="btn btn-info">SUC. QDELI VILLA</a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=9" type="button" class="btn btn-success">SUC. BAJIO</a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=10" type="button" class="btn btn-info">SUC. ARENAL</a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=11" type="button" class="btn btn-success">SUC. PLAN 3000</a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=12" type="button" class="btn btn-info">SUC. ROCA</a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=13" type="button" class="btn btn-success">SUC. VILLA</a>
            </div>
          </div>
           <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=14" type="button" class="btn btn-info">SUC. MUTUALISTA</a>
            </div>
          </div>
           <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=15" type="button" class="btn btn-success">SUC. CINE CENTER</a>
            </div>
          </div>
           <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=16" type="button" class="btn btn-info">SUC. BOULEVARD</a>
            </div>
          </div>
           <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=18" type="button" class="btn btn-success">SUC. QDELI VILLA 3</a>
            </div>
          </div>
           <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=19" type="button" class="btn btn-info">SUC. CENTRO DE PRODUCCION</a>
            </div>
          </div>
            <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=20" type="button" class="btn btn-success">SUC. OFICINA</a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <a href="index2.php?id=22" type="button" class="btn btn-info">SUC. CORTIJO</a>
            </div>
          </div>
         
       <br> 
      
         
             </table>
          </div>
        </div>
</div>
</form>
</body>
</html>