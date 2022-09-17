<?php include"../menu/menu_venta.php";
date_default_timezone_set('America/La_Paz');
$date1=date('Y-m-d');
$date2=date("Y-m-d",strtotime(date('Y-m-d')."- 1 days"));
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id'];
$sucursal=$usuario['nombresucursal'];

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$turno=$db->GetAll("select * from  turno where sucursal_id='$sucur'  and fecha between '$date2' and '$date1'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>turno</title>
    <link rel="stylesheet" href="../css/estiloyanbal.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/prettyPhoto.css" rel="stylesheet">
    <link href="../css/price-range.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
	<link href="../css/main.css" rel="stylesheet">
	<link href="../css/responsive.css" rel="stylesheet">
 	<link rel="shortcut icon" href="..images/ico/favicon.ico">
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


</head><!--/head-->
    <body>
<div class="container">
<div class="left-sidebar">
<form  method="post" action="agregar.php">
    <h2>INICIAR TURNO <br> <?php echo $sucursal;?></h2>
    <div class="row">
                <div class="col-md-4">
                 <label>Fecha:</label>
                 <div class="alert alert-success">
                 <?php echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ?>
                 </div>
                </div>
    </div>
    <div style="text-align:center;">
    <table border="0" style="margin: 0 auto;">
           <tr>
           <input class="btn btn-success" type="submit" value="INICIAR TURNO">
           </tr>
                </table>
     <br>
                <table width="340" border="1" cellspacing="1" cellpadding="5" align="center">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Turno</th>
                <th>Total</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($turno as $r){?>
<tr   class=warning>
    <td><?php echo $r["fecha"]; ?></td>
    <td><?php echo "Turno:".$r["nro"]." "; if($r["nro"]=="1"){echo " AM";}else{echo " PM";}?></td>
    <td><?php echo $r["total"]; ?></td>
 <?php if ($r["estado"] == 'si'){?>
    <td style="width:210px;"><a href="../ventas/nuevo.php?nro=<?php echo $r["nro"];?>&idturno=<?php echo $r["idturno"];?>">Ingresar al Turno</a>
  <?php } else { ?>
    <td style="width:210px;"><a href="#">Ingresar al Turno</a>
 <?php }?>

  <?php if($usuario['codigo_usuario']=='ric12345'||$usuario['codigo_usuario']=='miguel123'){
    if ($r["estado"] == 'si'){ ?>
                    <a href="./estado.php?id=<?php echo $r["idturno"];?>"
                    onclick ="return confirm('&iquest;Esta Seguro de desactivar turno?')" >
                    <img src="../images/alta.png" alt="" title="esta seguro de activar"> desactivar
                       </a>
                       <?php
                       }else{
                       ?>
                    <a href="./estado.php?id=<?php echo $r["idturno"];?> "
                    onclick ="return confirm('&iquest;Esta Seguro de Activar turno?')">
                    <img src="../images/baja.png" alt="" title="esta seguro de desactivar"> Activar
                    </a>
  <?php }} ?>
    <?php
    echo "<a class='' href='./pdfturno.php?nro=$r[nro]&idturno=$r[idturno]'
    target='_blank' role='button'><img src='../images/pdf.png' alt=''>PDF</a>";
     ?>
  </td>
  </tr>
 <?php }?>       
  </table>
 </div>
</form>
</div>
</div>  
<br><br><br><br>
    <footer id="footer">
		 </div>
		 </div>
		 <div class="footer-bottom">
			<div class="container">
				<div class="row">
					<center><p class="pull-center">Copyright © SISTEMA DONESCO S.R.L.</p></center>	
				</div>
			</div>
		 </div>
		</footer>		
</div>
</div>
</div>
</body>
</html>
