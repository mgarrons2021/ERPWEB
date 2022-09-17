<?php include "../menu/menu.php";
date_default_timezone_set('America/La_Paz');


$usuario = $_SESSION['usuario'];
$sucur = $usuario['sucursal_id'];

//Saca la ultima venta realizada
$nro = $db->GetOne("select max(nro)+1 from  compra where sucursal_id='$sucur'");
//echo"este es la sucursal mas 1:".$nro;
//$nro = $db->GetOne('SELECT max(nro)+1 FROM compra');
if ($nro == '') {
  $nro = 0;
  $nro++;
}
$dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$ventas = $db->GetAll("select * from proveedor where estado = 'activo'");
$query = $ventas;
$productos = $db->GetAll("select * from producto  where estado = 'activo' ORDER BY nombre ASC");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Registro Compra</title>
  <link rel="stylesheet" href="../css/estiloyanbal.css">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/font-awesome.min.css" rel="stylesheet">
  <link href="../css/prettyPhoto.css" rel="stylesheet">
  <link href="../css/price-range.css" rel="stylesheet">
  <link href="../css/animate.css" rel="stylesheet">
  <link href="../css/main.css" rel="stylesheet">
  <link href="../css/responsive.css" rel="stylesheet">
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

  <script src="../data/librerias/calendario2/js/bootstrap-datepicker.min.js"></script>
  <script src="../data/librerias/calendario2/locales/bootstrap-datepicker.es.min.js"></script>
    <!--libreria  para busqueda-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!--Funcion para script para el calendario-->
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
      $("#enviarproduc").click(function() {
        $.ajax({
          url: 'proveedor.php',
          type: 'POST',
          dataType: 'json',
          data: {
            idproducto: $(document.getElementById("codigoproveedor")).val()
          }
        }).done(
          function(respuesta) {
          $("#idproveedor").val(respuesta.idproveedor);
          $("#codigoproveedor").val(respuesta.codigoproveedor);
          $("#nombreproveedor").val(respuesta.nombreproveedor);
          });
      });
    });
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

  <!-- Buscar productos -->
  <script>
    $(document).ready(function() {
      $("#enviarproduc").click(function() {
        $.ajax({
          url: 'buscarproducto.php',
          type: 'POST',
          dataType: 'json',
          data: {
            idproducto: $(document.getElementById("idprod")).val()
          }
        }).done(
          function(respuesta) {
            $("#idproducto").val(respuesta.idproducto);
            //$("#nombreproducto").val(respuesta.nombreproducto);
            $("#punitario").val(respuesta.precio_compra);
            $("#um").val(respuesta.um);
          });
      });
    });
  </script>


  <!-- Multiplicar -->
  <script>
    function multiplicar() {
      m1 = document.getElementById("cantidad").value;
      m2 = document.getElementById("punitario").value;
      r = m1 * m2;
      document.getElementById("subtotal").value = r;
    }
  </script>

  <!--No se ocupa -->
  <script>
    $(document).ready(function() {
      $("#reg").click(function() {
        var ci = $("#ci").val();
        var n = $("#name").val();
        var ap = $("#ap").val();
        var t = $("#telf").val();
        $.post("ajax.php", {
          ci: ci,
          name: n,
          ap: ap,
          telf: t
        }, function(datos) {
          $("#resultado").html(datos);
          document.getElementById('ci').value = '';
          document.getElementById('name').value = '';
          document.getElementById('ap').value = '';
          document.getElementById('telf').value = '';
          document.getElementById('ci').focus();
        });
      });
    });
  </script>
  <script type="text/javascript">
	$(document).ready(function(){
		$('#codigoproveedor').val(1);
		recargarLista();

		$('#codigoproveedor').change(function(){
			recargarLista();
		});
	})
