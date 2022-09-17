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
    <title>Registro provedor</title>
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
   
       <h2>registro de nuevo rol </h2>


         <div class="form-group">
              <label class="col-md-4 control-label">Nombre:</label>  
            <div class="col-md-4">
             <input id="nombre" name="nombre" placeholder="Nombre" class="form-control input-md" type="text" required
             onkeyup="javascript:this.value=this.value.toUpperCase();"> 
            </div>
         </div>


<div class="form-group">
<table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
  <tr>
    <td>  <button type="submit" class="btn btn-primary">Aceptar</button></td>
    <td> <button type="reset" class="btn btn-primary">limpiar</button></td>
  </tr>
  <tr>    
    <td align="center"  colspan='2'><a href="listar.php">Volver</a></td>
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
					<center><p class="pull-center">Copyright © SISTEMA DONESCO SRL</p></center>	
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