<?php 
$conexion=mysqli_connect('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
$proveedor=$_POST['proveedor'];

	$sql="SELECT idproducto as id, idproveedor, nombre from producto where idproveedor=$proveedor and estado = 'activo' ORDER BY nombre ASC";

	$result=mysqli_query($conexion,$sql);

	$cadena="<label>SELECT 2 (productos)</label> 
			<select id='idprod' name='idprod'>";

	while ($ver=mysqli_fetch_row($result)) {
		$cadena=$cadena.'<option value='.$ver[0].'>'.utf8_encode($ver[2]).'</option>';
	}

	echo  $cadena."</select>";
	

?>