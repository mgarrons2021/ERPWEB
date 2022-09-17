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
                    
                    $sql_bodegaprincipalconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 20 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_bodegaprincipalcosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 20 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_bodegaprincipalrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 20  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_bodegaprincipalrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 20  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_bodegaprincialdiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 20   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 20  GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 20 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_bodegaprincipalrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 20   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 20    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
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

                    $sql_bodegaprincipalconsumo = $db->GetAll("SELECT sum(consumo) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 20 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_bodegaprincipalcosto = $db->GetAll("SELECT sum(consumo*1.66) AS total, fecha FROM consumoelectrico WHERE sucursal_id = 20 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' GROUP BY fecha;");
                    $sql_bodegaprincipalrangoconsumo = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE sucursal_id = 20  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin';");
                    $sql_bodegaprincipalrangocosto = $db->GetOne(" SELECT sum(consumo*1.66) AS total FROM consumoelectrico WHERE sucursal_id = 20  AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'");
                    $sql_bodegaprincialdiferencia = $db->GetAll("SELECT cee.id, cee.fecha, ce2.fechare, ce.consumo1, ce2.consumo1, IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        )  as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 20   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 20   GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
                    where cee.fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 20 group by cee.fecha  
                    ORDER BY `cee`.`fecha`  ASC;");
                    $sql_bodegaprincipalrangodiferencia = $db->GetOne("SELECT  sum(  IF(
                        (ce2.consumo1 - ce.consumo1) < 0,
                        (-(ce2.consumo1 - ce.consumo1) ), (ce2.consumo1 - ce.consumo1 )
                        ) ) as diferencia from consumoelectrico cee left join
                        (SELECT id, fecha, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 20   group by fecha) as ce on cee.id = ce.id  left join (SELECT id, 
                        fecha + interval 1 day as fechare, sum(consumo)as consumo1 FROM consumoelectrico ce WHERE sucursal_id = 20    GROUP BY fecha) as ce2 on ce2.fechare  = ce.fecha
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
                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 20 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '1', '0')"); 

                                    
                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 8 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '8', '0')"); 

                                    
                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 9 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '9', '0')"); 

                                    $eliminar= $db->execute("delete from consumoelectrico where fecha= '$fech' and sucursal_id = 10 and consumo = 0");
                                    $rellenar=$db->execute("INSERT INTO `consumoelectrico` (`id`, `nro`, `fecha`, `hora`, `consumo`, `sucursal_id`, `usuario_id`) 
                                    VALUES (NULL, '0', '$fech', '00:00:00', '0', '10', '0')"); 

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
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">OFICINA</td>
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
                   
                <!-- Sucursal qdeli villa -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">SUC. VILLA 2</td>
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
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">SUC. BAJIO</td>
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
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">SUC. ARENAL</td>
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
                
                <!-- Sucursal Paragua -->
                <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">SUC. PARAGUA</td>
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