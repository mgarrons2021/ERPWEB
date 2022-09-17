<html>
	<head>
		<script src="alert/sweetalert.min.js"></script>
		<link rel="stylesheet" type="text/css" href="alert/sweetalert.css" />
	</head>
	<body>
<?php
require_once '../config/conexion.inc.php';

$id=$_POST['id'];
$ci=$_POST['ci'];
$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$telefono=$_POST['telefono'];
$sql = $db->Execute("update cliente set ci='$ci',nombre='$nombre' ,apellido='$apellido' ,telefono='$telefono'  where id=$id");
			
if ($sql=!null){
	print "<script>alert(\"Actualizado exitosamente.\");window.location='listar.php';</script>";

}
else{
	print "<script>alert(\"No se pudo Actualizar.\");window.location='listar.php';</script>";
}
?>

</body>
</html>