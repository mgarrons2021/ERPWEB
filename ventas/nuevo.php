<?php include"../menu/menu_punto_venta.php";
date_default_timezone_set('America/La_Paz');
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$date=date('Y-m-d');
if(isset($_GET['idturno'])){
 $idt=$_GET['idturno'];
 $turno=$_GET['nro'];
}else{
$idt=$db->GetOne("select max(idturno) from turno where sucursal_id='$sucur'");
$turno=$db->GetOne("select nro from turno where idturno='$idt'");}
$nro=$db->GetOne("select count(sucursal_id)+1 from  venta where sucursal_id='$sucur' and turno='$turno' and idturno='$idt'");
if ($nro == ''){$nro = 0;$nro++;}

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$produtos= $db->GetAll('select * from plato');
$query2 = $produtos;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>venta</title>
    <link rel="stylesheet" href="../css/estiloyanbal.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/prettyPhoto.css" rel="stylesheet">
    <link href="../css/price-range.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
	<link href="../css/main.css" rel="stylesheet">
	<link href="../css/responsive.css" rel="stylesheet">
 	<link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../images/ico/apple-touch-icon-57-precomposed.png">
    <!--libreria  para el calendario-->
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <link href="../css/jqueryui.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>  
<script src="../data/librerias/calendario2/js/bootstrap-datepicker.min.js"></script>
<script src="../data/librerias/calendario2/locales/bootstrap-datepicker.es.min.js"></script>
<!--Funcion para script para el calendario-->

<!--
<style type="text/css">
h4 { 
 font: bold italic 2em  Georgia, Times, "Times New Roman", serif;
 margin: 0;
 padding: 0;
}
</style>
-->
<script type="text/javascript">
  $(function(){
  $('.input-daterange').datepicker({
    format: "yyyy-mm-dd",
    language: "es",
    orientation: "bottom auto",
    todayHighlight: true
});
  })
  </script>

<script>
function multiplicar(){
  total=0;
  contador=0;
  var basedatos=[];
  ///////////constructor
function item(id,cant){
    this.id=id;
    this.cant=cant;
}
//////////////funcion redondea a 5 o 0
function redondea(monto){
    this.monto=monto;
    monto=monto.toFixed(1);
    dato=monto.toString();
    ultimo=monto.charAt(dato.length - 1);
    if(parseInt(ultimo)>5)
    {monto=Math.round(monto);}
    else{
         if(parseInt(ultimo)==0){
         monto=Math.round(monto);}
         else{monto=Math.round(monto)+".50";}
        }
    return monto;
}
/////////////
  //var cantidades = new Array();
  var cantidades = [];
  if(cantidad.length==null){
    contador=1;
    //console.log("mi contador es :"+contador);
    id=document.getElementById('iddetalleventa').value;
    cant=document.getElementById('cantidad').value;
    pre=document.getElementById('precio').value;
    sub=cant*pre;
    document.getElementById('subtotal').value=redondea(sub);
    document.getElementById('cantidad').value =cant;
    total=total+parseFloat(document.getElementById('subtotal').value);
    nuevoitem=new item(id,cant);
    basedatos.push(nuevoitem);
  }
  else{contador=cantidad.length;
  for(let index = 0; index < contador; index++){
  // console.log("mi cantidad es :"+cantidad[index].value);
  //console.log("esto es el id que tengo que guardar"+iddetalleventa[index].value);
  id=iddetalleventa[index].value;
  cant=cantidad[index].value;
  ////////agregar array basedatos
  nuevoitem=new item(id,cant);
  basedatos.push(nuevoitem);
  //////////fin agregar base de tados
  cantidades[index] =cantidad[index].value;
  sub=cantidad[index].value*precio[index].value;
  subtotal[index].value=redondea(sub);
  total=total+parseFloat(subtotal[index].value);
  }}
  console.log(basedatos);
  /////////////////localstore
  localStorage.setItem("cantidades",JSON.stringify(basedatos));
  /////////////////
  //total=redondea(total); 
    //let redondeo=new redondear(total);
    document.getElementById('total').value=parseFloat(total);
}
</script>
<script>$(document).ready(function(){$("#reg").click(function(){var ci=$("#ci").val();var n=$("#name").val();var ap=$("#ap").val();var t=$("#telf").val();$.post("ajax.php",{ci:ci,name:n,ap:ap,telf:t},function(datos){$("#resultado").html(datos);document.getElementById('ci').value='';document.getElementById('name').value='';document.getElementById('ap').value='';document.getElementById('telf').value='';document.getElementById('ci').focus();});});});</script>
<script language="javascript"> 
$(document).ready(function(){
  $("#enviaid").click(function(){
  $.ajax({
    url:'d_cliente.php',
    type:'POST',
    dataType:'json',
    data:{nit:$(document.getElementById("nit")).val()}
         }).done(
        function(respuesta){
          $("#idcliente").val(respuesta.idcliente);
         $("#cliente").val(respuesta.nombre);
         $("#celular").val(respuesta.celular);
         $("#fecha").val(respuesta.fecha);
                           });
                            });});
