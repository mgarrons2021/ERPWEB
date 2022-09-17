<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="../images/favicon.ico">

    <title>Control de asistencia</title>
</head>
<body>
<?php 
require_once '../config/conexion.inc.php';
$sucursal = $db->GetAll("select idsucursal, nombre from sucursal where idsucursal = 7");

?>
<form class="form-horizontal" data-toggle="validator" name="elformulario"  role="" action="agregar.php" method="post">
<div class="titulo2">
    <h3><br></h3> 
</div>

<div class="card">
<div align="center"><img src = ../images/Logo_Correo.jpg width="250" height="100"></div>
    <div  align="center" class="card-header titulo">
        <h5>REGISTRO DE ASISTENCIA</h5>
        
    </div>
    <div class="card-body titulocard">
        <p class="card-title">Ingrese su codigo de usuario (<span class="required"> * </span>)</p>
        <input type="number" class="form-control"  name="codigo_usuario">
        <p class="card-title">Sucursal (<span class="required"> * </span>)</p>
        <select class="form-select"  id="sucursal_id" name="sucursal_id">
            <?php foreach($sucursal as $item) { ?>       
                <option value="<?php echo $item["idsucursal"] ?>"><?php echo $item["nombre"] ?></option>
            <?php } ?>
        </select>
        <div class="col text-center">
      <input type="submit" class="btn btn-danger" value="Ingresar" align="center">
    </div>
        
</div>
</form>
<script src="../js/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="vendor/select2/dist/js/select2.min.js"></script>
<style>
.titulo2{
    width: 50%;
    float: none;
    margin:auto;
    left: 50%;
    margin-top: 5%;
}
.titulo{
    width: 100%;
}
.required{
    color: red;
    font-size: 20px;
}
.card{
    width: 50%;
    align-items: center;
    float: none;
    margin:auto;
    line-height : 50px;
}
.titulocard{
    font-weight: bold;
}
.boton{
    width: 100%;
}
</style>
</body>
</html>