<?php include "../menu/menu.php";
require_once '../config/conexion.inc.php';
$nro_compra  = $_GET['nro'];
echo $nro_compra;
$usuario = $_SESSION['usuario'];
$sucur = $usuario['sucursal_id'];
$sacardatos = $db->GetOne( "SELECT * FROM `pago` WHERE compra_id = $nro_compra");
//Consulta para sacar la deuda de la compra seleccionada
$query_compra = $db->Execute("SELECT c.deuda FROM compra c WHERE c.nro = '$nro_compra'"); //sacar la deuda de la compra seleccionada 
// $query_deuda  = $db->Execute("SELECT p.* FROM pago p where p.compra_id = '$nro_compra'");
//Consulta para sacar la deuda
foreach ($query_compra as $r) {
    $deuda = number_format($r['deuda'], 2);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Listados de Deudas</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
    <style type="text/css">
        label {
            color: #000000;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: 500;
        }
    </style>
</head>
<body class="body">
    <div class="container">
        <div class="left-sidebar">
            <h2>Listado de pagos</h2>
            <!-- Boton para agregar el pago -->
            <div class="row">
                <div class="col-md-6">
                    <?php if ($deuda != '0.00') { ?>
                        <a href="../compra2/index2.php" class="btn btn-success btn-sm"> Agregar pago</a>
                    <?php } ?>
                </div>
                <div class="col-md-6">
                    <a href="nota_pagosg.php?id=<?= $nro_compra ?>" class="btn btn-info btn-sm pull-right" target='_blank' role='button'>Reporte General</a>
                    <!-- <a href="nota_pagosgprueba.php?id=<?= $nro_compra ?>" class="btn btn-info btn-sm pull-right" target='_blank' role='button'>Reporte General Prueba Impresion Directa</a> -->
                </div>
            </div>&nbsp;
            <div class="table-responsive">
                <script src="../js/bootstrap.min.js"></script>
                <script src="../js/jquery.dataTables.min.js"></script>
                <script src="../js/dataTables.bootstrap.min.js"></script>
                <table id="deudas" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nro. Compra</th>
                            <th>Nro Factura</th>
                            <th>Fecha de Pago</th>
                            <th>Monto Pagado</th>
                            <th>Deuda</th>
                            <th>Total Compra</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                $deudas = $db->Execute("SELECT p.*, c.estado, c.total FROM pago p INNER JOIN compra c ON  c.nro = p.compra_id  WHERE p.compra_id = $nro_compra   ORDER BY p.id_pago DESC");
                        // var_dump($deudas);
                        foreach ($deudas as $reg) { ?>
                            <tr class="warning">
                                <td> <?php echo $reg["compra_id"] ?> </td>
                                <td> <?php echo $reg["nro_factura"] ?> </td>
                                <td> <?php echo date('d/m/Y H:i:s', strtotime($reg["fecha"]))  ?> </td>
                                <td> <?php echo number_format($reg["monto"], 2) . 'Bs' ?></td>
                                <td> <?php echo number_format($reg["deuda"], 2) . 'Bs' ?></td>
                                <td> <?php echo number_format($reg["total"], 2) . 'Bs' ?></td>
                                <td><?php echo "<a class='' href='nota.php?id=$reg[id_pago]'; target='_blank' role='button'><img src='../images/pdf.png' alt=''>PDF</a>"; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#deudas").DataTable({
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
                },
                oAria: {
                    sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                    sSortDescending: ": Activar para ordenar la columna de manera descendente"
                }
            });
        });
    </script>
</body>
</html>