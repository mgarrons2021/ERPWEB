
<html>
	<head>
		<title></title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilos.css">
   <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
		<script src="../js/jquery.min.js"></script>
	</head>
	<body class="body">
    <?php include"../menu/menu.php"; 
    $id = $_GET['idcliente'];
    $persona= $db->GetRow("select * from cliente where idcliente = $id");
    ?>
    <script src="../js/jquery.js"></script>
<script src="../data/librerias/calendario2/js/bootstrap-datepicker.min.js"></script>
<script src="../data/librerias/calendario2/locales/bootstrap-datepicker.es.min.js"></script>
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
<div class="container">
  <div class="left-sidebar">
  <div class="contacto">
  <div class="row">
    <div class="col-md-12">
     <h2>modificar cliente</h2>
          <form class="form-horizontal" role="form" method="post" action="actualizar.php">
            <input type="hidden" name="idcliente" value="<?php echo $persona["idcliente"]; ?>">
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-4 control-label">
            NIT/CI:
          </label>
          <div class="col-sm-4">
            <input type="text"   
            class="form-control" id="nit_ci" name="nit_ci" value="<?php echo $persona["nit_ci"];?>" >
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-4 control-label">
            NOMBRE:
          </label>
          <div class="col-sm-4">
            <input class="form-control" id="nombre" name="nombre" type="text" 
            onkeyup="javascript:this.value=this.value.toUpperCase();
                    title="solo letras" pattern="[a-zA-Z - ]*" value="<?php echo $persona["nombre"];?>">
          </div>
        </div>
         <div class="form-group">
          <label for="inputPassword3" class="col-sm-4 control-label">
            CELULAR:
          </label>
          <div class="col-sm-4">
              <input class="form-control" title="solo numeros 8 digitos"pattern="^\d{8}$" id="celular" name="celular" type="number" value="<?php echo $persona["celular"];?>">
          </div>
        </div>
     
          
           <div class="form-group">
             <label class="col-md-4 control-label">
             FECHA CUMPLEAÑOS:
             </label>
            <div class="input-daterange col-sm-4 " id="datepicker"> 
            <input type="text" id="fecha" class="input-sm form-control" name="fecha" value="<?php echo $persona["fecha"];?>"/>  
            </div>
          </div>
          
          <div class="form-group">
          <label for="inputPassword3" class="col-sm-4 control-label">
           HUBICACION:
          </label>
          <div class="col-sm-4">
            <input class="form-control" id="hubicacion" name="hubicacion" type="text" value="<?php echo $persona["hubicacion"];?>">
         </div>
      </div>
        <div class="form-group">
          <div class="col-sm-12" align="center">
            <input type="submit" class="btn btn-primary" value="Actualizar">
            <a href="index.php" class="btn btn-primary">Cancelar</a>
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