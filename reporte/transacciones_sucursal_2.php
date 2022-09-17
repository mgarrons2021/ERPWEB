<html>

<head>
  <title>transacciones por sucursal</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <script src="../js/jquery.js"></script>
  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
  <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
  <style>
    td {
      font-size: 13px;
      height: 8px;
      width: 150px;
    }
  </style>
</head>

<body class="body">
  <?php include "../menu/menu.php";
  $usuario = $_SESSION['usuario'];
  $sucur = $usuario['sucursal_id'];

  $resultado_sucursal = $db->GetAll("SELECT * FROM sucursal");
  ?>
  <div class="container">
    <div class="left-sidebar">
      <h2>listado de transacciones por hora por sucursal</h2>
      <div class="table-responsive">
        <script src="../js/jquery.js"></script>
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
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap.min.js"></script>
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
        <form action="transacciones_sucursal_2.php" method="POST">
          <div class="row">
            <div class="col-md-6">
              <label>Sucursal:</label>
              <div class="input-group">
                <select name="sucursal" id="sucursal">
                  <?php foreach ($resultado_sucursal as $sucursal) { ?>
                    <option value="<?= $sucursal['idsucursal'] ?>"><?= $sucursal['nombre'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div> <br>
          <div class="row">
            <div class="col-md-6">
              <div class="input-daterange input-group" id="datepicker">
                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" />
                <span class="input-group-addon">A</span>
                <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" />
              </div>
            </div>
            <div class="col-md-2">
              <input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
            </div>
          </div>
        </form>
        <br>
        <?php if (isset($_POST['sucursal']) && isset($_POST['fechaini']) && isset($_POST['fechamax'])) {
          $sucursal_id = $_POST['sucursal'];
          $min = $_POST["fechaini"];
          $max = $_POST["fechamax"];
          $hora_1 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '08:00:00' AND '08:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_2 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '09:00:00' AND '09:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_3 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '10:00:00' AND '10:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_4 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '11:00:00' AND '11:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_5 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '12:00:00' AND '12:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_6 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '13:00:00' AND '13:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_7 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '14:00:00' AND '14:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_8 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '15:00:00' AND '15:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_9 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '16:00:00' AND '16:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_10 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max'  
                                AND v.hora BETWEEN '17:00:00' AND '17:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_11 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '18:00:00' AND '18:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_12 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '19:00:00' AND '19:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_13 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '20:00:00' AND '20:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_14 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '21:00:00' AND '21:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_15 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '22:00:00' AND '22:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");
          $hora_16 = $db->GetAll("SELECT  count(nro) as TT,  sum(total) as Total, s.nombre AS Sucursal FROM venta v INNER JOIN sucursal s ON s.idsucursal = v.sucursal_id WHERE estado = 'V' 
                                AND v.fecha BETWEEN '$min' AND '$max' 
                                AND v.hora BETWEEN '23:00:00' AND '23:59:59'
                                AND v.pago != 'comida_personal' AND v.sucursal_id = '$sucursal_id'");

          $tam = $db->GetAll("SELECT COUNT(nro) as TT, sum(total) as Total FROM venta WHERE estado = 'V'  
                            AND fecha BETWEEN'$min' AND '$max'
                            AND hora BETWEEN '08:00:00' AND '15:59:59' 
                            AND pago != 'comida_personal' AND sucursal_id = '$sucursal_id'");

          $tpm = $db->GetAll("SELECT COUNT(nro) as TT, sum(total) as Total FROM venta WHERE estado = 'V'  
                            AND fecha BETWEEN'$min' AND '$max'
                            AND hora BETWEEN '16:00:00' AND '23:59:59' 
                            AND pago != 'comida_personal' AND sucursal_id = '$sucursal_id'");

          $tt = $db->GetAll("SELECT COUNT(nro) as TT, sum(total) as Total FROM venta WHERE estado = 'V'  
                            AND fecha BETWEEN '$min' AND '$max'
                            AND hora BETWEEN '08:00:00' AND '23:59:59' 
                            AND pago != 'comida_personal' AND sucursal_id = '$sucursal_id'");
        }
        ?>
        <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Turno AM</th>
              <th>Sucursal</th>
              <th>T.T.</th>
              <th>Total</th>
            </tr>
          </thead>
           <?php if (isset($_POST['sucursal']) && isset($_POST['fechaini']) && isset($_POST['fechamax'])) { ?>
           <tbody>
              <tr>
                <td>08:00 a 09:00</td>
                <?php foreach ($hora_1 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>09:00 a 10:00</td>
                <?php foreach ($hora_2 as $i) { ?>
                 <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $i['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>10:00 a 11:00</td>
                <?php foreach ($hora_3 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>11:00 a 12:00</td>
                <?php foreach ($hora_4 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>12:00 a 13:00</td>
                <?php foreach ($hora_5 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>13:00 a 14:00</td>
                <?php foreach ($hora_6 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>14:00 a 15:00</td>
                <?php foreach ($hora_7 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>15:00 a 16:00</td>
                <?php foreach ($hora_8 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <thead>
                <tr>
                  <?php foreach ($tam as $tv) { ?>
                    <td colspan="2">
                      <h4>Total AM:</h4>
                    </td>
                    <td>
                      <h4><?= $tv['TT']; ?></h4>
                    </td>
                    <td>
                      <h4><?= $tv['Total']; ?>Bs.</h4>
                    </td>
                  <?php } ?>
                </tr>
              </thead>
              <thead>
                <tr>
                  <th>Truno PM</th>
                  <th>Sucursal</th>
                  <th>T.T.</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tr>
                <td>16:00 a 17:00</td>
                <?php foreach ($hora_9 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>17:00 a 18:00</td>
                <?php foreach ($hora_10 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>18:00 a 19:00</td>
                <?php foreach ($hora_11 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>19:00 a 20:00</td>
                <?php foreach ($hora_12 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>20:00 a 21:00</td>
                <?php foreach ($hora_13 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>21:00 a 22:00</td>
                <?php foreach ($hora_14 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>22:00 a 23:00</td>
                <?php foreach ($hora_15 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
              <tr>
                <td>23:00 a 23:59</td>
                <?php foreach ($hora_16 as $h) { ?>
                  <td><?= $h['Sucursal']; ?></td>
                  <td><?= $h['TT']; ?></td>
                  <td><?= $h['Total']; ?></td>
                <?php } ?>
              </tr>
            </tbody>
            <thead>
              <tr>
                <?php foreach ($tpm as $tv) { ?>
                  <td colspan="2">
                    <h4>Total PM:</h4>
                  </td>
                  <td>
                    <h4><?= $tv['TT']; ?></h4>
                  </td>
                  <td>
                    <h4><?= $tv['Total']; ?>Bs.</h4>
                  </td>
                <?php } ?>
              </tr>
            </thead>
            </tr>
            <tfoot>
              <tr>
                <?php foreach ($tt as $tv) { ?>
                  <td colspan="2">
                    <h4>Total Dia:</h4>
                  </td>
                  <td>
                    <h4><?= $tv['TT']; ?></h4>
                  </td>
                  <td>
                    <h4><?= $tv['Total']; ?>Bs.</h4>
                  </td>
                <?php } ?>
              </tr>
            </tfoot>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
</body>

</html>