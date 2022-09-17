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
    $persona= $db->GetRow("select * from rol where id = $id");
    ?>
<div class="container">
  <div class="left-sidebar">
  <div class="contacto">
  <div class="row">
    <div class="col-md-12">
     <h2>modificar rol</h2>
          <form class="form-horizontal" role="form" method="post" action="actualizar.php">
            <input type="hidden" name="id" value="<?php echo $persona["id"]; ?>">
        
         <div class="form-group">
              <label class="col-md-4 control-label">Nombre:</label>  
            <div class="col-md-4">
             <input id="nombre" name="nombre" placeholder="Nombre" class="form-control input-md" type="text" required
             onkeyup="javascript:this.value=this.value.toUpperCase(); " value="<?php echo $persona["nombre"];?>"> 
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