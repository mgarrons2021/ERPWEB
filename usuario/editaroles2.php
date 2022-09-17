<?php include"../menu/menu.php";
   $id = $_GET['vari'];
   $array1= array("","registro","consultores","pedidos","prestamo","venta","compra","producto","reportes");
     $arrays[]=array();
   $query= $db->GetAll('select * from permisos where usuario_id='.$id);

   $user= $db->GetRow("select p.id as idper,u.id as id, p.nombre as nom,p.ap_pat as ape,p.ap_mat as mat,u.fecha, u.usuario, u.clave, u.estado,u.rol_id, u.cod, r.nombre as rol 
                    from usuario u, persona p, rol r
                    where p.id = u.persona_id and
                          r.id = u.rol_id and
                          u.id = '$id' "); 
                  
if ($query != null) {
  foreach ($query as $r){
  $arrays[$c]=$r["nombre"];
                      $c++;
                         }
                     $array= array_values(array_unique($arrays));
                 sort($array); 
                    }

echo 
"<script type='text/javascript'>
function ConfirmDemo() {
//Ingresamos un mensaje a mostrar
var mensaje = confirm('¿Items actuales  ?');
//Detectamos si el usuario acepto el mensaje
if (mensaje) {
alert('¡Cambiar Items !''){document.location='editaroles.php';}
}
//Detectamos si el usuario denegó el mensaje
else {
alert('¡Cancelar!'){document.location='listar.php';} 
}
</script> ";

?>     
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Registro usuario</title>
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

<form class="form-horizontal" data-toggle="validator"  role="" action="agregarpermiso.php" method="post">
<!-- Form Name -->
      <h2>Asignacion de items</h2>
 
<div class="row" >
<div class="col-md-5">
<select class="form-control select-md" name="origen[]" id="origen" multiple="multiple" size="8">
<option value="1">Registro</option>
<option value="2">Consultor</option>
<option value="3">Pedidos</option>
<option value="4">Prestamos</option>
<option value="5">Ventas</option>
<option value="6">Compras</option>
<option value="7">Producto</option>
<option value="8">Reportes</option>
</select>
</div>

<div class="col-md-2">
<input type="button"  class="pasar izq btn btn-primary" value="Pasar »"><input type="button"  class="quitar der btn btn-primary" value="« Quitar"><br />
<input type="button"  class="pasartodos izq btn btn-primary" value="Todos »"><input type="button" class="quitartodos der btn btn-primary" value="« Todos">
</div>

<div class="col-md-5">
<select class="form-control select-md" name="destino[]" id="destino" multiple="multiple" size="8"></select>
</div>
</div>

<div class="row">
           <div class="form-group">
             <table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
            <tr>
              <td>  <button type="submit" i=d"ir" class="btn btn-primary">Aceptar</button></td>
              <td> <button type="reset" class="btn btn-primary">limpiar</button></td>
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
