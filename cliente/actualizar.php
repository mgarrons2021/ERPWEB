<html>
	<head>
		<script src="alert/sweetalert.min.js"></script>
		<link rel="stylesheet" type="text/css" href="alert/sweetalert.css" />

	</head>
	<body>
		
<?php
require_once '../config/conexion.inc.php';

$id=$_POST['idcliente'];
$nit_ci=$_POST['nit_ci'];
$nombre=$_POST['nombre'];
$celular=$_POST['celular'];
$fecha=$_POST['fecha'];
$hubicacion=$_POST['hubicacion'];
//$tipo_categoria=$_POST['tipo_categoria'];
//$tipo_credito=$_POST['tipo_credito'];

$sql = $db->Execute("update cliente set nit_ci='$nit_ci',nombre='$nombre',celular='$celular',fecha='$fecha', hubicacion='$hubicacion' where idcliente=$id");
			
if ($sql=!null) {
	print "<script>alert(\"Actualizado exitosamente.\");window.location='index.php';</script>";
	# code...
}
else{
	print "<script>alert(\"No se pudo Actualizar.\");window.location='index.php';</script>";
}
?>

</body>
</html>