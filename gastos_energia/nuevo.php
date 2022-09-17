<?php include"../menu/menu.php";
$query= $db->GetAll('select * from rol');
$date = date('Y-m-d');
$usuario =$_SESSION['usuario'];
$idusuario=$usuario['idusuario'];
$sucursal=$usuario['nombresucursal'];
$sucur=$usuario['sucursal_id'];
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$nro=$db->GetOne("select count(sucursal_id)+1 from consumoelectrico where sucursal_id='$sucur'");
$acumulado=$db->GetOne("SELECT SUM(consumototal) FROM consumoelectrico WHERE sucursal_id = $sucur and fecha = '$date'; "  );
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
    <title>Registro de consumo electrico</title>
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
  <script >
   function multiplicar() {
      m1 = parseFloat( document.getElementById("consumototal").value);
      m2 = parseFloat( document.getElementById("acumulado").value);
        if( document.getElementById("acumulado").value ===""){
           
            m2 = parseFloat( document.getElementById("consumototal").value);
            parseFloat( document.getElementById("costototal").value =  m2);
            parseFloat( document.getElementById("costoanterior").value =  0);
            m3 = parseFloat( m2 / 24).toFixed(2);
            m4 = parseFloat( m2 * 1.66).toFixed(2);
            document.getElementById("montohora").value = m3;
            document.getElementById("totalgasto").value = m4;
        }else{
      r =  m1 + m2;
      document.getElementById("costototal").value = r;
      m3 = parseFloat( r / 24).toFixed(2);
      m4 = parseFloat( r * 1.66).toFixed(2);
      document.getElementById("montohora").value = m3;
      document.getElementById("totalgasto").value = m4;
        }
    }
  </script>
<div class="left-sidebar">
<form class="form-horizontal" data-toggle="validator" name="elformulario"  role="" action="agregar.php" method="post">
    <h2>Registro de consumo electrico<br></h2>
            <div class="row">
                <div class="col-lg-6" style="float:none;margin:auto;">
                    <label for="">Nº Registro </label>
                    <input type="text" name="nro" id="nro" class="alert alert-success"
                        value="<?php echo "$nro"; ?>" disabled>
                    <input type="hidden" name="nro" id="nro" class="form-control"
                        value="<?php echo "$nro"; ?>">        
                </div>       
            </div>    
            <div class="row">                  
               <div class="col-lg-6" style="float:none;margin:auto;">
                      <input  id="fecha" name="fecha" placeholder="KW."  class="form-control input-md" type="hidden" />  

                    <label   >Lecturación  KW:</label>
                    <input  id="consumototal" name="consumototal"   class="form-control" type="decimal" onkeypress="return validar(event)" onChange="multiplicar();" />            
                <br>
                </div>
                <div class="row">
                <div class="form-group">
                    <table width="100" border="0" cellspacing="1" cellpadding="4" align="center">
                    <tr>
                    <td>  <button type="submit" id="ir" class="btn btn-success">ACEPTAR</button></td>
                </tr>
                    </table>
                </div>
            </div>
</form>

</body>
</html>
