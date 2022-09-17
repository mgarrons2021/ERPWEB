<?php include"../menu/menu.php";
$query= $db->GetAll('select * from rol');
$query2= $db->GetAll('select * from sucursal');
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
    <title>Registro de transacciones</title>
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
  m1=parseFloat(document.getElementById("hora1").value);
  m2=parseFloat(document.getElementById("hora2").value);
  m3=parseFloat(document.getElementById("hora3").value); 
  m4=parseFloat(document.getElementById("hora4").value);
  m5=parseFloat(document.getElementById("hora5").value);
  m6=parseFloat(document.getElementById("hora6").value);
  m7=parseFloat(document.getElementById("hora7").value);
  m8=parseFloat(document.getElementById("hora8").value);
  m9=parseFloat(document.getElementById("hora9").value);
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

<div class="container" >

	<div class="left-sidebar">
<form class="form-horizontal" data-toggle="validator" name="elformulario"  role="" action="agregar.php" method="post">
    <h2>registro de transacciones por Hora <br> <?php echo $sucursal;?><br>Turno AM</h2>
      <input type="hidden" name="idusuario" id="idusuario" value="<?php echo "$idusuario"; ?>">
       <input type="hidden" name="idsucursal" id="idsucursal" value="<?php echo "$sucursal_id"; ?>">
       <input type="hidden" name="turno" id="turno" value="AM">
         <div class="col-md-12">
            <label class="col-md-5 control-label">FECHA ACTUAL:</label>
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <input type="text" id="fecha" class="input-sm form-control" name="fecha" value="<?php echo date('Y-m-d');?>"/>
         </div>
            </div>
        <div class="col-md-12">
            <label class="col-md-5 control-label">08:00 - 09:00 AM:</label>  
            <div class="col-md-2">
            <input id="hora1" type="decimal" name="hora1" class="form-control input-md" placeholder="T.T.">
          </div>
        </div>

 <div class="col-md-12">
            <label class="col-md-5 control-label">09:00 - 10:00 AM:</label>  
            <div class="col-md-2">
            <input id="hora2" type="decimal" name="hora2" class="form-control input-md" placeholder="T.T." pattern="[z0-9_.]{1,15}">
            </div>
            </div>

            <div class="col-md-12" >
            <label class="col-md-5 control-label">10:00 - 11:00 AM:</label>  
            <div class="col-md-2">
            <input id="hora3" type="decimal" name="hora3" class="form-control input-md" placeholder="T.T." pattern="[z0-9_.]{1,15}">
            </div>
            </div>

            <div class="col-md-12">
            <label class="col-md-5 control-label">11:00 - 12:00 AM:</label>  
            <div class="col-md-2">
            <input id="hora4" type="decimal" name="hora4" class="form-control input-md" placeholder="T.T." pattern="[z0-9_.]{1,15}">
            </div>
            </div>

            <div class="col-md-12">
            <label class="col-md-5 control-label">12:00 - 01:00 PM:</label>  
            <div class="col-md-2">
            <input id="hora5" type="decimal" name="hora5" class="form-control input-md" placeholder="T.T." pattern="[z0-9_.]{1,15}">
            </div>
            </div>

            <div class="col-md-12">
            <label class="col-md-5 control-label">01:00 - 02:00 PM:</label>  
            <div class="col-md-2">
            <input id="hora6" type="decimal" name="hora6" class="form-control input-md" placeholder="T.T." pattern="[z0-9_.]{1,15}">
            </div>
            </div>

            <div class="col-md-12">
            <label class="col-md-5 control-label">02:00 - 03:00 PM:</label>  
            <div class="col-md-2">
            <input id="hora7" type="decimal" name="hora7" class="form-control input-md" placeholder="T.T." pattern="[z0-9_.]{1,15}">
            </div>
            </div>

           <div class="col-md-12">
            <label class="col-md-5 control-label">03:00 - 04:00 PM:</label>  
            <div class="col-md-2">
            <input id="hora8" type="decimal" name="hora8" class="form-control input-md" placeholder="T.T." pattern="[z0-9_.]{1,15}">
            </div>
            </div>

           <div class="col-md-12">
            
            <div class="col-md-2">
            <input id="hora9" type="hidden" name="hora9" class="form-control input-md" placeholder="T.T." pattern="[z0-9_.]{1,15}" >
            </div>
            
            </div>
          <div class="col-md-12">
          <label class="col-md-5 control-label">.</label> 
            <div class="col-md-2">
            <input type="button" id="igual" name="igual" class="form-control  input-md btn-success" value="SUMAR" onClick="sumar();"></input>
            </div>
            </div>

           <div class="col-md-12">
            <label class="col-md-5 control-label">Total Transacciones:</label>  
            <div class="col-md-2">
            <input id="total" type="decimal" name="total" class="form-control input-md" pattern="[z0-9_.]{1,15}">
            </div>
            </div>

        
       <br> 
      <div class="row">
           <div class="form-group">
             <table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
            <tr>
              <td> <button type="reset" class="btn btn-primary">LIMPIAR</button></td>
               <td>  <button type="submit" id="ir" class="btn btn-success">ACEPTAR</button></td>
              <td><a href="nuevo.php" class="btn btn-primary" role="button">ATRAS</a></td>
           </tr>
             </table>
          </div>
        </div>
</div>
</form>
</body>
</html>