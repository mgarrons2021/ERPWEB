<?php 
require_once '../config/conexion.producto.php';
$conexion=mysqli_connect('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
$proveedor=$_POST['proveedor'];
$sucursal=$_POST['sucursal'];
/*Consulta para traer los productos*/
$sql="SELECT propr.producto_id as id, propr.proveedor_id, p.nombre from producto p  inner JOIN
	producto_proveedor propr on p.idproducto = propr.producto_id inner join 
	proveedor pro on propr.proveedor_id = pro.idproveedor WHERE
	propr.proveedor_id= $proveedor and p.estado = 'activo' and propr.sucursal_id = $sucursal
	ORDER BY `p`.`nombre`  ASC;";
	$result=mysqli_query($db,$sql);
	$cadena = 'seleccione';
	$cadena="<label>SELECT 2 (productos)</label> 
			//<select id name='idprod'>";
	$cadena=$cadena.'<option>Seleccione... </option>';
	while ($row = $result->fetch_assoc()) {
		$cadena=$cadena.'<option value='.$row['id'].'>'.utf8_encode($row['nombre']).'</option>';
	}
	echo  $cadena."</select>";
?>