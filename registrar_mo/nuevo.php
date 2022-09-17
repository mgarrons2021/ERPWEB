<?php include"../menu/menu.php";
$query= $db->GetAll('select * from rol');
$usuario =$_SESSION['usuario'];
$idusuario=$usuario['idusuario'];
$sucursal=$usuario['nombresucursal'];
$sucur=$usuario['sucursal_id'];
$usuario1= $db->GetAll('select * from usuario');
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$nro=$db->GetOne("select count(sucursal_id)+1 from registrar where sucursal_id='$sucur'");
      if ($nro == ''){
        $nro = 0;
        $nro++;
        }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Registro de Mano de Obra</title>
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
<div class="container">
	<div class="left-sidebar">
<form class="form-horizontal" data-toggle="validator" name="elformulario"  role="" action="agregar.php" method="post">
    <h2>registro de Mano de Obra<br></h2>
    
    <div class="row">
              <div class="col-md-4">
                <label for="">Nº Registro M.O.:</label>
               <input type="text" name="nro" id="nro" class="alert alert-success"
                 value="<?php echo "$nro"; ?>" disabled>
                 <input type="hidden" name="nro" id="nro" class="form-control"
                 value="<?php echo "$nro"; ?>">
             </div>   
             </div>
             
    <div class="col-md-4">
              <div class="input-group">
               <select class="btn btn-info" name="turno" id="turno">
                <option value="0">SELEC TURNO</option>   
                <option value="1">AM</option>
                <option value="2">PM</option>
               </select>
             </div>
            </div>
            <div class="col-md-12">
              <label class="col-md-5 control-label">Fecha registro:</label>
              <div class="col-md-2">
              <input type="date" name="fecha" id="fecha" class="form-control" required>
            </div>
            </div>
            <div class="row">
       <div class="col-md-3">
        <div class="input-group">
         <label>Registre Trabajador:</label> 
               <select  name="sucursal_idtraspaso" id="sucursal_idtraspaso" class="form-control">
               <option value="">Funcionario</option>
               <?php foreach ($usuario1 as $r){?>
                  <option value="<?php echo $r["idusuario"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
               </select>
		     </div>
        </div>
      </div>



         <div class="col-md-12">
        <label  class="col-md-5 control-label">Ventas:</label>
          <div class="col-md-2">
    <input  id="ventas" name="ventas" placeholder="Bs."  class="form-control input-md" type="decimal" />
         </div>
         </div>
          <div class="col-md-12">
              <label  class="col-md-5 control-label " >Total Horas:</label>
            <div class="col-md-2">
            <input  id="horas" name="horas" placeholder="Hrs."  class="form-control input-md" type="decimal" />
          </div>
          </div>
          
          </div>
          <br>
         <div class="row">
           <div class="form-group">
             <table width="100" border="0" cellspacing="1" cellpadding="4" align="center">
            <tr>
               <td>  <button type="submit" id="ir" class="btn btn-success">ACEPTAR</button></td>
           </tr>
             </table>
          </div>
        </div>
</div>
</form>
</body>
</html>