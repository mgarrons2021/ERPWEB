<html>

<head>
  <title>Reporte Mano de Obra</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <script src="../js/jquery.js"></script>
  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
</head>

<body class="body">

  <div class="container">
    <div class="left-sidebar">
      <h2>Reporte de M.O. por sucursal</h2>
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
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js">
        </script>
        <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js">
        </script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.dataTables.min.css">
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
                },
                dom: 'Bfrtip',
                buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5'
                ]
              }
            })
          });
        </script>
        <form action="">
          <div class="row">
            <div class="col-md-6">
              <div class="input-daterange input-group" id="datepicker">
                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" />
                <span class="input-group-addon">A</span>
                <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" />
                <input type="hidden" id="form_sent" name="form_sent" value="true">
              </div>
            </div>
            <div class="col-md-2">
              <input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
            </div>
            <button class="btn btn-success col-md-3" onclick="exportTableToExcel('usuario')">Exportar a un archivo de Excel</button>
          </div>
        </form>
        <br>
        <?php
        function suc_am($sucur)
        {
          $total = 0;
          $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
          if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];
            $query = "SELECT sum(totalhoras)as totalhoras
            FROM registrar 
            where  sucursal_id='$sucur' and turno='1' and
            fecha between '$min' and '$max'";
          } else {
            $min = date("Y-m-d");
            $max = date("Y-m-d");
            $query = "SELECT sum(totalhoras)as totalhoras
            FROM registrar 
            where  sucursal_id='$sucur' and turno='1' and
            fecha between '$min' and '$max'";
          }
          $resultado = $conexion->query($query);
          foreach ($resultado as $r) {
            $total = number_format($r["totalhoras"], 2);
          }
          //echo number_format($total,2)." bs.";
          return $total;
        }

        function suc_horas_am($sucur)
        {
          $total = 0;
          $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
          if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];
            $query = "SELECT horas
            FROM registrar 
            where  sucursal_id='$sucur' and turno='1' and
            fecha between '$min' and '$max'";
          } else {
            $min = date("Y-m-d");
            $max = date("Y-m-d");
            $query = "SELECT horas
            FROM registrar 
            where  sucursal_id='$sucur' and turno='1' and
            fecha between '$min' and '$max'";
          }
          $resultado = $conexion->query($query);
          /* var_dump($resultado); */
          foreach ($resultado as $r) {
            $total = number_format($r["horas"], 2);
          }
          //echo number_format($total,2)." bs.";
          return $total;
        }
        function suc_ventas_am($sucur)
        {
          $total = 0;
          $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
          if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];
            $query = "SELECT ventas
            FROM registrar 
            where  sucursal_id='$sucur' and turno='1' and
            fecha between '$min' and '$max'";
          } else {
            $min = date("Y-m-d");
            $max = date("Y-m-d");
            $query = "SELECT ventas
            FROM registrar 
            where  sucursal_id='$sucur' and turno='1' and
            fecha between '$min' and '$max'";
          }
          $resultado = $conexion->query($query);
          /* var_dump($resultado); */
          foreach ($resultado as $r) {
            $total = number_format($r["ventas"], 2);
          }
          //echo number_format($total,2)." bs.";
          return $total;
        }

        function suc_pm($sucur)
        {
          $total = 0;
          $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
          if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];
            $query = "SELECT sum(totalhoras)as totalhoras
            FROM registrar 
            where  sucursal_id='$sucur' and turno='2' and
            fecha between '$min' and '$max'";
          } else {
            $min = date("Y-m-d");
            $max = date("Y-m-d");
            $query = "SELECT sum(totalhoras)as totalhoras
            FROM registrar 
            where  sucursal_id='$sucur' and turno='2' and
            fecha between '$min' and '$max'";
          }
          $resultado = $conexion->query($query);
          /* var_dump($resultado); */
          foreach ($resultado as $r) {
            $total = number_format($r["totalhoras"], 2);
          }
          //echo number_format($total,2)." bs.";
          return $total;
        }
        function suc_ventas_total_am()
        {
          $total = 0;
          $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
          if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];
            $query = "SELECT sum(ventas)as totalventasam
              FROM registrar 
              where turno='1' and
              fecha between '$min' and '$max'";
          } else {
            $min = date("Y-m-d");
            $max = date("Y-m-d");
            $query = "SELECT sum(ventas)as totalventasam
              FROM registrar 
              where turno='1' and
              fecha between '$min' and '$max'";
          }
          $resultado = $conexion->query($query);
          /* var_dump($resultado); */
          foreach ($resultado as $r) {
            $total = number_format($r["totalventasam"], 2);
          }
          //echo number_format($total,2)." bs.";
          return $total;
        }
        //TODO: sucursal_mo_am
        function suc_mo_am($sucur)
        {
          $total = 0;
          $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
          if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];
            $query = "SELECT ventas, horas
              FROM registrar 
              where  sucursal_id='$sucur' and turno='1' and
              fecha between '$min' and '$max'";
          } else {
            $min = date("Y-m-d");
            $max = date("Y-m-d");
            $query = "SELECT ventas, horas
              FROM registrar 
              where  sucursal_id='$sucur' and turno='1' and
              fecha between '$min' and '$max'";
          }
          $resultado = $conexion->query($query);
          foreach ($resultado as $r) {
            if ($r["ventas"] == 0) {
              return $total = "0.00";
            } else {
              $total = number_format((floatval($r["horas"] * 8.84) / floatval($r["ventas"]) * 100), 2);
              return $total;
            }
          }
        }
        function suc_horas_pm($sucur)
        {
          $total = 0;
          $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
          if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];
            $query = "SELECT horas
            FROM registrar 
            where  sucursal_id='$sucur' and turno='2' and
            fecha between '$min' and '$max'";
          } else {
            $min = date("Y-m-d");
            $max = date("Y-m-d");
            $query = "SELECT horas
            FROM registrar 
            where  sucursal_id='$sucur' and turno='2' and
            fecha between '$min' and '$max'";
          }
          $resultado = $conexion->query($query);
          /* var_dump($resultado); */
          foreach ($resultado as $r) {
            $total = $r["horas"];
          }
          //echo number_format($total,2)." bs.";
          return $total;
        }
        function suc_ventas_pm($sucur)
        {
          $total = 0;
          $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
          if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];
            $query = "SELECT ventas
            FROM registrar 
            where  sucursal_id='$sucur' and turno='2' and
            fecha between '$min' and '$max'";
          } else {
            $min = date("Y-m-d");
            $max = date("Y-m-d");
            $query = "SELECT ventas
            FROM registrar 
            where  sucursal_id='$sucur' and turno='2' and
            fecha between '$min' and '$max'";
          }
          $resultado = $conexion->query($query);
          /* var_dump($resultado); */
          foreach ($resultado as $r) {
            $total = number_format($r["ventas"], 2);
          }
          //echo number_format($total,2)." bs.";
          if ($total != 0) {
            return $total;
          } else {
            return $total = number_format(0, 2);
          }
        }
        //TODO: total_venta_sucursal_pm
        function suc_ventas_total_pm()
        {
          $total = 0;
          $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
          if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];
            $query = "SELECT sum(ventas)as totalventaspm
              FROM registrar 
              where turno='2' and
              fecha between '$min' and '$max'";
          } else {
            $min = date("Y-m-d");
            $max = date("Y-m-d");
            $query = "SELECT sum(ventas)as totalventaspm
              FROM registrar 
              where turno='2' and
              fecha between '$min' and '$max'";
          }
          $resultado = $conexion->query($query);
          /* var_dump($resultado); */
          foreach ($resultado as $r) {
            $total = number_format($r["totalventaspm"], 2);
          }
          //echo number_format($total,2)." bs.";
          return $total;
        }
        //TODO: sucursal_mo_pm
        function suc_mo_pm($sucur)
        {
          $total = 0;
          $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
          if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];
            $query = "SELECT ventas, horas
              FROM registrar 
              where  sucursal_id='$sucur' and turno='2' and
              fecha between '$min' and '$max'";
          } else {
            $min = date("Y-m-d");
            $max = date("Y-m-d");
            $query = "SELECT ventas
              FROM registrar 
              where  sucursal_id='$sucur' and turno='2' and
              fecha between '$min' and '$max'";
          }
          $resultado = $conexion->query($query);
          foreach ($resultado as $r) {
            if ($r["ventas"] == 0) {
              return $total = number_format(0, 2);
            } else {
              $total = number_format((floatval($r["horas"] * 8.84) / floatval($r["ventas"]) * 100), 2);
              return $total;
            }
          }
        }
        //TODO: sucursal_ventas_total
        function suc_ventas_suc_total($sucur)
        {
          $total = 0;
          $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
          if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];
            $query = "SELECT sum(ventas)as totalventas
              FROM registrar 
              where sucursal_id =$sucur and
              fecha between '$min' and '$max'";
          } else {
            $min = date("Y-m-d");
            $max = date("Y-m-d");
            $query = "SELECT sum(ventas)as totalventas
              FROM registrar 
              where sucursal_id = $sucur and
              fecha between '$min' and '$max'";
          }
          $resultado = $conexion->query($query);
          /* var_dump($resultado); */
          foreach ($resultado as $r) {
            $total = number_format($r["totalventas"], 2);
          }
          //echo number_format($total,2)." bs.";
          return $total;
        }
        //TODO: Total_ventas_sucursales
        function suc_ventas_total()
        {
          $total = 0;
          $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
          if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];
            $query = "SELECT sum(ventas)as totalventas
              FROM registrar 
              where 
              fecha between '$min' and '$max'";
          } else {
            $min = date("Y-m-d");
            $max = date("Y-m-d");
            $query = "SELECT sum(ventas)as totalventas
              FROM registrar 
              where
              fecha between '$min' and '$max'";
          }
          $resultado = $conexion->query($query);
          /* var_dump($resultado); */
          foreach ($resultado as $r) {
            $total = number_format($r["totalventas"], 2);
          }
          //echo number_format($total,2)." bs.";
          return $total;
        }
        //TODO: sucursal_mo_total
        function suc_mo_total($sucur)
        {
          $total = 0;
          $conexion = new mysqli('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
          if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];
            $query = "SELECT SUM(ventas)as ventas, SUM(horas)as horas
              FROM registrar 
              where  sucursal_id='$sucur' and
              fecha between '$min' and '$max'";
          } else {
            $min = date("Y-m-d");
            $max = date("Y-m-d");
            $query = "SELECT SUM(ventas)as ventas, SUM(horas)as horas
              FROM registrar 
              where  sucursal_id='$sucur' and
              fecha between '$min' and '$max'";
          }
          $resultado = $conexion->query($query);
          foreach ($resultado as $r) {
            if ($r["ventas"] == 0) {
              return $total = number_format(0, 2);
            } else {
              $total = number_format((floatval($r["horas"] * 8.84) / floatval($r["ventas"]) * 100), 2);
              return $total;
            }
          }
        }
        ?>
        <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr class="text-center">
              <th>Sucursal</th>
              <th>Horas Trabajadas AM</th>
              <th>Costo M.O.Turno AM</th>
              <th>Venta AM</th>
              <th>% M.O AM</th>
              <th>Horas Trabajadas PM</th>
              <th>Costo M.O.Turno PM</th>
              <th>Venta PM</th>
              <th>% M.O PM</th>
              <th>Total Costo M.O</th>
              <th>Total Horas</th>
              <th>Total Ventas</th>
              <th>Total M.O</th>
            </tr>
          </thead>
          <tbody>
            <tr class=warning>
              <td><?php echo "SUC. SUR"; ?></td>
              <td><?php echo suc_horas_am(2) . "Hrs" ?></td>
              <td><?php echo suc_am(2) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(2) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(2) . "%"; ?></td>
              <td><?php echo suc_horas_pm(2) . "Hrs"; ?></td>
              <td><?php echo suc_pm(2) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(2) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(2) . "%"; ?></td>
              <td><?php echo suc_am(2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(2) + suc_horas_pm(2)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(2) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(2) . "%"; ?></td>
            </tr>
            <tr class=warning>
              <td><?php echo "SUC. PARAGUA"; ?></td>
              <td><?php echo suc_horas_am(3) . "Hrs" ?></td>
              <td><?php echo suc_am(3) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(3) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(3) . "%"; ?></td>
              <td><?php echo suc_horas_pm(3) . "Hrs"; ?></td>
              <td><?php echo suc_pm(3) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(3) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(3) . "%"; ?></td>
              <td><?php echo number_format((suc_am(3) + suc_pm(3)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(3) + suc_horas_pm(3)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(3) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(3) . "%"; ?></td>
            </tr>
            <tr class=warning>
              <td><?php echo "SUC. PALMAS"; ?></td>
              <td><?php echo suc_horas_am(4) . "Hrs" ?></td>
              <td><?php echo suc_am(4) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(4) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(4) . "%"; ?></td>
              <td><?php echo suc_horas_pm(4) . "Hrs"; ?></td>
              <td><?php echo suc_pm(4) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(4) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(4) . "%"; ?></td>
              <td><?php echo number_format((suc_am(4) + suc_pm(4)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(4) + suc_horas_pm(4)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(4) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(4) . "%"; ?></td>
            </tr>
            <tr class=warning>
              <td><?php echo "SUC. TRES PASOS"; ?></td>
              <td><?php echo suc_horas_am(5) . "Hrs" ?></td>
              <td><?php echo suc_am(5) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(5) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(5) . "%"; ?></td>
              <td><?php echo suc_horas_pm(5) . "Hrs"; ?></td>
              <td><?php echo suc_pm(5) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(5) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(5) . "%"; ?></td>
              <td><?php echo number_format((suc_am(5) + suc_pm(5)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(5) + suc_horas_pm(5)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(5) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(5) . "%"; ?></td>
            </tr>
            <tr class=warning>
              <td><?php echo "SUC. PAMPA"; ?></td>
              <td><?php echo suc_horas_am(6) . "Hrs" ?></td>
              <td><?php echo suc_am(6) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(6) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(6) . "%"; ?></td>
              <td><?php echo suc_horas_pm(6) . "Hrs"; ?></td>
              <td><?php echo suc_pm(6) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(6) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(6) . "%"; ?></td>
              <td><?php echo number_format((suc_am(6) + suc_pm(6)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(6) + suc_horas_pm(6)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(6) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(6) . "%"; ?></td>
            </tr>
            <tr class=warning>
              <td><?php echo "SUC. RADIAL 26"; ?></td>
              <td><?php echo suc_horas_am(7) . "Hrs" ?></td>
              <td><?php echo suc_am(7) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(7) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(7) . "%"; ?></td>
              <td><?php echo suc_horas_pm(7) . "Hrs"; ?></td>
              <td><?php echo suc_pm(7) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(7) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(7) . "%"; ?></td>
              <td><?php echo number_format((suc_am(7) + suc_pm(7)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(7) + suc_horas_pm(7)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(7) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(7) . "%"; ?></td>
            </tr>
            <tr class=warning>
              <td><?php echo "SUC. QDELI VILLA"; ?></td>
              <td><?php echo suc_horas_am(8) . "Hrs" ?></td>
              <td><?php echo suc_am(8) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(8) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(8) . "%"; ?></td>
              <td><?php echo suc_horas_pm(8) . "Hrs"; ?></td>
              <td><?php echo suc_pm(8) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(8) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(8) . "%"; ?></td>
              <td><?php echo number_format((suc_am(8) + suc_pm(8)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(8) + suc_horas_pm(8)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(8) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(8) . "%"; ?></td>
            </tr>
            <tr class=warning>
              <td><?php echo "SUC. BAJIO"; ?></td>
              <td><?php echo suc_horas_am(9) . "Hrs" ?></td>
              <td><?php echo suc_am(9) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(9) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(9) . "%"; ?></td>
              <td><?php echo suc_horas_pm(9) . "Hrs"; ?></td>
              <td><?php echo suc_pm(9) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(9) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(9) . "%"; ?></td>
              <td><?php echo number_format((suc_am(9) + suc_pm(9)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(9) + suc_horas_pm(9)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(9) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(9) . "%"; ?></td>
            </tr>
            <tr class=warning>
              <td><?php echo "SUC. ARENAL"; ?></td>
              <td><?php echo suc_horas_am(10) . "Hrs" ?></td>
              <td><?php echo suc_am(10) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(10) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(10) . "%"; ?></td>
              <td><?php echo suc_horas_pm(10) . "Hrs"; ?></td>
              <td><?php echo suc_pm(10) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(10) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(10) . "%"; ?></td>
              <td><?php echo number_format((suc_am(10) + suc_pm(10)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(10) + suc_horas_pm(10)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(10) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(10) . "%"; ?></td>
            </tr>
            <tr class=warning>
              <td><?php echo "SUC. PLAN 3000"; ?></td>
              <td><?php echo suc_horas_am(11) . "Hrs" ?></td>
              <td><?php echo suc_am(11) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(11) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(11) . "%"; ?></td>
              <td><?php echo suc_horas_pm(11) . "Hrs"; ?></td>
              <td><?php echo suc_pm(11) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(11) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(11) . "%"; ?></td>
              <td><?php echo number_format((suc_am(11) + suc_pm(11)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(11) + suc_horas_pm(11)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(11) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(11) . "%"; ?></td>
            </tr>
            <tr class=warning>
              <td><?php echo "SUC. ROCA"; ?></td>
              <td><?php echo suc_horas_am(12) . "Hrs" ?></td>
              <td><?php echo suc_am(12) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(12) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(12) . "%"; ?></td>
              <td><?php echo suc_horas_pm(12) . "Hrs"; ?></td>
              <td><?php echo suc_pm(12) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(12) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(12) . "%"; ?></td>
              <td><?php echo number_format((suc_am(12) + suc_pm(12)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(12) + suc_horas_pm(12)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(12) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(12) . "%"; ?></td>
            </tr>
            <tr class=warning>
              <td><?php echo "SUC. VILLA"; ?></td>
              <td><?php echo suc_horas_am(13) . "Hrs" ?></td>
              <td><?php echo suc_am(13) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(13) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(13) . "%"; ?></td>
              <td><?php echo suc_horas_pm(13) . "Hrs"; ?></td>
              <td><?php echo suc_pm(13) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(13) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(13) . "%"; ?></td>
              <td><?php echo number_format((suc_am(13) + suc_pm(13)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(13) + suc_horas_pm(13)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(13) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(13) . "%"; ?></td>
            </tr>
            <tr class=warning>
              <td><?php echo "SUC. MUTUALISTA"; ?></td>
              <td><?php echo suc_horas_am(14) . "Hrs" ?></td>
              <td><?php echo suc_am(14) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(14) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(14) . "%"; ?></td>
              <td><?php echo suc_horas_pm(14) . "Hrs"; ?></td>
              <td><?php echo suc_pm(14) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(14) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(14) . "%"; ?></td>
              <td><?php echo number_format((suc_am(14) + suc_pm(14)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(14) + suc_horas_pm(14)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(14) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(14) . "%"; ?></td>
            </tr>
            <tr class=warning>
              <td><?php echo "SUC. CINE CENTER"; ?></td>
              <td><?php echo suc_horas_am(15) . "Hrs" ?></td>
              <td><?php echo suc_am(15) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(15) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(15) . "%"; ?></td>
              <td><?php echo suc_horas_pm(15) . "Hrs"; ?></td>
              <td><?php echo suc_pm(15) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(15) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(15) . "%"; ?></td>
              <td><?php echo number_format((suc_am(15) + suc_pm(15)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(15) + suc_horas_pm(15)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(15) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(15) . "%"; ?></td>
            </tr>

            <tr class=warning>
              <td><?php echo "SUC. BOULEVARD"; ?></td>
              <td><?php echo suc_horas_am(16) . "Hrs" ?></td>
              <td><?php echo suc_am(16) . "Bs"; ?></td>
              <td><?php echo suc_ventas_am(16) . "Bs"; ?></td>
              <td><?php echo suc_mo_am(16) . "%"; ?></td>
              <td><?php echo suc_horas_pm(16) . "Hrs"; ?></td>
              <td><?php echo suc_pm(16) . "Bs"; ?></td>
              <td><?php echo suc_ventas_pm(16) . "Bs"; ?></td>
              <td><?php echo suc_mo_pm(16) . "%"; ?></td>
              <td><?php echo number_format((suc_am(16) + suc_pm(16)), 2) . "Bs"; ?></td>
              <td><?php echo (suc_horas_am(16) + suc_horas_pm(16)) . "Hrs"; ?></td>
              <td><?php echo suc_ventas_suc_total(16) . "Bs"; ?></td>
              <td><?php echo suc_mo_total(16) . "%"; ?></td>
            </tr>
        </table>
        <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
          <tr>
            <td>
              <h4>Total ventas</h4>
            </td>
            <td>
              <h4><?php echo suc_ventas_total_am() . "Bs"; ?></h4>
            </td>
            <td>
              <h4><?php echo suc_ventas_total_pm() . "Bs"; ?></h4>
            </td>
            <td>
              <h4><?php echo suc_ventas_total() . "Bs"; ?></h4>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</body>

</html>
<script type="text/javascript">
  $("#filtrar").on("click", function() {
    fechainicio = document.getElementById("fechaini").value;
    fechamax = document.getElementById("fechamax").value;
    console.log("esta es la fecha:" + fechainicio + " y la fecha max:" + fechamax);
  });

  function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    // Specify file name
    filename = filename ? filename + '.xls' : 'Reporte_M.O._por_sucursal.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
      var blob = new Blob(['ufeff', tableHTML], {
        type: dataType
      });
      navigator.msSaveOrOpenBlob(blob, filename);
    } else {
      // Create a link to the file
      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

      // Setting the file name
      downloadLink.download = filename;

      //triggering the function
      downloadLink.click();
    }
  }
</script>