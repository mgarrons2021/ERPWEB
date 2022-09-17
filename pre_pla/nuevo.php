<?php include"../menu/menu.php";

date_default_timezone_set('America/La_Paz');
$query= $db->GetAll('select * from rol');
$nro=$db->GetOne("select max(nro)+1 from pre_pla");
//echo"este es la sucursal mas 1:".$nro;
//$nro = $db->GetOne('SELECT max(nro)+1 FROM compra');
      if ($nro == '') {
        $nro = 0;
        $nro++;
        }

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$usuario =$_SESSION['usuario'];
$idusuario=$usuario['idusuario'];
$sucursal=$usuario['nombresucursal'];
$sucursal_id=$usuario['sucursal_id'];
//$idreg_ventas=$_POST['idreg_ventas'];
$query3= $db->GetAll('select * from plato');
$query2= $db->GetAll('select * from sucursal');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Registro de precios</title>
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
</head><!--/head-->
    <body onLoad="listar();">
    <div class="container">
    <div class="left-sidebar">
    <h2>registro de nuevo plato</h2>
	  <div class="">
    <form method="post" action="agregar.php" enctype="multipart/form-data">
          <div class="row">
              <div class="col-md-1">
                <label for="">Plato:</label>
               <input type="text" name="nro" id="nro" class="alert alert-success"
                 value="<?php echo "$nro"; ?>" disabled>
                 <input type="hidden" name="nro" id="nro" class="form-control"
                 value="<?php echo "$nro"; ?>">
              </div>
                 <div class="col-md-4">
                 <label>Fecha:</label>
                 <div class="alert alert-success">
                 <?php echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ?>
                 </div>
                </div>
          </div>

         <div class="col-md-12">
             <label class="col-md-5 control-label">Fecha Actual:</label>
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <input type="text" id="fecha" class="input-sm form-control" name="fecha" value="<?php echo date('Y-m-d');?>"/>  
            </div>
          </div>
           <div class="col-md-12">
              <label class="col-md-5 control-label">Plato:</label>
            <div class="col-md-2" >
            <select class="form-control select-md" name="plato" id="plato">
                <option  value="0">Selec plato</option>
                 <?php  foreach($query3 as $plato){ ?>
                  <option  value="<?php echo $plato['idplato'];?>"><?php echo $plato['nombre'];?></option>
                  <?php } ?>
            </select>
            </div>
           </div>
       <div class="col-md-12">
              <label class="col-md-5 control-label">Sucursal:</label>
            <div class="col-md-2" >
            <select class="form-control select-md" name="sucursal" id="sucursal">
                 <option  value="0">Selec sucursal</option>
                 <?php  foreach($query2 as $sucur){ ?>
                  <option  value="<?php echo $sucur['idsucursal'];?>"><?php echo $sucur['nombre'];?></option>
                  <?php } ?>
            </select>
            </div>
           </div>
      <div class="col-md-12">
                <label class="col-md-5 control-label">Categoria:</label>
                <div class="col-md-2" >
              <div class="input-group"> 
              <div class="input-form">
             <select class="form-control select-md" name="categoria" id="categoria">
               <option value="0">Seleccione categoria</option>
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
       </div>

 <div class="col-md-12">
            <label class="col-md-5 control-label">Precio:</label>  
            <div class="col-md-2">
            <input id="precio" type="decimal" name="precio" class="form-control input-md" placeholder="bs." pattern="[z0-9_.]{1,15}">
            </div>
            </div>
            
 <div class="col-md-12">
            <label class="col-md-5 control-label">Precio Delivery:</label>  
            <div class="col-md-2">
            <input id="precio_d" type="decimal" name="precio_d" class="form-control input-md" placeholder="bs." pattern="[z0-9_.]{1,15}">
            </div>
            </div>
            
           
            
         </div>
       <br> 
      <div class="row">
           <div class="form-group">
             <table width="100" border="0" cellspacing="1" cellpadding="4" align="center">
            <tr>

               <td>  <button type="submit" id="ir" class="btn btn-success">ACEPTAR</button></td>
           </tr>
             </table>
          </div>
        </div>
</div>
</form>
</body>
</html>