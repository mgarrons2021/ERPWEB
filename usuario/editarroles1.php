<?php include"../menu/menu.php";
   
 $array1= array("","registro","consultores","pedidos","prestamo","venta","compra","producto","reportes");
 
 $array2= array("","Registro de usuarios, clientes, nota de venta, producto pedido","Registrar consultores ,listar ","pedidos , ver pagos ,listar pedidos recividos","Realizar prestamo, listar ","Realizar venta, listar ","Realizar compra, listar, ver almacen ","Registrar producto, listar","Ver Reportes ");
  $array3=array("","1","2","3","4","5","6","7","8");

   $arrays[]=array();
   $c=0;
   
  $ids = $_GET['vari'];
  
  $query= $db->GetAll('select * from permisos where usuario_id='.$ids);
  foreach ($query as $r){
   $arrays[$c]=$r["nombre"];
   $pocicion=$r["nombre"];
   $array3[$pocicion]="0";
   $c++;
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>permisos asignados</title>
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
 <script>

    $().ready(function()
  {
    $('.pasar').click(function() { return !$('#origen option:selected').remove().appendTo('#destino'); });
    $('.quitar').click(function() { return !$('#destino option:selected').remove().appendTo('#origen'); });
    $('.pasartodos').click(function() { $('#origen option').each(function() { $(this).remove().appendTo('#destino'); }); });
    $('.quitartodos').click(function() { $('#destino option').each(function() { $(this).remove().appendTo('#origen'); }); });
    $('.submit').click(function() { $('#destino option').prop('selected', 'selected'); });
  });
 </script>

</head>

<body>

<div class="container" >
  <div class="left-sidebar">

<form class="form-horizontal" data-toggle="validator"  role="form" action="nuevosroles.php" method="post">
<!-- Form Name -->
      <h2>permisos asignados</h2>
<div class="row" >


<input type="hidden" name="idperr" value="<?php echo $ids; ?>">

<div class="col-md-5">
<select class="form-control select-md" name="origen[]" id="origen" multiple="multiple" size="8">

<?php for ($i=0; $i <count($array3) ; $i++) { ?>

<?php if($array3[$i]=="1"){?><option value="1">Registro</option><?php }?>
<?php if($array3[$i]=="2"){?><option value="2">Consultor</option><?php }?>
<?php if($array3[$i]=="3"){?><option value="3">Pedidos</option><?php }?>
<?php if($array3[$i]=="4"){?><option value="4">Prestamos</option><?php }?>
<?php if($array3[$i]=="5"){?><option value="5">Ventas</option><?php }?>
<?php if($array3[$i]=="6"){?><option value="6">Compras</option><?php }?>
<?php if($array3[$i]=="7"){?><option value="7">Producto</option><?php }?>
<?php if($array3[$i]=="8"){?><option value="8">Reportes</option><?php }?>

<?php }?>
</select>
</div>

<div class="col-md-2">
<input type="button"  class="pasar izq btn btn-primary" value="Pasar »"><input type="button"  class="quitar der btn btn-primary" value="« Quitar"><br />
<input type="button"  class="pasartodos izq btn btn-primary" value="Todos »"><input type="button" class="quitartodos der btn btn-primary" value="« Todos">
</div>
<div class="col-md-5">
<select class="form-control select-md" name="destino[]" id="destino" multiple="multiple" size="8">
<?php for ($i=0; $i <count($arrays) ; $i++) {?>
<?php if($arrays[$i]=="1"){?><option value="1">Registro</option><?php }?>
<?php if($arrays[$i]=="2"){?><option value="2">Consultor</option><?php }?>
<?php if($arrays[$i]=="3"){?><option value="3">Pedidos</option><?php }?>
<?php if($arrays[$i]=="4"){?><option value="4">Prestamos</option><?php }?>
<?php if($arrays[$i]=="5"){?><option value="5">Ventas</option><?php }?>
<?php if($arrays[$i]=="6"){?><option value="6">Compras</option><?php }?>
<?php if($arrays[$i]=="7"){?><option value="7">Producto</option><?php }?>
<?php if($arrays[$i]=="8"){?><option value="8">Reportes</option><?php }?>
<?php }?>
</select>
</div>
</div>

<div class="row">
           <div class="form-group">
             <table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
            <tr>
              <td>  <button type="submit" id="ir" class="btn btn-primary">Aceptar</button></td>
              <td> <button type="reset" class="btn btn-primary">Restablecer</button></td>
           </tr>
             </table>
          </div>
        </div>
</form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
 <footer id="footer">
    </div>
    </div>
    <div class="footer-bottom">
      <div class="container">
        <div class="row">
          <center><p class="pull-center">Copyright © 2016 Ing.informatica soledad Codori& Noelia.</p></center>  
        </div>
      </div>
    </div>
    </footer>   
</div>
</div>

<script src="../js/intlTelInput.js"></script>
    <script>
      $("#telefono").intlTelInput({
        onlyCountries: ['bo', 'ar'],

        utilsScript: "../js/utils.js"
      });
    </script>
    <script>


</script>
    
</body>
</html>