<html>
	<head>
		<script src="alert/sweetalert.min.js"></script>
		<link rel="stylesheet" type="text/css" href="alert/sweetalert.css" />

	</head>
	<body>
		
<?php
require_once '../config/conexion.inc.php';

$id=$_POST['idproveedor'];
$codigo=$_POST['codigo'];
$nombre=$_POST['nombre'];
$celular=$_POST['celular'];
$empreza=$_POST['empreza'];
$nit=$_POST['nit'];
$tipo_categoria=$_POST['tipo_categoria'];
$tipo_credito=$_POST['tipo_credito'];

$sql = $db->Execute("update proveedor set codigo='$codigo',nombre='$nombre',celular='$celular',empreza='$empreza', nit='$nit',tipo_categoria='$tipo_categoria',tipo_credito='$tipo_credito'  where idproveedor=$id");
			
if ($sql=!null) {
	print "<script>alert(\"Actualizado exitosamente.\");window.location='listar.php';</script>";
	# code...
}
else{
	print "<script>alert(\"No se pudo Actualizar.\");window.location='listar.php';</script>";
}
?>

</body>
</html>