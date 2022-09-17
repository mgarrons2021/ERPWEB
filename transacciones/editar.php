<?php include"../menu/menu.php";

$usuario =$_SESSION['usuario'];
$idusuario=$usuario['idusuario'];
$sucursal=$usuario['nombresucursal'];
$sucursal_id=$usuario['sucursal_id'];
$idtransacciones=$_GET['id_v'];

$reg_ven= $db->GetRow("SELECT t.*, u.nombre as usuario,s.nombre as sucursal
FROM transacciones t,usuario u, sucursal s
where t.sucursal_id=s.idsucursal and t.usuario_id=u.idusuario and t.idtransacciones='$idtransacciones' ");
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
  m1=parseFloat(document.getElementById("hora1").value);
  m2=parseFloat(document.getElementById("hora2").value);
  m3=parseFloat(document.getElementById("hora3").value); 
  m4=parseFloat(document.getElementById("hora4").value);
  m5=parseFloat(document.getElementById("hora5").value);
  m6=parseFloat(document.getElementById("hora6").value);
  m7=parseFloat(document.getElementById("hora7").value);
  m8=parseFloat(document.getElementById("hora8").value);
  m9=parseFloat(document.getElementById("hora9").value);
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

      <h2>editar transacciones <br> <?php echo $sucursal;?></h2>
      <input type="hidden" name="idusuario" id="idusuario" value="<?php echo "$idusuario"; ?>">
      <input type="hidden" name="idsucursal" id="idsucursal" value="<?php echo "$sucursal_id"; ?>" >
      <input type="hidden" name="idtransacciones" id="idtransacciones" value="<?php echo "$idtransacciones"; ?>" >
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
          <label class="col-md-5 control-label">(08 - 09 AM)(04-05 PM):</label>  
            <div class="col-md-2">
            <input id="hora1" type="decimal" name="hora1" class="form-control input-md" value="<?php echo $reg_ven["hora1"];?>" >
          </div>
         </div>

 <div class="col-md-12">
            <label class="col-md-5 control-label">(09 - 10 AM)(05-06 PM):</label>  
            <div class="col-md-2">
            <input id="hora2" type="decimal" name="hora2" class="form-control input-md" value="<?php echo $reg_ven["hora2"];?>">
            </div>
            </div>

            <div class="col-md-12" >
            <label class="col-md-5 control-label">(10 - 11 AM)(06-07 PM):</label>  
            <div class="col-md-2">
            <input id="hora3" type="decimal" name="hora3" class="form-control input-md" value="<?php echo $reg_ven["hora3"];?>">
            </div>
            </div>

            <div class="col-md-12">
            <label class="col-md-5 control-label">(11 - 12 AM)(07-08 PM):</label>  
            <div class="col-md-2">
            <input id="hora4" type="decimal" name="hora4" class="form-control input-md" value="<?php echo $reg_ven["hora4"];?>">
            </div>
            </div>

            <div class="col-md-12">
            <label class="col-md-5 control-label">(12 - 01 PM)(08-09 PM):</label>  
            <div class="col-md-2">
            <input id="hora5" type="decimal" name="hora5" class="form-control input-md" value="<?php echo $reg_ven["hora5"];?>">
            </div>
            </div>

            <div class="col-md-12">
            <label class="col-md-5 control-label">(01 - 02 PM)(09-10 PM):</label>  
            <div class="col-md-2">
            <input id="hora6" type="decimal" name="hora6" class="form-control input-md" value="<?php echo $reg_ven["hora6"];?>">
            </div>
            </div>

            <div class="col-md-12">
            <label class="col-md-5 control-label">(02 - 03 PM)(10-11 PM):</label>  
            <div class="col-md-2">
            <input id="hora7" type="decimal" name="hora7" class="form-control input-md" value="<?php echo $reg_ven["hora7"];?>">
            </div>
            </div>

           <div class="col-md-12">
            <label class="col-md-5 control-label">(03 - 04 PM)(11-12 PM):</label>  
            <div class="col-md-2">
            <input id="hora8" type="decimal" name="hora8" class="form-control input-md" value="<?php echo $reg_ven["hora8"];?>">
            </div>
            </div>

           <div class="col-md-12">
            <label class="col-md-5 control-label">(00 - 00 PM)(12-01 PM):</label>  
            <div class="col-md-2">
            <input id="hora9" type="decimal" name="hora9" class="form-control input-md"value="<?php echo $reg_ven["hora9"];?>" >
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