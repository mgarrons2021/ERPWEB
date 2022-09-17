<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="#" />
    <title>Cronología de Venta General</title>

    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css" />
    <!--datables estilo bootstrap 4 CSS-->
    <link rel="stylesheet" type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">

    <!--font awesome con CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

</head>

<body class="body">
    <?php
    
    
    include "../menu/menu.php";
    include 'conexion.php';
    

    if (isset($_POST['fechaini']) && isset($_POST['horaini']) && isset($_POST['fechamax']) && isset($_POST['horamax'])) {
        $fecha_min = $_POST["fechaini"];
        $hora_min  = $_POST["horaini"];
        $fecha_max = $_POST["fechamax"];
        $hora_max  = $_POST["horamax"];
        
        $consulta = "SELECT p.categoria, p.nombre AS plato, 
        sum(dv.cantidad) as cantidad, pp.precio AS precio_uni, (sum(dv.cantidad)*pp.precio) as subtotal,v.fecha, v.hora, t.nro as turno
        FROM turno t, venta v, detalleventa dv, plato p ,pre_pla pp
        WHERE v.estado = 'V' 
        AND v.fecha BETWEEN '$fecha_min' AND '$fecha_max'
        AND v.hora BETWEEN '$hora_min' AND '$hora_max'
        AND v.idturno = t.idturno
        AND v.pago != 'comida_personal'
        AND t.nro = v.turno 
        AND dv.nro = v.nro 
        AND dv.idturno = v.idturno
		AND pp.plato_id = p.idplato
		AND pp.sucursal_id= dv.sucursal_id
        AND p.idplato = dv.plato_id GROUP BY p.idplato";

    } else {

        $fecha_min = date('d-m-Y');
        $hora_min  = time();
        $fecha_max = date('d-m-Y');
        $hora_max  = time();
        $consulta = "SELECT p.categoria, p.nombre AS plato, 
        sum(dv.cantidad) as cantidad, pp.precio AS precio_uni, (sum(dv.cantidad)*pp.precio) as subtotal,v.fecha, v.hora, t.nro as turno
        FROM turno t, venta v, detalleventa dv, plato p ,pre_pla pp
        WHERE v.estado = 'V' 
        AND v.fecha BETWEEN '$fecha_min' AND '$fecha_max'
        AND v.hora BETWEEN '$hora_min' AND '$hora_max'
        AND v.idturno = t.idturno
        AND v.pago != 'comida_personal'
        AND t.nro = v.turno 
        AND dv.nro = v.nro 
        AND dv.idturno = v.idturno
		AND pp.plato_id = p.idplato
		AND pp.sucursal_id= dv.sucursal_id
        AND p.idplato = dv.plato_id GROUP BY p.idplato";
    
    }
    
    $ventas = mysqli_query($db, $consulta);

    $resultado = array();
                      
    if ($ventas && mysqli_num_rows($ventas) >= 1) {
        $resultado = $ventas;
    }

    ?>

    <div class="container">
        <div class="left-sidebar">
            <h2>Cronología de Ventas General</h2>

            <div class="table-responsive">
                <form action="reporte.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                                <input type="date" id="fechaini" class="input-sm form-control" name="fechaini" required />
                                <input id="appt-time" type="time" id="horaini" class="input-sm form-control" name="horaini" step="2" required/>
                                <span class="input-group-addon">A</span>
                                <input type="date" id="fechamax" class="input-sm form-control" name="fechamax" required />
                                <input id="appt-time" type="time" id="horamax" class="input-sm form-control" name="horamax" step="2" required />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="submit" value="filtrar">
                        </div>
                    </div>
                </form>
                <br>
                <table id="mix_ventas" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio de Venta (Bs.)</th>
                            <th>Subtotal (Bs.)</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Turno</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $totalVendido=0;$totalKilos=0;$totalrefres=0;$totalparri=0;$totalservidos=0;$totalejecutivo=0;$totalpollos=0;$totalhamburguesas=0;$totalgaseosas=0;$totalsopa=0;$totalcombos=0;$totalporciones=0;$totalnKilos=0;$totalnrefres=0;$totalnparri=0;$totalnservidos=0;$totalnejecutivo=0;$totalnpollos=0;$totalnhamburguesas=0;$totalngaseosas=0;$totalnsopa=0;$totalncombos=0;$totalnporciones=0;
                        $totalcat = array(number_format($totalnKilos,2)=>'por kilo', number_format($totalrefres,2)=>'refrescos', number_format($totalnparri,2)=>'parrilla', number_format($totalnservidos,2)=>'platos servidos', number_format($totalnejecutivo,2)=>'menu ejecutivo', number_format($totalnpollos,2)=>'pollos', number_format($totalnhamburguesas,2)=>'hamburguesas', number_format($totalngaseosas,2)=>'gaseosas', number_format($totalnsopa,2)=>'sopa', number_format($totalncombos,2)=>'combos', number_format($totalnporciones,2)=>'porciones');

                        foreach ($resultado as $venta) { 
                            
                            $totalVendido=$totalVendido+$venta['subtotal'];
                                if($venta['categoria']=="por kilo"){
                                    $totalKilos=$totalKilos+$venta['subtotal'];   
                                }
                                if($venta['categoria']=="refrescos"){
                                    $totalrefres=$totalrefres+$venta['subtotal'];   
                                }
                                if($venta['categoria']=="parrilla"){
                                    $totalparri=$totalparri+$venta['subtotal'];   
                                }
                                if($venta['categoria']=="platos servidos"){
                                    $totalservidos=$totalservidos+$venta['subtotal'];   
                                }
                                if($venta['categoria']=="menu ejecutivo"){
                                    $totalejecutivo=$totalejecutivo+$venta['subtotal'];   
                                }
                                if($venta['categoria']=="pollos"){
                                    $totalpollos=$totalpollos+$venta['subtotal'];   
                                }
                                if($venta['categoria']=="hamburguesas"){
                                    $totalhamburguesas=$totalhamburguesas+$venta['subtotal'];   
                                }
                                if($venta['categoria']=="gaseosas"){
                                    $totalgaseosas=$totalgaseosas+$venta['subtotal'];   
                                }
                                if($venta['categoria']=="sopa"){
                                    $totalsopa=$totalsopa+$venta['subtotal'];   
                                }
                                if($venta['categoria']=="combos"){
                                    $totalcombos=$totalcombos+$venta['subtotal'];   
                                }
                                if($venta['categoria']=="porciones"){
                                    $totalporciones=$totalporciones+$venta['subtotal'];   
                                }
                                //////suma cantidades
                                if($venta['categoria']=="por kilo"){
                                    $totalnKilos=$totalnKilos+$venta['cantidad'];   
                                }
                                if($venta['categoria']=="refrescos"){
                                    $totalnrefres=$totalnrefres+$venta['cantidad'];   
                                }
                                if($venta['categoria']=="parrilla"){
                                    $totalnparri=$totalnparri+$venta['cantidad'];   
                                }
                                if($venta['categoria']=="platos servidos"){
                                    $totalnservidos=$totalnservidos+$venta['cantidad'];   
                                }
                                if($venta['categoria']=="menu ejecutivo"){
                                    $totalnejecutivo=$totalnejecutivo+$venta['cantidad'];   
                                }
                                if($venta['categoria']=="pollos"){
                                    $totalnpollos=$totalnpollos+$venta['cantidad'];   
                                }
                                if($venta['categoria']=="hamburguesas"){
                                    $totalnhamburguesas=$totalnhamburguesas+$venta['cantidad'];   
                                }
                                if($venta['categoria']=="gaseosas"){
                                    $totalngaseosas=$totalngaseosas+$venta['cantidad'];   
                                }
                                if($venta['categoria']=="sopa"){
                                    $totalnsopa=$totalnsopa+$venta['cantidad'];   
                                }
                                if($venta['categoria']=="combos"){
                                    $totalncombos=$totalncombos+$venta['cantidad'];   
                                }
                                if($venta['categoria']=="porciones"){
                                    $totalnporciones=$totalnporciones+$venta['cantidad'];   
                                }
                            ?>  
                            <tr class=warning>
                                <td><?= $venta['categoria'] ?></td>
                                <td><?= $venta['plato'] ?></td>
                                <td><?= number_format($venta['cantidad'],2) ?></td>
                                <td><?= $venta['precio_uni'] ?></td>
                                <td><?= number_format($venta['subtotal'],2) ?></td>
                                <td><?= date('d/m/Y', strtotime($venta['fecha'])) ?></td>
                                <td><?= $venta['hora'] ?></td>
                                <?php if ($venta['turno'] == '1') { ?>
                                    <td>AM</td>
                                <?php } else { ?>
                                    <td>PM</td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    
                    </tbody>
                    </div>
                 </table>
                 <br>
               
        </div>
    </div>

    </table>
   
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
   <tr>
   <td><h4>Total en Ventas</h4></td><td><h4> <?php echo number_format($totalVendido,2)." bs"; ?></h4>
   </td></tr>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="100%">
   <tr>
   <td><h4>Total por categoria (Bs.)</h4></td><td><h4> Cantidad Vendida</h4></tr>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="100%">
   <tr>
   <td><h4>Total por Kilo:  <?php echo number_format($totalKilos,2)." bs."; ?></h4></td><td><h4> <?php echo number_format($totalnKilos,2)." Und"; ?></h4></tr>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="50%">
   <tr>
   <td><h4>Total refrescos: <?php echo number_format($totalrefres,2)." bs."; ?></h4></td><td><h4><?php echo number_format($totalnrefres,2)." Und"; ?> </h4>
</tr>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="50%">
   <tr>
   <td><h4>Total parrilla: <?php echo number_format($totalparri,2)." bs."; ?> </h4></td><td><h4>  <?php echo number_format($totalnparri,2)." Und"; ?></h4>
   </tr>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="50%">
   <tr>
   <td><h4>Total platos servidos: <?php echo number_format($totalservidos,2)." bs."; ?></h4></td><td><h4><?php echo number_format($totalnservidos,2)." Und"; ?> </h4>
   </tr>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="50%">
   <tr>
   <td><h4>Total menu ejecutivo: <?php echo number_format($totalejecutivo,2)." bs."; ?></h4></td><td><h4> <?php echo number_format($totalnejecutivo,2)." Und"; ?></h4>
   </tr>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="50%">
   <tr>
   <td><h4>Total Pollos: <?php echo number_format($totalpollos,2)." bs."; ?></h4></td><td><h4> <?php echo number_format($totalnpollos,2)." Und"; ?></h4>
   </tr>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="50%">
   <tr>
   <td><h4>Total hamburguesas: <?php echo number_format($totalhamburguesas,2)." bs."; ?></h4></td><td><h4><?php echo number_format($totalnhamburguesas,2)." Und"; ?> </h4>
   </tr>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="50%">
   <tr>
   
   <td><h4>Total gaseosas: <?php echo number_format($totalgaseosas,2)." bs."; ?></h4></td><td><h4> <?php echo number_format($totalngaseosas,2)." Und"; ?></h4>
   </tr>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="50%">
   <tr>
   <td><h4>Total sopas: <?php echo number_format($totalsopa,2)." bs."; ?></h4></td><td><h4><?php echo number_format($totalnsopa,2)." Und"; ?> </h4>
   </tr>
   </table>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="50%">
   <tr>
   <td><h4>Total combos: <?php echo number_format($totalcombos,2)." bs."; ?></h4></td><td><h4> <?php echo number_format($totalncombos,2)." Und"; ?></h4>
   </tr>
   </table>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="50%">
   <tr>
   <td><h4>Total porciones: <?php echo number_format($totalporciones,2)." bs."; ?></h4></td><td><h4> <?php echo number_format($totalnporciones,2)." Und"; ?></h4>
   </tr>
   </table>
    </div>
</body>

<!-- jQuery, Popper.js, Bootstrap JS -->
<script src="jquery/jquery-3.3.1.min.js"></script>
<script src="popper/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- datatables JS -->
<script type="text/javascript" src="datatables/datatables.min.js"></script>

<!-- para usar botones en datatables JS -->
<script src="datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>

<!-- código JS propìo-->
<script type="text/javascript" src="main.js"></script>

</html>