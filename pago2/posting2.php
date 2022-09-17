<?php
include "../menu/menu.php";
require_once '../config/conexion.inc.php';
$fechahoy = date('Y-m-d h:i:s');
$nro = $_GET["nro"];
$porciones = explode("k", $nro);
$cuenta = count($porciones);
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
                    <a href="../compra2/index2.php" class="btn btn-success btn-sm"> Agregar pago</a>
                </div>
                <div class="col-md-6">
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
                        for ($i = 1; $i < $cuenta; $i++) {
                            $querst = $db->Execute("SELECT id_pago as idmax, p.compra_id, p.nro_factura, p.fecha, p.monto, p.deuda, c.estado, c.total FROM pago p INNER JOIN compra c ON  c.nro = p.compra_id where id_pago = (SELECT MAX(id_pago) AS ids from pago WHERE compra_id = $porciones[$i]) ");
                            foreach ($querst as $reg) {
                        ?>
                                <tr class="warning">
                                    <td> <?php echo $reg["compra_id"] ?> </td>
                                    <td> <?php echo $reg["nro_factura"] ?> </td>
                                    <td> <?php echo date('d/m/Y H:i:s', strtotime($reg["fecha"]))  ?> </td>
                                    <td> <?php echo number_format($reg["monto"], 2) . ' Bs.' ?></td>
                                    <td> <?php echo number_format($reg["deuda"], 2) . ' Bs.' ?></td>
                                    <td> <?php echo number_format($reg["total"], 2) . ' Bs.' ?></td>
                                    <td><?php echo "<a class='' href='nota.php?nro=$nro' target='_blank' role='button'><img src='../images/pdf.png' alt=''>PDF</a>"; ?></td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>