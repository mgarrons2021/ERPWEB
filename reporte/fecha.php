<?php
require_once '../config/conexion.inc.php';
$sucur=$usuario['sucursal_id'];


$fechaini=$_POS["fechaini"];
$fechamax=$_POS["fechamax"];

   $query = $db->GetAll("select t.*, t.fecha, u.nombre as usuario,s.nombre as snombre,t.total,t.estado
from traspaso t,usuario u,sucursal s
where t.usuario_id=u.idusuario and s.idsucursal=t.sucursal_idtraspaso and t.sucursal_id =$sucur    and t.Fecha between '$fechaini' and '$fechamax'");

   $dv = $db->GetAll("select dt.*,p.nombre as producto 
                      from detalletraspaso dt,producto p 
                      where p.idproducto = dt.producto_id");
                      
              print "<script>window.location='traspasos.php';</script>"; 

?>