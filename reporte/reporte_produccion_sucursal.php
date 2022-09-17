<html>
<head>
    <title>Registro de Produccion por Sucursal </title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="../js/jquery.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
 <?php  $suma_boulevar=0;
    $suma_cinecenter=0;
    $suma_mutualista=0;  
    $suma_villa=0;
    $suma_roca=0;
    $suma_plan3000=0;
    $suma_arenal=0;
    $suma_bajio=0;
    $suma_qdelivilla=0;
    $suma_radial26=0;
    $suma_pampa=0;
    $suma_3pasos=0;
    $suma_palmas=0;
    $suma_paragua=0;
    $suma_sur=0;
    $suma_total =0;
?>
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
    set_time_limit(300);
    $usuario = $_SESSION['usuario'];
    $sucur = $usuario['sucursal_id'];
    ?>
    <div class="container">
        <div class="left-sidebar">
            <h2>Registro Produccion por Sucursal</h2>
            <div class="table-responsive">
                <script src="../js/jquery.js"></script>
                <script src="../data/librerias/calendario2/js/bootstrap-datepicker.min.js"></script>
                <script src="../data/librerias/calendario2/locales/bootstrap-datepicker.es.min.js"></script>
                <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>


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
                <form action="reporte_produccion_sucursal.php" method="POST">
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
                    
                    /* silpancho*/
                    

                    $sql_boulevarSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    
                    $sql_cinecenterSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 15
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_mutualistaSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 14
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_villaSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 13
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_rocaSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 12
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_plan3000Silpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 11
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_arenalSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 10
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_bajioSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 9
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");                   

                    $sql_qdelivillaSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 8
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_radial26Silpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 7
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_pampaSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 6
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_3pasosSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 5
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_palmasSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 4
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_paraguaSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 3
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_surSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 2
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_totalSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id  BETWEEN 2 and 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    /* CUADRIL 0.250g*/
                    

                    $sql_boulevarCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    
                    $sql_cinecenterCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 15
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_mutualistaCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 14
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_villaCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 13
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_rocaCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 12
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_plan3000CUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 11
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_arenalCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 10
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_bajioCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 9
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");                   

                    $sql_qdelivillaCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 8
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_radial26CUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 7
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_pampaCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 6
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_3pasosCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 5
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_palmasCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 4
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_paraguaCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 3
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_surCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 2
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_totalCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id  BETWEEN 2 and 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    /* milanesa*/
                    

                    $sql_boulevarMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    
                    $sql_cinecenterMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 15
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_mutualistaMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 14
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_villaMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 13
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_rocaMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 12
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_plan3000Milanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 11
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_arenalMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 10
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_bajioMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 9
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");                   

                    $sql_qdelivillaMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 8
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_radial26Milanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 7
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_pampaMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 6
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_3pasosMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 5
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_palmasMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 4
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_paraguaMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 3
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_surMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 2
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_totalMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id  BETWEEN 2 and 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    /* hamburguesa*/

                    $sql_boulevarHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    
                    $sql_cinecenterHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 15
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_mutualistaHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 14
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_villaHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 13
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_rocaHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 12
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_plan3000Hamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 11
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_arenalHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 10
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_bajioHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 9 
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_qdelivillaHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 8 
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_radial26Hamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 7 
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_pampaHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 6
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_3pasosHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 5
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_palmasHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 4
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_paraguaHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 3
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_surHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 2
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_totalHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id  BETWEEN 2 and 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    

                    /* pollo*/

                    $sql_boulevarPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    
                    $sql_cinecenterPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 15
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_mutualistaPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 14
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_villaPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 13
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_rocaPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 12
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_plan3000Pollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 11
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_arenalPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 10
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_bajioPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 9
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_qdelivillaPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 8
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_radial26Pollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 7
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_pampaPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 6
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_3pasosPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 5
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_palmasPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 4
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_paraguaPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 3
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_surPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 2
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_totalPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id  BETWEEN 2 and 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    /* filete*/

                    $sql_boulevarFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    
                    $sql_cinecenterFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 15
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_mutualistaFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 14
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_villaFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 13
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_rocaFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 12
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_plan3000Filete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 11
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_arenalFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 10
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_bajioFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 9
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");                   

                    $sql_qdelivillaFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 8
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_radial26Filete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 7
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_pampaFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 6
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_3pasosFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 5
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_palmasFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 4
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_paraguaFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 3
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_surFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 2
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_totalFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id  BETWEEN 2 and 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    

                    
                } else{

                    $fechaInicio = date('d-m-Y');
                    $fechaFin    = date('d-m-Y');
                    $fecha = $db->GetAll("SELECT fecha FROM venta WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha");
                    
                    /* silpancho*/
                    

                    $sql_boulevarSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    
                    $sql_cinecenterSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 15
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_mutualistaSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 14
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_villaSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 13
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_rocaSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 12
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_plan3000Silpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 11
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_arenalSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 10
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_bajioSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 9
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");                   

                    $sql_qdelivillaSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 8
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_radial26Silpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 7
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_pampaSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 6
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_3pasosSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 5
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_palmasSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 4
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_paraguaSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 3
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_surSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 2
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_totalSilpancho = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id  BETWEEN 2 and 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'SILPANCHO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    /* CUADRIL 0.250g*/
                    

                    $sql_boulevarCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    
                    $sql_cinecenterCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 15
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_mutualistaCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 14
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_villaCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 13
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_rocaCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 12
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_plan3000CUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 11
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_arenalCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 10
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_bajioCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 9
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");                   

                    $sql_qdelivillaCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 8
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_radial26CUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 7
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_pampaCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 6
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_3pasosCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 5
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_palmasCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 4
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_paraguaCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 3
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_surCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 2
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_totalCUADRIL= $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id  BETWEEN 2 and 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'CUADRIL 0.250g'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    /* milanesa*/
                    

                    $sql_boulevarMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    
                    $sql_cinecenterMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 15
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_mutualistaMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 14
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_villaMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 13
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_rocaMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 12
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_plan3000Milanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 11
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_arenalMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 10
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_bajioMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 9
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");                   

                    $sql_qdelivillaMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 8
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_radial26Milanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 7
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_pampaMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 6
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_3pasosMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 5
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_palmasMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 4
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_paraguaMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 3
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_surMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 2
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_totalMilanesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id  BETWEEN 2 and 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'MILANESA DE POLLO 200 G'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    /* hamburguesa*/

                    $sql_boulevarHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    
                    $sql_cinecenterHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 15
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_mutualistaHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 14
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_villaHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 13
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_rocaHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 12
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_plan3000Hamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 11
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_arenalHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 10
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_bajioHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 9 
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_qdelivillaHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 8 
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_radial26Hamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 7 
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_pampaHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 6
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_3pasosHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 5
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_palmasHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 4
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_paraguaHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 3
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_surHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 2
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre");

                    $sql_totalHamburguesa = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id  BETWEEN 2 and 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'HAMBURGUESA QDELI'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    

                    /* pollo*/

                    $sql_boulevarPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    
                    $sql_cinecenterPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 15
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_mutualistaPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 14
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_villaPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 13
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_rocaPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 12
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_plan3000Pollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 11
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_arenalPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 10
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_bajioPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 9
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_qdelivillaPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 8
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_radial26Pollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 7
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_pampaPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 6
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_3pasosPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 5
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_palmasPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 4
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_paraguaPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 3
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_surPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 2
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_totalPollo = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id  BETWEEN 2 and 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'PIEZA DE POLLO'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    /* filete*/

                    $sql_boulevarFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    
                    $sql_cinecenterFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 15
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_mutualistaFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 14
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_villaFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 13
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_rocaFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 12
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_plan3000Filete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 11
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_arenalFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 10
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_bajioFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 9
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");                   

                    $sql_qdelivillaFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 8
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_radial26Filete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 7
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_pampaFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 6
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_3pasosFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 5
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");


                    $sql_palmasFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 4
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_paraguaFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 3
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_surFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id = 2
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    $sql_totalFilete = $db->GetAll("SELECT p.categoria, p.nombre AS plato, prod.nombre, s.idsucursal AS sucursal, 
                    sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * dp.cantidad as cantidadproducto,  dp.cantidad
                    FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
                    WHERE v.estado = 'V' 
                    AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                    AND v.sucursal_id  BETWEEN 2 and 16
                    AND v.sucursal_id = s.idsucursal 
                    AND v.idturno = t.idturno AND t.nro = v.turno 
                    AND dv.nro = v.nro AND dv.idturno = v.idturno
                    and dv.sucursal_id = s.idsucursal
                    and dp.nro = p.nro
                    and prod.idproducto = dp.producto_id
                    AND p.idplato = dv.plato_id 
                    AND prod.nombre like 'FILETE'
                    GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;");

                    
                    $total = $db->GetAll("SELECT sum(consumo) AS total FROM consumoelectrico WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha");
                    $total_rango = $db->GetOne("SELECT sum(consumo) AS total FROM consumoelectrico WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin");       
                }
                ?>
                <table id="tblventas" class="table table-striped table-hover table-bordered" width="100%">
                    <thead style="background-color: #FFCC79;">
                        <tr>
                            <th style="text-align: center; background-color: #F1A323;">Sucursal</th>
                            <th style="text-align: center;">Suc. Boulevar</th>
                            <th style="text-align: center;">Suc. CineCenter</th>
                            <th style="text-align: center;">Suc. Mutualista</th>
                            <th style="text-align: center;">Suc. Villa</th>
                            <th style="text-align: center;">Suc. Roca</th>
                            <th style="text-align: center;">Suc. Plan3000</th>
                            <th style="text-align: center;">Suc. Arenal</th>
                            <th style="text-align: center;">Suc. Bajio</th>
                            <th style="text-align: center;">Suc. QdeliVilla</th>
                            <th style="text-align: center;">Suc. Radial26</th>
                            <th style="text-align: center;">Suc. Pampa</th>
                            <th style="text-align: center;">Suc. 3Pasos</th>
                            <th style="text-align: center;">Suc. Palmas</th>
                            <th style="text-align: center;">Suc. Paragua</th>
                            <th style="text-align: center;">Suc. Sur</th>
                            <th style="text-align: center;">Total</th>
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
                                $limite=0;
                                }?>

                            <?php } ?>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;" style="width: 10px;">Silpancho</td>
                        </tr>
                        <tr> 
                            <!-- Boulevarsilpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=16 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_boulevarSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_boulevars = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 16 and producto like 'SILPANCHO'"); 
                            foreach($sql_boulevars as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_boulevar = $suma_boulevar + $datos['cantidad']  ?>   
                            <?php } ?>

                            <!-- Cinecentersilpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=15 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_cinecenterSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_cinecenters = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 15 and producto like 'SILPANCHO'"); 
                            foreach($sql_cinecenters as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_cinecenter = $suma_cinecenter + $datos['cantidad']  ?>       
                            <?php } ?>

                            <!-- Mutualistasilpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=14 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_mutualistaSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_mutualistas = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 14 and producto like 'SILPANCHO'"); 
                            foreach($sql_mutualistas as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_mutualista = $suma_mutualista + $datos['cantidad']  ?>      
                            <?php } ?>

                            <!-- Villasilpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=13 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_villaSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_villas = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 13 and producto like 'SILPANCHO'"); 
                            foreach($sql_villas as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_villa = $suma_villa + $datos['cantidad']  ?>      
                            <?php } ?>

                            <!-- Rocasilpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=12 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_rocaSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_rocas = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 12 and producto like 'SILPANCHO'"); 
                            foreach($sql_rocas as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_roca = $suma_roca + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- Plan3000silpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=11 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_plan3000Silpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_plan3000s = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 11 and producto like 'SILPANCHO'"); 
                            foreach($sql_plan3000s as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_plan3000 = $suma_plan3000 + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- Arenalsilpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=10 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_arenalSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_arenals = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 10 and producto like 'SILPANCHO'"); 
                            foreach($sql_arenals as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_arenal = $suma_arenal + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- Bajiosilpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=9 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_bajioSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_bajios = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 9 and producto like 'SILPANCHO'"); 
                            foreach($sql_bajios as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_bajio = $suma_bajio + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- Qdelivillasilpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=8 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_qdelivillaSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_qdelivillas = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 8 and producto like 'SILPANCHO'"); 
                            foreach($sql_qdelivillas as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_qdelivilla = $suma_qdelivilla + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- Radial26silpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=7 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_radial26Silpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_radial26s = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 7 and producto like 'SILPANCHO'"); 
                            foreach($sql_radial26s as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_radial26 = $suma_radial26 + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- Pampasilpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=6 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_pampaSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_pampas = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 6 and producto like 'SILPANCHO'"); 
                            foreach($sql_pampas as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_pampa = $suma_pampa + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- 3pasossilpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=5 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_3pasosSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_3pasoss = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 5 and producto like 'SILPANCHO'"); 
                            foreach($sql_3pasoss as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_3pasos = $suma_3pasos + $datos['cantidad']  ?>
                            <?php } ?>

                            <!-- palmassilpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=4 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_palmasSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_palmass = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 4 and producto like 'SILPANCHO'"); 
                            foreach($sql_palmass as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_palmas = $suma_palmas + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- paraguasilpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=3 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_paraguaSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_paraguas = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 3 and producto like 'SILPANCHO'"); 
                            foreach($sql_paraguas as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_paragua = $suma_paragua + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- sursilpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=2 and producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_surSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_surs = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 2 and producto like 'SILPANCHO'"); 
                            foreach($sql_surs as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>    
                                    <?php  $suma_sur = $suma_sur + $datos['cantidad']  ?>  
                            <?php } ?>    
                            
                            <!-- Total silpancho-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where  producto like 'SILPANCHO'"); ?>
                            <?php foreach ($sql_totalSilpancho as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_totals = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` where producto like 'SILPANCHO'"); 
                            foreach($sql_totals as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>    
                                    <?php  $suma_total = $suma_total + $datos['cantidad']  ?>  
                            <?php } ?>  
                        </tr>
                        <tr> 
                        </tr>
                    </tr>
                            
                    <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Cuadril 0.250g</td>
                        </tr>
                        <tr> 

                            <!-- BoulevarCUADRIL 0.250g-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=16 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_boulevarCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_boulevardatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 16 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_boulevardatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_boulevar = $suma_boulevar + $datos['cantidad']  ?>      
                            <?php } ?>

                            <!-- CinecenterCUADRIL 0.250g-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=15 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_cinecenterCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_cinecenterdatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 15 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_cinecenterdatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>  
                                    <?php  $suma_cinecenter = $suma_cinecenter + $datos['cantidad']  ?>  
                            <?php } ?>

                            <!-- MutualistaCUADRIL 0.250g-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=14 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_mutualistaCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_mutualistadatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 14 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_mutualistadatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_mutualista = $suma_mutualista + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- VillaCUADRIL-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=13 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_villaCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_villadatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 13 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_villadatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_villa = $suma_villa + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- RocaCUADRIL-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=12 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_rocaCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_rocadatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 12 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_rocadatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_roca = $suma_roca + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- Plan3000CUADRIL 0.250g-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=11 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_plan3000CUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_plan3000 = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 11 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_plan3000 as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_plan3000 = $suma_plan3000 + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- ArenalCUADRIL-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=10 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_arenalCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_arenalc = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 10 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_arenalc as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_arenal = $suma_arenal + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- BajioCUADRIL 0.250g-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=9 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_bajioCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_bajio = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 9 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_bajio as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_bajio = $suma_bajio + $datos['cantidad']  ?>   
                            <?php } ?>

                            <!-- QdelivillaCUADRIL 0.250g-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=8 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_qdelivillaCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_qdelivilla = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 8 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_qdelivilla as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_qdelivilla = $suma_qdelivilla + $datos['cantidad']  ?>      
                            <?php } ?>

                            <!-- Radial26CUADRIL-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=7 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_radial26CUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_radial26 = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 7 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_radial26 as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_radial26 = $suma_radial26 + $datos['cantidad']  ?>      
                            <?php } ?>

                            <!-- PampaCUADRIL-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=6 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_pampaCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_pampa = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 6 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_pampa as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_pampa = $suma_pampa + $datos['cantidad']  ?>        
                            <?php } ?>

                            <!-- 3pasosCUADRIL-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=5 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_3pasosCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_3pasos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 5 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_3pasos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_3pasos = $suma_3pasos + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- palmasCUADRIL-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=4 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_palmasCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_palmas = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 4 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_palmas as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_palmas = $suma_palmas + $datos['cantidad']  ?>      
                            <?php } ?>

                            <!-- paraguaCUADRIL-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=3 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_paraguaCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_paragua = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 3 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_paragua as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>  
                                    <?php  $suma_paragua = $suma_paragua + $datos['cantidad']  ?>  
                            <?php } ?>

                            <!-- surCUADRIL-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=2 and producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_surCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_sur = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 2 and producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_sur as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>   
                                    <?php  $suma_sur = $suma_sur + $datos['cantidad']  ?>   
                            <?php } ?>

                            <!-- Total CUADRIL -->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where  producto like 'CUADRIL 0.250g'"); ?>
                            <?php foreach ($sql_totalCUADRIL as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_totalc = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` where producto like 'CUADRIL 0.250g'"); 
                            foreach($sql_totalc as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>    
                                    <?php  $suma_total = $suma_total + $datos['cantidad']  ?>  
                            <?php } ?>  
                        </tr>
                        <tr> 
                        </tr>
                            
                    </tr>
                </tr>

                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Milanesa</td>
                        </tr>
                        <tr>                          
                            <!-- boulevarmilanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=16 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_boulevarMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_boulevarm = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 16 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_boulevarm as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>  
                                    <?php  $suma_boulevar = $suma_boulevar + $datos['cantidad']  ?>       
                            <?php } ?>

                            <!-- cinecentermilanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=15 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_cinecenterMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_cinecenterm = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 15 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_cinecenterm as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_cinecenter = $suma_cinecenter + $datos['cantidad']  ?>   
                            <?php } ?>

                            <!-- mutualistamilanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=14 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_mutualistaMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_mutualistam = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 14 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_mutualistam as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_mutualista = $suma_mutualista + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- villamilanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=13 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_villaMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_villam = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 13 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_villam as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_villa = $suma_villa + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- rocamilanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=12 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_rocaMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_rocam = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 12 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_rocam as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_roca = $suma_roca + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- plan3000milanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=11 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_plan3000Milanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_plan3000m = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 11 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_plan3000m as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_plan3000 = $suma_plan3000 + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- Arenalmilanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=10 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_arenalMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_arenalm = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 10 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_arenalm as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_arenal = $suma_arenal + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- bajiomilanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=9 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_bajioMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_bajiom = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 9 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_bajiom as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_bajio = $suma_bajio + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- qdelivillamilanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=8 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_qdelivillaMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_qdelivillam = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 8 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_qdelivillam as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_qdelivilla = $suma_qdelivilla + $datos['cantidad']  ?>      
                            <?php } ?>

                            <!-- radial26milanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=7 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_radial26Milanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_radial26m = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 7 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_radial26m as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>  
                                    <?php  $suma_radial26 = $suma_radial26 + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- pampamilanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=6 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_pampaMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_pampam = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 6 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_pampam as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_pampa = $suma_pampa + $datos['cantidad']  ?>         
                            <?php } ?>

                            <!-- 3pasosmilanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=5 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_3pasosMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_3pasosm = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 5 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_3pasosm as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_3pasos = $suma_3pasos + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- palmasmilanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=4 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_palmasMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_palmasm = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 4 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_palmasm as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_palmas = $suma_palmas + $datos['cantidad']  ?>      
                            <?php } ?>

                            <!-- paraguamilanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=3 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_paraguaMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_paraguam = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 3 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_paraguam as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>  
                                    <?php  $suma_paragua = $suma_paragua + $datos['cantidad']  ?>  
                            <?php } ?>

                            <!-- surmilanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=2 and producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_surMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_surm = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 2 and producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_surm as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_sur = $suma_sur + $datos['cantidad']  ?>      
                            <?php } ?>

                            <!-- Total milanesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where  producto like 'MILANESA DE POLLO 200 G'"); ?>
                            <?php foreach ($sql_totalMilanesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_totalm = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` where producto like 'MILANESA DE POLLO 200 G'"); 
                            foreach($sql_totalm as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>    
                                    <?php  $suma_total = $suma_total + $datos['cantidad']  ?>  
                            <?php } ?>

                        </tr>
                        <tr> 
                        </tr>
                            
                    </tr>
                </tr>

                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Hamburguesa</td>
                        </tr>
                        <tr>
                            

                            <!-- Boulevarhamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=16 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_boulevarHamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_boulevardatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 16 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_boulevardatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_boulevar = $suma_boulevar + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- Cinecenterhamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=15 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_cinecenterHamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_cinecenterdatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 15 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_cinecenterdatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_cinecenter = $suma_cinecenter + $datos['cantidad']  ?>           
                            <?php } ?>

                            <!-- Mutualistahamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=14 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_mutualistaHamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_mutualistadatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 14 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_mutualistadatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_mutualista = $suma_mutualista + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- villahamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=13 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_villaHamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_villadatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 13 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_villadatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_villa = $suma_villa + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- rocahamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=12 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_rocaHamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_rocadatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 12 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_rocadatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_roca = $suma_roca + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- plan3000hamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=11 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_plan3000Hamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_plan3000datos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 11 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_plan3000datos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_plan3000 = $suma_plan3000 + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- arenalhamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=10 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_arenalHamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_arenaldatosh = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 10 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_arenaldatosh as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_arenal = $suma_arenal + $datos['cantidad']  ?>    
                            <?php } ?>
            
                            <!--bajiohamburguesa-->    
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=9 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php $rellenar =$db->execute("INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '0', '0', '0' ,'9')"); ?>   
                            <?php foreach ($sql_bajioHamburguesa as $dato) { ?>
                                <?php    
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                ?> 
                            <?php } ?>  
                                <?php
                                $sql_bajioDatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 9 and producto like 'HAMBURGUESA QDELI'"); 
                                foreach($sql_bajioDatos as $dato) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($dato['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_bajio = $suma_bajio + $dato['cantidad']  ?>    
                            <?php } ?>

                            <!-- Qdelivillahamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=8 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_qdelivillaHamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_qdelivilladatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 8 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_qdelivilladatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_qdelivilla = $suma_qdelivilla + $datos['cantidad']  ?>      
                            <?php } ?>

                            <!-- Radial26Hamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=7 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_radial26Hamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_radial26datos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 7 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_radial26datos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_radial26 = $suma_radial26 + $datos['cantidad']  ?>       
                            <?php } ?>

                            <!-- PampaHamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=6 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_pampaHamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_pampadatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 6 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_pampadatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_pampa = $suma_pampa + $datos['cantidad']  ?>     
   
                            <?php } ?>

                            <!-- 3pasosHamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=5 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_3pasosHamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_3pasosdatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 5 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_3pasosdatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_3pasos = $suma_3pasos + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- Palmashamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=4 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_palmasHamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_palmasdatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 4 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_palmasdatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_palmas = $suma_palmas + $datos['cantidad']  ?>       
                            <?php } ?>

                            <!-- Paraguahamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=3 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_paraguaHamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_paraguadatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 3 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_paraguadatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>  
                                    <?php  $suma_paragua = $suma_paragua + $datos['cantidad']  ?>  
                            <?php } ?>

                            <!-- Surhamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=2 and producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_surHamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_surdatos = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 2 and producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_surdatos as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>  
                                    <?php  $suma_sur = $suma_sur + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- Total hamburguesa-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where  producto like 'HAMBURGUESA QDELI'"); ?>
                            <?php foreach ($sql_totalHamburguesa as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_totalh = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` where producto like 'HAMBURGUESA QDELI'"); 
                            foreach($sql_totalh as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>    
                                    <?php  $suma_total = $suma_total + $datos['cantidad']  ?>  
                            <?php } ?>
                                                        
                        </tr>
                        <tr> 
                        </tr>
                            
                    </tr>
                </tr>
                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Pollo</td>
                        </tr>
                        <tr>
                            <!-- boulevarpollo-->
                        <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=16 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_boulevarPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_boulevarp = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 16 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_boulevarp as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_boulevar = $suma_boulevar + $datos['cantidad']  ?>        
                            <?php } ?>
                            <!-- cinecenterpollo-->
                        <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=15 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_cinecenterPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_cinecenterp = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 15 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_cinecenterp as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_cinecenter = $suma_cinecenter + $datos['cantidad']  ?>       
                            <?php } ?> 

                    
                            <!-- mutualistapollo-->
                        <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=14 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_mutualistaPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_mutualistap = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 14 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_mutualistap as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_mutualista = $suma_mutualista + $datos['cantidad']  ?>     
                            <?php } ?>
                            <!-- villapollo-->
                        <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=13 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_villaPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_villap = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 13 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_villap as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_villa = $suma_villa + $datos['cantidad']  ?>     
                            <?php } ?>
                            <!-- Rocapollo-->
                        <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=12 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_rocaPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_rocap = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 12 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_rocap as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_roca = $suma_roca + $datos['cantidad']  ?>    
                            <?php } ?>
                        
                        <!-- Plan3000pollo-->
                        <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=11 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_plan3000Pollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_plan3000p = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 11 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_plan3000p as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_plan3000 = $suma_plan3000 + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- Arenalpollo-->
                        <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=10 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_arenalPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_arenalp = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 10 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_arenalp as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_arenal = $suma_arenal + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- Bajiopollo-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=9 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_bajioPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_bajiop = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 9 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_bajiop as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_bajio = $suma_bajio + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- Qdelivillapollo-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=8 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_qdelivillaPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_qdelivillap = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 8 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_qdelivillap as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_qdelivilla = $suma_qdelivilla + $datos['cantidad']  ?>      
                            <?php } ?>
                            <!-- Radial26pollo-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=7 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_radial26Pollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_radial26p = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 7 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_radial26p as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_radial26 = $suma_radial26 + $datos['cantidad']  ?>       
                            <?php } ?>
                            <!-- Pampapollo-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=6 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_pampaPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_pampap = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 6 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_pampap as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_pampa = $suma_pampa + $datos['cantidad']  ?>     
    
                            <?php } ?>

                            <!-- 3pasospollo-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=5 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_3pasosPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_3pasosp = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 5 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_3pasosp as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_3pasos = $suma_3pasos + $datos['cantidad']  ?>    
                            <?php } ?>
                            <!-- Palmaspollo-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=4 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_palmasPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_palmasp = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 4 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_palmasp as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_palmas = $suma_palmas + $datos['cantidad']  ?>      
                            <?php } ?>

                            <!-- paraguapollo-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=3 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_paraguaPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_paraguap = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 3 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_paraguap as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>  
                                    <?php  $suma_paragua = $suma_paragua + $datos['cantidad']  ?>  
                            <?php } ?>
                            
                            <!-- surpollo-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=2 and producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_surPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_surp = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 2 and producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_surp as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_sur = $suma_sur + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- Total pollo-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where  producto like 'PIEZA DE POLLO'"); ?>
                            <?php foreach ($sql_totalPollo as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_totalp = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` where producto like 'PIEZA DE POLLO'"); 
                            foreach($sql_totalp as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>    
                                    <?php  $suma_total = $suma_total + $datos['cantidad']  ?>  
                            <?php } ?>
                        </tr>
                        <tr>                   
                        </tr>
                            
                    </tr>
                </tr>
                <tr>
                        <tr>
                            <td rowspan="3" style="text-align: center;" style="width: 10px;">Filete</td>
                        </tr>
                        <tr> 
                        

                            <!-- Boulevarfilete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=16 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_boulevarFilete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_boulevarf = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 16 and producto like 'FILETE'"); 
                            foreach($sql_boulevarf as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>  
                                    <?php  $suma_boulevar = $suma_boulevar + $datos['cantidad']  ?>       
                            <?php } ?>

                            <!-- Cinecenterfilete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=15 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_cinecenterFilete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_cinecenterf = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 15 and producto like 'FILETE'"); 
                            foreach($sql_cinecenterf as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_cinecenter = $suma_cinecenter + $datos['cantidad']  ?>       
                            <?php } ?>

                            <!-- Mutualistafilete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=14 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_mutualistaFilete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_mutualistaf = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 14 and producto like 'FILETE'"); 
                            foreach($sql_mutualistaf as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_mutualista = $suma_mutualista + $datos['cantidad']  ?>     
                            <?php } ?>


                            <!-- Villafilete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=13 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_villaFilete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_villaf = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 13 and producto like 'FILETE'"); 
                            foreach($sql_villaf as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_villa = $suma_villa + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- Rocafilete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=12 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_rocaFilete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_rocaf = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 12 and producto like 'FILETE'"); 
                            foreach($sql_rocaf as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_roca = $suma_roca + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- Plan3000filete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=11 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_plan3000Filete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_plan3000f = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 11 and producto like 'FILETE'"); 
                            foreach($sql_plan3000f as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_plan3000 = $suma_plan3000 + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- Arenalfilete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=10 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_arenalFilete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_arenalf = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 10 and producto like 'FILETE'"); 
                            foreach($sql_arenalf as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_arenal = $suma_arenal + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- Bajiofilete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=9 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_bajioFilete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_bajiof = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 9 and producto like 'FILETE'"); 
                            foreach($sql_bajiof as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_bajio = $suma_bajio + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- Qdelivillafilete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=8 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_qdelivillaFilete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_qdelivillaf = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 8 and producto like 'FILETE'"); 
                            foreach($sql_qdelivillaf as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_qdelivilla = $suma_qdelivilla + $datos['cantidad']  ?>      
                            <?php } ?>

                            <!-- Radial26filete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=7 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_radial26Filete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_radial26f = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 7 and producto like 'FILETE'"); 
                            foreach($sql_radial26f as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_radial26 = $suma_radial26 + $datos['cantidad']  ?>       
                            <?php } ?>

                            <!-- Pampafilete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=6 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_pampaFilete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_pampaf = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 6 and producto like 'FILETE'"); 
                            foreach($sql_pampaf as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>  
                                    <?php  $suma_pampa = $suma_pampa + $datos['cantidad']  ?>     
  
                            <?php } ?>

                            <!-- 3pasosfilete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=5 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_3pasosFilete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_3pasosf = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 5 and producto like 'FILETE'"); 
                            foreach($sql_3pasosf as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_3pasos = $suma_3pasos + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- Palmasfilete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=4 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_palmasFilete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_palmasf = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 4 and producto like 'FILETE'"); 
                            foreach($sql_palmasf as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_palmas = $suma_palmas + $datos['cantidad']  ?>       
                            <?php } ?>

                            <!-- Paraguafilete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=3 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_paraguaFilete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_paraguaf = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 3 and producto like 'FILETE'"); 
                            foreach($sql_paraguaf as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>
                                    <?php  $suma_paragua = $suma_paragua + $datos['cantidad']  ?>    
                            <?php } ?>

                            <!-- Surfilete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where sucursal_id=2 and producto like 'FILETE'"); ?>
                            <?php foreach ($sql_surFilete as $dato) { ?>
                                <?php                                               
                                    $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`,`sucursal_id`)
                                    VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]' ,'$dato[sucursal]')");
                                    
                                ?> 
                            <?php } ?>  
                            <?php
                            $sql_surf = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` WHERE sucursal_id = 2 and producto like 'FILETE'"); 
                            foreach($sql_surf as $datos) { ?>  
                                    <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td> 
                                    <?php  $suma_sur = $suma_sur + $datos['cantidad']  ?>     
                            <?php } ?>

                            <!-- Total filete-->
                            <?php $borrar =$db->execute ("DELETE FROM apoyo where  producto like 'FILETE'"); ?>
                                <?php foreach ($sql_totalFilete as $dato) { ?>
                                    <?php                                               
                                        $sumatotal=$db->execute( "INSERT INTO `apoyo` (`id`, `nro`, `categoria`, `producto`, `cantidad`)
                                        VALUES (NULL, '1', '$dato[categoria]', '$dato[nombre]', '$dato[cantidadproducto]')");
                                        
                                    ?> 
                                <?php } ?>  
                                <?php
                                $sql_totalf = $db ->GetAll("SELECT ifnull(sum(cantidad), 0)as cantidad FROM `apoyo` where producto like 'FILETE'"); 
                                foreach($sql_totalf as $datos) { ?>  
                                        <td style="background-color: #D9EDFC;"><?= number_format($datos['cantidad'],2,',',' ') ?></td>    
                                        <?php  $suma_total = $suma_total + $datos['cantidad']  ?>  
                            <?php } ?>

                        </tr>
                        <tr> 
                        </tr>
                            
                    </tr>
                </tr>
                    </tbody>
                    <tfoot>
                    <td style="background-color: #FFCC79;" align="center"><h5>Total</h5></td>
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_boulevar,2,',',' ') ?>     </td>
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_cinecenter,2,',',' ') ?></td>   
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_mutualista,2,',',' ') ?></td>  </td>   
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_villa,2,',',' ') ?></td>   
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_roca,2,',',' ') ?></td>   
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_plan3000,2,',',' ') ?></td>
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_arenal,2,',',' ') ?></td>      
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_bajio,2,',',' ') ?></td>   
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_qdelivilla,2,',',' ') ?></td>   
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_radial26,2,',',' ') ?></td>
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_pampa,2,',',' ') ?></td>   
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_3pasos,2,',',' ') ?></td>   
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_palmas,2,',',' ') ?></td>   
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_paragua,2,',',' ') ?></td>   
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_sur,2,',',' ') ?></td>
                    <td style="background-color: #FFCC79;"> <?php echo number_format( $suma_total,2,',',' ') ?></td>          
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
            link.download = "produccion_sucursal.xls";
            link.href = uri + base64(format(template, ctx))
            link.click();
        }
    </script>
</script>
    
</body>

</html>