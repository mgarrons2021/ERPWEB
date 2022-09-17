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
    $prod= $db->GetRow("select * from producto where idproducto = $id");
    $impuesto = $db->GetAll("select * from tipo_impuesto");
    $medida = $db->GetAll("select * from unidad_medida");
    $articulo= $db->GetAll("select * from tipo_articulo");
    $categoria= $db->GetAll("select * from categoria");
    $proveedor= $db->GetAll("select * from proveedor");
    ?>
<div class="container">
  <div class="left-sidebar">
  <div class="contacto">
  <div class="row">
    <div class="col-md-12">
     <h2>modificar producto</h2>
          <form class="form-horizontal" role="form" method="post" action="actualizar.php">
            <input type="hidden" name="id" value="<?php echo $prod["idproducto"]; ?>">

         <div class="form-group">
              <label class="col-md-4 control-label">CODIGO:</label>
            <div class="col-md-4">
            <input id="codigo" name="codigo" placeholder="codigo"
            class="form-control input-md" type="text" value="<?php echo $prod['codigo_producto'];?>">
            </div>
         </div>

         <div class="form-group">
              <label class="col-md-4 control-label">NOMBRE:</label>
            <div class="col-md-4">
             <input id="nombre" name="nombre" placeholder="Nombre" class="form-control input-md" type="text"
          value="<?php echo $prod['nombre'];?>">
            </div>
         </div>
         
          <div class="form-group">
              <label class="col-md-4 control-label">DESCRIPCION</label>
            <div class="col-md-4">
             <input id="descripcion" name="descripcion" placeholder="descripcion"
             class="form-control input-md" type="text"
             title="Campo esclusivo de texto" title="Campo Solo Texto"
              value="<?php echo $prod['descripcion'];?>">
            </div>
         </div> 
        <div class="form-group">
              <label class="col-md-4 control-label">Realizar:</label>
            <div class="col-md-4">
            <select class="form-control select-md" name="excluir_ventas">
                  <option value="<?php echo $prod['excluir_ventas'];?>"><?php if($prod['excluir_ventas']=="no"){echo"Excluir venta";}else{echo"Incluir venta";}?></option>
                  <option  value="no">Excluir venta</option>
                  <option value="si">Incluir venta</option>
               </select>
            </div>
        </div>   
          
          <div class="form-group">
              <label class="col-md-4 control-label">PRECIO COMPRA:</label>
              <div class="col-md-4"> 
              <input type="double" name="precio" id="precio" class="form-control" 
              placeholder="#" value="<?php echo $prod['precio_compra'];?>">
            </div>
          </div>

          <div class="form-group">
              <label class="col-md-4 control-label">ESTADO:</label>
            <div class="col-md-4">
            <select class="form-control select-md" name="estado">
                 <option  value="<?php echo $prod['estado'];?>"><?php echo $prod['estado'];?></option>
                  <option value="activo">Activo</option>
                  <option value="inactivo">Inactivo</option>
               </select>
            </div>
          </div>
      <div class="form-group">
            <label class="col-md-4 control-label">Proveedor:</label>
            <div class="col-md-4">
               <select class="form-control select-md" name="idproveedor">
                <?php foreach ($proveedor as $r){ if($prod['idproveedor']==$r['idproveedor']){?>
              <option value="<?php echo $r["idproveedor"]?>"><?php echo $r["empreza"]; ?></option>
                <?php }}?>
               <?php foreach ($proveedor as $r){?>
                  <option value="<?php echo $r["idproveedor"]?>"><?php echo $r["empreza"]; ?></option>
                <?php }?>
               </select>
            </div>
            </div>
         <div class="form-group">
            <label class="col-md-4 control-label">Tipo de Impuesto:</label>
            <div class="col-md-4">
               <select class="form-control select-md" name="tipo_impuesto">
                <?php foreach ($impuesto as $r){ if($prod['idtipo_impuesto']==$r['idtipo_impuesto']){?>
              <option value="<?php echo $r["idtipo_impuesto"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }}?>
               <?php foreach ($impuesto as $r){?>
                  <option value="<?php echo $r["idtipo_impuesto"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
               </select ect>
            </div>
            </div>
    
            <div class="form-group">
            <label class="col-md-4 control-label">Unidad de Medida:</label>
            <div class="col-md-4">
               <select class="form-control select-md" name="unidad_medida">
               <?php foreach ($medida as $r){ if($prod['idunidad_medida']==$r['idunidad_medida']){?>
              <option value="<?php echo $r["idunidad_medida"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }}?>
               <?php foreach ($medida as $r){?>
                  <option value="<?php echo $r["idunidad_medida"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
               </select>
            </div>
            </div>
            <div class="form-group">
            <label class="col-md-4 control-label">Categoria:</label>
            <div class="col-md-4">
               <select class="form-control select-md" name="categoria">
               <?php foreach ($categoria as $r){ if($prod['idcategoria']==$r['idcategoria']){?>
              <option value="<?php echo $r["idcategoria"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }}?>
               <?php foreach ($categoria as $r){?>
                  <option value="<?php echo $r["idcategoria"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
               </select>
            </div>
            </div>

            <div class="form-group">
            <label class="col-md-4 control-label">Tipo de Articulo:</label>
            <div class="col-md-4">
               <select class="form-control select-md" name="tipo_articulo">
               <?php foreach ($articulo as $r){ if($prod['idtipo_articulo']==$r['idtipo_articulo']){?>
              <option value="<?php echo $r["idtipo_articulo"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }}?>
               <?php foreach ($articulo as $r){?>
                  <option value="<?php echo $r["idtipo_articulo"]?>"><?php echo $r["nombre"]; ?></option>
                <?php }?>
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