</script>


<script language="javascript">
  function mostrar(datos){
if (datos==1){$('#listaplato').load('listarplatos.php',{"plato":"Sopa"});}
if (datos==2){$('#listaplato').load('listarplatos.php',{"plato":"Hamburguesas"});}
if (datos==3){$('#listaplato').load('listarplatos.php',{"plato":"Especiales"});}
if (datos==4){$('#listaplato').load('listarplatos.php',{"plato":"Postres"});}
if (datos==5){$('#listaplato').load('listarplatos.php',{"plato":"Refrescos"});}
if (datos==6){$('#listaplato').load('listarplatos.php',{"plato":"Combos"});}
if (datos==7){$('#listaplato').load('listarplatos.php',{"plato":"Parrilla"});}
if (datos==8){$('#listaplato').load('listarplatos.php',{"plato":"Guarniciones"});}
if (datos==9){$('#listaplato').load('listarplatos.php',{"plato":"Gaseosas"});}
if (datos==10){$('#listaplato').load('listarplatos.php',{"plato":"Platos Servidos"});}
if (datos==11){$('#listaplato').load('listarplatos.php',{"plato":"Pollos"});}
if (datos==12){$('#listaplato').load('listarplatos.php',{"plato":"Por Kilo"});}
if (datos==13){$('#listaplato').load('listarplatos.php',{"plato":"Menu Ejecutivo"});}
if (datos==14){$('#listaplato').load('listarplatos.php',{"plato":"Platos Ejecutivo"});}
}
</script>

<script language="javascript">
   function listar(){
    $('#listado').load('listar.php',{
    "nro":$('#nro').val(),
    "cambio":$('#cambio').val(),
    "vuelto":$('#vuelto').val(),
    "idturno":$('#idturno').val()
    });}
  function agregar(plato,precio){
              $('#listado').load('registrarplato.php',
              {"idplato":plato,
                "precio":precio,
                "nit":$('#nit').val(),
                "turno":$('#turno').val(),
                "idturno":$('#idturno').val(),
                "total":$('#total').val(),
                "cambio":$('#cambio').val(),
                "vuelto":$('#vuelto').val(),
                "input[name='precio[]']":$("input[name='precio[]']").val(),
                "input[name='cantidad[]']":$("input[name='cantidad[]']").val(),
                "input[name='subtotal[]']":$("input[name='subtotal[]']").val(),
                "input[name='iddetalleventa[]']":$("input[name='iddetalleventa[]']").val(),
                "nro":$('#nro').val()
              });
                return true;
              }
  function eliminar(id,cant){$.post('eliminar.php',{"input[name='cantidad[]']":$("input[name='cantidad[]']").val(),"nro":id},
  function(){
  listar();
  //multiplicar();
  }
  );}
