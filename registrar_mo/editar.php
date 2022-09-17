<html>
	<head>
		<title></title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css"> 
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/prettyPhoto.css" rel="stylesheet">
    <link href="../css/price-range.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
	  <link href="../css/main.css" rel="stylesheet">
	  <link href="../css/responsive.css" rel="stylesheet">
		<script src="../js/jquery.min.js"></script>
	</head>
	<body class="body">
    <?php require_once '../config/conexion.inc.php';
    $id = $_GET["ids"];
    $result= mysqli_query($enlace,"select c.*,z.nombre as nombrezona,t.nombre as tnegocio   from cliente c, zona z, tipo_negocio t where idcliente = '$id' and c.idzona=z.idzona and t.idtipo_negocio=c.idtipo_negocio ");
      $data=mysqli_fetch_array($result);
    $query="select * from zona";
    $query2="select * from tipo_negocio";
    ?>
<div class="container">
  <div class="left-sidebar">
  <br>
  <div class="contacto">
  <h2>Modificar Clientes</h2>
  <div class="row">
    <div class="col-md-12">
     
          <form class="form-horizontal" role="form" method="post" action="actualizar.php" action="editarroles.php">
            <input type="hidden" name="idcliente" value="<?php echo $user["idcliente"]; ?>">
          
      
      
        <div class="form-group">
             <label class="col-md-4 control-label">NOMBRE COMPLETO:</label>
             <div class="col-md-4">
             <input id="nombre" name="nombre" value="<?php echo($data['nombre']) ?>"placeholder="Nombre completo" class="form-control input-md" type="text" required onKeyPress="return soloLetras(event);"
             onkeyup="javascript:this.value=this.value.toUpperCase();" required/>
            </div>
         </div>

        <div class="form-group">
              <label  class="col-md-4 control-label " >CELULAR.:</label>
            <div class="col-md-4">
            <input  id="celular" name="celular" value="<?php echo($data['celular']) ?>" class="form-control input-md" type="number"   maxlength="8" required
             onkeyup="javascript:this.value=this.value.toUpperCase();" required/>
            </div>
         </div>

<div class="form-group">
             <label class="col-md-4 control-label">NOMBRE DEL NEGOCIO:</label>
             <div class="col-md-4">
             <input id="negocio" name="negocio" value="<?php echo($data['negocio']) ?>"
             class="form-control input-md" type="text" title="Campo Solo Texto"  
             required onkeypress="return soloLetras(event);"
             onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
         </div>

         <div class="form-group">
             <label class="col-md-4 control-label">DIRECCION:</label>
             <div class="col-md-4">
             <input id="direccion" name="direccion" value="<?php echo($data['negocio']) ?>"
             class="form-control input-md" type="text" title="Campo Solo Texto"
             required onkeypress=" return soloLetras(event);"
             onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
         </div>


 <div class="form-group">
            <label class="col-md-4 control-label">UBICACION GPS:</label>
            <div class="col-md-4">
            <input id="gps" name="gps" value="<?php echo($data['gps']) ?>" class="form-control input-md" type="text" name="direc"
            title=" ubicacion GPS"
            required onKeyPress="return soloLetras(event);"
             onkeyup="javascript:this.value=this.value.toUpperCase();" required/>
            </div>
         </div>

    <div class="form-group">
             <label class="col-md-4 control-label">Observaciones:</label>
             <div class="col-md-4">
             <input id="observacion" name="observacion" value="<?php echo($data['observaciones']) ?>"
             class="form-control input-md" type="text" title="Campo Solo Texto"
             onkeypress=" return soloLetras(event);"
             onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
         </div>
          <div class="form-group">
            <label class="col-md-4 control-label">ZONA:</label>
            <div class="col-md-4">
               <select class="form-control select-md" name="zona">
                 <option value="<?php echo $data["idzona"]?>"><?php echo $data["nombrezona"]; ?></option>
               <?php foreach ($ejecuta=mysqli_query($enlace,$query) as $r){?>
                  <option value="<?php echo $r["idzona"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
               </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label">TIPO DE NEGOCIO:</label>
            <div class="col-md-4">
               <select class="form-control select-md" name="tnegocio">
                 <option value="<?php echo $data["idtipo_negocio"]?>"><?php echo $data["tnegocio"]; ?></option>
               <?php foreach ($ejecuta=mysqli_query($enlace,$query2) as $r){?>
                  <option value="<?php echo $r["idtipo_negocio"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
               </select>
            </div>
         </div>

 <div class="form-group">
            <label class="col-md-4 control-label">ESTADO:</label>
            <div class="col-md-4">
               <select class="form-control select-md" name="estado">
                 <option value="activo">Activo</option>
                  <option value="inactivo">Inactivo</option>
                <?php}?>
               </select>
            </div>
         </div>

<div class="row">
           <div class="form-group">
             <table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
            <tr>
             <td> <a href="listar.php" class="btn btn-primary" role="button">Cancelar</a></td>
              <td>  <button type="submit" id="ir" class="btn btn-primary">Modificar</button></td>
              <td> <button type="reset" class="btn btn-primary">limpiar</button></td>
           </tr>
             </table>
          </div>
        </div>
        </div>
      </form>


    </div>
  </div>
</div>
</div>
</div>
	</body>
</html>