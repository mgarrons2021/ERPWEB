<?php include"../menu/menu.php";
$query= $db->GetAll('select * from rol');

$usuario =$_SESSION['usuario'];
$idusuario=$usuario['idusuario'];
$sucursal=$usuario['nombresucursal'];
$sucursal_id=$usuario['sucursal_id'];
//$idreg_ventas=$_POST['idreg_ventas'];
$query3= $db->GetAll('select * from producto');
$query2= $db->GetAll('select * from sucursal');
$query5= $db->GetAll('select * from proveedor');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Asignar proveedor a producto</title>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/intlTelInput.css"> 
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="../js/jquery.js"></script>   
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </head>
    
<script>
$(document).ready(function() {
    $('.producto').select2();
});
</script>
<script>
$(document).ready(function() {
    $('.proveedor').select2();
});
</script>

<script>
$(document).ready(function() {
    $('.sucursal').select2();
});
</script>
<div class="table-responsive">
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
  <body>
<div class="container">
	<div class="left-sidebar">
<form class="form-horizontal" data-toggle="validator" name="elformulario"  role="" action="agregarasignarproveedor.php" method="post">
    <h2>Asignar proveedor a producto<br></h2>
        <div class="col-md-12">
            <label class="col-md-5 control-label">Fecha Actual:</label>
            <div class="input-daterange col-md-3 " id="datepicker"> 
            <input type="text" id="fecha" class="input-sm form-control" name="fecha" value="<?php echo date('Y-m-d');?>" disabled/>  
            </div>
          </div>
          <div class="col-md-12">
              <label class="col-md-5 control-label">Producto:</label>
            <div class="col-md-3" >
            <select class="producto"  name="producto" id="producto">
                <option  value="0">Seleccionar producto</option>
                <?php  foreach($query3 as $plato){ ?>
                  <option  value="<?php echo $plato['idproducto'];?>"><?php echo $plato['nombre'];?></option>
                  <?php } ?>
            </select>
            </div>
          </div>
          <div class="col-md-12" >
          <label class="col-md-5 control-label">Proveedor:</label>
          <div class="col-md-3" >
          <select class="proveedor"  name="proveedor" id="proveedor">
                <option  value="0">Seleccionar proveedor</option>
                <?php  foreach($query5 as $proveedor){ ?>
                  <option  value="<?php echo $proveedor['idproveedor'];?>"><?php echo $proveedor['empreza'];?></option>
                  <?php } ?>
            </select>
          </div>
          </div>

          <div class="col-md-12">
              <label class="col-md-5 control-label">Sucursal:</label>
            <div class="col-md-3" >
            <select class="sucursal" name="sucursal" id="sucursal">
                <option  value="0">Selec sucursal</option>
                <?php  foreach($query2 as $sucur){ ?>
                  <option  value="<?php echo $sucur['idsucursal'];?>"><?php echo $sucur['nombre'];?></option>
                  <?php } ?>
            </select>
            </div>
          </div>

        <div class="col-md-12">
            <label class="col-md-5 control-label">Precio:</label>  
            <div class="col-md-3">
            <input id="precio" type="decimal" name="precio" class="form-control input-sm" placeholder="bs." pattern="[z0-9_.]{1,15}">
            </div>
            </div>
      <br> 
      <div class="row">
          <div class="form-group">
            <table width="100" border="0" cellspacing="1" cellpadding="5" align="center">
            <tr>
              <td>  <button type="submit" id="ir" class="btn btn-success">ACEPTAR</button></td>
          </tr>
            </table>
          </div>
        </div>
</div>
</form>
</body>
<style>
    .col-md-12{
        margin-top: 2px;
        margin-bottom: 2px;
    }
</style>
</html>