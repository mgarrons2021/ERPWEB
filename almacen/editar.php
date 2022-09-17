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
    $id = $_GET['id'];
    $persona= $db->GetRow("select * from cliente where id = $id");
    ?>
<div class="container">
  <div class="left-sidebar">
  <div class="contacto">
  <div class="row">
    <div class="col-md-12">
     <h2>modificar cliente</h2>
          <form class="form-horizontal" role="form" method="post" action="actualizar.php">
            <input type="hidden" name="id" value="<?php echo $persona["id"]; ?>">

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-4 control-label">
            Nro de Carnet:
          </label>
          <div class="col-sm-4">
            <input type="text" title="numeros de 8 a 9 digitos" pattern="^\d{7,8}$" required 
            class="form-control" name="ci" value="<?php echo $persona["ci"];?>" >
          </div>
        </div>

        <div class="form-group">

          <label for="inputPassword3" class="col-sm-4 control-label">
            Nombre:
          </label>
          <div class="col-sm-4">
            <input class="form-control" name="nombre" type="text" 
            
                    title="solo letras" pattern="[a-zA-Z - ]*" value="<?php echo $persona["nombre"];?>">
          </div>
        </div>

        <div class="form-group">

          <label for="inputPassword3" class="col-sm-4 control-label">
            Apellido:
          </label>
          <div class="col-sm-4">
            <input class="form-control" pattern="[a-zA-Z - ]*" 
            title="solo letras" 
            name="apellido" type="text" value="<?php echo $persona["apellido"];?>">
          </div>
        </div>
       
       
        <div class="form-group">

          <label for="inputPassword3" class="col-sm-4 control-label">
            Telefono:
          </label>
          <div class="col-sm-4">
              <input class="form-control" title="solo numeros 8 digitos"pattern="^\d{8}$" name="telefono" type="number" value="<?php echo $persona["telefono"];?>">
          </div>
        </div>
        
         
        
        <div class="form-group">
          <div class="col-sm-12" align="center">

            <input type="submit" class="btn btn-primary" value="Actualizar">
            <a href="listar.php" class="btn btn-primary">Cancelar</a>
        
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