<?php
include('../menu/menu.php');
$nv = $db->GetRow("select * from producto");
$impuesto = $db->GetAll("select * from tipo_impuesto");
$medida = $db->GetAll("select * from unidad_medida");
$articulo = $db->GetAll("select * from tipo_articulo");
$categoria = $db->GetAll("select * from categoria");
$proveedor = $db->GetAll("select * from proveedor");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Registro de Nuevo Producto</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/font-awesome.min.css" rel="stylesheet">
  <link href="../css/prettyPhoto.css" rel="stylesheet">
  <link href="../css/price-range.css" rel="stylesheet">
  <link href="../css/animate.css" rel="stylesheet">
  <link href="../css/main.css" rel="stylesheet">
  <link href="../css/responsive.css" rel="stylesheet">

  <!-- Datatable -->
  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="images/ico/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="../images/ico/apple-touch-icon-57-precomposed.png">

</head>

<body class="body">

  <div class="container" class="left-sidebar">
    <div class="left-sidebar">
      <form class="form-horizontal" action="agregar.php" method="post" enctype="multipart/form-data">
        <h2>Registro de Nuevo producto</h2>

        <div class="form-row">
          <div class="form-group col-md-4">
            <label class="bmd-label-floating">Proveedor</label>
            <select class="form-control select-md" name="idproveedor" id="proveedor">
              <?php foreach ($proveedor as $r) { ?>
                <option value="<?php echo $r["idproveedor"] ?>"><?php echo $r["empreza"]; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label class="bmd-label-floating">Tipo de impuesto</label>
            <select class="form-control select-md" name="tipo_impuesto" id="tipo_impuesto">
              <?php foreach ($impuesto as $r) { ?>
                <option value="<?php echo $r["idtipo_impuesto"] ?>"><?php echo $r["nombre"]; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label class="bmd-label-floating">Unidad de medida</label>
            <select class="form-control select-md" name="unidad_medida" id="unidad_medida">
              <?php foreach ($medida as $r) { ?>
                <option value="<?php echo $r["idunidad_medida"] ?>"><?php echo $r["nombre"]; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label class="bmd-label-floating">Catergoria</label>
            <select class="form-control select-md" name="categoria" id="categoria">
              <?php foreach ($categoria as $r) { ?>
                <option value="<?php echo $r["idcategoria"] ?>"><?php echo $r["nombre"]; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label class="bmd-label-floating">Tipo de articulo</label>
            <select class="form-control select-md" name="tipo_articulo" id="tipo_articulo">
              <?php foreach ($articulo as $r) { ?>
                <option value="<?php echo $r["idtipo_articulo"] ?>"><?php echo $r["nombre"]; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
          <table class="table table-hover" id="tblproducto" cellspacing="0" width="100%">
            <div class="col-md-10">
              <div class="form-group bmd-form-group">
                <input type="text" class="form-control" id="producto" placeholder="Ingrese el producto a solicitar" />
              </div>
            </div>
            <thead class="text-info">
              <tr style="max-width: 100%;">
                <th>Nombre</th>
                <th>Código</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th style="visibility: hidden;">Provedor</th>
                <th>Quitar</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="form-group">
          <table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
            <tr>
              <td> <button type="submit" class="btn btn-primary">Aceptar</button></td>
              <td> <button type="reset" class="btn btn-primary">limpiar</button></td>
            </tr>
          </table>
        </div>
    </div>
    </form>
    <br><br><br>


    <footer id="footer">
  </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <center>
          <p class="pull-center">Copyright © SISTEMA DONESCO</p>
        </center>
      </div>
    </div>
  </div>
  </footer>
  </div>
  </div>

  <!-- Datatable -->
  <script src="../js/jquery.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function () {
        $("form").keypress(function (e) {
            if (e.which == 13) {
                return false;
            }
        });
    });
  </script>

  <script>
    $("#telefono").intlTelInput({
      onlyCountries: ['bo', 'ar'],

      utilsScript: "../js/utils.js"
    });
  </script>

  <script>
    var tblproducto;
    var producto_list = {
      items: {
        producto: [],
      },
      add: function(item) {
        this.items.producto.push(item);
        this.list();
      },
      list: function() {
        tblproducto = $('#tblproducto').DataTable({
          "language": {
            "sEmptyTable": "Ningún dato disponible en esta tabla",
          },
          paging: false,
          filter: false,
          info: false,
          autoWidth: false,
          responsive: true,
          destroy: true,
          ordering: false,
          data: this.items.producto,
          columns: [{
              "data": "nombre"
            },
            {
              "data": "codigo"
            },
            {
              "data": "descripcion"
            },
            {
              "data": "precio"
            },
            {
              "data": "proveedor"
            },
          ],
          columnDefs: [{
              targets: [1],
              class: "text-center",
              orderable: false,
              render: function(data, type, row) {
                return '<input  name="codigo" placeholder="codigo" class="form-control input-md" style="width: 50%;" type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" value="' + row.codigo + '">';
              }
            },
            {
              targets: [2],
              class: "text-center",
              orderable: false,
              render: function(data, type, row) {
                return '<input  name="descripcion" placeholder="descripcion" class="form-control input-md" type="text" title="Campo esclusivo de texto" title="Campo Solo Texto" onkeyup="javascript:this.value=this.value.toUpperCase();" value="' + row.descripcion + '">';
              }
            },
            {
              targets: [3],
              class: "text-center",
              orderable: false,
              render: function(data, type, row) {
                return '<input type="double" name="precio" class="form-control" style="width: 50%;" placeholder="Bs." value="' + row.precio + '">';
              }
            },
            {
              targets: [4],
              class: "text-center",
              visible: false,
              orderable: false,
              render: function(data, type, row) {
                return '<input type="text" name="proveedor" class="form-control" style="width: 50%;" placeholder="Bs." value="' + row.proveedor + '">';
              }
            },
            {
              targets: [5],
              class: "text-center",
              orderable: false,
              render: function(data, type, row) {
                return '<a rel="remove" class="btn btn-danger btn-sm"><i class="material-icons">x</i></a>';
              }
            },
          ],
        })
      },
    };

    $('#tblproducto tbody')
      .on('click', 'a[rel="remove"]', function() {
        var tr = tblproducto.cell($(this).closest('td', 'li')).index();
        producto_list.items.producto.splice(tr.row, 1);
        producto_list.list();
      })
      .on('change', 'input[name="codigo"]', function() {
        var codigo = $(this).val();
        var tr = tblproducto.cell($(this).closest('td, li')).index();
        producto_list.items.producto[tr.row].codigo = codigo;
      })
      .on('change', 'input[name="descripcion"]', function() {
        var descripcion = $(this).val();
        var tr = tblproducto.cell($(this).closest('td, li')).index();
        producto_list.items.producto[tr.row].descripcion = descripcion;
      })
      .on('change', 'input[name="precio"]', function() {
        var precio = $(this).val();
        var tr = tblproducto.cell($(this).closest('td, li')).index();
        producto_list.items.producto[tr.row].precio = precio;
      });

    
    //Enter para agregar el producto
    var producto = document.getElementById('producto');
    producto.addEventListener('keyup', function(e) {
      var keycode = e.keyCode || e.which;
        if(producto.value != ''){
          if (keycode == 13) {
            var item = {
              "nombre": "",
              "codigo": "",
              "descripcion": "",
              "precio": "",
              "proveedor": "",
              "tipo_impuesto": "",
              "unidad_medida": "",
              "tipo_articulo": "",
              "categoria": "",
              "estado":"",
            };
            item.nombre        = producto.value;
            item.codigo        = ""
            item.descripcion   = "";
            item.precio        = "";
            item.proveedor     = $('#proveedor').val();
            item.tipo_impuesto = $('#tipo_impuesto').val();
            item.unidad_medida = $('#unidad_medida').val();
            item.tipo_articulo = $('#tipo_articulo').val();
            item.categoria     = $('#categoria').val();
            item.estado        = "activo";
            producto_list.add(item);
            //Cargar al local storage para no perder los datos cargados
            localStorage.setItem("productos", JSON.stringify(producto_list));
            producto.value = "";
          }
        }
      });
  </script>

  <script>
    $('form').on('submit', function(e) {
      e.preventDefault();
      var parameters = new FormData();
      parameters.append('producto_list', JSON.stringify(producto_list.items));
      $.ajax({
        url: 'agregar.php',
        type: 'POST',
        data: parameters,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(response){
          if(response.estado == 'true'){
            alert("Producto agregado correctamente");
            window.location.href = 'listar.php';
          }else 
            if(response.estado == 'false'){
            alert("error al procesar la solicitud, rellene los datos correctamente");
          }
        }
      });
    });
  </script>
</body>
</html>