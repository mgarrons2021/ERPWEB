<?php 
require_once '../config/conexion.inc.php';

$sucursal= $db->GetAll('select * from sucursal');
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
    <title>SISTEMA DONESCO S.R.L.</title>
    <link rel="stylesheet" href="master.css">
    <link rel="shortcut icon" href="../images/favicon.ico">

</head>
<body>
     <br>
 		<!--form-->
	<div class="container" >
	<div class="row">
	<div class="col-sm-4 col-sm-offset-1">
	<div class="login-form">
	    <div align="center"><img src = img/Logo_Correo.jpg width="350" height="100"></div>
		<!--<h1 align="center" class="current_page_item"><b href="">SISTEMA DONESCO S.R.L.</b></h1>
								
		<!--login form-->
	<label for="username">CODIGO DE ACCESO</label>
	<form action="../config/login.php" method="post">
	<input type="password" placeholder="Ingrese su codigo" name="codusuario" />
    <label for="username">SELECCIONE LA SUCURSAL</label>
    <br>
    <div class="input-group" >
    <select class="sucur" name="idsucursal" id="idsucursal" style="width:300px" style="height:500px" >
    <?php foreach ($sucursal as $r){?>
    <option value="<?php echo $r["idsucursal"]?>"><?php echo $r["nombre"]; ?></option>
    <?php }?>
    </select>
	<div>
	<button type="submit" class="current_page_item">ACCEDER</button>
	</div>
	
</form>
<br>
</body>
</html>
</form>
</body>
</html>