<?php include"../menu/menu.php";

  $query= $db->GetAll('select * from rol');
  $query2= $db->GetAll('select * from sucursal');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Registro Usuario</title>
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


 <script language="JavaScript">
    function ver_password() {
        var input_form = document.elformulario.clave;
     
        if (document.elformulario.input_ver.checked) {
            input_form.setAttribute("type", "text");
        }
        else {
            input_form.setAttribute("type", "password");
        }
    }
    </script>
</head>

<body>

<div class="container" >
	<div class="left-sidebar">

<form class="form-horizontal" data-toggle="validator" name="elformulario"  role="" action="agregar.php" method="post">
<!-- Form Name -->
      <h2>registro de nuevo usuario</h2>



      <div class="form-group">
              <label  class="col-md-4 control-label " >Codigo.:</label>
            <div class="col-md-4">
            <input  id="codigo" name="codigo" placeholder="codigo "  class="form-control input-md" type="text"   maxlength="11" required
             onkeyup="javascript:this.value=this.value.toUpperCase();" required/>
            </div>
         </div>

        <div class="form-group">
             <label class="col-md-4 control-label">NOMBRE:</label>
             <div class="col-md-4">
             <input id="nombre" name="nombre" placeholder="Nombre completo" class="form-control input-md" type="text" required onKeyPress="return soloLetras(event);"
             onkeyup="javascript:this.value=this.value.toUpperCase();" required/>
            </div>
         </div>
         
         <div class="form-group">
             <label class="col-md-4 control-label">CARGO:</label>
             <div class="col-md-4">
             <input id="cargo" name="cargo" placeholder="Cargo" class="form-control input-md" type="text" required onKeyPress="return soloLetras(event);"
             onkeyup="javascript:this.value=this.value.toUpperCase();" required/>
            </div>
         </div>

         <div class="form-group">
          <label class="col-md-4 control-label">CELULAR.:</label>  
            <div class="col-md-4">
            <input id="celular" type="number" name="celular" class="form-control input-md" placeholder="Telefono o celular" required="Telefono" onkeyup="javascript:this.value=this.value.toUpperCase()" SoloNumeros(event);>
            </div>
            </div>
         
          <div class="form-group">
            <label class="col-md-4 control-label">DIRECCION:</label>
            <div class="col-md-4">
            <input id="direccion" name="direccion" placeholder="Domicilio donde vive" class="form-control input-md" type="text" name="direc"
            title=" direccion domicilio"
            required onKeyPress="return soloLetras(event);"
             onkeyup="javascript:this.value=this.value.toUpperCase();" required/>
            </div>
         </div>
         
         
         <!--<div class="form-group">
              <label class="col-md-4 control-label">CORREO ELECTRONICO:</label>
            <div class="col-md-4">
             <input id="correo" name="correo" placeholder="Correo electronico" class="form-control input-md" type="email" required
             required/>
            </div>
         </div>-->
         
          
          <div class="form-group">
              <label class="col-md-4 control-label">ESTADO:</label>
            <div class="col-md-4">
            <select class="form-control select-md" name="estado">
                  <option  value="activo">Activo</option>
                  <option value="inactivo">Inactivo</option>
               </select>
            </div>
          </div>
          <div class="form-group">
              <label class="col-md-4 control-label">FECHA:</label>
            <div class="col-md-4">
            <input id="fecha" name="fecha" value="<?php echo date('d-m-y') ?>" class="form-control input-md" disabled="disabled"  />
            </div>
          </div>
          <div class="row">
            <label class="col-md-4 control-label">ROL:</label>
            <div class="col-md-4">
               <select class="form-control select-md" name="rol">
               <?php foreach ($query as $r){?>
                  <option value="<?php echo $r["idrol"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
               </select>
            </div>
            </div>
       <br>
            <div class="row">
            <label class="col-md-4 control-label">SUCURSAL:</label>
            <div class="col-md-4">
               <select class="form-control select-md" name="sucursal">
               <?php foreach ($query2 as $r){?>
                  <option value="<?php echo $r["idsucursal"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
               </select>
            </div>
            </div>
  
<div class="row">
           <div class="form-group">
             <table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
            <tr>
              <td>  <button type="submit" id="ir" class="btn btn-primary">Aceptar</button></td>
              <td> <button type="reset" class="btn btn-primary">limpiar</button></td>
           </tr>
             </table>
          </div>
        </div>
        </div>


</form>


<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" align="center">Asignacion de Items</h4>
        </div>

        <table id="usuario" class="table table-striped table-hover table-bordered"
        cellspacing="0" width="100%">

           <label class="col-md-1 control-label">&nbsp;&nbsp;Rol:</label>
           <div class="col-md-4">
              <input id="nombre" name="nombre" placeholder="Nuevo Rol"
              class="form-control input-md" type="text" title="Campo Solo Texto"
              required onkeypress=" return soloLetras(event);">
           </div>

        <div class="col-md-3">
        <input type="submit" id="limpiar" class="btn btn-default" value="Nuevo" >
        </div>

       <div class="col-md-4" >
               <select class="form-control select-md" name="rol">
               <?php foreach ($query as $r){?>
                  <option value="<?php echo $r["id"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
               </select>
            </div>
        </table>



        <div class="modal-body">
        <div class="table-responsive">
        <table id="usuario" class="table table-striped table-hover table-bordered"
        cellspacing="0" width="100%">

       <thead>
            <tr>
                <td>Descripion</td>
                <td>Permisos</td>
               <td>Asignar</td>

            </tr>
        </thead>

        <tbody>
<?php    foreach ($query2 as $r  ){?>
<tr>
<td><?php  $c++;  echo $array2[$c]; ?></td>
 <td><?php  echo $array1[$c]; ?></td>

  <td>

  <?php
                if ($r["estado"] == 'activo') { ?>
                    <a href="./estado.php?id=<?php echo $r["id"];?>"
                    onclick ="return confirm('&iquest;Esta Seguro Dar de Baja?')" >
                        <img src="../images/alta.png" alt="" title="DAR DE BAJA">Baja
                     </a>
                       <?php
                   } else {
                       ?>
                    <a href="./estado.php?id=<?php echo $r["id"];?> "
                    onclick ="return confirm('&iquest;Esta Seguro Dar de Alta?')">
                    <img src="../images/baja.png" alt="" title="DAR DE ALTA">Alta
                    </a>
       <?php } ?>
  </td>
 </tr>
 <?php }?>
  </table>
      </div>
       <div align="right">
        <input type="submit" id="enviar" class="btn btn-primary"
        value="Aceptar" class="close" data-dismiss="modal" aria-hidden="true">
        </div>
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
					<center><p class="pull-center">Copyright © SISTEMA DONESCO SRL</p></center>	
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