</script>
<script language="javascript">
  function aceptar_dos(destino){
document.formulario.action=destino;
document.formulario.submit();
}
</script>
</head><!--/head-->
    <body onLoad="listar();">
    <div class="container">
    <div class="left-sidebar">
   <!-- <a href="index.php.php?idturno=<?php //echo $r["idturno"];?>"><strong>Ventas Realizadas</strong><span class="glyphicon glyphicon-plus"></span></a>-->
	  <div class="">
      <form name="formulario" method="post" >
          <div class="row">
                 <div class="col-md-1">
                 <label for="">T.T.:</label>
                 <input type="text" name="nro" id="nro" class="" value="<?php echo "$nro";?>" disabled>
                 <input type="hidden" name="nro" id="nro" class="form-control" value="<?php echo "$nro"; ?>">
                 <input type="hidden" name="idturno" id="idturno" class="form-control" value="<?php echo "$idt"; ?>">
                 <input type="hidden" name="turno" id="turno" class="form-control" value="<?php echo "$turno"; ?>">
                 </div>
                 <div class="col-md-3">
                 <label>Fecha:</label>
                 <div class="">
                 <input type="text" value="<?php echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ?>" disabled>
                 </div>
                 </div>
                     <div class="col-md-4">
                         <h2>registro de nueva venta<br><?php echo $usuario['nombresucursal']." Turno: ".$turno." ";if($turno=="1"){echo "AM";}else{echo "PM";}?></h2>
                         </div>
                 <div class="col-md-4">
                 <h3><a href="../turno/actualizar.php?idturno=<?php echo $idt;?>&turno=<?php echo $turno;?>&nro=<?php echo $nro;?>">Finalizar turno</a></h3>
                 </div>
          </div>
          
        <div class="row">
            <div class="col-md-2">
              <label>Lugar:</label>
              <div class="input-group">
               <select class="form-control" name="lugar" id="lugar" onChange="delivery(this);">
               <option value="RESTAURANTE">En Restaurante</option>
               <option value="PARaLLEVAR">Para LLevar</option>
               <option value="VENTaEXTERNA">Venta Externa</option>
               <option value="DELIVERY">Delivery</option>
               </select>
              </div>
            </div>
            <div id="listadelivery"></div>  
            <div class="col-md-2">
             <label>Pago:</label>
               <div class="input-group">
               <div class="input-group">
               <select class="form-control" name="pago" id="pago">
               <option value="efectivo">Efectivo</option>
               <option value="visa">Tarjeta Cred/Deb</option>
               <option value="credito">Credito</option>
               </select>
              </div>
              </div>
              </div>
        <!--</div>
          <div class="row">-->
            <div class="col-md-2">
             <label>Nit/Ci:</label>
              <div class="input-group">
              <input type="text" id="nit" name="nit" placeholder="Nit/Ci" class="form-control" value="0">
             <!--<input type="text" id="nit" name="nit" placeholder="Nit/Ci" class="form-control" value="0" onChange="cambiar(this);">-->
              <span class="input-group-btn">
            <a data-toggle="modal" href="#" >
             <button  class="btn btn-default" type="button" id="enviaid" name="enviaid" ><span class="glyphicon glyphicon-search"></span></button>
             </a>
              </span>
              </div>
              </div>
              <div class="col-md-2">
              <label>cliente:</label>
              <div class="input-group">
              <input type="text" id="cliente" name="cliente" placeholder="cliente" class="form-control">
              </div>
              </div>
              <div class="col-md-2">
              <label>celular:</label>
              <div class="input-group">
              <input type="text" id="celular" name="celular" placeholder="celular" class="form-control">
              </div>
              </div>
              <div class="col-md-2" >
              <label>fecha nacimiento:</label>
              <div class="input-daterange input-group" id="datepicker">
              <input type="text" id="fecha" name="fecha"  class="input-sm form-control" >
              </div>
              </div>
              </div>
        <br>
