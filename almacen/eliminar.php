<?php
include "../config/conexion.inc.php";

if(!empty($_GET)){
			
			
			$sql = $db->Execute("DELETE FROM cliente WHERE id=".$_GET["id"]);
			$query = $sql;
			if($query!=null){
				print "<script>alert(\"Eliminado exitosamente.\");window.location='listar.php';</script>";
			}else{
				print "<script>alert(\"No se pudo eliminar.\");window.location='listar.php';</script>";

			}
}

?>