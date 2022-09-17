<?php
include('../menu/menu.php') 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Registro de cliente</title>
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
</head><!--/head-->

<body class="body">

<div class="container" class="left-sidebar">
	<div  class="left-sidebar">



<form class="form-horizontal" data-toggle="validator"  role="form" action="agregar.php" method="post">
   
       <h2>Registro de Nuevo cliente</h2>

<!-- Text input
         <div class="form-group">
              <label class="col-md-4 control-label">C&oacute;DIGO:</label>  
            <div class="col-md-4">
            <input id="codigo" name="codigo" placeholder="codigo" class="form-control input-md" type="int" maxlength="11" > 
            </div>
         </div>-->
            <div class="form-group">
              <label class="col-md-4 control-label">NOMBRE COMPLETO:</label>  
            <div class="col-md-4">
             <input id="nombre" name="nombre" placeholder="Nombre y Apellido" class="form-control input-md" type="text"  onkeypress="return soloLetras(event);"
             onkeyup="javascript:this.value=this.value.toUpperCase();"> 
            </div>
         </div>
          <div class="form-group">
              <label class="col-md-4 control-label">CELULAR:</label>  
            <div class="col-md-4">
             <input id="celular" name="celular" placeholder="celular" class="form-control input-md" 
             type="tel"   title="Campo Solo de Numero"  onKeyPress="return SoloNumeros(event);"> 
            </div>
         </div>
        <div class="form-group">
              <label class="col-md-4 control-label">EMPRESA:</label>  
            <div class="col-md-4">
             <input id="empreza" name="empreza" placeholder="Nombre de la Empreza " class="form-control input-md" type="text" onkeypress="return soloLetras(event);"
             onkeyup="javascript:this.value=this.value.toUpperCase();"> 
            </div>
         </div>
         <div class="form-group">
              <label class="col-md-4 control-label">NIT:</label>  
            <div class="col-md-4">
             <input id="nit" name="nit_ci" placeholder="nit" class="form-control input-md" 
             type="tel" > 
            </div>
         </div>
    
<div class="form-group">
<table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
  <tr>
    <td>  <button type="submit" class="btn btn-primary">Aceptar</button></td>
    <td> <button type="reset" class="btn btn-primary">limpiar</button></td>
  </tr>
  <tr>    
    <td align="center"  colspan='2'><a href="index.php">Volver</a></td>
  </tr>
</table>
</div>
</form>
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
<script src="../js/intlTelInput.js"></script>
    <script>
      $("#telefono").intlTelInput({
        onlyCountries: ['bo', 'ar'],

        utilsScript: "../js/utils.js"
      });
    </script>
    <script>


</script>
</body>
</html>