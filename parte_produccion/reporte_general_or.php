<html>

<head>
    <title>Reorte General - Parte Producción</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="../js/jquery.js"></script>
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">

</head>

<body class="body">
    <?php include "../menu/menu.php";

    $usuario = $_SESSION['usuario'];

    ?>

    <div class="container">
        <div class="left-sidebar">
            <h2>Lista General de Parte Produccion</h2>

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
                <form action="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                                <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" />
                                <span class="input-group-addon">A</span>
                                <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" />
                                <input type="hidden" id="form_sent" name="form_sent" value="true">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
                        </div>
                    </div>
                </form>

                <br>

                <?php if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
                    $min = $_GET["fechaini"];
                    $max = $_GET["fechamax"];
                    $query = $db->GetAll("SELECT t.*, t.fecha, u.nombre AS usuario,t.total FROM parte_produccion t,usuario u 
                                  WHERE t.usuario_id = u.idusuario AND t.Fecha BETWEEN '$min' AND '$max'");
                } else {
                    $min = date('Y-m-d');
                    $max = date('Y-m-d');

                    $query = $db->GetAll("SELECT t.*, t.fecha, u.nombre AS usuario, t.total FROM parte_produccion t,usuario u
                                WHERE t.usuario_id=u.idusuario  AND t.Fecha BETWEEN '$min' AND '$max'");
                }

                ?>

                <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Usuario</th>
                            <th>De Sucursal</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nro = 0;
                        $total = 0;
                        foreach ($query as $r) {
                            $nro = $nro + 1;
                            $total = $total + $r["total"] ?>
                            <tr class="warning">
                                <td><?php echo $nro; ?></td>
                                <td><?php echo $r["fecha"]; ?></td>
                                <td><?php echo $r["hora"]; ?></td>
                                <td><?php echo $r["usuario"]; ?></td>
                                <td><?php echo $db->GetOne('SELECT nombre FROM sucursal where idsucursal = ' . $r['sucursal_id']); ?></td>

                                <td><?php echo number_format($r["total"], 2); ?> bs.</td>
                            </tr>
                        <?php } ?>
                </table>
                <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                    <tr>
                        <td>
                            <h4>Total parte de produccion</h4>
                        </td>
                        <td>
                            <h4> <?php echo number_format($total, 2); ?> Bs.</h4>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>