</script>
<script type="text/javascript">
	function recargarLista(){
		$.ajax({
			type:"POST",
			url:"prodproveedor.php",
			data:"proveedor=" + $('#codigoproveedor').val(),
			success:function(r){
				$('#select2lista').html(r);
			}
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

    function listar() {
      $('#listado').load('listar.php', {
        "nro": $('#nro').val()
      });
    }

    //verificar datos vacios 
    function agregar() {
      np = $("#nombreproducto").val();
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
        alert("Precione en buscar para insetar precio");
        $("#punitario").focus();
        return false;
      }
      alertify.set('notifier', 'position', 'bottom-right');
      // Registrar la compra
      alertify.success('Producto Agregado Exitosamente');
      $('#listado').load('registrarVenta.php', 
      {
        "idproducto":   $('#idproducto').val(),
        "idproveedor":  $('#idproveedor').val(),
        "cantidad":     $('#cantidad').val(),
        "pventa":       $('#pventa').val(),
        "punitario":    $('#punitario').val(),
        "fechaentrega": $('#fechaentrega').val(),
        "nro": $('#nro').val()
      });
      return true;
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

  <!-- Dattable del detalle -->
  <script type="text/javascript">
    $(document).ready(function() {
      $('#usuario').DataTable({
        "language": {
          "sProcessing": "Procesando...",
          "sLengthMenu": "Mostrar _MENU_ registros",
          "sZeroRecords": "No se encontraron resultados",
          "sEmptyTable": "Ningun dato disponible en esta tabla",
          "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix": "",
          "sSearch": "Buscar:",
          "sUrl": "",
          "sInfoThousands": ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Ãšltimo",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
          },
          "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }
        }
      });


    });
  </script>

  <style type="text/css">
    option.one {
      background-color: #FF7400;
      font: 20px "Comic Sans MS", cursive;
      font-weight: bold;
    }
  </style>
</head>
<!--/head-->

<body onLoad="listar();">
  <div class="container">
    <div class="left-sidebar">
      <h2>registro de nueva compra</h2>
      <div class="">
        <form method="post" action="agregar.php">
          <div class="row">
            <div class="col-md-1">
              <label for="">Compra:</label>
              <input type="text" name="nro" id="nro" class="alert alert-success" value="<?php echo "$nro"; ?>" disabled>
              <input type="hidden" name="nro" id="nro" class="form-control" value="<?php echo "$nro"; ?>">
              <input type="hidden" name="idproveedor" id="idproveedor" class="form-control">
              <input type="hidden" name="idproducto" id="idproducto" class="form-control">
            </div>

            <!-- fecha de la compra que se muesta en  -->
            <div class="col-md-4">
              <label>Fecha:</label>
              <div class="alert alert-success">
                <?php echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') ?>
              </div>
            </div>
          </div>

          <br>
          <!-- 1er Fila -->
          <div class="row">
            <!-- Empresa -->
            <div class="col-md-3">
              <div class="input-group">
            <label>Selecione Empresa (proveedor)</label>
			      <select class="form-control" id="codigoproveedor" name="codigoproveedor">
            <?php foreach ($query as $r) {

                      ?>
                        <option value="<?php echo $r["idproveedor"] ?>"><?php echo $r["nombre"]; ?><?php echo $r["empreza"]; ?></option>
                  <?php 
                    }
                   ?>
			      </select>
      </div>
            </div>
          </div><br>
          <!-- 2da Fila -->
          <div class="row">  
      <script>
      $("#codigoproveedor").select2();
               </script>

                <!-- Producto -->
               <div class="col-md-3">
              <div class="input-group">
            <div id="select2lista"></div>
            </div>
            </div>
            <script>
                 $("#lista2").select2();
               </script>
            <!-- Precio -->
            <div class="col-md-2">
              <label>Precio de Compra: <span style="color: red;">*</span></label>
              <div class="input-group">
                <input type="number" step="0.001" name="punitario" id="punitario" placeholder="Bs." class="form-control" onkeypress="return validar(event)" value="" onChange="multiplicar();" >
                <span class="input-group-btn">
                  <a data-toggle="modal" href="#">
                    <button class="btn btn-default" type="button" id="enviarproduc"><span class="glyphicon glyphicon-search"></span></button>
                  </a>
                </span>
              </div>
            </div>

            <!-- Unidad de medida -->
            <div class="col-md-1">
              <label>U.M:</label>
              <input type="text" step="0.001" name="um" id="um" class="form-control" value="" disabled>
            </div>

            <!-- Cantidad -->
            <div class="col-md-2">
              <label>Cantidad: <span style="color: red;">*</span></label>
              <input type="number" step="0.001" name="cantidad" id="cantidad" class="form-control" onkeypress="return validar(event)" value="" onChange="multiplicar();">
            </div>

            <!-- Signo = -->
            <div class="col-md-1">
              <label for="">.</label>
              <button type="button" class="form-control" value="" onclik="multiplicar()">=</button>
            </div>

            <!-- Subtotal -->
            <div class="col-md-2">
              <label>Subtotal:</label>
              <input type="number" step="0.001" name="subtotal" id="subtotal" placeholder="Bs." class="form-control" value="" disabled>
            </div>

            <!-- boton agregar al carrito de compras-->
            <div class="col-md-1">
              <label>.</label>
              <input class="form-control " type="button" value="Agregar" onClick="agregar();">
            </div>
          </div> <br>


          <br>
          </script>
          <div class="row">
            <div id="listado"></div>
          </div>
      </div>
      <div class="row">
        <div class="form-group">
          <table width="201" border="0" cellspacing="1" cellpadding="4" align="center">
            <tr>
              <td> <button type="submit" id="btn" class="btn btn-primary">Aceptar</button></td>
              <td> <button type="reset" class="btn btn-primary">limpiar</button></td>
            </tr>
          </table>
        </div>
      </div>
      </form>
      <br><br><br>
      <br><br><br>
      <br><br><br>

      <!--tablas modales-->

    </div>



    <footer id="footer">
  </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <center>
          <p class="pull-center">Copyright © SISTEMA DONESCO.</p>
        </center>
      </div>
    </div>
  </div>
  </footer>
  </div>
  </div>
  </div>



</body>

</html>