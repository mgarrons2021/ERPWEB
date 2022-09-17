<html>

<head>
    <title>Listado de ventas Fechas</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="../js/jquery.js"></script>
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/
    io2/css/bootstrap-datepicker.min.css">
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


    ?>
    <div class="container">
        <div class="left-sidebar">
            <h2>listado de Eliminaciones por Fechas </h2>
            <div class="table-responsive">
                <script src="../js/jquery.js"></script>
                <script src="../data/librerias/
                io2/js/bootstrap-datepicker.min.js"></script>
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
                <form action="reporte_eliminacion_rf.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                                <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" value="<?php if (isset($_POST['fechaini'])) {
                                                                                                                            echo $_POST['fechaini'];
                                                                                                                        } ?>" />
                                <span class="input-group-addon">A</span>
                                <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" value="<?php if (isset($_POST['fechamax'])) {
                                                                                                                            echo $_POST['fechamax'];
                                                                                                                        } ?>" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
                        </div>
                    </div>
                </form>
                <br>
                <button onclick="exceller()" class="btn btn-success">Export</button><br>

                <?php

                if (isset($_POST['fechaini']) && isset($_POST['fechamax'])) {
                    $array = [];
                    $fechaInicio = $_POST['fechaini'];
                    $fechaFin    = $_POST['fechamax'];

                    $fecha = $db->GetAll("SELECT fecha FROM venta WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha");

                    $sql_am_sur = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=2 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_sur = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=2 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_sur_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_sur = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=2 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_sur = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=2 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_sur = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_trespasos = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=5 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    // $sql_pm_trespasos = $db->GetAll("SELECT sum(total) AS total, fecha FROM venta WHERE sucursal_id = 5 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND turno = 2 AND pago != 'comida_personal' AND estado = 'V' GROUP BY fecha");
                    $sql_trespasos_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=5 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_trespasos = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=5 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    // $sql_total_rango_pm_trespasos = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE sucursal_id = 5 AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' AND turno = 2");
                    $sql_total_rango_trespasos = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=5 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_pampa = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=6 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_pampa = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=6 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pampa_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=6 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_pampa = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=6 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_pampa = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=6 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pampa = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=6 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_radial26 = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=7 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    // $sql_pm_radial26 = $db->GetAll("SELECT sum(total) AS total, fecha FROM venta WHERE sucursal_id = 7 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND turno = 2 AND pago != 'comida_personal' AND estado = 'V' GROUP BY fecha");
                    $sql_radial26_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=7 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_radial26 = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=7 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    // $sql_total_rango_pm_radial26 = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE sucursal_id = 7 AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' AND turno = 2");
                    $sql_total_rango_radial26 = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=7 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_qdelivilla = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=8 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_qdelivilla = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=8 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_qdelivilla_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=8 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_qdelivilla = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=8 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_qdelivilla = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=8 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_qdelivilla = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=8 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_bajio = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=9 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_bajio = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=9 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_bajio_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=9 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_bajio = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=9 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_bajio = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=9 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_bajio = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=9 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_arenal = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=10 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_arenal = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=10 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_arenal_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=10 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_arenal = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=10 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_arenal = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=10 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_arenal = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=10 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_plan = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=11 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    // $sql_pm_plan = $db->GetAll("SELECT sum(total) AS total, fecha FROM venta WHERE sucursal_id = 11 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND turno = 2 AND pago != 'comida_personal' AND estado = 'V' GROUP BY fecha");
                    $sql_plan_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=11 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_plan = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=11 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    // $sql_total_rango_pm_plan = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE sucursal_id = 11 AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' AND turno = 2");
                    $sql_total_rango_plan = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=11 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_villa = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=13 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_villa = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=13 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_villa_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=13 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_villa = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=13 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_villa = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=13 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_villa = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=13 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_cinecenter = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=15 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_cinecenter = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=15 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_cinecenter_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=15 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_cinecenter = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=15 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_cinecenter = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=15 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_cinecenter = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=15 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_boulevar = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=16 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_boulevar_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=16 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_boulevar = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=16 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_boulevar = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=16 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    
                    
                    $sql_am_mutu    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=14 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_mutu    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=14 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_mutu_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=14 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_mutu = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=14 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_mutu = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=14 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_mutu = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=14 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");

                    $sql_am_roca    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=12 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_roca    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=12 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_roca_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=12 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_roca = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=12 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_roca = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=12 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_roca = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=12 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");

                    $sql_am_palmas    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=4 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_palmas    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=4 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_palmas_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=4 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_palmas = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=4 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_palmas = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=4 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_palmas = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=4 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");

                    $sql_am_paragua    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=3 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_paragua    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=3 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_paragua_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=3 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_paragua = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=3 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_paragua = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=3 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_paragua = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=3 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $total = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day ORDER BY Calendar.day ASC");
                    $total_rango = $db->GetOne("SELECT sum(total) AS total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                } else {
                    $fechaInicio = date('d-m-Y');
                    $fechaFin    = date('d-m-Y');
                    $fecha = $db->GetAll("SELECT fecha FROM eliminacion WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha");
                    
                    $sql_am_sur = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=2 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_sur = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=2 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_sur_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_sur = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=2 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_sur = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=2 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_sur = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_trespasos = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=5 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    // $sql_pm_trespasos = $db->GetAll("SELECT sum(total) AS total, fecha FROM venta WHERE sucursal_id = 5 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND turno = 2 AND pago != 'comida_personal' AND estado = 'V' GROUP BY fecha");
                    $sql_trespasos_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=5 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_trespasos = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=5 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    // $sql_total_rango_pm_trespasos = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE sucursal_id = 5 AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' AND turno = 2");
                    $sql_total_rango_trespasos = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=5 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_pampa = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=6 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_pampa = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=6 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pampa_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=6 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_pampa = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=6 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_pampa = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=6 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pampa = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=6 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_radial26 = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=7 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    // $sql_pm_radial26 = $db->GetAll("SELECT sum(total) AS total, fecha FROM venta WHERE sucursal_id = 7 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND turno = 2 AND pago != 'comida_personal' AND estado = 'V' GROUP BY fecha");
                    $sql_radial26_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=7 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_radial26 = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=7 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    // $sql_total_rango_pm_radial26 = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE sucursal_id = 7 AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' AND turno = 2");
                    $sql_total_rango_radial26 = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=7 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_qdelivilla = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=8 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_qdelivilla = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=8 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_qdelivilla_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=8 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_qdelivilla = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=8 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_qdelivilla = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=8 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_qdelivilla = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=8 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_bajio = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=9 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_bajio = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=9 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_bajio_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=9 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_bajio = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=9 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_bajio = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=9 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_bajio = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=9 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_arenal = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=10 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_arenal = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=10 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_arenal_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=10 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_arenal = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=10 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_arenal = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=10 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_arenal = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=10 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_plan = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=11 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    // $sql_pm_plan = $db->GetAll("SELECT sum(total) AS total, fecha FROM venta WHERE sucursal_id = 11 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND turno = 2 AND pago != 'comida_personal' AND estado = 'V' GROUP BY fecha");
                    $sql_plan_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=11 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_plan = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=11 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    // $sql_total_rango_pm_plan = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE sucursal_id = 11 AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' AND turno = 2");
                    $sql_total_rango_plan = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=11 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_villa = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=13 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_villa = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=13 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_villa_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=13 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_villa = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=13 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_villa = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=13 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_villa = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=13 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_cinecenter = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=15 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_cinecenter = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=15 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_cinecenter_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=15 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_cinecenter = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=15 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_cinecenter = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=15 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_cinecenter = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=15 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $sql_am_boulevar = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=16 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_boulevar_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=16 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_boulevar = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=16 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_boulevar = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=16 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    
                    
                    $sql_am_mutu    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=14 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_mutu    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=14 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_mutu_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=14 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_mutu = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=14 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_mutu = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=14 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_mutu = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=14 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");

                    $sql_am_roca    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=12 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_roca    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=12 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_roca_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=12 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_roca = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=12 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_roca = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=12 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_roca = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=12 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");

                    $sql_am_palmas    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=4 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_palmas    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=4 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_palmas_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=4 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_palmas = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=4 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_palmas = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=4 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_palmas = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=4 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");

                    $sql_am_paragua    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=3 AND e.turno = 1 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_pm_paragua    = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=3 AND e.turno = 2 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_paragua_total = $db->GetAll("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=3 WHERE Calendar.day BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day");
                    $sql_total_rango_am_paragua = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=3 AND turno = 1 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_pm_paragua = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=3 AND turno = 2 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_total_rango_paragua = $db->GetOne("SELECT sum(total) as total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha AND e.sucursal_id=3 WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");


                    $total = $db->GetAll("SELECT sum(total) AS total,Calendar.day as fecha FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY Calendar.day ORDER BY Calendar.day ASC");
                    $total_rango = $db->GetOne("SELECT sum(total) AS total FROM Calendar LEFT JOIN eliminacion e ON Calendar.day = e.fecha WHERE Calendar.day  BETWEEN '$fechaInicio' AND '$fechaFin'");
                }

                ?>
                <table id="tblventas" class="table table-striped table-hover table-bordered" width="100%">
                    <thead style="background-color: #FFCC79;">
                        <tr>
                            <th style="text-align: center; background-color: #F1A323;">Sucursal</th>
                            <th style="text-align: center;">Turno</th>
                            <?php foreach ($fecha as $d) {
                                $fech=$d['fecha']; ?>
                                <th style="text-align: center;"><?= date('d/m/Y', strtotime($d['fecha'])) ?></th>
                            <?php } ?>
                            <th style="font-size: 10px;">Total <?= date('d/m', strtotime($fechaInicio)) ?>a<?= date('d/m', strtotime($fechaFin)) ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Suc. Sur</td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_sur as $dato) { ?>
                                <?php if ($dato['total'] != null){ ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #D9EDFC;">0.00</td>
                                <?php } ?>
                            <?php }?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_sur, 2, ',', '.')  ?></td>

                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php foreach ($sql_pm_sur as $dato) { ?>
                                <?php if ($dato['total'] == NULL) { ?>
                                    <?php (number_format($dato['total'], 2)); ?>
                                    <td style="background-color: #D9EDFC;">0.00</td>
                                <?php } else { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_pm_sur, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_sur_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">-</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_sur, 2, ',', '.')?></td>
                        </tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Suc. Tres Pasos</td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_trespasos as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #D9EDFC;">-</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= $sql_total_rango_am_trespasos ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_trespasos_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">-</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_trespasos, 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Suc. Pampa</td>
                        </tr>

                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_pampa as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #D9EDFC;">-</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_pampa, 2, ',', '.')?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php foreach ($sql_pm_pampa as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #D9EDFC;">-</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_pm_pampa, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_pampa_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">-</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_pampa, 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Suc. Radial 26</td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_radial26 as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #D9EDFC;">-</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_radial26, 2, ',', '.')?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_radial26_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">-</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_radial26, 2, ',', '.')?></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Suc. Qdeli Villa</td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_qdelivilla as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #D9EDFC;">-</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_qdelivilla, 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php foreach ($sql_pm_qdelivilla as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #D9EDFC;">-</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_pm_qdelivilla, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_qdelivilla_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 && $dato['total'] != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">-</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_qdelivilla, 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Suc. Bajio</td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_bajio as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #D9EDFC;">-</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_bajio, 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php foreach ($sql_pm_bajio as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #D9EDFC;">-</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_pm_bajio, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_bajio_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_bajio, 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Suc. Arenal</td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_arenal as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_arenal, 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php foreach ($sql_pm_arenal as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_pm_arenal, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_arenal_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_arenal, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Suc. Plan 3000</td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_plan as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_plan, 2, ',', '.')  ?></td>
                        </tr>

                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_plan_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 && $dato['total'] != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_plan, 2, ',', '.')?></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Suc. Villa</td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_villa as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_villa, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php foreach ($sql_pm_villa as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_pm_villa, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_villa_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_villa, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Suc. Cine Center</td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_cinecenter as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_cinecenter, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php foreach ($sql_pm_cinecenter as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_pm_cinecenter, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_cinecenter_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_cinecenter, 2, ',', '.') ?></td>
                        </tr>
                        
                        
                        
                        
                        
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Suc. Mutualista</td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_mutu as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_mutu, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php foreach ($sql_pm_mutu as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_pm_mutu, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_mutu_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_mutu, 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Suc. Boulevard</td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_boulevar as $d) { ?>
                                <?php if (number_format($d['total'], 2) != 0 || number_format($d['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($d['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #D9EDFC;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_boulevar, 2, ',', '.')  ?></td>
                        </tr>

                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_boulevar_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_boulevar, 2, ',', '.')  ?></td>
                        </tr>

                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Suc. Roca</td>
                        </tr>

                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_roca as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_roca, 2, ',', '.')?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php foreach ($sql_pm_roca as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_pm_roca, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_roca_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_roca, 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Suc. Palmas</td>
                        </tr>

                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_palmas as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_palmas, 2, ',', '.')?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php foreach ($sql_pm_palmas as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_pm_palmas, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_palmas_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_palmas, 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Suc. Paragua</td>
                        </tr>

                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php foreach ($sql_am_paragua as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_am_paragua, 2, ',', '.')?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php foreach ($sql_pm_paragua as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_total_rango_pm_paragua, 2, ',', '.')  ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #408EC8;">Total</td>
                            <?php foreach ($sql_paragua_total as $dato) { ?>
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                    <td style="background-color: #408EC8;"><?= number_format($dato['total'], 2, ',', '.')  ?></td>
                                <?php } else { ?>
                                    <td style="background-color: #408EC8;">0.00</td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #408EC8;"><?= number_format($sql_total_rango_paragua, 2, ',', '.') ?></td>
                        </tr>



                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" style="background-color: #FFCC79;">
                                <h5>Total</h5>
                            </td>
                            <?php foreach ($total as $dato) { ?>
                                <td style="background-color: #FFCC79;">
                                    <h5><?= number_format($dato['total'], 2, ',', '.')?></h5>
                                </td>
                            <?php } ?>
                            <td style="background-color: #FFCC79;"><?= number_format($total_rango, 2, ',', '.')  ?></td>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
    <script>
        function exceller() {
            var uri = 'data:application/vnd.ms-Excel;base64,',
                template = '<html xmlns:o="urn:schemas-Microsoft-com:office:office" xmlns:x="urn:schemas-Microsoft-com:office:Excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
                base64 = function(s) {
                    return window.btoa(unescape(encodeURIComponent(s)))
                },
                format = function(s, c) {
                    return s.replace(/{(\w+)}/g, function(m, p) {
                        return c[p];
                    })
                }
            var toExcel = document.getElementById("tblventas").innerHTML;
            var ctx = {
                worksheet: name || '',
                table: toExcel
            };
            var link = document.createElement("a");
            link.download = "ventas.xls";
            link.href = uri + base64(format(template, ctx))
            link.click();
        }
    </script>
</body>

</html>