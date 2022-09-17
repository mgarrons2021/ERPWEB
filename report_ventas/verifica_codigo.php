<?php include"../menu/menu.php";
date_default_timezone_set('America/La_Paz');
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$ultimo= $db->GetOne("select max(idautorizacion) from auntorizacion where sucursal_id=$sucur"); 
$dat_empre= $db->GetRow("SELECT * FROM auntorizacion WHERE sucursal_id=$sucur and idautorizacion=$ultimo"); 
$codigoControl = "";
if(isset($_REQUEST['generar_CC'])){
    require("../librerias/codigo_control/CodigoControl.php");
    $authorizationNumber=$_POST['autorizacion'];
    $invoiceNumber=$_POST['factura'];
    $nitci=$_POST['nit'];
    $dateOfTransaction=$_POST['fecha']; //20210409
    $transactionAmount=$_POST['monto']; //0.76 = 1
    $dosageKey=$_POST['llave'];
    $fecha_compra = str_replace("-", "", $dateOfTransaction);
    $monto_compra = round($transactionAmount);
    $codigoControl = CodigoControl::generar($authorizationNumber, $invoiceNumber, $nitci, str_replace("-", "", strval($fecha_compra)), strval(round($monto_compra)), $dosageKey);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>verificar</title>
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
<style type="text/css">
option.one {background-color: #FF7400;
font: 20px "Comic Sans MS", cursive; 
font-weight: bold;}
</style>
</head><!--/head-->
<body onLoad="listar();">
<div class="container">
  <div class="left-sidebar">
    <h2>verificar codigo de control</h2>
	<div class="">
<form method="post" action="">
            <div class="col-md-2">
            <label>Autorizacion:</label>
            <input type="text"  name="autorizacion" id="autorizacion" value="<?php echo $dat_empre['n_auto'];?>"> 
            </div>
            <div class="col-md-2">
            <label>Nro. Factura:</label>
            <input type="text"  name="factura" id="factura"  value="<?php echo $dat_empre['n_factura'];?>"  >
            </div>
            <!-- boton agregar al carrito de compras-->
            <div class="col-md-2">
            <label>Nit/Ci</label>
             <input type="text"  name="nit" id="nit" value="<?php echo $dat_empre['nit_suc'];?>" >
            </div>
             <div class="col-md-2">
            <label>fecha</label>
             <input type="text"  name="fecha" id="fecha"  >
            </div>
              <div class="col-md-2">
            <label>Monto</label>
             <input type="text"  name="monto" id="monto"  >
            </div>
             <div class="col-md-2">
            <label>Llave</label>
             <input type="text"  name="llave" id="llave" value="<?php echo $dat_empre['llave'];?>" >
            </div>
          
             <div class="col-md-2">
            <label>codigo Verificacion</label>
             <input type="text" value="<?php echo $codigoControl; ?>" name="codigo" id="codigo"  >
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
              <td>  <button type="submit" name="generar_CC" id="btn" class="btn btn-primary">Generar</button></td>
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