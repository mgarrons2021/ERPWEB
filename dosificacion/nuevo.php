<?php include"../menu/menu.php";
$query= $db->GetAll('select * from rol');

$usuario =$_SESSION['usuario'];
$idusuario=$usuario['idusuario'];
$sucursal=$usuario['nombresucursal'];
$sucursal_id=$usuario['sucursal_id'];
$query3= $db->GetAll('select * from auntorizacion');
$query2= $db->GetAll('select * from sucursal');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Registro de Dosificacion</title>
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
    <h2>Registro nueva Dosificacion<br></h2>
         <div class="col-md-12">
             <label class="col-md-5 control-label">Fecha Inicio:</label>
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <input type="text" id="fech_ini" class="input-sm form-control" name="fech_ini" value="<?php echo date('Y-m-d');?>"/>  
            </div>
          </div>
           <div class="col-md-12">
             <label class="col-md-5 control-label">Fecha Fin:</label>
            <div class="input-daterange col-md-2 " id="datepicker"> 
            <input type="text" id="fech_fin" class="input-sm form-control" name="fech_fin" value="<?php echo date('Y-m-d');?>"/>  
            </div>
          </div>
          
          <div class="col-md-12">
          <label class="col-md-5 control-label">Numero de Autorizacion:</label> 
            <div class="col-md-2">
            <input id="n_auto" type="decimal" name="n_auto" class="form-control input-md" placeholder="0">
          </div>
         </div>
          <div class="col-md-12">
          <label class="col-md-5 control-label">Nit:</label>  
            <div class="col-md-2">
            <input id="nit_suc" type="decimal" name="nit_suc" class="form-control input-md" placeholder="0">
          </div>
         </div>
          <div class="col-md-12">
          <label class="col-md-5 control-label">Factura:</label>  
            <div class="col-md-2">
            <input id="n_factura" type="decimal" name="n_factura" class="form-control input-md" placeholder=" ">
          </div>
         </div>
          <div class="col-md-12">
          <label class="col-md-5 control-label">Llave:</label>  
            <div class="col-md-2">
            <input id="Text" type="decimal" name="llave" class="form-control input-md" placeholder=" ">
          </div>
         </div>
         <div class="col-md-12">
          <label class="col-md-5 control-label">Estado:</label>  
            <div class="col-md-2">
            <input id="Text" type="decimal" name="estado" class="form-control input-md" placeholder=" ">
          </div>
         </div>
         
         
           
           
       <div class="col-md-12">
              <label class="col-md-5 control-label">Sucursal:</label>
            <div class="col-md-2" >
            <select class="form-control select-md" name="sucursal" id="sucursal">
                 <option  value="0">Selec sucursal</option>
                 <?php  foreach($query2 as $sucur){ ?>
                  <option  value="<?php echo $sucur['idsucursal'];?>"><?php echo $sucur['nombre'];?></option>
                  <?php } ?>
            </select>
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