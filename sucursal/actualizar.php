<html>
	<head>
		<script src="alert/sweetalert.min.js"></script>
		<link rel="stylesheet" type="text/css" href="alert/sweetalert.css" />

	</head>
	<body>
		
<?php
require_once '../config/conexion.inc.php';

$id=$_POST['id'];
$nombre=$_POST['nombre'];


$sql = $db->Execute("update rol set nombre='$nombre' where id=$id");
			
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