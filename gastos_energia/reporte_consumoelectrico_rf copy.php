<html>

<head>
    <title>Listado de ventas Fechas</title>
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
            <h2>Reporte de consumo electrico por Fechas </h2>
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
                <form action="reporte_consumoelectrico_rf.php" method="POST">
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
                    $dia_anterior_inicio = date("Y-m-d",strtotime($fechaInicio." -1 days")); 
                    $dia_anterior_fin = date("Y-m-d",strtotime($fechaFin." -1 days")); 
    
                    $fecha = $db->GetAll("SELECT fecha FROM consumoelectrico WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha");
                    
                    $sql_bodegaprincipalconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 1 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_bodegaprincipalcosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 1 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_bodegaprincipalrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 1  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_bodegaprincipalrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 1  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_bodegaprincialdiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 1   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 1    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 1 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_bodegaprincipalrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 1   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 1    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
                    
                    $sql_surconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 2 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_surcosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 2 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_surrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 2  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_surrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 2  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_surdiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 2   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 2    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 2 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_surrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 2  group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 2    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
                    
                    $sql_trespasosconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 5 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_trespasoscosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 5 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_trespasosrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 5  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_trespasosrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 5  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_trespasosdiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 5   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 5    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 5 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_trespasosrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 5   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 5    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
                    
                    $sql_pampaconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 6 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_pampacosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 6 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_pamparangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 6  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_pamparangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 6  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_pampadiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 6   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 6    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 6 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_pamparangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 6   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 6    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
                    
                    $sql_radial26consumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 7 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_radial26costo = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 7 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_radial26rangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 7  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_radial26rangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 7  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_radial26diferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 7  group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 7    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 7 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_radial26rangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 7   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 7    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
                    

                    $sql_qdelivillaconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 8 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_qdelivillacosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 8 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_qdelivillarangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 8   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_qdelivillarangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 8  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_qdelivilladiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 8   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 8    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 8 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_qdelivillarangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 8   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 8    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_bajioconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 9 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_bajiocosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 9 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_bajiorangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 9   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_bajiorangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 9  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_bajiodiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 9   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 9    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 9 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_bajiorangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 9  group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 9     GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_arenalconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 10 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_arenalcosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 10 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_arenalrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 10   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_arenalrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 10  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_arenaldiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 10   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 10    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 10 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_arenalrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 10   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 10    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
            
                    $sql_plan3000consumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 11 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_plan3000costo = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 11 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_plan3000rangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 11   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_plan3000rangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 11  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_plan3000diferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 11   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 11   GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 11 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_plan3000rangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 11   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 11    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_villaconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 13 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_villacosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 13 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_villarangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 13   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_villarangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 13  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_villadiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 13   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 13    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 13 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_villarangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 13   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 13    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_cinecenterconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 15 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_cinecentercosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 15 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_cinecenterrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 15   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_cinecenterrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 15  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_cinecenterdiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 15   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 15    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 15 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_cinecenterrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 15   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 15    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
                    
                    $sql_mutualistaconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 14 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_mutualistacosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 14 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_mutualistarangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 14   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_mutualistarangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 14  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_mutualistadiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 14   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 14   GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 14 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_mutualistarangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 14   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 14    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_boulevarconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 16 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_boulevarcosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 16 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_boulevarrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 16   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_boulevarrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 16  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_boulevardiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 16   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 16    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 16 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_boulevarrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 16   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 16    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_rocaconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 12 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_rocacosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 12 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_rocarangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 12   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_rocarangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 12  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_rocadiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 12   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 12    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 12 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_rocarangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 12   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 12    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_palmasconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 4 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_palmascosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 4 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_palmasrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 4   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_palmasrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 4  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_palmasdiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 4   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 4    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 4 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_palmasrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 4   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 4    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_paraguaconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 3 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_paraguacosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 3 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_paraguarangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 3   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_paraguarangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 3  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_paraguadiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 3   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 3    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 3 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_paraguarangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 3   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 3    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $total = $db->GetAll("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce     GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $total_rango = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce     GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                        where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        ORDER BY `cee`.`fecha`  ASC;");   
                    
                } else{

                    $fechaInicio = date('d-m-Y');
                    $fechaFin    = date('d-m-Y');

                    $fecha = $db->GetAll("SELECT fecha FROM consumoelectrico WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha"); 

                    $sql_bodegaprincipalconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 1 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_bodegaprincipalcosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 1 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_bodegaprincipalrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 1  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_bodegaprincipalrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 1  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_bodegaprincialdiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 1   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 1    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 1 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_bodegaprincipalrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 1   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 1    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
                    
                    $sql_surconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 2 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_surcosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 2 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_surrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 2  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_surrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 2  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_surdiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 2   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 2    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 2 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_surrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 2  group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 2    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
                    
                    $sql_trespasosconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 5 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_trespasoscosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 5 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_trespasosrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 5  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_trespasosrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 5  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_trespasosdiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 5   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 5    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 5 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_trespasosrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 5   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 5    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
                    
                    $sql_pampaconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 6 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_pampacosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 6 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_pamparangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 6  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_pamparangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 6  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_pampadiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 6   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 6    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 6 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_pamparangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 6   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 6    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
                    
                    $sql_radial26consumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 7 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_radial26costo = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 7 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_radial26rangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 7  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_radial26rangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 7  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_radial26diferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 7  group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 7    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 7 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_radial26rangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 7   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 7    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
                    

                    $sql_qdelivillaconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 8 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_qdelivillacosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 8 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_qdelivillarangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 8   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_qdelivillarangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 8  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_qdelivilladiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 8   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 8    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 8 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_qdelivillarangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 8   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 8    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_bajioconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 9 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_bajiocosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 9 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_bajiorangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 9   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_bajiorangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 9  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_bajiodiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 9   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 9    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 9 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_bajiorangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 9  group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 9     GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_arenalconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 10 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_arenalcosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 10 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_arenalrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 10   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_arenalrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 10  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_arenaldiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 10   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 10    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 10 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_arenalrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 10   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 10    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
            
                    $sql_plan3000consumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 11 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_plan3000costo = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 11 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_plan3000rangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 11   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_plan3000rangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 11  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_plan3000diferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 11   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 11   GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 11 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_plan3000rangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 11   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 11    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_villaconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 13 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_villacosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 13 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_villarangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 13   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_villarangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 13  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_villadiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 13   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 13    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 13 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_villarangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 13   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 13    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_cinecenterconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 15 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_cinecentercosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 15 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_cinecenterrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 15   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_cinecenterrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 15  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_cinecenterdiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 15   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 15    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 15 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_cinecenterrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 15   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 15    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");
                    
                    $sql_mutualistaconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 14 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_mutualistacosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 14 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_mutualistarangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 14   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_mutualistarangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 14  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_mutualistadiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 14   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 14   GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 14 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_mutualistarangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 14   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 14    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_boulevarconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 16 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_boulevarcosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 16 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_boulevarrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 16   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_boulevarrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 16  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_boulevardiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 16   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 16    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 16 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_boulevarrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 16   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 16    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_rocaconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 12 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_rocacosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 12 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_rocarangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 12   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_rocarangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 12  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_rocadiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 12   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 12    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 12 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_rocarangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 12   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 12    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_palmasconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 4 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_palmascosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 4 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_palmasrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 4   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_palmasrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 4  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_palmasdiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 4   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 4    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 4 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_palmasrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 4   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 4    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $sql_paraguaconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 3 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_paraguacosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 3 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_paraguarangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 3   AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_paraguarangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 3  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_paraguadiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 3   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 3    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 3 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_paraguarangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 3   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 3    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    ORDER BY `cee`.`fecha`  ASC;");

                    $total = $db->GetAll("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce     GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $total_rango = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce     GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                        where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        ORDER BY `cee`.`fecha`  ASC;");       
                }
                ?>
                <table id="tblventas" class="table table-striped table-hover table-bordered" width="100%">
                    <thead style="background-color: #FFCC79;">
                        <tr>
                            <th style="text-align: center; background-color: #F1A323;">Sucursal</th>
                            <th style="text-align: center;">Detalle</th>
                            <?php foreach ($fecha as $dato) { ?>
                                <?php
                                $fech = $dato['fecha'];
                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 1 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '1', '0')"); 

                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 2 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '2', '0')"); 
                                    
                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 5 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '5', '0')"); 

                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 6 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '6', '0')"); 

                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 7 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '7', '0')"); 

                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 8 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '8', '0')"); 

                                    
                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 9 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '9', '0')"); 

                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 10 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '10', '0')"); 

                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 11 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '11', '0')"); 

                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 13 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '13', '0')"); 

                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 15 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '15', '0')"); 

                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 14 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '14', '0')"); 

                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 16 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '16', '0')"); 

                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 12 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '12', '0')"); 
                                    
                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 4 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '4', '0')"); 

                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 3 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '3', '0')");      
                             ?>    
                                <th style="text-align: center;"><?= date('d/m/Y', strtotime($dato['fecha'])) ?></th>
                            <?php } ?>
                            <th style="font-size: 10px;">Total <?= date('d/m', strtotime($fechaInicio)) ?>a<?= date('d/m', strtotime($fechaFin)) ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Bodega Principal</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_bodegaprincipalconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_bodegaprincipalrangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_bodegaprincipalcosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_bodegaprincipalrangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_bodegaprincialdiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;" class="total"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_bodegaprincipalrangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                    </tr>
                    <!-- Sucursal sur -->
                    <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal Sur</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_surconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;" style="color: #ff3d00"><?= number_format($sql_surrangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_surcosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_surrangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_surdiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_surrangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                    </tr>

                <!-- Sucursal trespasos -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal tres pasos</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_trespasosconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_trespasosrangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_trespasoscosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_trespasosrangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_trespasosdiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_trespasosrangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>
                
                <!-- Sucursal pampa -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal pampa</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_pampaconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_pamparangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_pampacosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_pamparangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_pampadiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_pamparangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>
                <!-- Sucursal radial 26 -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal Radial 26</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_radial26consumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_radial26rangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_radial26costo as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_radial26rangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_radial26diferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_radial26rangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>
                <!-- Sucursal qdeli villa -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal Qdeli Villa</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_qdelivillaconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_qdelivillarangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_qdelivillacosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_qdelivillarangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_qdelivilladiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_qdelivillarangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>
                <!-- Sucursal bajio -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal Bajio</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_bajioconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_bajiorangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_bajiocosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_bajiorangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_bajiodiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_bajiorangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>

                <!-- Sucursal arenal -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal Arenal</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_arenalconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_arenalrangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_arenalcosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_arenalrangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_arenaldiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_arenalrangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>

                <!-- Sucursal plan3000 -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal Plan 3000</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_plan3000consumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_plan3000rangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_plan3000costo as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_plan3000rangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_plan3000diferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_plan3000rangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>
                <!-- Sucursal villa -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal Villa</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_villaconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_villarangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_villacosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_villarangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_villadiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_villarangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>  
                <!-- Sucursal cine center -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal Cine center</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_cinecenterconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_cinecenterrangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_cinecentercosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_cinecenterrangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_cinecenterdiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_cinecenterrangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>
                <!-- Sucursal mutualista -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal Mutualista</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_mutualistaconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_mutualistarangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_mutualistacosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_mutualistarangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_mutualistadiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_mutualistarangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>
                <!-- Sucursal Boulevar -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal Boulevar</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_boulevarconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_boulevarrangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_boulevarcosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_boulevarrangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_boulevardiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_boulevarrangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>                   
                
                <!-- Sucursal Roca -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal Roca</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_rocaconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_rocarangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_rocacosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_rocarangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_rocadiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_rocarangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>

                <!-- Sucursal Palmas -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal Palmas</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_palmasconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_palmasrangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_palmascosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_palmasrangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_palmasdiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_palmasrangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>

                <!-- Sucursal Paragua -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Sucursal Paragua</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Lecturación</td>
                                <?php foreach ($sql_paraguaconsumo as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> KW </td>
                                    <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00 </td>
                                <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_paraguarangoconsumo, 2, ',', '.' )  ?> KW </td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Costo</td>
                            <?php foreach ($sql_paraguacosto as $dato) { ?>   
                            <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>        
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_paraguarangocosto, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                        <td style="background-color: #81d4fa;">Diferencia dia anterior</td>
                            <?php foreach ($sql_paraguadiferencia as $dato) { ?>   
                            <?php 
                                if (number_format($dato['diferencia'], 2) != 0 && number_format($dato['diferencia'], 2) != null) { ?>        
                                        <td style="background-color: #81d4fa;"><?= number_format($dato['diferencia'], 2, ',', '.')  ?> KW. </td>            
                                <?php } else { ?>
                                        <td style="background-color: #81d4fa;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="background-color: #81d4fa;"><?= number_format($sql_paraguarangodiferencia, 2, ',', '.' )  ?> KW. </td>
                        </tr>
                </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" style="text-align: center; background-color: #FFCC79;">
                                <h5>Total</h5>
                            </td>
                            <?php foreach ($total as $dato) { ?>
                                <td style="background-color: #FFCC79;">
                                    <h5><?= number_format($dato['diferencia'], 2, ',', '.')?></h5>
                                </td>
                            <?php } ?>
                            <td style="background-color: #FFCC79;"> <h5> <?= number_format($total_rango, 2, ',', '.')  ?> </h5></td>
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
            link.download = "consumoelectrico.xls";
            link.href = uri + base64(format(template, ctx))
            link.click();
        }
    </script>
    <style>
        .total{
            color: "#ff3d00";
            background-color: "#D9EDFC";
        }
    </style>
</body>

</html>