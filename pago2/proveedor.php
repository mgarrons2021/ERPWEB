<html>
<title>Listados de Compra </title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
<link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
</head>

<body class="body">
    <?php include "../menu/menu.php";

    require_once '../config/conexion.producto.php';
    $usuario = $_SESSION['usuario'];
    $sucur = $usuario['sucursal_id'];
    $user = $usuario['idusuario'];
    $sucursales = "0";
    $nomsucur = "";
    if ($sucursales == "0") {

        $nomsucur = "TODAS";
    }

    if (isset($_POST['sucursales'])) {

        $sucursales = $_POST['sucursales'];
    }

    ?>
    <div class="container">
        <div class="left-sidebar">
            <h2>listado de Compras3</h2>
            <div class="table-responsive">

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
                <script src="../js/jquery.js"></script>
                <script src="../js/bootstrap.min.js"></script>
                <script src="../js/jquery.dataTables.min.js"></script>
                <script src="../js/dataTables.bootstrap.min.js"></script>
                <script src="../data/librerias/calendario2/js/bootstrap-datepicker.min.js"></script>
                <script src="../data/librerias/calendario2/locales/bootstrap-datepicker.es.min.js"></script>
                <script src="../js/bootstrap.min.js"></script>
                <script src="../js/jquery.dataTables.min.js"></script>
                <script src="../js/dataTables.bootstrap.min.js"></script>
                <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js">
                </script>
                <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
                <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
                <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
                <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
                <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
                <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
                <script type="text/javascript">
                    $(document).ready(function() {
                        // Setup - add a text input to each footer cell
                        // DataTable
                        var table = $('#usuario').DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                'print',
                                {
                                    extend: 'pdfHtml5',
                                    title: 'Envio de produccion',
                                    message: ''

                                }
                            ],
                            "language": {
                                "sProcessing": "Procesando...",
                                "sLengthMenu": "Mostrar _MENU_ registros",
                                "sZeroRecords": "No se encontraron resultados",
                                "sEmptyTable": "Ningun dato disponible en esta tabla",
                                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                                "sInfoPostFix": "",
                                "sSearch": "Buscar:",
                                "sUrl": "",
                                "sInfoThousands": ",",
                                "sLoadingRecords": "Cargando...",
                                "oPaginate": {
                                    "sFirst": "Primero",
                                    "sLast": "Ãšltimo",
                                    "sNext": "Siguiente",
                                    "sPrevious": "Anterior",

                                },
                                "oAria": {
                                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                }
                            }
                        }); // Apply the search
                        table.columns().every(function() {
                            var that = this;
                            $('input', this.footer()).on('keyup change', function() {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            });
                        });

                    });
                </script>
                <form action="proveedor.php" method="POST">
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
                            <br>

                            <input type="hidden" name="sucursal" id="sucursal" value="<?php if (isset($_GET['sucursal'])) {
                                                                                            echo $_GET['sucursal'];
                                                                                        } else {
                                                                                            echo  "1";
                                                                                        }  ?>" />

                            <div class="input-group">
                                <span class="input-group-addon">Sucursales:</span>
                                <select name="sucursales" id="sucursales" onchange="myFunction(this.value)">
                                    <option value="<?php
                                                    if (isset($_POST['sucursales'])) {
                                                        echo $_POST['sucursales'];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?>"> <?php
                                                            if ($sucursales == "0") {

                                                                echo $nomsucur;
                                                            } else {
                                                                $srucur = $_POST['sucursales'];

                                                                $sucut = mysqli_query($dbds, "SELECT nombre FROM sucursal WHERE idsucursal = $srucur");

                                                                $sucursa = mysqli_fetch_array($sucut);

                                                                echo $sucursa["nombre"];
                                                            }
                                                            ?></option>

                                    <option value="0">TODAS</option>

                                    <?php

                                    $queryt = mysqli_query($db, "SELECT idsucursal, nombre FROM sucursal");

                                    while ($valores = mysqli_fetch_array($queryt)) {
                                        echo '<option value="' . $valores['idsucursal'] . '">' . $valores['nombre'] . '</option>';
                                    }

                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
                        </div>
                    </div>
                </form>
                <br>
                <?php
                if (isset($_POST['fechaini']) &&  isset($_POST['fechamax'])) {

                    $min = $_POST["fechaini"];
                    $max = $_POST["fechamax"];


                    $proveedor = mysqli_query($db, "SELECT idproveedor, empreza FROM proveedor");
                } else {

                    $min = date("Y-m-d");
                    $max = date("Y-m-d");


                    $proveedor = mysqli_query($db, "SELECT idproveedor, empreza FROM proveedor");
                }

                ?>
                <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">



                    <thead>
                        <tr>
                            <th>Proveedor</th>
                            <th>Sucursal</th>
                            <th>Total</th>
                            <th>Pagado</th>
                            <th>Deuda</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        while ($fila = mysqli_fetch_array($proveedor)) {

                           $idproveedor = $fila["idproveedor"];

                            if ($sucursales == "0") {

                                $result = mysqli_query($db, "SELECT  SUM(c.total) AS total, SUM(c.deuda) as deuda FROM compra c
      INNER JOIN sucursal suc on c.sucursal_id = suc.idsucursal
      WHERE c.fecha  BETWEEN '$min' and '$max' AND c.proveedor_id = $idproveedor");


                                $sumcursa = mysqli_fetch_array($result);

                                $pagado = $sumcursa["total"] - $sumcursa["deuda"];
                            } else {
                                $result = mysqli_query($db, "SELECT  SUM(c.total) AS total, SUM(c.deuda) as deuda FROM compra c
    INNER JOIN sucursal suc on c.sucursal_id = suc.idsucursal
    WHERE c.fecha  BETWEEN '$min' and '$max' AND c.proveedor_id = $idproveedor AND c.sucursal_id = '$sucursales'");
                                $sumcursa = mysqli_fetch_array($result);

                                $pagado = $sumcursa["total"] - $sumcursa["deuda"];
                            }

                        ?>
                            <tr class=warning>

                                <td><?php echo $fila["idproveedor"]; ?></td>
                                <td><?php echo $fila["empreza"]; ?></td>
                                <td><?php echo $sumcursa["total"]; ?></td>
                                <td><?php echo $pagado; ?></td>
                                <td><?php echo $sumcursa["deuda"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script>
    function myFunction(val) {
        var sus = document.getElementById("sucursals").val();

        location.href = "../pago2/proveedor.php?sucursal=" + sus;
    }
</script>

</html>