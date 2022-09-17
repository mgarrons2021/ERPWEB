
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
    $id = $_GET['idproveedor'];
    $persona= $db->GetRow("select * from proveedor where idproveedor = $id");
    ?>
<div class="container">
  <div class="left-sidebar">
  <div class="contacto">
  <div class="row">
    <div class="col-md-12">
     <h2>modificar provedor</h2>
          <form class="form-horizontal" role="form" method="post" action="actualizar.php">
            <input type="hidden" name="idproveedor" value="<?php echo $persona["idproveedor"]; ?>">

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-4 control-label">
            CODIGO:
          </label>
          <div class="col-sm-4">
            <input type="text"   
            class="form-control" name="codigo" value="<?php echo $persona["codigo"];?>" >
          </div>
        </div>

        <div class="form-group">
          <label for="inputPassword3" class="col-sm-4 control-label">
            NOMBRE:
          </label>
          <div class="col-sm-4">
            <input class="form-control" name="nombre" type="text" 
            onkeyup="javascript:this.value=this.value.toUpperCase();
                    title="solo letras" pattern="[a-zA-Z - ]*" value="<?php echo $persona["nombre"];?>">
          </div>
        </div>

         <div class="form-group">
          <label for="inputPassword3" class="col-sm-4 control-label">
            CELULAR:
          </label>
          <div class="col-sm-4">
              <input class="form-control" title="solo numeros 8 digitos"pattern="^\d{8}$" name="celular" type="number" value="<?php echo $persona["celular"];?>">
          </div>
        </div>
          <div class="form-group">
          <label for="inputPassword3" class="col-sm-4 control-label">
            EMPREZA:
          </label>
          <div class="col-sm-4">
            <input class="form-control" name="empreza" type="text" 
            
                    title="solo letras" pattern="[a-zA-Z - ]*" value="<?php echo $persona["empreza"];?>">
          </div>
        </div>
          <div class="form-group">
          <label for="inputPassword3" class="col-sm-4 control-label">
            NIT:
          </label>
          <div class="col-sm-4">
            <input class="form-control" name="nit" type="text" 
            
                    title="solo letras"  value="<?php echo $persona["nit"];?>">
          </div>
        </div>
         <div class="form-group">
            <label class="col-md-4 control-label">TIPO DE CATEGORIA:</label>
            <div class="col-md-4">
               <select class="form-control select-md" name="tipo_categoria">
                  <option value="<?php echo $persona["tipo_categoria"];?>"><?php echo $persona["tipo_categoria"];?></option>
                  <option value="Alimentos">Alimentos</option>
                   <option value="Bebidas">Bebidas</option>
                    <option value="NoComestible">No Comestible</option>
               </select>
            </div>
            </div>
    <div class="form-group">
            <label class="col-md-4 control-label">TIPO DE CREDITO:</label>
            <div class="col-md-4">
               <select class="form-control select-md" name="tipo_credito">
               <option value="<?php echo $persona["tipo_credito"];?>"><?php echo $persona["tipo_credito"];?></option>
                  <option value="credito1">credito1</option>
                   <option value="credito2">credito2</option>
                    <option value="credito3">credito3</option>
               </select>
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