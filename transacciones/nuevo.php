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
    <h2>registro de transacciones por Hora <br> <?php echo $sucursal;?></h2>
    <div style="text-align:center;">
    <table border="0" style="margin: 0 auto;">
           <tr>
           <td><a href="nuevo_am.php"  class="btn btn-success"><h1> AM </h1></a></td>
           <td><a href="nuevo_pm.php" id="ir" class="btn btn-success"><h1> PM </h1></a></td>
           </tr>
                </table>
           </div>
</form>
</div>
</div>
</body>
</html>