<html>

<head>
    <title>Reporte Registro LLegada Produccion </title>
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
            <h2>Registro de recepcion de produccion por sucursal</h2>
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
                <form action="reporte_llegada_produccion.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                                <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" value="<?php if (isset($_POST['fechaini'])) {                                                                                      } ?>" />
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
                    $fecha = $db->GetAll("SELECT fecha FROM registro_taxi WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha;");                   
                
                    $sql_CDP = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as CDP, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 19 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha order by fecha;");
                    $sql_Roca = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 12 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha order by fecha;");
                    $diferenciaroca_cdp = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 12 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha order by fecha
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 19 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha order by fecha
                        )
                        t2
                    where t1.fecha = t2.fecha;");
                    
                    $sql_Palmas = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 4 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha order by fecha;");

                    $diferenciapalmas_roca = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 4 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha order by fecha
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 12 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha order by fecha 
                        )
                        t2
                    where t1.fecha = t2.fecha;");
                    

                    $sql_Sur = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 2 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha order by fecha;");

                    $diferenciasur_palmas = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 2 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha order by fecha
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 4 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha order by fecha
                        )
                        t2
                    where t1.fecha = t2.fecha;");

                    $sql_Cine = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 15 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha order by fecha;");
                    $sql_Boulevar = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 16 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha order by fecha;");
                    $sql_Arenal = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 10 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha order by fecha;");

                    $diferenciaarenal_boulevar = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 10 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha order by fecha
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 16 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha order by fecha 
                        )
                        t2
                    where t1.fecha = t2.fecha;");


                    $sql_Mutualista = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 14 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha order by fecha;");

                    $diferenciamutualista_arenal = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 14 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha order by fecha 
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 10 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha order by fecha
                        )
                        t2
                    where t1.fecha = t2.fecha;");

                    $sql_Paragua = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 3 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha order by fecha;");

                    $diferenciaparagua_mutualista = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 3 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha order by fecha
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 14 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha order by fecha
                        )
                        t2
                    where t1.fecha = t2.fecha;");


                    $sql_Pampa = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 6 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha order by fecha;");

                    $diferenciapampa_paragua = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 6 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha order by fecha
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 3 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha order by fecha
                        )
                        t2
                    where t1.fecha = t2.fecha;");



                    $sql_3Pasos = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 5 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha order by fecha;");

                    $diferenciacinecenter_3pasos = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 15 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha order by fecha
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 5 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha order by fecha
                        )
                        t2
                    where t1.fecha = t2.fecha;");

                    $sql_Villa = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 13 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha order by fecha;");
                    $diferenciavilla_3pasos = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 13 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha order by fecha
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 5 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha order by fecha
                        )
                        t2
                    where t1.fecha = t2.fecha;");

                    $sql_Plan3000 = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 11 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha order by fecha;"); 

                    $diferenciaplan3000_villa = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 11 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha order by fecha
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 13 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha order by fecha
                        )
                        t2
                    where t1.fecha = t2.fecha;");
                                        
                } else{

                    $fechaInicio = date('d-m-Y');
                    $fechaFin    = date('d-m-Y');

                    $fecha = $db->GetAll("SELECT fecha FROM registro_taxi WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha;");                   
                
                    $sql_CDP = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as CDP, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 19 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha;");
                    $sql_Roca = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 12 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha;");
                    $diferenciaroca_cdp = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 12 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha 
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 19 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha 
                        )
                        t2
                    where t1.fecha = t2.fecha;");
                    
                    $sql_Palmas = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 4 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha;");

                    $diferenciapalmas_roca = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 4 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha 
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 12 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha 
                        )
                        t2
                    where t1.fecha = t2.fecha;");
                    

                    $sql_Sur = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 2 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha;");

                    $diferenciasur_palmas = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 2 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha 
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 4 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha 
                        )
                        t2
                    where t1.fecha = t2.fecha;");

                    $sql_Cine = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 15 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha;");
                    $sql_Boulevar = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 16 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha;");
                    $sql_Arenal = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 10 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha;");

                    $diferenciaarenal_boulevar = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 10 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha 
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 16 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha 
                        )
                        t2
                    where t1.fecha = t2.fecha;");


                    $sql_Mutualista = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 14 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha;");

                    $diferenciamutualista_arenal = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 14 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha 
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 10 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha 
                        )
                        t2
                    where t1.fecha = t2.fecha;");

                    $sql_Paragua = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 3 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha;");

                    $diferenciaparagua_mutualista = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 3 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha 
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 14 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha 
                        )
                        t2
                    where t1.fecha = t2.fecha;");


                    $sql_Pampa = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 6 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha;");

                    $diferenciapampa_paragua = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 6 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha 
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 3 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha 
                        )
                        t2
                    where t1.fecha = t2.fecha;");



                    $sql_3Pasos = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 5 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha;");

                    $diferenciacinecenter_3pasos = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 15 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha 
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 5 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha 
                        )
                        t2
                    where t1.fecha = t2.fecha;");

                    $sql_Villa = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 13 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha;");
                    $diferenciavilla_3pasos = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 13 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha 
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 5 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha 
                        )
                        t2
                    where t1.fecha = t2.fecha;");

                    $sql_Plan3000 = $db->GetAll("SELECT TIME_FORMAT(sum(hora), '%T') as hora, sum(cantidad_bolsas) as cantidad  FROM registro_taxi WHERE sucursal_id = 11 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                    GROUP by fecha;"); 

                    $diferenciaplan3000_villa = $db->GetAll("SELECT t1.hora2, t2.hora1   
                    FROM 
                    (
                        SELECT  TIME_FORMAT(sum(hora), '%T') as hora2 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 11 and fecha BETWEEN '$fechaInicio' and '$fechaFin' 
                        GROUP by fecha 
                    
                    )t1 ,
                        (SELECT  TIME_FORMAT(sum(hora), '%T') as hora1 , fecha FROM registro_taxi 
                        WHERE sucursal_id = 13 and fecha BETWEEN '$fechaInicio' and '$fechaFin'
                        GROUP by fecha 
                        )
                        t2
                    where t1.fecha = t2.fecha;");  
                }
                ?>
                <table id="tblventas" class="table  table-bordered" width="100%">
                    <thead style="background-color: #FFCC79;">
                        <tr>
                            <th style="text-align: center; background-color: #F1A323;">Sucursal</th>
                            <th style="text-align: center;">Detalle</th>
                            <?php foreach ($fecha as $dato) { ?>    
                                <?php
                                $limite = 1;
                                $fech = $dato['fecha'];
                                if($limite=1){ 
                                $eliminar= $db->execute("delete from registro_taxi where fecha= '$fech' and sucursal_id = 19 and cantidad_bolsas = 0");
                                $rellenar=$db->execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`, `taxi_id`, `cantidad_bolsas`) VALUES 
                                (NULL, '$fech', '00:00:00', '19', '0', '0', '0')"); 
                            
                            
                            
                                $fech = $dato['fecha']; 
                                $eliminar= $db->execute("delete from registro_taxi where fecha= '$fech' and sucursal_id = 12 and cantidad_bolsas = 0");
                                $rellenar=$db->execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`, `taxi_id`, `cantidad_bolsas`) VALUES 
                                (NULL, '$fech', '00:00:00', '12', '0', '0', '0')"); 
                            
                            
                                $fech = $dato['fecha']; 
                                $eliminar= $db->execute("delete from registro_taxi where fecha= '$fech' and sucursal_id = 4 and cantidad_bolsas = 0");
                                $rellenar=$db->execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`, `taxi_id`, `cantidad_bolsas`) VALUES 
                                (NULL, '$fech', '00:00:00', '4', '0', '0', '0')"); 


                                $fech = $dato['fecha'];
                                $eliminar= $db->execute("delete from registro_taxi where fecha= '$fech' and sucursal_id = 2 and cantidad_bolsas = 0");
                                $rellenar=$db->execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`, `taxi_id`, `cantidad_bolsas`) VALUES 
                                (NULL, '$fech', '00:00:00', '2', '0', '0', '0')"); 


                                $fech = $dato['fecha'];
                                $eliminar= $db->execute("delete from registro_taxi where fecha= '$fech' and sucursal_id = 15 and cantidad_bolsas = 0");
                                $rellenar=$db->execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`, `taxi_id`, `cantidad_bolsas`) VALUES 
                                (NULL, '$fech', '00:00:00', '15', '0', '0', '0')"); 
                            
                                
                                $fech = $dato['fecha']; 
                                $eliminar= $db->execute("delete from registro_taxi where fecha= '$fech' and sucursal_id = 16 and cantidad_bolsas = 0");
                                $rellenar=$db->execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`, `taxi_id`, `cantidad_bolsas`) VALUES 
                                (NULL, '$fech', '00:00:00', '16', '0', '0', '0')"); 
                

                                $fech = $dato['fecha']; 
                                $eliminar= $db->execute("delete from registro_taxi where fecha= '$fech' and sucursal_id = 10 and cantidad_bolsas = 0");
                                $rellenar=$db->execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`, `taxi_id`, `cantidad_bolsas`) VALUES 
                                (NULL, '$fech', '00:00:00', '10', '0', '0', '0')");                                    


                                $fech = $dato['fecha']; 
                                $eliminar= $db->execute("delete from registro_taxi where fecha= '$fech' and sucursal_id = 14 and cantidad_bolsas = 0");
                                $rellenar=$db->execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`, `taxi_id`, `cantidad_bolsas`) VALUES 
                                (NULL, '$fech', '00:00:00', '14', '0', '0', '0')");  

    
                                $fech = $dato['fecha']; 
                                $eliminar= $db->execute("delete from registro_taxi where fecha= '$fech' and sucursal_id = 3 and cantidad_bolsas = 0");
                                $rellenar=$db->execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`, `taxi_id`, `cantidad_bolsas`) VALUES 
                                (NULL, '$fech', '00:00:00', '3', '0', '0', '0')");  
                

                                $fech = $dato['fecha']; 
                                $eliminar= $db->execute("delete from registro_taxi where fecha= '$fech' and sucursal_id = 6 and cantidad_bolsas = 0");
                                $rellenar=$db->execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`, `taxi_id`, `cantidad_bolsas`) VALUES 
                                (NULL, '$fech', '00:00:00', '6', '0', '0', '0')");  
                            
                                
                                $fech = $dato['fecha']; 
                                $eliminar= $db->execute("delete from registro_taxi where fecha= '$fech' and sucursal_id = 5 and cantidad_bolsas = 0");
                                $rellenar=$db->execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`, `taxi_id`, `cantidad_bolsas`) VALUES 
                                (NULL, '$fech', '00:00:00', '5', '0', '0', '0')"); 
                                
                                
                                $fech = $dato['fecha']; 
                                $eliminar= $db->execute("delete from registro_taxi where fecha= '$fech' and sucursal_id = 13 and cantidad_bolsas = 0");
                                $rellenar=$db->execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`, `taxi_id`, `cantidad_bolsas`) VALUES 
                                (NULL, '$fech', '00:00:00', '13', '0', '0', '0')");  
                                
            
                                $fech = $dato['fecha']; 
                                $eliminar= $db->execute("delete from registro_taxi where fecha= '$fech' and sucursal_id = 11 and cantidad_bolsas = 0");
                                $rellenar=$db->execute("INSERT INTO `registro_taxi` (`id`, `fecha`, `hora`, `sucursal_id`, `CDP`, `taxi_id`, `cantidad_bolsas`) VALUES 
                                (NULL, '$fech', '00:00:00', '11', '0', '0', '0')"); 
                                
                            
                                $limite=0;
                                }?>

                                <th style="text-align: center;"><?= date('d/m/Y', strtotime($dato['fecha'])) ?></th>  
                            <?php } ?>
                    
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="movil">
                            <td></td>
                            <td  align="center" style="text-align: center;" > Movil 1 </td>
                        </tr>
                    <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">CDP</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Hora salida</td>
                                <?php foreach ($sql_CDP as $dato) { ?>
                                    <?php if ($dato['CDP'] != 0 && $dato['CDP'] != null) { ?>
                                        <td style="background-color: #D9EDFC;" text-align: center><?= $dato['CDP'] ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">00:00:00</td>
                                        <?php } ?>
                                <?php } ?>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Cantidad de bolsas enviadas</td>
                                <?php foreach ($sql_CDP as $dato) { ?>    
                                    <?php if ($dato['cantidad']!= 0 && $dato['cantidad'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['cantidad']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                <?php } ?>
                        </tr>
                        
                    </tr>
                    
                    <tr>
                    </tr>
                        
                    <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Roca</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Hora recepción</td>
                                <?php foreach ($sql_Roca as $dato) { ?> 
                                        <td style="background-color: #D9EDFC;"><?= $dato['hora']  ?>  </td>
                                <?php } ?>
                            
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Cantidad de bolsas</td>
                                <?php foreach ($sql_Roca as $dato) { ?> 
                                    <?php if ($dato['cantidad']!= 0 && $dato['cantidad'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['cantidad']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Diferencia CDP - Roca </td>

                            <?php foreach ($diferenciaroca_cdp as $dato){ 
                                    $horauno=new DateTime($dato['hora2']); 
                                    $hora2=new DateTime($dato['hora1']);                                       
                                    $intervalo = $horauno->diff($hora2); 
                                ?>             
                                <td style="background-color: #D9EDFC;"><?php echo $intervalo->format('%H Horas %i minutos').PHP_EOL; ?>  </td>
                                <?php } ?>
                        </tr>
                        
                        
                        <tr> 
                        </tr>
                            
                    </tr>
                </tr>
                
                <tr>
                    <tr>
                        <td rowspan="4" style="text-align: center;" style="width: 10px;">Palmas</td>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Hora recepción</td>
                            <?php foreach ($sql_Palmas as $dato) { ?> 
                                <?php if ($dato['hora']!= 0 && $dato['hora'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['hora']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Cantidad de bolsas</td>
                            <?php foreach ($sql_Palmas as $dato) { ?> 
                                <?php if ($dato['cantidad']!= 0 && $dato['cantidad'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['cantidad']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                            <td style="background-color: #D9EDFC;">Diferencia Roca - Palmas </td>
                            <?php foreach ($diferenciapalmas_roca as $dato){ 
                                    $horauno=new DateTime($dato['hora2']); 
                                    $hora2=new DateTime($dato['hora1']);                                       
                                    $intervalo = $horauno->diff($hora2); 
                                ?>             
                                <td style="background-color: #D9EDFC;"><?php echo $intervalo->format('%H Horas %i minutos').PHP_EOL; ?>  </td>
                                <?php } ?>
                        </tr>
                    <tr> 
                    </tr>
                    
                    </tr>
                </tr>    
                <tr>
                    <tr>
                        <td rowspan="4" style="text-align: center;" style="width: 10px;">Sur</td>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Hora recepción</td>
                            <?php foreach ($sql_Sur as $dato) { ?> 
                                <?php if ($dato['hora']!= 0 && $dato['hora'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['hora']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Cantidad de bolsas</td>
                            <?php foreach ($sql_Sur as $dato) { ?> 
                                <?php if ($dato['cantidad']!= 0 && $dato['cantidad'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['cantidad']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                            <td style="background-color: #D9EDFC;">Diferencia Palmas - Sur </td>
                            <?php foreach ($diferenciasur_palmas as $dato){ 
                                    $horauno=new DateTime($dato['hora2']); 
                                    $hora2=new DateTime($dato['hora1']);                                       
                                    $intervalo = $horauno->diff($hora2); 
                                ?>             
                                <td style="background-color: #D9EDFC;"><?php echo $intervalo->format('%H Horas %i minutos').PHP_EOL; ?>  </td>
                                <?php } ?>
                        </tr>
                    <tr> 
                    </tr>
                    
                    </tr>
                </tr>                             
                    <tr>
                            <td colspan="3" align="center"> Movil 2 </td>
                    </tr>
                        <tr> 
                        </tr>                           
                    </tr>
                    
             
                
                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Boulevar</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Hora recepción</td>
                            <?php foreach ($sql_Boulevar as $dato) { ?>    
                                <?php if ($dato['hora']!= 0 && $dato['hora'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['hora']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Cantidad de bolsas</td>
                                <?php foreach ($sql_Boulevar as $dato) { ?>    
                                    <?php if ($dato['cantidad']!= 0 && $dato['cantidad'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['cantidad']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                    <?php } ?>
                        </tr>
                        
                        <tr> 
                        </tr>                           
                    </tr>
                </tr>
                <tr>
                    <tr>
                        <td rowspan="4" style="text-align: center;" style="width: 10px;">Arenal</td>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Hora recepción</td>
                            <?php foreach ($sql_Arenal  as $dato) { ?> 
                                <?php if ($dato['hora']!= 0 && $dato['hora'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['hora']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Cantidad de bolsas</td>
                            <?php foreach ($sql_Arenal  as $dato) { ?> 
                                <?php if ($dato['cantidad']!= 0 && $dato['cantidad'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['cantidad']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                            <td style="background-color: #D9EDFC;">Diferencia Boulevar - Arenal </td>
                            <?php foreach ($diferenciaarenal_boulevar as $dato){ 
                                    $horauno=new DateTime($dato['hora2']); 
                                    $hora2=new DateTime($dato['hora1']);                                       
                                    $intervalo = $horauno->diff($hora2); 
                                ?>             
                                <td style="background-color: #D9EDFC;"><?php echo $intervalo->format('%H Horas %i minutos').PHP_EOL; ?>  </td>
                                <?php } ?>
                        </tr>
                    <tr> 
                    </tr>
                    
                    </tr>
                </tr>
                <tr>
                    <tr>
                        <td rowspan="4" style="text-align: center;" style="width: 10px;">Mutualista</td>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Hora recepción</td>
                            <?php foreach ($sql_Mutualista   as $dato) { ?> 
                                <?php if ($dato['hora']!= 0 && $dato['hora'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['hora']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Cantidad de bolsas</td>
                            <?php foreach ($sql_Mutualista  as $dato) { ?> 
                                <?php if ($dato['cantidad']!= 0 && $dato['cantidad'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['cantidad']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                            <td style="background-color: #D9EDFC;">Diferencia Arenal - Mutualista </td>
                            <?php foreach ($diferenciamutualista_arenal as $dato){ 
                                    $horauno=new DateTime($dato['hora2']); 
                                    $hora2=new DateTime($dato['hora1']);                                       
                                    $intervalo = $horauno->diff($hora2); 
                                ?>             
                                <td style="background-color: #D9EDFC;"><?php echo $intervalo->format('%H Horas %i minutos').PHP_EOL; ?>  </td>
                                <?php } ?>
                        </tr>
                    <tr> 
                    </tr>
                    
                    </tr>
                </tr>
                
                <tr>
                    <tr>
                        <td rowspan="4" style="text-align: center;" style="width: 10px;">Paragua</td>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Hora recepción</td>
                            <?php foreach ($sql_Paragua    as $dato) { ?> 
                                <?php if ($dato['hora']!= 0 && $dato['hora'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['hora']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Cantidad de bolsas</td>
                            <?php foreach ($sql_Paragua  as $dato) { ?> 
                                <?php if ($dato['cantidad']!= 0 && $dato['cantidad'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['cantidad']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                            <td style="background-color: #D9EDFC;">Diferencia Mutualista - Paragua </td>
                            <?php foreach ($diferenciaparagua_mutualista as $dato){ 
                                    $horauno=new DateTime($dato['hora2']); 
                                    $hora2=new DateTime($dato['hora1']);                                       
                                    $intervalo = $horauno->diff($hora2); 
                                ?>             
                                <td style="background-color: #D9EDFC;"><?php echo $intervalo->format('%H Horas %i minutos').PHP_EOL; ?>  </td>
                                <?php } ?>
                        </tr>
                    <tr> 
                    </tr>
                    
                    </tr>
                </tr>
                <tr>
                    <tr>
                        <td rowspan="4" style="text-align: center;" style="width: 10px;">Pampa</td>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Hora recepción</td>
                            <?php foreach ($sql_Pampa as $dato) { ?> 
                                <?php if ($dato['hora']!= 0 && $dato['hora'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['hora']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Cantidad de bolsas</td>
                            <?php foreach ($sql_Pampa as $dato) { ?> 
                                <?php if ($dato['cantidad']!= 0 && $dato['cantidad'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['cantidad']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                            <td style="background-color: #D9EDFC;">Diferencia  Paragua - Pampa </td>
                            <?php foreach ($diferenciapampa_paragua as $dato){ 
                                    $horauno=new DateTime($dato['hora2']); 
                                    $hora2=new DateTime($dato['hora1']);                                       
                                    $intervalo = $horauno->diff($hora2); 
                                ?>             
                                <td style="background-color: #D9EDFC;"><?php echo $intervalo->format('%H Horas %i minutos').PHP_EOL; ?>  </td>
                                <?php } ?>
                        </tr>
                    <tr> 
                    </tr>
                    
                    </tr>
                </tr>
                <tr>
                            <td colspan="3" align="center"> Movil 3 </td>
                    </tr>
                <tr>
                <tr>
                    <tr>
                        <td rowspan="3" style="text-align: center;" style="width: 10px;">Cine Center</td>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Hora recepción</td>
                            <?php foreach ($sql_Cine as $dato) { ?>    
                                <?php if ($dato['hora']!= 0 && $dato['hora'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?=   $dato['hora']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    
                    <tr> 
                        <td style="background-color: #D9EDFC;">Cantidad de bolsas</td>
                            <?php foreach ($sql_Cine as $dato) { ?>    
                                <?php if ($dato['cantidad']!= 0 && $dato['cantidad'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['cantidad']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr>
                        <td rowspan="4" style="text-align: center;" style="width: 10px;">3 Pasos</td>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Hora recepción</td>
                            <?php foreach ($sql_3Pasos as $dato) { ?> 
                                <?php if ($dato['hora']!= 0 && $dato['hora'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['hora']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Cantidad de bolsas</td>
                            <?php foreach ($sql_3Pasos as $dato) { ?> 
                                <?php if ($dato['cantidad']!= 0 && $dato['cantidad'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['cantidad']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                            <td style="background-color: #D9EDFC;">Diferencia  Cine - 3 Pasos </td>
                            <?php foreach ($diferenciacinecenter_3pasos as $dato){ 
                                    $horauno=new DateTime($dato['hora2']); 
                                    $hora2=new DateTime($dato['hora1']);                                       
                                    $intervalo = $horauno->diff($hora2); 
                                ?>             
                                <td style="background-color: #D9EDFC;"><?php echo $intervalo->format('%H Horas %i minutos').PHP_EOL; ?>  </td>
                                <?php } ?>
                        </tr>
                    <tr> 
                    </tr>
                    
                    </tr>
                    <tr>
                        <td rowspan="4" style="text-align: center;" style="width: 10px;"> Villa </td>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Hora recepción</td>
                            <?php foreach ($sql_Villa as $dato) { ?> 
                                <?php if ($dato['hora']!= 0 && $dato['hora'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['hora']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Cantidad de bolsas</td>
                            <?php foreach ($sql_Villa as $dato) { ?> 
                                <?php if ($dato['cantidad']!= 0 && $dato['cantidad'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['cantidad']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                            <td style="background-color: #D9EDFC;">Diferencia  3 Pasos - Villa </td>
                            <?php foreach ($diferenciavilla_3pasos as $dato){ 
                                    $horauno=new DateTime($dato['hora2']); 
                                    $hora2=new DateTime($dato['hora1']);                                       
                                    $intervalo = $horauno->diff($hora2);  
                                ?>             
                                <td style="background-color: #D9EDFC;"><?php echo $intervalo->format('%H Horas %i minutos').PHP_EOL; ?>  </td>
                                <?php } ?>
                        </tr>
                    <tr>
                    <tr>
                        <td rowspan="4" style="text-align: center;" style="width: 10px;"> Plan 3000 </td>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Hora recepción</td>
                            <?php foreach ($sql_Plan3000 as $dato) { ?> 
                                <?php if ($dato['hora']!= 0 && $dato['hora'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['hora']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                        <td style="background-color: #D9EDFC;">Cantidad de bolsas</td>
                            <?php foreach ($sql_Plan3000 as $dato) { ?> 
                                <?php if ($dato['cantidad']!= 0 && $dato['cantidad'] != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= $dato['cantidad']  ?>  </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                <?php } ?>
                    </tr>
                    <tr> 
                            <td style="background-color: #D9EDFC;">Diferencia  Villa - Plan 3000 </td>
                            <?php foreach ($diferenciaplan3000_villa as $dato){ 
                                    $horauno=new DateTime($dato['hora2']); 
                                    $hora2=new DateTime($dato['hora1']);                                       
                                    $intervalo = $horauno->diff($hora2); 
                                ?>             
                                <td style="background-color: #D9EDFC;"><?php echo $intervalo->format('%H Horas %i minutos').PHP_EOL; ?>  </td>
                                <?php } ?>
                        </tr>
                    <tr>
                    </tbody>
                    <tfoot>
                        
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
            link.download = "registro_llegada_produccion.xls";
            link.href = uri + base64(format(template, ctx))
            link.click();
        }
    </script>
    <style>
        .movil{
            width: 100%;
            align-content: center;
        }
    </style>
</body>
</html>