<div class="row">   
<div class="col-md-12" >
<table  class="default" border="0">   
 <tr>
 <td VALIGN="TOP">
        <table  class="" border="0" style="width:500px"> 
         <tr>
          <td>
          <button type="button" class="btn btn-warning " id="catplato1" name="catplato1" value="1" onClick="mostrar('1');">Sopas</button>
          <button type="button" class="btn btn-warning " id="catplato12" name="catplato12" value="12" onClick="mostrar('12');">Por Kilo</button>
          <button type="button" class="btn btn-warning " id="catplato10" name="catplato10" value="10" onClick="mostrar('10');">Platos Servidos</button>
          <button type="button" class="btn btn-warning " id="catplato7" name="catplato7" value="7" onClick="mostrar('7');">A la Parrilla</button>
          <button type="button" class="btn btn-warning " id="catplato8" name="catplato8" value="8" onClick="mostrar('8');">Guarniciones</button>
          </td>
          </tr>
          <tr>
          <td>
          <button type="button" class="btn btn-info" id="catplato2" name="catplato2" value="2" onClick="mostrar('2');">Hamburguesas</button>
          <button type="button" class="btn btn-info" id="catplato11" name="catplato11" value="11" onClick="mostrar('11');">Pollos</button>
          <button type="button" class="btn btn-info" id="catplato11" name="catplato13" value="13" onClick="mostrar('13');">Menu Ejecutivo</button>
          <button type="button" class="btn btn-info" id="catplato11" name="catplato14" value="14" onClick="mostrar('14');">Platos Ejecutivo</button>
           <button type="button" class="btn btn-info" id="catplato11" name="catplato14" value="15" onClick="mostrar('15');">Venta Externa</button>
          </td>
          </tr>
          <tr>
          <td>
          <button type="button" class="btn btn-success" id="catplato3" name="catplato3" value="3" onClick="mostrar('3');">Especiales</button>
          <button type="button" class="btn btn-success" id="catplato6" name="catplato6" value="6" onClick="mostrar('6');">Combos</button>
          <button type="button" class="btn btn-success" id="catplato9" name="catplato9" value="9" onClick="mostrar('9');">Gaseosas</button>
          <button type="button" class="btn btn-success" id="catplato5" name="catplato5" value="5" onClick="mostrar('5');">Refrescos</button>
          <button type="button" class="btn btn-success" id="catplato4" name="catplato4" value="4" onClick="mostrar('4');">Postres</button>
          </td>
         </tr>
       </table>
        
        
      <div id="listaplato"  style="width:610px"></div>
 </td>
 <td VALIGN="TOP"> 
    <div id="listado"  style="width:500px"></div>
    
    <div id="listacobrar">
         <?php if($sucur=="2"||$sucur=="1"){?>
           <table width="200" border="0" cellspacing="0" cellpadding="5" align="center">
            <tr>
              <td> <td><button type="button" class="btn btn-info" onClick="aceptar_dos('aceptar2.php');"> COBRAR  </button></td>
              <td> <button type="reset" class="btn btn-warning">LIMPIAR</button></td>
              <td> <td><button type="button" class="btn btn-danger" onClick="aceptar_dos('aceptar.php');">  COBRAR  </button></td>
              <!--<td> <td><button type="button" onclick="co_2(); return false;" class="btn btn-danger"> COBRAR </button></td>-->
            </tr>
           </table>
           <?php } else{ ?>
            <table width="200" border="0" cellspacing="0" cellpadding="5" align="center">
            <tr>
              <td> <button type="reset" class="btn btn-warning">LIMPIAR</button></td>
              <td> <td><button type="submit"  class="btn btn-danger"> COBRAR </button></td>
            </tr>
           </table>
           <?php }?>
    </div>
<td/>
    </tr>
</table>
</div>
</div>
</form>
<br><br><br>
    <footer id="footer">
		 </div>
		 </div>
		 <div class="footer-bottom">
			<div class="container">
				<div class="row">
					<center><p class="pull-center">Copyright © SISTEMA DONESCO SRL</p></center>	
				</div>
			</div>
		 </div>
		</footer>
