<?php include "../menu/menu.php";
date_default_timezone_set('America/La_Paz');
$usuario = $_SESSION['usuario'];
$ss = implode(" ", $_SESSION['usuario']);
/* print $ss; */
$sucur = $usuario['sucursal_id'];
$sucursal = $db->GetAll("
select * 
from sucursal 
where idsucursal between '2' and '16' ");


?>

<html>

<head>
  <title>Entradas y Salidas</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
</head>

<body class="body">
  <?php
  if (isset($_POST['form_sent']) && $_POST['form_sent'] == "true") {
    $sucursal_id = $_POST["sucursal_id"];
    $fecha_inicial = $_POST["fechainicial"];
    $fecha_final = $_POST["fechafinal"];
    if ($sucursal_id == 20) {
      $query = $db->query("
      select   r.id,u.nombre nombre_usuario, u.cargo nombre_cargo,u.horario hora_ingreso,s.nombre nombre_sucursal,r.fecha,r.hora_entrada , hora_salida 
      from registro_ingreso r, usuario u,sucursal s
      where u.codigo_usuario=r.usuario_id and r.sucursal_id=s.idsucursal and r.fecha between '$fecha_inicial' and '$fecha_final'
    ");
    } else {
      $query = $db->query("
        select r.id,u.nombre nombre_usuario, u.cargo nombre_cargo,u.horario hora_ingreso,s.nombre nombre_sucursal,r.fecha,r.hora_entrada , r.hora_salida 
        from registro_ingreso r, usuario u,sucursal s
        where u.codigo_usuario=r.usuario_id and r.sucursal_id=s.idsucursal and r.sucursal_id=$sucursal_id and r.fecha between '$fecha_inicial' and '$fecha_final'
      ");
    }
  } else {
    $query = $db->query("
      select   r.id,u.nombre nombre_usuario, u.cargo nombre_cargo,u.horario hora_ingreso,s.nombre nombre_sucursal,r.fecha,r.hora_entrada , hora_salida 
      from registro_ingreso r, usuario u,sucursal s
      where u.codigo_usuario=r.usuario_id and r.sucursal_id=s.idsucursal 
    ");
  }

  ?>

  <div class="container">
    <div class="left-sidebar">
      <h2>Control Asistencia de Colaboradores</h2>
      <div class="table-responsive">
        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap.min.js"></script>
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

        <script src="../data/librerias/calendario2/js/bootstrap-datepicker.min.js"></script>
        <script src="../data/librerias/calendario2/locales/bootstrap-datepicker.es.min.js"></script>
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
        <form method="post" action="">
          <div class="row">
            <div class="col-md-3">
              <div class="input-group">
                <label>Filtrar por Sucursal:</label>
                <select name="sucursal_id" id="sucursal_id" class="form-control">
                  <option value="">Seleccione una Sucursal</option>
                  <?php foreach ($sucursal as $r) { ?>
                    <option value="<?php echo $r["idsucursal"] ?>"><?php echo $r["nombre"]; ?></option>
                  <?php } ?>
                  <option value="20">TODAS LAS SUCURSALES</option>
                </select>
              </div>
            </div>
          </div>

          <br>
          <div class="row">
            <div class="col-md-6">
              <div class="input-daterange input-group" id="datepicker">
                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                <input type="text" id="fechainicial" class="input-sm form-control" name="fechainicial" />
                <span class="input-group-addon">A</span>
                <input type="text" id="fechafinal" class="input-sm form-control" name="fechafinal" />
                <input type="hidden" id="form_sent" name="form_sent" value="true">
              </div>
            </div>
            <div class="col-md-2">
              <input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
            </div>
          </div>
        </form>
        <br>
        <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Cargo</th>
              <th>Usuario</th>
              <th>Horario</th>
              <th>Sucursal</th>
              <th>Fecha</th>
              <th>Hora Entrada</th>
              <th>Hora Salida</th>
              <th>Horas Trabajadas</th>
              <th>Total a Pagar</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $total_a_pagar_por_dia = 0;
            foreach ($query as $r) {
            ?>
              <tr class=warning>
                <td><?php echo $r["id"]; ?></td>
                <td><?php echo $r["nombre_cargo"]; ?></td>
                <td><?php echo $r["nombre_usuario"]; ?></td>
                <td><?php echo $r["hora_ingreso"]; ?></td>
                <td><?php echo $r["nombre_sucursal"]; ?></td>
                <td><?php echo $r["fecha"]; ?></td>
                <td><?php echo $r["hora_entrada"]; ?></td>
                <td><?php echo $r["hora_salida"];
                    $format = 'H:i:s';
                    $date = DateTime::createFromFormat($format, $r["hora_entrada"])->format('H:i:s');
                    $date2 = DateTime::createFromFormat($format, $r["hora_salida"])->format('H:i:s');

                    $horaInicio = new DateTime($date);
                    $horaTermino = new DateTime($date2);
                    $horasTrabajadas =  $horaTermino->diff($horaInicio);

                    ?></td>
                <td><?php
                    $newdate = DateTime::createFromFormat($format, "00:00:00")->format('H:i:s');
                    if ($r["hora_salida"] != $newdate) {

                      $costo_por_hora = 8;
                      /* echo $horasTrabajadas->format('H:i:s'); */
                      $Formateado = $horasTrabajadas->format('%H:%i:%s');
                      /* echo  $Formateado; */
                      echo  $horasTrabajadas->format('%H horas %i minutos %s segundos');
                      list($hora, $min, $seg) = explode(":", $Formateado);
                      $resultado = $hora + $min / 60 + $seg / 3600;
                      /*  echo "</br>" . number_format($resultado, 3) . " solo horas" */
                      /*  if($contador<sizeof($arrayHoraSalida)){
                    echo $arrayHoraSalida[$contador]; 
                  } else{
                    echo "";
                  } */
                    }
                    ?></td>
                <td><?php
                    $newdate = DateTime::createFromFormat($format, "00:00:00")->format('H:i:s');
                    if ($r["hora_salida"] != $newdate) {
                      $total_a_pagar = $resultado * $costo_por_hora;
                      $total_a_pagar_por_dia += $total_a_pagar;
                      echo number_format($total_a_pagar, 2) . " Bs";
                    }
                    ?>
                </td>
              </tr>
            <?php  }

            ?>
        </table>

      </div>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <tr>
          <td>
            <h4>Total a Pagar :</h4>
          </td>
          <td>
            <h4> <?php echo number_format($total_a_pagar_por_dia, 4) . " bs"; ?></h4>
          </td>
        </tr>
      </table>


    </div>
  </div> <!-- Start WOWSlider.com BODY section -->

</body>

</html>