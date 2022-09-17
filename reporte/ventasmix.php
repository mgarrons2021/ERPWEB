<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="#" />
    <title>Reporte Producción y Ventas</title>
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css" />
    <!--datables estilo bootstrap 4 CSS-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <!--font awesome con CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

</head>

<body class="body">
    <?php
    set_time_limit(300);
    include "../menu/menu.php";
    include '../config/conexion.producto.php';
    $consulta_sucursal = "SELECT * FROM sucursal ORDER BY idsucursal DESC";
    $sucursales = mysqli_query($db, $consulta_sucursal);
    $resultado_sucursal = array();
    if ($sucursales && mysqli_num_rows($sucursales) >= 1) {
        $resultado_sucursal = $sucursales;
    }
    if (isset($_POST['sucursal']) && isset($_POST['fechaini'])  && isset($_POST['fechamax'])) {
        $sucursal_id = $_POST['sucursal'];
        $fecha_min = $_POST["fechaini"];
        $fecha_max = $_POST["fechamax"];
        $consulta = "SELECT p.categoria, p.nombre AS plato, prod.nombre, s.nombre AS sucursal, 
        sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * 			dp.cantidad as cantidadproducto,  dp.cantidad
        FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
        WHERE v.estado = 'V' 
        AND v.fecha BETWEEN '$fecha_min' AND '$fecha_max'
        AND v.sucursal_id = $sucursal_id 
        AND v.sucursal_id = s.idsucursal 
        AND v.idturno = t.idturno AND t.nro = v.turno 
        AND dv.nro = v.nro AND dv.idturno = v.idturno
        and dv.sucursal_id = s.idsucursal
        and dp.nro = p.nro
        and prod.idproducto = dp.producto_id
        AND p.idplato = dv.plato_id 
        GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;";
    } else {
        $sucursal_id = 0;
        $fecha_min = date('d-m-Y');
        $fecha_max = date('d-m-Y');
        $comida_personal = "SELECT p.categoria, p.nombre AS plato, prod.nombre, s.nombre AS sucursal, 
        sum(dv.cantidad) as cantidad, v.fecha, v.hora, t.nro as turno  , sum(dv.cantidad) * 			dp.cantidad as cantidadproducto,  dp.cantidad
        FROM turno t, venta v, detalleventa dv, plato p, sucursal s, detalleplato dp, producto prod
        WHERE v.estado = 'V' 
        AND v.fecha BETWEEN '$fecha_min' AND '$fecha_max'
        AND v.sucursal_id = $sucursal_id 
        AND v.sucursal_id = s.idsucursal 
        AND v.idturno = t.idturno AND t.nro = v.turno 
        AND dv.nro = v.nro AND dv.idturno = v.idturno
        and dv.sucursal_id = s.idsucursal
        and dp.nro = p.nro
        and prod.idproducto = dp.producto_id
        AND p.idplato = dv.plato_id 
        GROUP BY v.fecha, v.turno, p.categoria, p.nombre, prod.nombre;";
    }

    $ventas = mysqli_query($db, $consulta);
    $resultado = array();
    if ($ventas && mysqli_num_rows($ventas) >= 1) {
        $resultado = $ventas;
    }
    ?>

    <div class="container">
        <div class="left-sidebar">
            <h2>Reporte Producción y Ventas</h2>
            <div class="table-responsive">
                <form action="reporte_produccion_ventas.php" method="POST">
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
                                <!--<input id="appt-time" type="time" id="horaini" class="input-sm form-control" name="horaini" step="2" required />-->
                                <span class="input-group-addon">A</span>
                                <input type="date" id="fechamax" class="input-sm form-control" name="fechamax" required />
                                <!--<input id="appt-time" type="time" id="horamax" class="input-sm form-control" name="horamax" step="2" required />-->
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="submit" value="filtrar">
                        </div>
                    </div>
                </form>
                <br>
                <table id="productos" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($ventas as $venta) { ?>
                            <tr class=warning>
                                <td><?= $venta['categoria'] ?></td>
                                <td><?= $venta['nombre'] ?></td>
                                <td><?= $venta['cantidadproducto'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot align="right">
                    <tr colspan="6">
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    </div>
    <!-- Datatable -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript"></script>
</body>

<!-- datatables JS -->
<script type="text/javascript" src="datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#productos').DataTable({
            footerCallback: function(tfoot, data, start, end, display) {
            var api = this.api();
            $(api.column(2).footer()).html(
            "Total: " + api.column(2).data().reduce(function(a, b) {
                var x = parseFloat(a) || 0;
                var y = parseFloat(b) || 0;
                x.toFixed(2);
                y.toFixed(2);
                r = (x + y).toFixed(2);
                return r ;
            }, 0)
            );
        }

        });
    });
</script>

<!-- código JS propìo-->
<script type="text/javascript" src="main.js"></script>
</html>