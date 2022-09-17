<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="#" />
    <title>Cronologia de Ventas por sucursal</title>

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
    $consulta_sucursal = "SELECT * FROM sucursal ORDER BY idsucursal DESC";
    $sucursales = mysqli_query($db, $consulta_sucursal);
    $resultado_sucursal = array();
    if ($sucursales && mysqli_num_rows($sucursales) >= 1) {
        $resultado_sucursal = $sucursales;
    }

    if (isset($_POST['sucursal']) && isset($_POST['fechaini']) && isset($_POST['horaini']) && isset($_POST['fechamax']) && isset($_POST['horamax'])) {
        $sucursal_id = $_POST['sucursal'];
        $fecha_min = $_POST["fechaini"];
        $hora_min  = $_POST["horaini"];
        $fecha_max = $_POST["fechamax"];
        $hora_max  = $_POST["horamax"];
       
       $consulta = "SELECT p.categoria, p.nombre AS plato, s.nombre AS sucursal, sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno 
FROM turno t, venta v, detalleventa dv, plato p, sucursal s 
WHERE v.estado = 'V' 
AND v.fecha BETWEEN '$fecha_min' AND '$fecha_max' 
AND v.hora BETWEEN '$hora_min' AND '$hora_max' 
AND v.sucursal_id = '$sucursal_id' 
AND v.sucursal_id = s.idsucursal 
AND v.idturno = t.idturno 
AND t.nro = v.turno AND dv.nro = v.nro 
AND dv.idturno = v.idturno 
AND p.idplato = dv.plato_id GROUP BY v.fecha, v.turno, p.categoria, p.nombre";

    } else {
        $sucursal_id = 0;
        $fecha_min = date('d-m-Y');
        $hora_min  = time();
        $fecha_max = date('d-m-Y');
        $hora_max  = time();
        $consulta = "SELECT p.categoria, p.nombre AS plato, s.nombre AS sucursal, 
        count(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno 
        FROM turno t, venta v, detalleventa dv, plato p, sucursal s 
        WHERE v.estado = 'V' 
        AND v.fecha BETWEEN '$fecha_min' AND '$fecha_max'
        AND v.hora BETWEEN '$hora_min' AND '$hora_max' 
        AND v.sucursal_id = '$sucursal_id' 
        AND v.sucursal_id = s.idsucursal 
        AND v.idturno = t.idturno AND t.nro = v.turno 
        AND dv.nro = v.nro AND dv.idturno = v.idturno 
        AND p.idplato = dv.plato_id GROUP BY p.idplato";

        $monto_total = 0.00;
    }

    $ventas = mysqli_query($db, $consulta);
    $resultado = array();
    if ($ventas && mysqli_num_rows($ventas) >= 1) {
        $resultado = $ventas;
    }

    ?>

    <div class="container">
        <div class="left-sidebar">
            <h2>Cronologia de Ventas por Sucursal</h2>

            <div class="table-responsive">
                <form action="reporte_general_sucursal.php" method="POST">
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
                                <input type="date" id="fechaini" class="input-sm form-control" name="fechaini" required />
                                <input id="appt-time" type="time" id="horaini" class="input-sm form-control" name="horaini" step="2" required />
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
                            <th>Plato</th>
                            <th>Sucursal</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Turno</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($resultado as $venta) { ?>
                            <tr class=warning>
                                <td><?= $venta['categoria'] ?></td>
                                <td><?= $venta['plato'] ?></td>
                                <td><?= $venta['sucursal'] ?></td>
                                <td><?= $venta['cantidad'] ?></td>
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
                </table>
                <!-- <table class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                    <tr>
                        <td><h4>Total</h4></td>
                        <td><h4>Bs.</h4></td>
                    </tr>
                </table> -->
            </div>
        </div>
    </div>
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