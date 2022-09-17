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
    <title>Registro Cliente</title>
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
    <script>
 /* function soloLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";//Se define todo el abecedario que se quiere que se muestre.
    especiales = [8, 37, 39, 46, 6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.

    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}


function SoloNumeros(evt){
 if(window.event){//asignamos el valor de la tecla a keynum
  keynum = evt.keyCode; //IE
 }
 else{
  keynum = evt.which; //FF
 } 
 //comprobamos si se encuentra en el rango numérico y que teclas no recibirá.
 if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 ){
  return true;
 }
 else{
  return false;
 }
}
*/

</script>
</head><!--/head-->

<body class="body">

<div class="container" class="left-sidebar">
	<div  class="left-sidebar">



<form class="form-horizontal" data-toggle="validator"  role="form" action="agregar.php" method="post">
   
       <h2>registro de nuevo Cliente</h2>

<!-- Text input-->
         <div class="form-group">
              <label class="col-md-4 control-label">Ci/Nit:</label>  
            <div class="col-md-4">
            <input id="ci" name="ci" placeholder="ci" class="form-control input-md" type="int" required="numero" title="campo solo de numeros de 7-8 digitos" required onKeyPress="return SoloNumeros(event);"> 
            </div>
         </div>
         <div class="form-group">
              <label class="col-md-4 control-label">Nombre:</label>  
            <div class="col-md-4">
             <input id="nombre" name="nombre" placeholder="Nombre" class="form-control input-md" type="text"> 
            </div>
         </div>

          <div class="form-group">
              <label class="col-md-4 control-label">Apellidos</label>  
            <div class="col-md-4">
             <input id="Apellido.M" name="apellido" placeholder="Apellido.M"  name"apellido" 
             class="form-control input-md" type="text" required pattern="[a-zA-Z]*" 
             title="Campo esclusivo de texto" title="Campo Solo Texto" 
             required onkeypress="return soloLetras(event);" > 
            </div>
         </div>

         

          <div class="form-group">
              <label class="col-md-4 control-label">Telefono:</label>  
            <div class="col-md-4">
             <input id="telefono" name="telefono" placeholder="Telefono" class="form-control input-md" 
             type="telefono"   title="Campo Solo de Numero" required onKeyPress="return SoloNumeros(event);"> 
            </div>
         </div>

<div class="form-group">
<table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
  <tr>
    <td>  <button type="submit" class="btn btn-primary">Aceptar</button></td>
    <td> <button type="reset" class="btn btn-primary">limpiar</button></td>
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
					<center><p class="pull-center">Copyright © 2021 SISTEMA DONESCO SRL</p></center>	
				</div>
			</div>
		</div>
		</footer>		
</div>
</div>
</body>
</html>