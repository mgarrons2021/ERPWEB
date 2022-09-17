<?php include"../menu/menu.php";

$usuario =$_SESSION['usuario'];
$idusuario=$usuario['idusuario'];
$sucursal=$usuario['nombresucursal'];
$sucursal_id=$usuario['sucursal_id'];
$idreg_ventas=$_GET['id_v'];

$reg_ven= $db->GetRow("SELECT reg.*, u.nombre as usuario,s.nombre as sucursal
FROM reg_ventas reg,usuario u, sucursal s
where reg.sucursal_id=s.idsucursal and reg.usuario_id=u.idusuario and reg.idreg_ventas='$idreg_ventas' ");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Registro de ventas</title>
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
    <link rel="stylesheet" href="../css/intlTelInput.css"> 
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
 <script language="JavaScript">
    function ver_password(){
        var input_form = document.elformulario.clave;
        if (document.elformulario.input_ver.checked) {
            input_form.setAttribute("type", "text");
        }
        else {
            input_form.setAttribute("type", "password");
        }
    }
    </script>
    <script>
function sumar(){
  m1=parseFloat(document.getElementById("gaseosas").value);
  m2=parseFloat(document.getElementById("plato_servido").value);
  m3=parseFloat(document.getElementById("hamburguesas").value); 
  m4=parseFloat(document.getElementById("delivery").value);
  m5=parseFloat(document.getElementById("platos").value);
  m6=parseFloat(document.getElementById("kl").value);
  m7=parseFloat(document.getElementById("porciones").value);
  m8=parseFloat(document.getElementById("refrescos").value);
  m9=parseFloat(document.getElementById("venta_externa").value);
   if(isNaN(m1)){m1=0;}
   if(isNaN(m2)){m2=0;}
   if(isNaN(m3)){m3=0;}
   if(isNaN(m4)){m4=0;}
   if(isNaN(m5)){m5=0;}
   if(isNaN(m6)){m6=0;}
   if(isNaN(m7)){m7=0;}
   if(isNaN(m8)){m8=0;}
   if(isNaN(m9)){m9=0;}
   suma=m1+m2+m3+m4+m5+m6+m7+m8+m9;
   document.getElementById("total").value=suma;
   console.log(m1);
  }
</script>

<div class="table-responsive">
<script src="../js/jquery.js"></script>
<script src="../data/librerias/calendario2/js/bootstrap-datepicker.min.js"></script>
<script src="../data/librerias/calendario2/locales/bootstrap-datepicker.es.min.js"></script>
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
</head>
<body>

<div class="container" >
	<div class="left-sidebar">
<form class="form-horizontal" data-toggle="validator" name="elformulario"  role="" action="actualizar.php" method="post">
<!-- Form Name -->

      <h2>editar ventas de <br> <?php echo $sucursal;?></h2>
      <input type="hidden" name="idusuario" id="idusuario" value="<?php echo "$idusuario"; ?>">
      <input type="hidden" name="idsucursal" id="idsucursal" value="<?php echo "$sucursal_id"; ?>" >
      <input type="hidden" name="idreg_ventas" id="idreg_ventas" value="<?php echo "$idreg_ventas"; ?>" >
      <div class="col-md-12">
             <label class="col-md-5 control-label">FECHA ACTUAL:</label>
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <input type="text" id="fecha" class="input-sm form-control" name="fecha" value="<?php echo $reg_ven["fecha"];?>"/>  
            </div>
          </div>
           <div class="col-md-12">
              <label class="col-md-5 control-label">TURNO:</label>
            <div class="col-md-2" >
            <select class="form-control select-md" name="turno" id="turno">
            <option value="<?php echo $reg_ven['turno'];?>"><?php echo $reg_ven["turno"];?></option>
                  <option  value="AM">AM</option>
                  <option value="PM">PM</option>
            </select>
            </div>
           </div>
         <div class="col-md-12">
          <label class="col-md-5 control-label">GASEOSAS (Bebidas):</label>  
            <div class="col-md-2">
            <input id="gaseosas" type="decimal" name="gaseosas" class="form-control input-md" value="<?php echo $reg_ven["gaseosas"];?>">
          </div>
         </div>

 <div class="col-md-12">
            <label class="col-md-5 control-label">PLATO SERVIDO:</label>  
            <div class="col-md-2">
            <input id="plato_servido" type="decimal" name="plato_servido" class="form-control input-md" value="<?php echo $reg_ven["plato_servido"];?>" pattern="[z0-9_.]{1,15}">
            </div>
            </div>

            <div class="col-md-12" >
            <label class="col-md-5 control-label">HAMBURGUESAS:</label>  
            <div class="col-md-2">
            <input id="hamburguesas" type="decimal" name="hamburguesas" class="form-control input-md" value="<?php echo $reg_ven["hamburguesas"];?>" pattern="[z0-9_.]{1,15}">
            </div>
            </div>

            <div class="col-md-12">
            <label class="col-md-5 control-label">DELIVERY:</label>  
            <div class="col-md-2">
            <input id="delivery" type="decimal" name="delivery" class="form-control input-md" value="<?php echo $reg_ven["delivery"];?>" pattern="[z0-9_.]{1,15}">
            </div>
            </div>

            <div class="col-md-12">
            <label class="col-md-5 control-label">PLATOS:</label>  
            <div class="col-md-2">
            <input id="platos" type="decimal" name="platos" class="form-control input-md" value="<?php echo $reg_ven["platos"];?>" pattern="[z0-9_.]{1,15}">
            </div>
            </div>

            <div class="col-md-12">
            <label class="col-md-5 control-label">POR KILO:</label>  
            <div class="col-md-2">
            <input id="kl" type="decimal" name="kl" class="form-control input-md" value="<?php echo $reg_ven["kl"];?>" pattern="[z0-9_.]{1,15}">
            </div>
            </div>

            <div class="col-md-12">
            <label class="col-md-5 control-label">PORCIONES:</label>  
            <div class="col-md-2">
            <input id="porciones" type="decimal" name="porciones" class="form-control input-md" value="<?php echo $reg_ven["porciones"];?>" pattern="[z0-9_.]{1,15}">
            </div>
            </div>

           <div class="col-md-12">
            <label class="col-md-5 control-label">REFRESCOS:</label>  
            <div class="col-md-2">
            <input id="refrescos" type="decimal" name="refrescos" class="form-control input-md" value="<?php echo $reg_ven["refrescos"];?>" pattern="[z0-9_.]{1,15}">
            </div>
            </div>

           <div class="col-md-12">
            <label class="col-md-5 control-label">VENTA EXTERNA:</label>  
            <div class="col-md-2">
            <input id="venta_externa" type="decimal" name="venta_externa" class="form-control input-md" value="<?php echo $reg_ven["venta_externa"];?>" pattern="[z0-9_.]{1,15}" >
            </div>
            
            </div>
          <div class="col-md-12">
          <label class="col-md-5 control-label">.</label> 
            <div class="col-md-2">
            <input type="button" id="igual" name="igual" class="form-control  input-md btn-success" value="SUMAR" onClick="sumar();"></input>
            </div>
            </div>

           <div class="col-md-12">
            <label class="col-md-5 control-label">Total:</label>  
            <div class="col-md-2">
            <input id="total" type="decimal" name="total" class="form-control input-md" value="<?php echo $reg_ven["total"];?>" pattern="[z0-9_.]{1,15}">
            </div>
            </div>
            <div class="col-md-12">
            <label class="col-md-5 control-label">Transacciones:</label>  
            <div class="col-md-2">
          <input id="transacciones" type="number" name="transacciones" class="form-control input-md" value="<?php echo $reg_ven["transacciones"];?>" pattern="[z0-9_.]{1,15}">
            </div>
            </div>
         </div>
       <br> 
      <div class="row">
           <div class="form-group">
             <table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
            <tr>
              <td> <button type="reset" class="btn btn-primary">LIMPIAR</button></td>
               <td>  <button type="submit" id="ir" class="btn btn-success">ACTUALIZAR</button></td>
              <td><a href="listar.php" class="btn btn-primary" role="button">ATRAS</a></td>
           </tr>
             </table>
          </div>
        </div>
</div>
</form>
</body>
</html>