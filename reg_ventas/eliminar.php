<?php
include "../config/conexion.inc.php";
$id = $_GET['id'];
if(!empty($_GET)){
			$sql = $db->Execute("DELETE FROM reg_ventas WHERE idreg_ventas=$id");
        //$sql = $db->Execute("DELETE *FROM producto_pedido WHERE id=".$_GET["id"]);
			if($sql!=null){
				print "<script>alert(\"Eliminado exitosamente.\");window.location='listar.php';</script>";
			}else{
				print "<script>alert(\"No se pudo eliminar.\");window.location='listar.php';</script>";
			}
}
?>