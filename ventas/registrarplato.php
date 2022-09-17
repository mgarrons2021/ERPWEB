<?php
require_once '../config/conexion.inc.php';
session_start();
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$idplato=$_POST['idplato'];
$precio=$_POST['precio'];
$_nro=$_POST['nro'];
$idturno=$_POST['idturno'];
//$_precio_unitario=$db->GetOne('SELECT precio_uni FROM plato where idplato = '.$idplato);
$fila['nro'] = $_nro;
$fila['idturno'] = $idturno;
$fila['precio'] =$precio;
$fila['cantidad'] =1;
$fila['subtotal'] =1*$precio;
$fila['plato_id'] =$idplato;
$fila['sucursal_id'] = $sucur;
$db->AutoExecute('detalleventa', $fila, 'INSERT');
$ventas = $db->Execute("SELECT * from detalleventa where nro = '$_nro' and idturno='$idturno' and sucursal_id= '$sucur'");
echo'<div class="container">
<table class="table" border="1" style="width:300px">
<tr>
  <th>Plato</th>
  <th>Cantidad</th>
  <th>Costo Unitario</th>
  <th>Sub Total</th>
  <th>Opc</th>
</tr>
</div>';
$total=0;
$c=0;
foreach($ventas as $reg){
  echo'<tr>
  <input type="hidden" id="iddetalleventa" name="iddetalleventa[]" value="'.$reg['iddetalleventa'].'">
  <td style="width:90px">'.$db->GetOne('SELECT nombre FROM plato where idplato = '.$reg['plato_id']).'</td>
  <td style="width:50px"><input type="text" style="width : 50px; heigth : 50px" id="cantidad" name="cantidad[]" value="" onChange="multiplicar();"></td>
  <td style="width:50px"><input type="text" style="width : 50px; heigth : 50px" id="precio" name="precio[]" value="'.$reg['precio'].'"readonly>bs.</td>
  <td style="width:50px"><input type="text" style="width : 50px; heigth : 50px" id="subtotal" name="subtotal[]" value="" readonly>bs.</td>
  <td style="width:50px"><a class="btn"  href="javascript:eliminar('.$reg['iddetalleventa'].')"><span class="glyphicon glyphicon-remove"></span></a></td>
  </tr>';
 $c=$c+1;
}
print'<script>
function operaciones()
{
    var num1 = document.getElementById("total").value;
    var num2 = document.getElementById("cambio").value;
    document.getElementById("vuelto").value=num2-num1;
    
} </script>';
echo'<tr>
  <td colspan="2">TOTAL A CANCELAR</td>
  <td></td>
  <td><input type="text" style="width : 60px; heigth : 50px" id="total" name="total" value="" readonly> bs.<br>
  <input type="text" style="width : 60px; heigth : 50px" id="cambio" name="cambio" value="" onChange="cambio();"> bs.<br>
  <input type="button" class="btn btn-success" value="CAMBIO" onclick="operaciones(); return false;"/><br>
  <input type="text" style="width : 60px; heigth : 50px" id="vuelto" name="vuelto" value="" readonly> bs.</td>
  <td></td>
</tr></table>';
print '<script>
function cambio(){
console.log("esto es el cambio pero no funciona");
}</script><script>
var cantidades=JSON.parse(localStorage.getItem("cantidades"));
total = 0;
 iddetalle=iddetalleventa.length;
 canti=cantidades.length;
 console.log("este es el tamano de los items:"+iddetalle);
 console.log("este es el tamano json:"+canti);
 for(var j=0; j<iddetalle; j++){
   console.log("con esto  se tiene que comparar es el iddetalle venta"+iddetalleventa[j].value);
     for (var i = 0; i <canti; i++){
         console.log(iddetalleventa[j].value+" esto es igual a ? :"+cantidades[i].id);
               if(iddetalleventa[j].value==cantidades[i].id){
               cantidad[j].value=cantidades[i].cant;
               subtotal[j].value=cantidades[i].cant*precio[j].value;
               total=total+parseFloat(subtotal[j].value);
               //console.log("esto es mi array de datos que no sale:"+cantidades[i]);
                                        }
                                    }
                              }
document.getElementById("total").value=total;
</script>';
?>