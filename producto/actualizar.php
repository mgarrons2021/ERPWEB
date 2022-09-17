<html>
	<head>
		<script src="alert/sweetalert.min.js"></script>
		<link rel="stylesheet" type="text/css" href="alert/sweetalert.css" />
	</head>
	<body>		
<?php
require_once '../config/conexion.inc.php';
$id=$_POST['id'];
$codigo=$_POST['codigo'];
$nombre=$_POST['nombre'];
$descripcion=$_POST['descripcion'];
$precio=$_POST['precio'];
$estado=$_POST['estado'];
$idproveedor=$_POST['idproveedor'];
$excluir_ventas='no';
$tipo_impuesto=$_POST['tipo_impuesto'];
$tipo_articulo=$_POST['tipo_articulo'];
$unidad_medida=$_POST['unidad_medida'];
$categoria=$_POST['categoria'];

$sql = $db->Execute("update producto set codigo_producto='$codigo', nombre='$nombre', excluir_ventas='$excluir_ventas', descripcion='$descripcion',precio_compra='$precio',estado='$estado',idproveedor='$idproveedor',idtipo_impuesto='$tipo_impuesto',idunidad_medida='$unidad_medida',idcategoria='$categoria',idtipo_articulo='$tipo_articulo'  where idproducto = '$id'");

$sql_detalle = $db->Execute("update detalle_producto_proveedor set 
                   proveedor_id = $idproveedor 
                   WHERE producto_id = $id");

if ($sql=!null) {
	print "<script>alert(\"Actualizado exitosamente.\");window.location='listar.php';</script>";
}
else{
	print "<script>alert(\"No se pudo Actualizar.\");window.location='listar.php';</script>";
}
?>
</body>
</html>