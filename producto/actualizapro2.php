<html>
	<head>
		<title></title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilos.css">

		<script src="../js/jquery.min.js"></script>
	</head>
	<body class="body">
	<?php include"../menu/menu.php"; 
    $id = $_GET['id'];
    
    $sql = $db->Execute("update producto set estado ='activo' WHERE idproducto = $id"); 

if ($sql=!null) {
	
	print "<script>alert(\"Actualizado Correctamente.\");window.location='listar.php';</script>";
}
else{
	print "<script>alert(\"No se pudo Actualizar.\");window.location='listar.php';</script>";
}
    ?>

	</body>
</html>