</div>
</div>
</div>
</body>
</html>
<script>
function delivery(obj){
lugar=document.getElementById("lugar").value;
if(lugar=="DELIVERY"){
    document.getElementById('listadelivery').innerHTML=`
<div class="col-md-2">
<label>Delivery:</label>
<div class="input-group">
<select class="form-control "name="DELIVERY" id="DELIVERY" >
    <option value="0">Seleccione delivery</option>
    <option value="pedidosya">PedidosYa</option>
    <option value="patioservice">PatioService</option>
    <option value="yaigo">Yaigo</option>
    <option value="mrdelivery">Mr. Delivery</option>
    <option value="km6">Km 6</option>
    <option value="superhelper">Super Helper</option>
    <option value="ordenya">OrdenYa</option>
    <option value="ubereats">UberEats</option>
    </select>
    </div>
    </div>`;
    }
    if(lugar=="ventaexterna"){
     document.getElementById('listadelivery').innerHTML=``; 
    }
}
function cambiar(obj){
document.getElementById('listacobrar').style.display="none";
}
</script>
<script>
  function co_2(){
              load('aceptar.php',
              {"idplato":plato,
                "precio":precio,
                "nit":$('#nit').val(),
                "turno":$('#turno').val(),
                "idturno":$('#idturno').val(),
                "total":$('#total').val(),
                "cambio":$('#cambio').val(),
                "vuelto":$('#vuelto').val(),
                "cliente":$('#cliente').val(),
                "celular":$('#celular').val(),
                "fecha":$('#fecha').val(),
                "lugar":$('#lugar').val(),
                "pago":$('#pago').val(),
                "input[name='precio[]']":$("input[name='precio[]']").val(),
                "input[name='cantidad[]']":$("input[name='cantidad[]']").val(),
                "input[name='subtotal[]']":$("input[name='subtotal[]']").val(),
                "input[name='iddetalleventa[]']":$("input[name='iddetalleventa[]']").val(),
                "nro":$('#nro').val()
              });
                return true;
              }
        function co_3(){
              load('aceptar2.php',
              {"idplato":plato,
                "precio":precio,
                "nit":$('#nit').val(),
                "turno":$('#turno').val(),
                "idturno":$('#idturno').val(),
                "total":$('#total').val(),
                "cambio":$('#cambio').val(),
                "vuelto":$('#vuelto').val(),
                "cliente":$('#cliente').val(),
                "celular":$('#celular').val(),
                "fecha":$('#fecha').val(),
                "lugar":$('#lugar').val(),
                "pago":$('#pago').val(),
                "input[name='precio[]']":$("input[name='precio[]']").val(),
                "input[name='cantidad[]']":$("input[name='cantidad[]']").val(),
                "input[name='subtotal[]']":$("input[name='subtotal[]']").val(),
                "input[name='iddetalleventa[]']":$("input[name='iddetalleventa[]']").val(),
                "nro":$('#nro').val()
              });
                return true;
              }
     //function actualizar(){location.reload(true);}
        //function limpiar(){document.getElementById('listacobrar').innerHTML="";}
   // function cobrar(){limpiar(); botones();}
   // var cobrar=0;
function cobrar(){
cobrar=document.getElementById("nit").value;
///console.log("esto es el nit"+cobrar);
if(cobrar==0){
    document.getElementById('listacobrar').innerHTML="";
document.getElementById('listacobrar').innerHTML=`
<table width="200" border="0" cellspacing="0" cellpadding="5" align="center">
            <tr>
              <td> <button type="reset" class="btn btn-warning">LIMPIAR</button></td>
              <td> <td><button type="button" onclick="co_2(); return false;" class="btn btn-danger"> COBRAR </button></td>
            </tr>
           </table>`;
           console.log("esto es tamabien  mas es el nit"+cobrar);
           document.getElementById("nit").value=0;
           cobrar=0;
    }
    else{
        document.getElementById('listacobrar').innerHTML="";
    document.getElementById('listacobrar').innerHTML=`
<table width="200" border="0" cellspacing="0" cellpadding="5" align="center">
            <tr>
              <td> <button type="reset" class="btn btn-warning">LIMPIAR</button></td>
              <td> <td><button type="button" onclick="co_3(); return false;"  class="btn btn-info"> COBRAR </button></td>
            </tr>
</table>`;
  console.log("esto es  de la factura"+cobrar);
cobrar=0;
       }
}
</script>
