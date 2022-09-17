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
                    
                    function rellenar ($idsucursal) {

                    }
                   
                    $sql_paraguaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 3 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_paraguarangoDelivery = $db->GetOne("SELECT sum( total) , fecha FROM `venta` WHERE sucursal_id = 3 and lugar like 'Delivery' and fecha  BETWEEN '$fechaInicio' and '$fechaFin';");
                    
                    $sql_3pasosDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 5 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_3pasosrangoDelivery = $db->GetOne("SELECT DISTINCT total , fecha FROM `venta` WHERE sucursal_id = 5 and lugar like 'Delivery' and fecha  BETWEEN '$fechaInicio' and '$fechaFin';");
                    
                    $sql_boulevarDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 16 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_boulevarrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 16;");

                    $sql_laspalmasDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 4 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_laspalmasrangoDelivery = $db->GetOne("SELECT sum( total) , fecha FROM `venta` WHERE sucursal_id = 4 and lugar like 'Delivery' and fecha  BETWEEN '$fechaInicio' and '$fechaFin';");

                    $sql_megacineDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 15 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_megacinerangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 15;");

                    $sql_mutualistaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 14 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_mutualistarangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 14;");

                    $sql_pampaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 6 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_pamparangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 6;");

                    $sql_planDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 11 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_planrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 11;");

                    $sql_radialDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 7 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_radialrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 7;");

                    $sql_rocaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 12 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_rocarangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 12;");

                    $sql_surDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 2 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");  
                    $sql_surrangoDelivery = $db->GetOne(" SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 2 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin'");

                    $sql_villa1Delivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 13 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_villa1rangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 13;");

                    $sql_villa2qdeliDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 8 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_villa2qdelirangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 8;");
                    
                    $sql_arenalDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 10 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_arenalrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 10;");

                    $sql_bajioDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 9 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_bajiorangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 9;");

                    $total = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE  lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $total_rango = $db->GetOne("SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin';" );   
                    
                } else{

                    $fechaInicio = date('d-m-Y');
                    $fechaFin    = date('d-m-Y');

                    $fecha = $db->GetAll("SELECT fecha FROM venta WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha");
                   
                    $sql_paraguaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 3 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_paraguarangoDelivery = $db->GetOne("SELECT sum( total) , fecha FROM `venta` WHERE sucursal_id = 3 and lugar like 'Delivery' and fecha  BETWEEN '$fechaInicio' and '$fechaFin';");
                    
                    $sql_3pasosDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 5 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_3pasosrangoDelivery = $db->GetOne("SELECT DISTINCT total , fecha FROM `venta` WHERE sucursal_id = 5 and lugar like 'Delivery' and fecha  BETWEEN '$fechaInicio' and '$fechaFin';");
                    
                    $sql_boulevarDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 16 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_boulevarrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 16;");

                    $sql_laspalmasDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 4 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_laspalmasrangoDelivery = $db->GetOne("SELECT sum( total) , fecha FROM `venta` WHERE sucursal_id = 4 and lugar like 'Delivery' and fecha  BETWEEN '$fechaInicio' and '$fechaFin';");

                    $sql_megacineDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 15 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_megacinerangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 15;");

                    $sql_mutualistaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 14 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_mutualistarangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 14;");

                    $sql_pampaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 6 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_pamparangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 6;");

                    $sql_planDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 11 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_planrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 11;");

                    $sql_radialDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 7 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_radialrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 7;");

                    $sql_rocaDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 12 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_rocarangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 12;");

                    $sql_surDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 2 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");  
                    $sql_surrangoDelivery = $db->GetOne(" SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 2 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin'");

                    $sql_villa1Delivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 13 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_villa1rangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 13;");

                    $sql_villa2qdeliDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 8 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_villa2qdelirangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 8;");
                    
                    $sql_arenalDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 10 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_arenalrangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 10;");

                    $sql_bajioDelivery = $db->GetAll("SELECT DISTINCT sum(total) as total, fecha  FROM `venta` WHERE sucursal_id = 9 and lugar like 'Delivery' and fecha BETWEEN
                    '$fechaInicio' and '$fechaFin' GROUP by fecha;");
                    $sql_bajiorangoDelivery = $db->GetOne(" SELECT sum(Total) as total FROM `venta` WHERE lugar like 'Delivery' and fecha BETWEEN '$fechaInicio' and '$fechaFin' and sucursal_id = 9;");

                    $total = $db->GetAll("SELECT sum(total) AS total FROM venta WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin' and lugar like 'Delivery'  GROUP BY fecha");
                    $total_rango = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin  and lugar like 'Delivery'" );   
                    
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
                                
                                <?php
                                $limite = 1;
                               $fech = $dato['fecha'];
                               if($limite=1){ 
                                $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 3 and total = 0");
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '3', '0', '0', '');"); 
                              
                             
                               
                               $fech = $dato['fecha']; 
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 5 and total = 0");
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '5', '0', '0', '');"); 
                                   
                               
                               $fech = $dato['fecha']; 
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 16 and total = 0 ");
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '16', '0', '0', '');"); 


                             
                               $fech = $dato['fecha'];
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 4 and total = 0"); 
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '4', '0', '0', '');"); 
                                  
                                
                              
                               $fech = $dato['fecha']; 
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 15 and total = 0"); 
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '15', '0', '0', '');"); 
                                   
                                
                               $fech = $dato['fecha']; 
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 14 and total = 0");
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '14', '0', '0', '');"); 
                                  

                              
                               $fech = $dato['fecha']; 
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 6 and total = 0 ");
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '6', '0', '0', '');"); 
                                  

                                
                               $fech = $dato['fecha']; 
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 11 and total = 0 ");
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '11', '0', '0', '');"); 
                                  
                               
                               $fech = $dato['fecha']; 
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 7 and total = 0");
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '7', '0', '0', '');"); 
                               
                                
                               $fech = $dato['fecha']; 
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 12 and total = 0 ");
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '12', '0', '0', '');"); 
                                   
                                
                               $fech = $dato['fecha']; 
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 2 and total = 0 ");
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '2', '0', '0', '');"); 
                                   
                               
                               $fech = $dato['fecha']; 
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 13 and total = 0");
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '13', '0', '0', '');"); 
                                   
                               $fech = $dato['fecha']; 
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 8 and total = 0 ");
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '8', '0', '0', '');"); 
                                  
                              
                               $fech = $dato['fecha']; 
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 10 and total = 0 ");
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '10', '0', '0', '');"); 

                               

                              
                               $fech = $dato['fecha']; 
                               $eliminar= $db->execute("delete from venta where fecha= '$fech' and sucursal_id = 9 and total = 0 ");
                               $rellenar=$db->execute("INSERT INTO `venta` (`idventa`, `nro_factura`, `nro`, 
                               `fecha`, `hora`, `total`, `lugar`, 
                               `pago`, `turno`, `idturno`, `estado`, `cod_control`, 
                               `cliente_id`, `usuario_id`, `sucursal_id`, `inventario_id`, `autorizacion_id`, 
                               `qr`) VALUES (NULL, '0', '0', '$fech' , '09:00:00', '0', 'Delivery', 
                               '0', '0', '0', 'null', '0', '0', '3', '9', '0', '0', '');"); 
                                  
                           
                                $limite=0;
                              
                                }?>

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
                            <td style="background-color: #D9EDFC;">Total</td>
                                <?php foreach ($sql_paraguaDelivery as $dato) { ?>
                                    <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                       
                                <?php } ?>

                            <td style="background-color: #D9EDFC;"><?= number_format($sql_paraguarangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                    </tr>
                            
                    <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">3 pasos</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                             <?php foreach ($sql_3pasosDelivery as $dato) { ?> 
                                <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_3pasosrangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
                    </tr>
                </tr>

                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Boulevar</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                            <?php foreach ($sql_boulevarDelivery as $dato) { ?> 
                                <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_boulevarrangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
                    </tr>
                </tr>

                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Las Palmas</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                             <?php foreach ($sql_laspalmasDelivery as $dato) { ?>    
                                <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                    <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_laspalmasrangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
                    </tr>
                </tr>
                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Megacine</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                            <?php foreach ($sql_megacineDelivery as $dato) { ?>  
                                <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                    <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_megacinerangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
                    </tr>
                </tr>
                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Mutualista</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                             <?php foreach ($sql_mutualistaDelivery as $dato) { ?>    
                                <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                    <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_mutualistarangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
                    </tr>
                </tr>
                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Pampa</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                            <?php foreach ($sql_pampaDelivery as $dato) { ?>     
                                <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                    <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_pamparangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
                    </tr>
                </tr>
                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Plan</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                            <?php foreach ($sql_planDelivery as $dato) { ?>  
                                <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                            <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_planrangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
                    </tr>
                </tr>
                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Radial</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                            <?php foreach ($sql_radialDelivery as $dato) { ?>   
                                <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                    <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_radialrangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
                    </tr>
                </tr>
                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Roca</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                            <?php foreach ($sql_rocaDelivery as $dato) { ?>    
                                <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                        <?php } ?>
                                    <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_rocarangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
                    </tr>
                </tr>

                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Sur</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                            <?php foreach ($sql_surDelivery as $dato) { ?>     
                                <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                        
                                    <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_surrangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
                    </tr>
                </tr>
                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Villa 1ro</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                            <?php foreach ($sql_villa1Delivery as $dato) { ?> 
                                <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                    <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_villa1rangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
                    </tr>
                </tr>
                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Villa 2 Qdeli</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                            <?php foreach ($sql_villa2qdeliDelivery as $dato) { ?>    
                                <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                        
                                    <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_villa2qdelirangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
                    </tr>
                </tr>
                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Arenal</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                            <?php foreach ($sql_arenalDelivery as $dato) { ?> 
                                <?php if (number_format($dato['total'], 2) != 0 && number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                     
                                    <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_arenalrangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
                    </tr>
                </tr>
                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Bajio</td>
                        </tr>
                        <tr> 
                            <td style="background-color: #D9EDFC;">Total</td>
                            <?php foreach ($sql_bajioDelivery as $dato) { ?>  
                                <?php if (number_format($dato['total'], 2) != 0 || number_format($dato['total'], 2) != null) { ?>
                                        <td style="background-color: #D9EDFC;"><?= number_format($dato['total'], 2, ',', '.')  ?> Bs. </td>
                                        <?php } else { ?>
                                            <td style="background-color: #D9EDFC;">0,00</td>
                                    <?php } ?>
                                      
                                    <?php } ?>
                            <td style="background-color: #D9EDFC;"><?= number_format($sql_bajiorangoDelivery, 2, ',', '.' )  ?> Bs. </td>
                        </tr>
                        <tr> 
                           
                        </tr>
                            
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
                                    <h5> Bs. <?= number_format($dato['total'], 2, ',', '.')?></h5>
                                </td>
                            <?php } ?>
                            <td style="background-color: #FFCC79;">  <?= number_format($total_rango, 2, ',', '.')  ?> Bs. </td>
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