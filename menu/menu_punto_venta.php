<?php
require_once '../config/conexion.inc.php';
session_start();
$usuario =$_SESSION['usuario'];
$id=$usuario['idusuario'];
if($usuario==""||$usuario==null){
print "<script>alert(\"no exsite usuario vuelva a ingresar.\");window.location='../index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PUNTO DE VENTA</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/estiloyanbal.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/prettyPhoto.css" rel="stylesheet">
    <link href="../css/price-range.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
	<link href="../css/main.css" rel="stylesheet">
	<link href="../css/responsive.css" rel="stylesheet">
	<link rel="stylesheet" href="../data/alert/css/alertify.min.css" />
	<link rel="stylesheet" href="../data/alert/css/themes/default.min.css" />
	<link rel="stylesheet" href="../css/intlTelInput.css">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../images/ico/apple-touch-icon-57-precomposed.png">
    <script src="../js/datavalidacion.js"></script>
    <script src="../js/intlTelInput.js"></script>
    </head><!--/head-->
<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
						   <ul class="nav nav-pills">
						   <li><br>
						   <button type="button" class="btn btn-danger"  onclick="window.location.href = '../index.php';">
                           <span class="glyphicon glyphicon-off"></span>
                           </button>
						   </li>
								<li><a href="#"><i class="fa fa-user fa-3x"></i> </a></li>
								<li><a href="#"><i class=""></i><?php echo "$usuario[nombrerol] :  $usuario[nombreusuario]:<br>$usuario[nombresucursal]"; ?></a></li>
						   </ul>
                     <ul>
                     </ul>
					   </div>
					   </div>
					   <div class="col-sm-6">
					   <div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
				     </ul>
						</div>
					</div>
				</div>
			</div>
		</div>
					</div><!-- container -->
			    </div>	
			</div>
</div><!--/header-bottom-->

</header><!--/header-->
    <script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.scrollUp.min.js"></script>
	<script src="../js/price-range.js"></script>
    <script src="../js/jquery.prettyPhoto.js"></script>
    <script src="../js/main.js"></script>
    <script src="../data/alert/alertify.min.js"></script>
</body>
</html>