<?php
include "../config/conexion.inc.php";

if(!empty($_GET)){
			
			$sql = $db->Execute("DELETE FROM cliente WHERE idcliente=".$_GET["idcliente"]);
			$query = $sql;
			if($query!=null){
				print "<script>alert(\"Eliminado exitosamente.\");window.location='index.php';</script>";
			}else{
				print "<script>alert(\"No se pudo eliminar.\");window.location='index.php';</script>";
			}
}

?>