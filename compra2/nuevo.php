<?php include "../menu/menu.php";
date_default_timezone_set('America/La_Paz');
  $usuario = $_SESSION['usuario'];
  $usuarioid = $usuario['idusuario'];
  $sucur = $usuario['sucursal_id'];
  $nro = $db->GetOne("select max(nro)+1 from  compra where sucursal_id='$sucur'");
  $idinventario = $db->GetOne("SELECT max(nro) FROM inventario where sucursal_id=" . $sucur);
  $codigo = $db->GetOne('SELECT max(iddetallecompra)+1 FROM detallecompra');
  $idcompra = $db->GetOne('SELECT max(idcompra)+1 FROM compra');
  $fecha = date('Y-m-d');
  $fecha_vencimiento = date("Y-m-d",strtotime($fecha."+ 7 days"));
  if ($nro == '') {
    $nro = 0;
    $nro++;
  }
  $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
  $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $ventas = $db->GetAll("select * from proveedor where estado = 'activo'");
  $proveedores = $db->GetAll("select distinct pro.* from proveedor pro inner join producto_proveedor prpro on pro.idproveedor = prpro.proveedor_id where pro.estado = 'activo'
    and prpro.sucursal_id = $sucur;");
  $query = $ventas;
  $productos = $db->GetAll("select * from producto  where estado = 'activo' ORDER BY nombre ASC");
  $compras = $db->Execute("INSERT INTO compra VALUES ('1500', '5', '600', '600', '2021-12-14', NULL, '1', '1', '1', '1', NULL");
  if (isset($_POST['producto_list'])) {
    $producto_list = json_decode($_POST['producto_list'], true);
    echo $producto_list;
  }

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Registro Compra</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/font-awesome.min.css" rel="stylesheet">
  <link href="../css/price-range.css" rel="stylesheet">
  <link href="../css/animate.css" rel="stylesheet">
  <link href="../css/responsive.css" rel="stylesheet">
  <link href="../css/jquery.toast.css" rel="stylesheet">
  <link rel="shortcut icon" href="images/ico/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="../images/ico/apple-touch-icon-57-precomposed.png">
  <style type="text/css">
    .ocultar {
      display: none;
    }
  </style>
  <!--libreria  para el calendario-->
  <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="../js/jquery.js"></script>
  <script src="../js/jquery-ui.min.js"></script>
  <link href="../css/jqueryui.css" type="text/css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/jquery-ui.css">
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap.min.js"></script>
  <script src="../js/jquery.toast.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <!-- Datatable -->
  <script src="../data/librerias/calendario2/js/bootstrap-datepicker.min.js"></script>
  <script src="../data/librerias/calendario2/locales/bootstrap-datepicker.es.min.js"></script>
  <!--libreria  para busqueda-->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!--Funcion para script para el calendario-->
  <script type="text/javascript">
    $(function() {
      $('.input-daterange').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        orientation: "bottom auto",
        todayHighlight: true
      });
    })
  </script>
  <script>
    $(document).ready(function() {
      $('#bp').click(function() {
        var np = $('#nombreprod').val();
        if (np == '') {
          alert('Codigo de producto inexistente');
          $('#productocod').focus();
        };
      });
    });
  </script>
  <script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
  </script>
  <!-- Multiplicar -->
  <script type="text/javascript">
    function multiplicar() {     
      $.ajax({
        url: 'buscarproducto.php',
        type: 'POST',
        dataType: 'json',
        data: {
          "idproducto": $(document.getElementById("select2lista")).val(),
          "sucursal": $(document.getElementById("sucur")).val(),   
          "idproveedor" : $(document.getElementById("idproveedor")).val(),     
        }
      }).done(
        function(respuesta) {
          $("#idproducto").val(respuesta.idproducto);
          $("#nombreproducto").val(respuesta.nombreproducto);
          $("#punitario").val(respuesta.precio_compra);
          $("#pventa").val(respuesta.precio_venta);
          $("#um").val(respuesta.um);
          $("#proveedor_id").val(respuesta.proveedor_id);
        });
      $('#codigoproveedor').select2("enable", false);
      m1 = document.getElementById("cantidad").value;
      m2 = document.getElementById("punitario").value;
      r = m1 * m2;
      document.getElementById("subtotal").value = r;
    }
  </script>
  <script>
    function verificarinputfactura() {
      m1 = document.getElementById("nro_factura").value;
      m2 = document.getElementById("nro_autorizacion").value;
      m3 = document.getElementById("codigo_control").value;
      m4 = document.getElementById("nro_recibo").value;
      if(m2 && m1 && m3 ){
        $("#codigoproveedor").prop('disabled', false);
        $("#select2lista").prop('disabled', false);
        $("#cantidad").prop('disabled', false);
        $("#producto").prop('disabled', false);
      }
    }
  </script>
  <script>
    function verificarinputrecibo() {
      m4 = document.getElementById("nro_recibo").value;
      if(m4 ){
        $("#codigoproveedor").prop('disabled', false);
        $("#select2lista").prop('disabled', false);
        $("#cantidad").prop('disabled', false);
        $("#producto").prop('disabled', false);
      }
    }
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#codigoproveedor').val(1);
      recargarLista();
      $('#codigoproveedor').change(function() {
        recargarLista();
      });
    })
  </script>
  <script type="text/javascript">
    function recargarLista() {
      
      $.ajax({
        type: "POST",
        url: "prodproveedor.php",
        data: {"proveedor" : $('#codigoproveedor').val(),
          "sucursal":$('#sucur').val()}, 
        success: function(r) {
          $('#select2lista').html(r).fadeIn();
        }
      });
      $.ajax({
        url: 'proveedor.php',
        type: 'POST',
        dataType: 'json',
        data: {
          idproveedor: $(document.getElementById("codigoproveedor")).val(),
        }
      }).done(
        function(respuesta) {
          $("#idproveedor").val(respuesta.idproveedor);
          $("#codigoproveedor").val(respuesta.codigoproveedor);
          $("#nombreproveedor").val(respuesta.nombreproveedor);
          document.getElementById("nitpro").value = respuesta.nitproveedor;
        });
    }
  </script>
  <script language="javascript">
    function nro_factura() {
      $.post('nro_factura.php',
        function(valor) {
          $('#nro_factura').val(valor);
        });
      
    }
    function eliminar(id) {
      $.post('eliminar.php', {
          "nro": id
        },
        function() {
          listar();
        }
      );
    }
  </script>
  <!-- Datatable del detalle -->
  <script type="text/javascript">
    $(document).ready(function() {
      $('#usuario').DataTable({
        language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _MENU_ registros",
          sZeroRecords: "No se encontraron resultados",
          sEmptyTable: "Ningun dato disponible en esta tabla",
          sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
          sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
          sInfoPostFix: "",
          sSearch: "Buscar:",
          sUrl: "",
          sInfoThousands: ",",
          sLoadingRecords: "Cargando...",
          oPaginate: {
            sFirst: "Primero",
            sLast: "Ãšltimo",
            sNext: "Siguiente",
            sPrevious: "Anterior"
          },
          oAria: {
            sSortAscending: ": Activar para ordenar la columna de manera ascendente",
            sSortDescending: ": Activar para ordenar la columna de manera descendente"
          }
        }
      });
    });
  </script>  
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
        <h2>registro de nueva compra</h2>
        <div class="row">
          <div class="col-md-1">
            <label for="">Compra:</label>
            <input type="text" name="nro" id="nro" class="alert alert-success" value="<?php echo "$nro"; ?>" disabled>
            <input type="hidden" name="nro" id="nro" class="form-control" value="<?php echo "$nro"; ?>">
            <input type="hidden" name="codigo" id="codigo" class="form-control" value="<?php echo "$codigo"; ?>">
            <input type="hidden" name="sucur" id="sucur" class="form-control" value="<?php echo "$sucur"; ?>">
            <input type="hidden" name="idproveedor" id="idproveedor" class="form-control">
            <input type="hidden" name="idproducto" id="idproducto" class="form-control">
            <input type="hidden" name="usuarioid" id="usuarioid" class="form-control" value="<?php echo "$usuarioid"; ?>">
            <input type="hidden" name="idcompra" id="idcompra" class="form-control" value="<?php echo "$idcompra"; ?>">
            <input type="hidden" name="idinventario" id="idinventario" class="form-control" value="<?php echo "$idinventario"; ?>">
            <input type="hidden" name="nitpro" id="nitpro" class="form-control">
          </div>
          <div class="col-md-4">
            <label>Fecha:</label>
            <div class="alert alert-success">
              <?php echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') ?>
              <input type="hidden" name="fecha" id="fecha" class="form-control" value="<?php echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') ?>">
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <!--Nro de factura-->
          <div class=" col-md-1 form-check-inline">
            <label>Factura <strong style="color: red;">*</strong></label>
            <input class="form-check-input" name="facturavisible" id="facturavisible" type="checkbox" value="">
          </div>
          <div class="col-md-1 form-check-inline">
            <label>Recibo <strong style="color: red;">*</strong></label>
            <input class="form-check-input" type="checkbox" role="switch" id="recibovisible" type="checkbox" value="">
          </div>
          <!-- fecha de vencimiento -->
            <input type="hidden" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control input-sm" value="<?php echo $fecha_vencimiento;?>" required>
          <input type="hidden" name="emitefactura" id="emitefactura" class="form-control input-sm">
          <input type="hidden" name="emiterecibo" id="emiterecibo" class="form-control input-sm">
          <!-- Nrofactura -->
          <div class="col-md-3" style="display:none" id="mostrarfactura" >
            <label>Nro.Factura <span style="color: red;">*</span></label>
            <input type="number" name="nro_factura" id="nro_factura" class="form-control input-sm" min="0" placeholder="Nro.Factura" >
          </div>
          <!-- Nrorecibo -->
          <div class="col-md-3" style="display:none" id="mostrarrecibo">
            <label>Nro.Recibo <span style="color: red;">*</span></label>
            <input type="number" name="nro_recibo" id="nro_recibo" class="form-control input-sm" min="0" placeholder="Nro.Recibo"  required onkeypress="return validar(event)" value="" onChange="verificarinputrecibo();">
          </div>
          <!-- Nro de autorizacion -->
          <div class="col-md-3" style="display: none" id="mostrarnroautorizacion">
            <label>Nro.Autorización <span style="color: red;">*</span></label>
            <input type="number" name="nro_autorizacion" id="nro_autorizacion" class="form-control input-sm" min="0" placeholder="Nro.Autorizacion" required>
          </div>
          <!-- Cod control -->
          <div class="col-md-3" style="display: none" id="mostrarcodigocontrol">
            <label>Cod.Control <span style="color: red;">*</span></label>
            <input type="text" name="codigo_control" id="codigo_control" class="form-control input-sm" min="0" placeholder="Cod.Control"  required onkeypress="return validar(event)" value="" onChange="verificarinputfactura();">
          </div>
        </div><br>
        <!-- 1ra Fila -->
        <div class="row">
          <div class="col-md-3">
            <div class="input-group">
              <label>Proveedor <span style="color: red;">*</span> </label>
              <select class="js-example-basic-multiple" id="codigoproveedor" name="codigoproveedor" >
                <?php foreach ($proveedores as $f) { ?>
                  <option value="<?php echo $f["idproveedor"] ?>"><?php echo $f["nombre"]; ?><?php echo $f["empreza"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <script>
            $("#codigoproveedor").select2();
          </script>
          <div class="col-md-3">
            <div>
            <label>Producto <span style="color: red;">*</span></label>
            <select class="js-example-basic-multiple" id="select2lista"   onkeypress="return validar(event)" value="" onChange="multiplicar();">
          </select>
            </div>
          </div>
          <script>
            $("#lista2").select2();
          </script>
          <!-- Precio -->
          <div class="col-md-1">
            <label>Precio </label>
            <input type="number" step="0.001" name="punitario" id="punitario" placeholder="Bs." class="preciosubtotal form-control input-sm" disabled>
          </div>
          <!-- Unidad de medida -->
          <input type="hidden" step="0.001" name="um" id="um" class="preciosubtotal input-sm" value="" disabled>
          <!-- Cantidad -->
          <div class="col-md-2">
            <label>Cantidad <span style="color: red;">*</span></label>
            <input type="number" step="0.001" name="cantidad" id="cantidad" placeholder="Ingrese cantidad" class="form-control input-sm" onkeypress="return validar(event)" value="" onChange="multiplicar();">
          </div>
          <!-- Subtotal -->
          <div class="col-md-2">
            <label>Subtotal</label>
            <input type="number" step="0.001" name="subtotal" id="subtotal" placeholder="Bs." class="preciosubtotal form-control input-sm" value="" disabled>
          </div>
          <div class="col-md-1">
            <label>&nbsp</label>
            <input class="btn btn-danger btn-sm" type="button" id="add" value="Agregar" >
          </div>
      
        </div><br>
    </div>
    <div cellspacing="0" width="100%">
      <table class="table table-bordered" id="tblproducto" cellspacing="0" width="100%">
        <div class="col-md-10">
        </div>
        <thead>
          <tr>
            <th>Codigo</th>
            <th>Producto</th>
            <th>Unidad de medida</th>
            <th>Costo unitario</th>
            <th>Cantidad</th>
            <th>Sub total</th>
            <th>Quitar</th>
          </tr>
        </thead>
        <tbody>
            <th> Total a cancelar</th>
            <th> </th>
            <th> </th>
            <th></th>
            <th> </th>
            <th> Bs. 0.00</th>
            <th> </th>
        </tbody>
        <tfoot align="right">
          <tr colspan="6">
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    </div>
    <tr>
    </tr>
    <div class="form-group">
      <table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
        <tr>
          <div class="row">
            <!-- Descripcion -->
            <div class="col-md-5" style="float:none;margin:auto;">
              <label>Glosa: </label>
              <input type="text" class="form-control input-sm" id="producto" placeholder="Opcional" value="Sin glosa" />
            </div>
          </div>
          <td> <button type="submit" id="aceptar" class="btn btn-primary">Aceptar</button></td>
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
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("form").keypress(function(e) {
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
    $(document).ready(function() {
      $("#codigoproveedor").prop('disabled', true);
      $("#select2lista").prop('disabled', true);
      $("#cantidad").prop('disabled', true);
      $("#producto").prop('disabled', true);
      $("#facturavisible").click(function() {         
        if ($(this).is(":checked")) {
          $("#mostrarfactura").show();
          $("#mostrarrecibo").hide();
          $("#mostrarnroautorizacion").show();
          $("#mostrarcodigocontrol").show();
          document.getElementById("emitefactura").value = "Si";
          $('#emiterecibo').val("No");          
        } else if ($(this).is(":not(:checked)")) {
          $("#mostrarfactura").hide();
          $("#mostrarnroautorizacion").hide();
          $("#mostrarcodigocontrol").hide();
          document.getElementById("emitefactura").value = "No";
        }
      });
      $("#recibovisible").click(function() {
        if ($(this).is(":checked")) {
          $("#mostrarrecibo").show();
          $("#mostrarfactura").hide();
          $('#emiterecibo').val("Si");
          document.getElementById("emitefactura").value = "No";
        } else if ($(this).is(":not(:checked)")) {
          $("#mostrarrecibo").hide();
          document.getElementById("#emiterecibo").value = "No";
        }
      });
    });
  </script>
  <script>
    var tblproducto;
    var producto_list = {
      items: {
        producto: [],
        glosa:[],
      },
      add: function(item) {
        this.items.producto.push(item);
        this.list();
      },
      addglosa: function (glos){
        this.items.glosa.push(glos);
        this.list();
      },
      list: function() {
        np = $("#lista2").val();
        valor = $("#cantidad").val();
        valor2 = $("#punitario").val();
        valor3 = $("#pventa").val();
        if (np == '') {
          alert("codigo de producto inexistente");
          $("#codigoproducto").focus();
          return false;
        } else if (valor == null || isNaN(valor) || /^s+$/.test(valor) || valor == 0) {
          alert("ingrese cantidad valida");
          $("#cantidad").focus();
          return false;
        } else if (valor2 == null || isNaN(valor2) || /^s+$/.test(valor2) || valor2 == 0) {
          alert("Precione en buscar para insertar precio");
          $("#punitario").focus();
          return false;
        }
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
              "data": "nombre2"
            },
            {
              "data": "unidad"
            },
            {
              "data": "costounitario"
            },
            {
              "data": "cantidad"
            },
            {
              "data": "subtotal"
            },
          ],
          columnDefs: [
            {
              targets: [0], 
              class: "text-center",
              orderable: false,
            },
            {
              targets: [1], 
              class: "text-center",
              orderable: false,
            },
            {
              targets: [2], 
              class: "text-center",
              orderable: false,
            },
            {
              targets: [3], 
              class: "text-center",
              orderable: false,
            },
            {
              targets: [4], 
              class: "text-center",
              orderable: false,
            },
            {
              targets: [5], 
              class: "text-center",
              orderable: false,
            },
            
            {
            targets: [6],
            class: "text-center",
            orderable: false,
            render: function() {
              return '<a rel="remove" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> </a>';
            }
          }, ],
          footerCallback: function(tfoot, data, start, end, display) {
            var api = this.api();
            $(api.column(5).footer()).html(
              "Total: " + api.column(5).data().reduce(function(a, b) {
                var x = parseFloat(a) || 0;
                var y = parseFloat(b) || 0;
                x.toFixed(2);
                y.toFixed(2);
                r = (x + y).toFixed(2);
                return r + ' Bs.';
              }, 0)
            );
          }
        })
      },
    };
    $('#tblproducto tbody')
      .on('click', 'a[rel="remove"]', function() {
        var tr = tblproducto.cell($(this).closest('td', 'li')).index();
        producto_list.items.producto.splice(tr.row, 1);
        producto_list.list();
      })
    /*Enter para agregar el producto*/
    document.getElementById("add").addEventListener("keypress", function(e) {
      var keycode = e.keyCode || e.which;
      if (keycode == 13) {
        Input_Tarea();
      }
    });
    /*Click para agregar el producto*/
    document.getElementById("add").addEventListener("click", function() {
      Input_Tarea();
    });
    function Input_Tarea() {
      if ($('#cantidad').val() == 0) {
        alert('Debe llenar todos los datos');
      } else {
        var producto = document.getElementById('producto');
        var item = {
          "nombre": "",
          "nro": "",
          "nombre2": "",
          "costounitario": "",
          "cantidad": "",
          "subtotal": "",
          "estado": "",
          "codigo": "",
          "sucursal": "",
          "precioventa": "",
          "fecha": "",
          "total": "",
          "usuarioid": "",
          "proveedorid": "",
          "compraid": "",
          "inventarioid": "",
          "unidad": "",
          "sumatotal": "",
          "emitefactura": "",
          "emiterecibo": "",
          "numerofactura": "",
          "numerorecibo": "",
          "fecha_vencimiento": "",
          "nroautorizacion": "",
          "codigocontrol": "",
          "nitproveedor": "",
        };
        item.nombre = $('#idproducto').val();
        item.nro = $('#nro').val();
        item.nombre2 = $('#select2lista').find(':selected').html();
        item.unidad = $('#um').val();
        item.costounitario = $('#punitario').val() + ' Bs.';
        item.cantidad = $('#cantidad').val();
        item.subtotal = ($('#punitario').val() * $('#cantidad').val()).toFixed(2) + ' Bs.';
        item.estado = "activo";
        item.codigo = $('#codigo').val();
        item.sucursal = $('#sucur').val();
        item.precioventa = $('#pventa').val();
        item.fecha = $('#fecha').val();
        item.total = $('#pventa').val();
        item.usuarioid = $('#usuarioid').val();
        item.proveedorid = $('#idproveedor').val();
        item.compraid = $('#idcompra').val();
        item.inventarioid = $('#idinventario').val();
        item.emitefactura = $('#emitefactura').val();
        item.emiterecibo = $('#emiterecibo').val();
        item.fecha_vencimiento = $('#fecha_vencimiento').val();
        item.nrofactura = $('#nro_factura').val();
        item.nrorecibo = $('#nro_recibo').val();
        item.codigocontrol = $('#codigo_control').val();
        item.nroautorizacion = $('#nro_autorizacion').val();
        item.nitproveedor = document.getElementById("nitpro").value;
        producto_list.add(item);
        localStorage.setItem("productos", JSON.stringify(producto_list));
        producto.value = "";
      }
    }
  </script>
  <script>
    $("#aceptar").click(function(e) { 
      producto_list.addglosa($('#producto').val());
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
        success: function(response) {
          if (response.estado == 'true') {
            $.toast({
                heading: 'Registro correcto',
                text: 'El registro de la compra se ha realizado de manera correcta',
                position: 'bottom-right',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1500,
                afterHidden: function () {
                  window.location.href = 'nuevo.php';
                } 
            })
          } else
          if (response.estado == 'false') {           
            $.toast({
                heading: 'Error',
                text: 'Porfavor verifique los datos ingresados',
                position: 'bottom-right',
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 1500,
                afterHidden: function () {
                  window.location.href = 'nuevo.php';
                }
            })
          }
        }
      });
    });
  </script>
  <script>
  </script>
  <style>
    .preciosubtotal {
      border: 0;
      margin-right: 10;
    }
    .select2producto{
      background-color: whitesmoke;
    }
  </style>
</body>
</html>