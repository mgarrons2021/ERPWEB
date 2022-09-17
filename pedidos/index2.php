<html>

<head>
  <title>Pedidos</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
</head>

<body class="body">
  <?php
  require_once '../config/conexion.inc.php';
  session_start();
  $usuario = $_SESSION['usuario'];
  $sucur = $usuario['sucursal_id'];
  $ids = $_GET["id"];
  if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
    $ids = $_GET["ids"];
    $min = $_GET["fechaini"];
    $max = $_GET["fechamax"];
    if ($_GET['fecha'] == 1) {
      $ventas = $db->GetAll("select t.*, u.nombre as usuario,s.nombre as sucursal, t.sucursal_id
from pedido t,usuario u, sucursal s
where t.sucursal_id=$ids and t.usuario_id=u.idusuario and t.sucursal_id=s.idsucursal and t.Fecha_p between '$min' and '$max' ORDER BY t.idpedido DESC");
    } else {
      $ventas = $db->GetAll("select t.*, u.nombre as usuario,s.nombre as sucursal, t.sucursal_id
from pedido t,usuario u, sucursal s
where t.sucursal_id=$ids and t.usuario_id=u.idusuario and t.sucursal_id=s.idsucursal and t.Fecha_e between '$min' and '$max' ORDER BY t.idpedido DESC");
    }
  } else {
    $date = date("Y-m-d", strtotime(date('Y-m-d') . "- 2 days"));
    $date1 = date('Y-m-d');
    $ventas = $db->GetAll("select t.*, u.nombre as usuario,s.nombre as sucursal, t.sucursal_id
from pedido t,usuario u, sucursal s
where t.sucursal_id=$ids and t.usuario_id=u.idusuario and t.sucursal_id=s.idsucursal and t.Fecha_p between '$date' and '$date1' ORDER BY t.idpedido DESC");
  }
  $query = $ventas;
  ?>
  <div class="container">
    <div class="left-sidebar">
      <h2>Lista de Pedidos</h2>
      <!-- aqui es el bonton de atras -->
      <a class="glyphicon glyphicon-arrow-left" href="env_dir.php">ATRAS</a>

      <!-- termina el boton de atraz -->

      <div class="table-responsive">
        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap.min.js"></script>
        <script src="../data/librerias/calendario2/js/bootstrap-datepicker.min.js"></script>
        <script src="../data/librerias/calendario2/locales/bootstrap-datepicker.es.min.js"></script>
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
        <script type="text/javascript">
          $(document).ready(function() {
            $("#usuario").DataTable({
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
            })
          });
        </script>
        <form action="">
          <div class="row">
            <div class="col-md-7">
              <div class="input-daterange input-group" id="datepicker">
                <select class="form-control select-md" name="fecha" id="fecha" value="1">
                  <option value="1">Por fecha solicitada</option>
                  <option value="2">Por fecha de envio</option>
                </select>
                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" />
                <span class="input-group-addon">A</span>
                <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" />
                <input type="hidden" id="form_sent" name="form_sent" value="true">
                <input type="hidden" id="ids" name="ids" value="<?php echo $ids; ?>">
              </div>
            </div>
            <div class="col-md-2">
              <input class="form-control btn-success" type="submit" value="filtrar" id="filtrar" name="filtrar">
            </div>
          </div>
        </form>

        <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="1" style="width:350px">
          <thead>
            <tr>
              <!-- <th>Hora</th>-->
              <th>Cod</th>
              <th>Fecha Ped</th>
              <th>Sucursal</th>
              <th>Pedido</th>
              <th>Opc</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $c = 0;
            $total = 0;
            $total2 = 0;
            $total_envio = 0;
            $total_envio2 = 0;
            foreach ($query as $r) {
              $c = $c + 1; ?>
              <tr class=warning>
                <!--<td><? php // echo $r["hora_solicitud"]; 
                        ?></td>-->
                <td><?php echo $r["nro"] . "-" . $r["sucursal_id"]; ?></td>
                <td><?php echo $r["fecha_p"]; ?></td>
                <td><?php echo $r["sucursal"]; ?></td>
                <td><?php if ($r["total"] > 0) {
                      echo "INSUM ";
                    }
                    if ($r["total2"] > 0) {
                      echo " PRODUC";
                    } ?></td>
                <td style="width:100px;">
                  <a href="detalle2.php?id=<?php echo $r["nro"]; ?>&sucursalid=<?php echo $r["sucursal_id"]; ?>&idped=<?php echo $r["idpedido"]; ?>"><img src="../images/ver.png" alt="" title="Modificar">Ver Detalle</a>
                  <?php // echo "<a class='' href='#?nro=$r[nro]' target='_blank' role='button'><img src='../images/pdf.png' alt=''>PDF</a>";
                  ?>
                  <?php if ($r["estado"] == 'si') { ?>
                    <a href="./estado.php?idpedido=<?php echo $r["idpedido"]; ?>" onclick="return confirm('&iquest;Esta Seguro de negar los envios?')">
                      <img src="" alt="" title="ACEPTADO">
                      <p style="color:#008f39"> Aceptado </p>
                    </a>
                    <?php  } else {
                    if ($r["estado"] == 'no') { ?>
                      <a href="">
                        <img src="" alt="" title="PENDIENTE">
                        <p style="color:#FF0000"> Pendiente </p>
                      </a>
                    <?php } else {
                      if ($r["estado"] == 'ok') ?>
                      <a href="./estado.php?idpedido=<?php echo $r["idpedido"]; ?> " onclick="return confirm('&iquest;Esta Seguro de forzar el envio ?')">
                        <img src="" alt="" title="ENVIADO">
                        <p style="color:#ff8000"> Enviado </p>
                      </a>
                  <?php }
                  } ?>

                </td>
              </tr>
              <div class="modal fade" id="ver<?php echo $r["nro"]; ?>" data-backdrop="static" data-keyboard="false" draggable="modal-header" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Detalle Pedidos <?php echo $r["nro"]; ?></h4>
                    </div>
                    <div class="modal-body">
                      <div class="row panel panel-primary">
                        <div class="col-md-2">
                          codigo
                        </div>
                        <div class="col-md-3">
                          producto
                        </div>
                        <div class="col-md-2">
                          cantidad
                        </div>
                        <div class="col-md-2">
                          precio
                        </div>
                        <div class="col-md-2">
                          subtotal
                        </div>
                      </div>
                      <?php
                      $consul = $db->GetAll("
select p.idproducto, p.codigo_producto,p.nombre,dt.cantidad,p.precio_compra,dt.subtotal
from detallepedido dt,producto p 
where dt.nro = $r[nro] and p.idproducto = dt.producto_id ");
                      foreach ($consul as $key) { ?>
                        <div class="row">
                          <div class="col-md-2" id="pedido">
                            <?php echo $key["codigo_producto"]; ?>
                          </div>
                          <div class="col-md-3">
                            <?php echo $key["nombre"]; ?>
                          </div>
                          <div class="col-md-2">
                            <input type="text" name="c" id="c" class="form-control" value="<?php echo $key["cantidad"]; ?>" onChange="multiplicar();">
                          </div>
                          <div class="col-md-2">
                            <input type="text" name="p" id="p" class="form-control" value="<?php echo $key["precio_compra"]; ?>" disabled>
                          </div>
                          <div class="col-md-2">
                            <input type="text" name="s" id="s" class="form-control" value="<?php echo $key["subtotal"]; ?>" disabled>
                          </div>
                        </div>
                      <?php } ?>
                      <br>
                      <div class="row panel panel-primary">
                        <div class="col-md-9">TOTAL</div>
                        <div class="col-md-2">
                          <?php echo $r["total"]; ?>
                        </div>
                      </div>
                    </div>
                    <div class=""></div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal"></button>
                      <button type="button" class="btn btn-primary" data-dismiss="modal">Enviar</button>
                    </div>
                  </div>
                </div>
              </div>
            <?php $total = $total + $r["total"];
              $total2 = $total2 + $r["total2"];
              $total_envio = $total_envio + $r["total_envio"];
              $total_envio2 = $total_envio2 + $r["total_envio2"];
            } ?>
        </table>

      </div>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
    </div>
  </div> <!-- Start WOWSlider.com BODY section -->
  <!-- End WOWSlider.com 
  BODY section -->
</body>

</html>
<script type="text/javascript">
  $("#filtrar").on("click", function() {
    fechainicio = document.getElementById("fechaini").value;
    fechamax = document.getElementById("fechamax").value;

    console.log("esta es la fecha:" + fechainicio + " y la fecha max:" + fechamax);

  });
</script>