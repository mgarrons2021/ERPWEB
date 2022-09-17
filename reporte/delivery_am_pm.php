<html>

<head>
    <title>Registro Delivery por sucursal </title>
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
    ?>
    <div class="container">
        <div class="left-sidebar">
            <h2>Registro Delivery por sucursal</h2>
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
                <form action="delivery.php" method="POST">
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
                    $fecharelleno = $fechaInicio;

                    $fecha = $db->GetAll("SELECT fecha FROM venta WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha");

                    function rellenar($idsucursal)
                    {
                    }

                    /*Paragua*/
                    $sql_paraguaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 3 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_paraguaDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 3 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_paraguaDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 3 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_paraguarangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 3 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_paraguarangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 3 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_paraguarangoDelivery = $db->GetOne("SELECT sum( total) , fecha FROM `venta` WHERE sucursal_id = 3 and lugar like 'Delivery' and fecha  BETWEEN '$fechaInicio' and '$fechaFin';");

                    /*3 Pasos*/
                    $sql_3pasosDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 5 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_3pasosDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 5 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_3pasosDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 5 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_3pasosrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 5 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_3pasosrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 5 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_3pasosrangoDelivery = $db->GetOne("SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 5;");


                    /*Boulevar*/
                    $sql_boulevarDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 16 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_boulevarDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 16 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_boulevarDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 16 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_boulevarrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 16 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_boulevarrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 16 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_boulevarrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 16;");

                    /*Palmas */
                    
                    $sql_palmasDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 4 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_palmasDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 4 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_palmasDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 4 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_palmasrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 4 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_palmasrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 4 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_palmasrangoDelivery = $db->GetOne("SELECT sum( total) , fecha FROM `venta` WHERE sucursal_id = 4 and lugar like 'Delivery' and fecha  BETWEEN '$fechaInicio' and '$fechaFin';");

                    /* Cine center */
                    $sql_CineDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 15 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_CineDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 15 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_CineDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 15 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_cinerangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 15 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_cinerangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 15 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_CinerangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 15;");


                    /* Mutualista */
                    $sql_mutualistaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 14 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_mutualistaDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 14 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_mutualistaDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 14 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_mutualistarangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                     WHERE v.sucursal_id = 14 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_mutualistarangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                     WHERE v.sucursal_id = 14 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_mutualistarangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 14;");

                    /* Pampa */
                    $sql_pampaDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 6 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_pampaDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 6 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_pamparangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 6 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_pamparangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 6 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_pampaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 6 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_pamparangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 6;");

                    /* Plan3000 */
                    $sql_plan3000Delivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 11 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_plan3000Delivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 11 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_planDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 11 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_planrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 11 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_planrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 11 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_planrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 11;");

                    /* Radial 26 */
                    $sql_radialDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 7 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_radialDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 7 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_radialDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 7 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_radialrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 7 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_radialrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 7 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_radialrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 7;");

                    /* Roca */
                    $sql_rocaDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 12 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_rocaDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 12 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_rocaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 12 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_rocarangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 12 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_rocarangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 12 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_rocarangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 12;");

                    /* Sur */
                    $sql_surDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 2 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_surDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 2 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_surDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 2 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_surrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 2 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_surrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 2 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_surrangoDelivery = $db->GetOne(" SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 2 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin'");

                    /* Villa */
                    $sql_villa1Delivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 13 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_villa1Delivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 13 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_villa1Delivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 13 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_villa1rangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 13 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_villa1rangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 13 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_villa1rangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 13;");

                    /* QdeliVilla */
                    $sql_villa2Delivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 8 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_villa2Delivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 8 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_villa2qdeliDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 8 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_villa2rangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 8 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_villa2rangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 8 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_villa2qdelirangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 8;");

                    /* Arenal */
                    $sql_arenalDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 10 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_arenalDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 10 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_arenalDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 10 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_arenalrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 10 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_arenalrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 10 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_arenalrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 10;");

                    /* Bajio */
                    $sql_bajioDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 9 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_bajioDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 9 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_bajioDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 9 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_bajiorangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 9 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_bajiorangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 9 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_bajiorangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 9;");


                    $total = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE  lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $total_rango = $db->GetOne("SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin';");
                } else {

                    $fechaInicio = date('d-m-Y');
                    $fechaFin    = date('d-m-Y');

                    $fecha = $db->GetAll("SELECT fecha FROM venta WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha");

                    $sql_paraguaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 3 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_paraguaDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 3 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_paraguaDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 3 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_paraguarangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 3 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_paraguarangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 3 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_paraguarangoDelivery = $db->GetOne("SELECT sum( total) , fecha FROM `venta` WHERE sucursal_id = 3 and lugar like 'Delivery' and fecha  BETWEEN '$fechaInicio' and '$fechaFin';");

                    /*3 Pasos*/
                    $sql_3pasosDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 5 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_3pasosDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 5 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_3pasosDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 5 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_3pasosrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 5 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_3pasosrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 5 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_3pasosrangoDelivery = $db->GetOne("SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 5;");


                    /*Boulevar*/
                    $sql_boulevarDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 16 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_boulevarDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 16 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_boulevarDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 16 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_boulevarrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 16 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_boulevarrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 16 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_boulevarrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 16;");

                    /*Palmas */
                    
                    $sql_palmasDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 4 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_palmasDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 4 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_palmasDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 4 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_palmasrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 4 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_palmasrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 4 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_palmasrangoDelivery = $db->GetOne("SELECT sum( total) , fecha FROM `venta` WHERE sucursal_id = 4 and lugar like 'Delivery' and fecha  BETWEEN '$fechaInicio' and '$fechaFin';");

                    /* Cine center */
                    $sql_CineDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 15 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_CineDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 15 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_CineDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 15 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_cinerangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 15 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_cinerangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 15 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_CinerangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 15;");


                    /* Mutualista */
                    $sql_mutualistaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 14 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_mutualistaDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 14 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_mutualistaDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 14 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_mutualistarangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                     WHERE v.sucursal_id = 14 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_mutualistarangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                     WHERE v.sucursal_id = 14 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_mutualistarangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 14;");

                    /* Pampa */
                    $sql_pampaDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 6 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_pampaDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 6 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_pamparangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 6 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_pamparangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 6 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_pampaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 6 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_pamparangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 6;");

                    /* Plan3000 */
                    $sql_plan3000Delivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 11 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_plan3000Delivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 11 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_planDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 11 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_planrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 11 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_planrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 11 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_planrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 11;");

                    /* Radial 26 */
                    $sql_radialDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 7 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_radialDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 7 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_radialDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 7 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_radialrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 7 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_radialrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 7 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_radialrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 7;");

                    /* Roca */
                    $sql_rocaDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 12 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_rocaDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 12 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_rocaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 12 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_rocarangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 12 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_rocarangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 12 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_rocarangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 12;");

                    /* Sur */
                    $sql_surDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 2 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_surDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 2 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_surDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 2 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_surrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 2 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_surrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 2 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_surrangoDelivery = $db->GetOne(" SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 2 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin'");

                    /* Villa */
                    $sql_villa1Delivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 13 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_villa1Delivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 13 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_villa1Delivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 13 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_villa1rangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 13 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_villa1rangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 13 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_villa1rangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 13;");

                    /* QdeliVilla */
                    $sql_villa2Delivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 8 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_villa2Delivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 8 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_villa2qdeliDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 8 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_villa2rangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 8 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_villa2rangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 8 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_villa2qdelirangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 8;");

                    /* Arenal */
                    $sql_arenalDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 10 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_arenalDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 10 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_arenalDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 10 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_arenalrangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 10 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_arenalrangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 10 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_arenalrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 10;");

                    /* Bajio */
                    $sql_bajioDelivery_am = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 9 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 1 GROUP by v.fecha;");
                    $sql_bajioDelivery_pm = $db->GetAll("SELECT DISTINCT sum(v.total) as total, v.fecha  FROM venta v inner join turno t on v.idturno=t.idturno  WHERE v.sucursal_id = 9 and v.lugar like 'Delivery' and v.fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' and t.nro = 2 GROUP by v.fecha;");
                    $sql_bajioDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 9 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_bajiorangoDelivery_pm = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 9 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 2;");
                    $sql_bajiorangoDelivery_am = $db->GetOne("SELECT sum( v.total) , v.fecha FROM venta v inner join turno t on v.idturno = t.idturno 
                    WHERE v.sucursal_id = 9 and v.lugar like 'Delivery' and v.fecha  BETWEEN '$fechaInicio' and '$fechaFin' and t.nro = 1;");
                    $sql_bajiorangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 9;");

                    $total = $db->GetAll("SELECT sum(total) AS total FROM venta WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin' and lugar like 'Delivery'  GROUP BY fecha");
                    $total_rango = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin  and lugar like 'Delivery'");

                    $total = $db->GetAll("SELECT sum(consumo) AS total FROM consumoelectrico WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha");
                    $total_rango = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin");
                }
                ?>
                <table id="tblventas" class="table table-striped table-hover table-bordered" width="100%">
                    <thead style="background-color: #FFCC79;">
                        <tr>
                            <th style="text-align: center; background-color: #F1A323;">Sucursal</th>
                            <th style="text-align: center;">Detalle</th>

                            <?php foreach ($fecha as $dato) { ?>
                                <th style="text-align: center;"><?= date('d/m/Y', strtotime($dato['fecha'])) ?></th>
                            <?php } ?>
                            <th style="font-size: 10px;">Total <?= date('d/m', strtotime($fechaInicio)) ?>a<?= date('d/m', strtotime($fechaFin)) ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Paragua</td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_paraguaDelivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_paraguaDelivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_paraguarangoDelivery_am, 2, ',', '.')  ?> Bs. </td>
                        </tr>
                        <tr>
                            <!-- MODIFICAR AQUI  -->
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_paraguaDelivery_pm == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_paraguaDelivery_pm as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_paraguarangoDelivery_pm, 2, ',', '.')  ?> Bs. </td>
                        </tr>
                        <tr>
                            <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_paraguaDelivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_paraguaDelivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_paraguarangoDelivery, 2, ',', '.')  ?> Bs. </td>
                        </tr>
                        <tr>

                        </tr>
                        </tr>

                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">3 Pasos </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_3pasosDelivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_3pasosDelivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_3pasosrangoDelivery_am, 2, ',', '.')  ?> Bs. </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_3pasosDelivery_pm == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_3pasosDelivery_pm as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_3pasosrangoDelivery_pm, 2, ',', '.')  ?> Bs. </td>
                        </tr>
                        <tr>
                            <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_3pasosDelivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_3pasosDelivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_3pasosrangoDelivery, 2, ',', '.')  ?> Bs. </td>
                        </tr>
                        <tr>
                        </tr>
                        </tr>

                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Boulevar </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_boulevarDelivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_boulevarDelivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_boulevarrangoDelivery_am, 2, ',', '.')  ?> Bs. </td>
                        </tr>
                        <tr>
                            <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_boulevarDelivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_boulevarDelivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_boulevarrangoDelivery, 2, ',', '.')  ?> Bs. </td>
                        </tr>
                        <tr>
                        </tr>
                        </tr>

                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Palmas </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_palmasDelivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_palmasDelivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_palmasrangoDelivery_am, 2, ',', '.')  ?> Bs. </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_palmasDelivery_pm == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_palmasDelivery_pm as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_palmasrangoDelivery_pm, 2, ',', '.')  ?> Bs. </td>
                        </tr>
                        <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_palmasDelivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_palmasDelivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_palmasrangoDelivery, 2, ',', '.')  ?> Bs. </td>
                        <tr>
                        </tr>
                        </tr>
                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Cine Center </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_CineDelivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_CineDelivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_cinerangoDelivery_am, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_CineDelivery_pm == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_CineDelivery_pm as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_cinerangoDelivery_pm, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                            <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_CineDelivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_CineDelivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_CinerangoDelivery, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                        </tr>
                        </tr>
                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;"> Mutualista </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_mutualistaDelivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_mutualistaDelivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_mutualistarangoDelivery_am, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_mutualistaDelivery_pm == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_mutualistaDelivery_pm as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_mutualistarangoDelivery_pm, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                            <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_mutualistaDelivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_mutualistaDelivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_mutualistarangoDelivery, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                        </tr>
                        </tr>
                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;"> Pampa </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_pampaDelivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_pampaDelivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_pamparangoDelivery_am, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_pampaDelivery_pm == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_pampaDelivery_pm as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_pamparangoDelivery_pm, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                            <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_pampaDelivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_pampaDelivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_pamparangoDelivery, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                        </tr>
                        </tr>
                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;"> Plan 3000 </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_plan3000Delivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_plan3000Delivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_planrangoDelivery_am, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                            <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_planDelivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_planDelivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_planrangoDelivery, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                        </tr>
                        </tr>
                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;"> Radial 26 </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_radialDelivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_radialDelivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_radialrangoDelivery_am, 2, ',', '.')  ?> Bs. </td>


                        </tr>                       
                        <tr>
                            <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_radialDelivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_radialDelivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_radialrangoDelivery, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                        </tr>
                        </tr>
                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;"> Roca </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_rocaDelivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_rocaDelivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_rocarangoDelivery_am, 2, ',', '.')  ?> Bs. </td>


                        </tr> 
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_rocaDelivery_pm == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_rocaDelivery_pm as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_rocarangoDelivery_pm, 2, ',', '.')  ?> Bs. </td>


                        </tr> 
                        <tr>
                            <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_rocaDelivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_rocaDelivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_rocarangoDelivery, 2, ',', '.')  ?> Bs. </td>


                        </tr> 
                        <tr>
                        </tr>
                        </tr>

                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;"> Sur </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_surDelivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_surDelivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_surrangoDelivery_am, 2, ',', '.')  ?> Bs. </td>


                        </tr> 
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_surDelivery_pm == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_surDelivery_pm as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_surrangoDelivery_pm, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                            <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_surDelivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_surDelivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_surrangoDelivery, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                        </tr>
                        </tr>
                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;"> Villa </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_villa1Delivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_villa1Delivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_villa1rangoDelivery_am, 2, ',', '.')  ?> Bs. </td>


                        </tr> 
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_villa1Delivery_pm == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_villa1Delivery_pm as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_villa1rangoDelivery_pm, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                            <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_villa1Delivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_villa1Delivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_villa1rangoDelivery, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                        </tr>
                        </tr>
                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;"> QdeliVilla </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_villa2Delivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_villa2Delivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_villa2rangoDelivery_am, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_villa2Delivery_pm == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_villa2Delivery_pm as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_villa2rangoDelivery_pm, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                            <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_villa2qdeliDelivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_villa2qdeliDelivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_villa2qdelirangoDelivery, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                        </tr>
                        </tr>
                        <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;"> Bajio </td>
                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">AM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_bajioDelivery_am == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_bajioDelivery_am as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_bajiorangoDelivery_am, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                            <td style="background-color: #D9EDFC;">PM</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_bajioDelivery_pm == null) {
                                    echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_bajioDelivery_pm as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #D9EDFC;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #D9EDFC;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_bajiorangoDelivery_pm, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                            <td style="background-color: #81d4fa;">Total</td>
                            <?php
                            foreach ($fecha as $f) {
                                if ($sql_bajioDelivery == null) {
                                    echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                } else {
                                    $sw = false;
                                    foreach ($sql_bajioDelivery as $dato) {
                                        if ($dato["fecha"] == $f["fecha"] && number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) {
                                            $sw = true;
                                            echo '<td style="background-color: #81d4fa;">' . number_format($dato['total'], 2, ',', '.') . 'Bs' . '</td>';
                                        }
                            ?>
                            <?php }
                                    if ($sw == false) {
                                        echo '<td style="background-color: #81d4fa;">' . '0.00' . '</td>';
                                    }
                                }
                            } ?>
                            <td style="background-color: #81d4fa;"><?= number_format($sql_bajiorangoDelivery, 2, ',', '.')  ?> Bs. </td>


                        </tr>
                        <tr>
                        </tr>
                        </tr>


                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" style="background-color: #FFCC79;">
                                <h5>Total</h5>
                            </td>
                            <?php foreach ($total as $dato) { ?>
                                <td style="background-color: #FFCC79;">
                                    <h5> Bs. <?= number_format($dato['total'], 2, ',', '.') ?></h5>
                                </td>
                            <?php } ?>
                            <td style="background-color: #FFCC79;"> <?= number_format($total_rango, 2, ',', '.')  ?> Bs. </td>
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
            link.download = "delivery.xls";
            link.href = uri + base64(format(template, ctx))
            link.click();
        }
    </script>
</body>

</html>