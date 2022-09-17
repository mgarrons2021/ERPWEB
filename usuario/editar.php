<html>
	<head>
		<title></title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilos.css">

		<script src="../js/jquery.min.js"></script>
	</head>
	<body class="body">
    <?php include"../menu/menu.php";
    $id = $_GET['ids'];

    $user= $db->GetRow("SELECT u.idusuario, u.codigo_usuario, u.nombre ,u.celular, u.direccion ,u.correo, u.estado, u.fecha, r.nombre as nombrerol, s.nombre as nombresucursal,r.idrol, s.idsucursal
    FROM usuario u, rol r, sucursal s
    where u.rol_id=r.idrol and
          u.sucursal_id=s.idsucursal and
          u.idusuario = '$id' ");
    $query =$db->GetAll("select * from rol");
    $query2 =$db->GetAll ("select * from sucursal");
    ?>
<div class="container">
  <div class="left-sidebar">
  <div class="contacto">
  <h2>Editar Usuario</h2>
  <div class="row">
    <div class="col-md-12">
     
          <form class="form-horizontal" role="form" method="post" action="actualizar.php" action="actualizar.php">
            <input type="hidden" name="idusuario" value="<?php echo $user["idusuario"]; ?>">

 <div class="form-group">
              <label class="col-md-4 control-label">CODIGO:</label>
            <div class="col-md-4">
             <input id="codigo_usuario" name="codigo_usuario" placeholder="Codigo del usuario" class="form-control input-md" type="text"
             required="Usuario" title="Codigo del usuario" value="<?php echo $user["codigo_usuario"];?>" 
             onkeyup="javascript:this.value=this.value.toUpperCase();"> 
            </div>
          </div>

          <div class="form-group">
              <label class="col-md-4 control-label">NOMBRE:</label>
            <div class="col-md-4">
             <input id="nombre" name="nombre" placeholder="nombre" class="form-control input-md" type="text" required onKeyPress="return soloLetras(event);" value="<?php echo $user["nombre"];?>"
             onkeyup="javascript:this.value=this.value.toUpperCase();" required/>
            </div>
         </div> 

      <div class="form-group">
              <label class="col-md-4 control-label">CELULAR:</label>  
            <div class="col-md-4">
       <input type="text" name="celular"class="form-control input-md" id="inputPassword" placeholder="Celular"
       value="<?php echo $user["celular"];?>" 
       onkeyup="javascript:this.value=this.value.toUpperCase();">
          </div>
        </div>
        <div class="form-group">
              <label class="col-md-4 control-label">DIRECCION:</label>
            <div class="col-md-4">
             <input id="direccion" name="direccion" placeholder="direccion" class="form-control input-md" type="text" value="<?php echo $user["direccion"];?>" />
            </div>
         </div>
        <div class="form-group">
              <label class="col-md-4 control-label">CORREO ELECTRONICO:</label>
            <div class="col-md-4">
             <input id="correo" name="correo" placeholder="Correo electronico" class="form-control input-md" type="email" value="<?php echo $user["correo"];?>"/>
            </div>
         </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-4 control-label">Rol:</label>
          <div class="col-sm-4">
               <select class="form-control" name="rol" id="rol">
                <option value="<?php echo $user["idrol"];?>"><?php echo $user["nombrerol"];?></option> 
                <?php foreach ($query as $r){?>
                <option value="<?php echo $r["idrol"]?>"><?php echo $r["nombre"]; ?></option>
                <?php  }?>
               </select>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-4 control-label">SUCURSAL:</label>
          <div class="col-sm-4">
              <select class="form-control" name="sucursal" >
                <option value="<?php echo $user["idsucursal"];?>"><?php echo $user["nombresucursal"];?></option> 
                <?php foreach ($query2 as $r){?>
                  <option value="<?php echo $r["idsucursal"]?>"><?php echo $r["nombre"]; ?></option>
                <?php  }?>
              </select>
          </div>
        </div>
        
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-4 control-label">
            Estado:
          </label>
          <div class="col-sm-4">
            <select class="form-control" name="estado" id="">
              <?php if ($user["estado"]=="activo") { ?>
                <option value="activo">activo</option>
                <option value="inactivo">inactivo</option>
             <?php } else {?>
             <option value="inactivo">inactivo</option>
             <option value="activo">activo</option>
             <?php } ?> 
            </select>
          </div>
        </div>

       



        
        
        <div class="row">
           <div class="form-group">
             <table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
            <tr>
              <td>  <button type="submit" class="btn btn-primary">Guardar</button></td>
              <td>  <a href="listar.php" class="btn btn-primary">Cancelar</a></td>
           </tr>
             </table>
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