<?php
require_once '../config/conexion.inc.php';
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$_catplato = $_POST['plato'];
echo'<div class="container"><h4>'.$_catplato.'</h4></div>';
$ventas=$db->Execute("SELECT p.*, pre.precio as precio_pla ,pre.precio_d as precio_dely
from plato p,pre_pla pre where pre.categoria= '$_catplato' and pre.plato_id=p.idplato and pre.sucursal_id='$sucur' order by p.nombre");
echo '<style type="text/css">
  .boton_personalizado{
    text-decoration: none;
    padding: 0px;
    font-weight: 400;
    font-size: 15px;
    color: #ffffff;
    background-color: #47A55B;
    border-radius: 5px;
    border: 0px solid #0016b0;
  }
    .boton_personalizado2{
    text-decoration: none;
    padding: 0px;
    font-weight: 400;
    font-size: 15px;
    color: #ffffff;
    background-color: #2AB3B1;
    border-radius: 5px;
    border: 0px solid #0016b0;
  }
  .espacio{
    text-decoration: none;
    padding: 0px;
    font-weight: 300;
    font-size: 15px;
    color: #000000;
    background-color: #FFFFFF;
    border-radius: 5px;
    border: 0px solid #0016b0;   
  }
</style>';
echo'<table  border="1"  style="width:50px">';
$c=0;
foreach($ventas as $reg){
  if($c==0){echo'<tr>';}
  $c=$c+1;
  echo
 '<td><img src="'.$reg['imagen'].'"width="100" height="70"><b class="espacio">'.$reg['nombre'].'</b>
  <br>'.$reg['precio_pla'] .' bs.<button class="boton_personalizado" type="button" onClick="agregar('. $reg['idplato'] .','.$reg['precio_pla'] .');">Agregar</button>
  <br>'.$reg['precio_dely'].' bs.<button class="boton_personalizado2" type="button" onClick="agregar('. $reg['idplato'] .','. $reg['precio_dely'] .');">Delivery</button>
  </td>';
if($c==6){echo'</tr>'; $c=0;}
}
echo '</table>';
?>