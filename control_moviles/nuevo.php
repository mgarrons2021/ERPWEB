<?php include"../menu/menu.php";
$query= $db->GetAll('select * from rol');
$date = date('Y-m-d');
$usuario =$_SESSION['usuario'];
$idusuario=$usuario['idusuario'];
$sucursal=$usuario['nombresucursal'];
$sucur=$usuario['sucursal_id'];
$sucur;
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$nro=$db->GetOne("select count(sucursal_id)+1 from consumoelectrico where sucursal_id='$sucur'");
$verificar_datos = $db-> Execute("SELECT * FROM `registro_taxi` where fecha = '$date' and sucursal_id = $sucur");
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
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
<div class="left-sidebar">
<form class="form-horizontal" data-toggle="validator" name="elformulario"  role="" action="agregar.php" method="post">
    <h2>Registro de recepcion de mercaderia<br></h2>
            <div class="row">
                <div class="col-lg-6" style="float:none;margin:auto;">
                    <input type="hidden" name="nro" id="nro" class="form-control"
                        value="<?php echo "$nro"; ?>">        
                </div>       
            </div>    
            <div class="row">                  
                <div class="col-lg-6" style="float:none;margin:auto;">
                <div class="col-lg-12" >
                    <label class="textolabel" id="div_bolsas_recepcionadas" style="display:none">Cantidad de bolsas recepcionadas:</label>
                    <label class="textolabel" id="div_bolsas_enviadas" style="display:none">Cantidad de bolsas enviadas:</label>
                    <input  id="cantidad_bolsas" name="cantidad_bolsas" class="form-control inputd" type="number" required/>            
                </div>
                <br>
                </div>
                <div class="col-lg-6" style="float:none;margin:auto;">
                <div class="col-lg-10" style="">
                    <input  id="fecha" name="fecha" placeholder="KW."  class="form-control input-md inputd" type="hidden" />  
                    <label style="display:none" id="lbl_recepcion" class="textolabel">Hora de recepcion:</label>
                    <label style="display:none" id="lbl_salida" class="textolabel">Hora de salida:</label>
                    <input type="text" name="inputhora" id="inputhora" class="form-control inputd" placeholder="Obtener hora"  value ="" readonly>
                </div>
                <div class="col-lg-2">
                <input type="hidden" name="fecha" id="fecha" value=" <?php echo $date ?>">
                <input type="hidden" name="sucursal" id="sucursal" value=" <?php echo $sucur?>">
                <input type="hidden" name="taxi_id" id="taxi_id" value="">
                <input type="hidden" name="cdp" id="cdp" value="">
                    <label> &nbsp</label>
                    <button class="btn btn-warning  btn_hora" type="button" id="btn_hora"> Agregar</button>            
                </div>
                </div>  
            </div>
                <div class="row">                    
                <div class="form-group">
                    <table width="100" border="0" cellspacing="1" cellpadding="4" align="center">
                    <tr>
                        <br>
                    <td>  <button type="submit" id="ir" class="btn btn-success">ACEPTAR</button></td>
                </tr>
                    </table>
                </div>
            </div>
            <?php foreach ($verificar_datos  as $dato) { ?>
                <input type="hidden" id="verificador" value ="<?php echo $dato['cantidad_bolsas']?>">
            <?php }  ?>
</form>
<script>
    $(document).ready(function() {
        var sucursal = document.getElementById("sucursal").value;
        $("#ir").prop('disabled', true);
        if (sucursal == 19){
            $("#div_bolsas_enviadas").show();
            $("#lbl_salida").show();
            document.getElementById("taxi_id").value = 0;  
            var time =  moment().format("HH:mm:ss");
            document.getElementById("btn_hora").addEventListener("click", function() {
            document.getElementById("inputhora").value = time;
            document.getElementById("cdp").value = time;
            $("#ir").prop('disabled', false);
        });         
        }else{
            $("#ir").prop('disabled', true);
            $("#div_bolsas_recepcionadas").show();
            $("#lbl_recepcion").show();
            var time =  moment().format("HH:mm:ss");
            document.getElementById("btn_hora").addEventListener("click", function() {
            document.getElementById("inputhora").value = time;
            document.getElementById("cdp").value = null;
            $("#ir").prop('disabled', false);
        //alert(sucursal);
        if((sucursal == 12) || (sucursal == 4) || (sucursal == 2) || (sucursal == 15)){
            //alert('1');   
            document.getElementById("taxi_id").value = 1;  
        }else if((sucursal  ==  16) || (sucursal  ==  10) || (sucursal  ==   14) || (sucursal  ==  3) || (sucursal  ==  6)) {
            //alert('2');   
            document.getElementById("taxi_id").value = 2;
        }else if((sucursal  ==  5) || (sucursal  == 13) || (sucursal  == 11)){
            //alert('3');   
            document.getElementById("taxi_id").value = 3;
        }       
        });  
        }    
    });
</script>
<script>
    $(document).ready(function() {
        var verificar = document.getElementById("verificador").value;
        //alert(verificar);
        if(verificar > 0){
            document.getElementById("ir").addEventListener("click", function() {
                alert('El registro diario ya fue realizado');
                $("#ir").prop('disabled', true);
        });
        }else{
            
        }       
    });
</script>
<style>
    .btn_hora{
        background-color: red;
        margin-right: 25px;
        border-radius: 20px;
        border: 0;
        justify-content: center;
        margin-top: 5px;
    }
    .texto{
        color: whitesmoke;
    }
    .inputd{
        border-radius: 20px;
    }
    .textolabel{
        font-size: 17px;
    }
</style>
</body>
</html>