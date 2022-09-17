<?php include "../menu/menu.php";
require_once '../config/conexion.inc.php';
$nro_compra  = $_GET['nro'];
$usuario = $_SESSION['usuario'];
$sucur = $usuario['sucursal_id'];
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
                        <button type="button" class="btn btn-success btn-sm" id="<?= $nro_compra ?>" data-toggle="modal" data-target="#modalpago">Agregar pago</button><br>
                    <?php } ?>
                </div>
                <div class="col-md-6">
                    <a href="nota_pagosg.php?id=<?= $nro_compra ?>" class="btn btn-info btn-sm pull-right" target='_blank' role='button'>Reporte General</a>
                    <!-- <a href="nota_pagosgprueba.php?id=<?= $nro_compra ?>" class="btn btn-info btn-sm pull-right" target='_blank' role='button'>Reporte General Prueba Impresion Directa</a> -->
                </div>
            </div>&nbsp;

            <!-- Modal  para agregar pago-->
            <div class="modal fade" id="modalpago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel" style="text-align: center; color: #008080;;">Registrar Pago <br> Cod. de Compra (<?= $nro_compra ?>)</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Formulario para agregar el pago -->
                        <form method="POST" action="agregar.php">
                            <div class="modal-body">
                                <input type="hidden" name="nro_compra" readonly value="<?= $nro_compra ?>" />
                                <input type="hidden" name="deuda" readonly value="<?= $deuda ?>" />
                                <!-- 1er Fila -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Banco<span style="color: red;">*</span></label>
                                        <div class="form-group bmd-form-group">
                                            <input type="text" name="banco" id="banco" class="form-control input-sm" placeholder="Ingrese el banco" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Nro cuenta<span style="color: red;">*</span></label>
                                        <div class="form-group bmd-form-group">
                                            <input type="number" name="nro_cuenta" id="nro_cuenta" class="form-control input-sm" placeholder="Nro cuenta" min="0" required>
                                        </div>
                                    </div>

                                    <!-- Tipo pago -->
                                    <div class="col-md-3">
                                        <label>Tipo de Pago:<span style="color: red;">*</span></label>
                                        <select name="tipo_pago" id="tipo_pago" class="form-control input-sm">
                                            <option value="cheque">Cheque</option>
                                            <option value="credito">Crédito</option>
                                            <option value="contado">Contado</option>
                                        </select>
                                    </div>



                                </div>

                                <!-- 3er fila -->
                                <div class="row">

                                    <!-- Monto a pagar -->
                                    <div class="col-md-5">
                                        <label>Ingrese el monto a pagar <span style="color: red;">*</span></label>
                                        <div class="form-group bmd-form-group">
                                            <input type="text" name="monto" id="monto" class="form-control input-sm" placeholder="ingresa el monto a pagar" required>
                                        </div>
                                    </div>

                                    <!-- Nro comprobante -->
                                    <div class="col-md-4">
                                        <label>Nro comprobante<span style="color: red;">*</span></label>
                                        <div class="form-group bmd-form-group">
                                            <input type="number" name="nro_comprobante" id="nro_comprobante" class="form-control input-sm" placeholder="Nro comprobante" min="0" required>
                                        </div>
                                    </div>

                                    <!-- nro de cheque  -->
                                    <div class="col-md-3">
                                        <label>Nro Cheque: <strong style="color: red;">*</strong></label>
                                        <input type="number" name="nro_cheque" class="form-control input-sm" placeholder=" nro de cheque" min="0" required>
                                    </div>

                                    <!-- C/f o S/F -->
                                    <div class="col-md-4">
                                        <label>Factura:<span style="color: red;">*</span></label>
                                        <select name="emite_factura" id="emite_factura" class="form-control input-sm">
                                            <option value="si">Si</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                    
                                    <!--Nro de factura-->
                                    <div class="col-md-4">
                                        <label>Nro Factura:<span style="color: red;">*</span></label>
                                        <input type="number" name="nro_factura" id="nro_factura" class="form-control input-sm" min="0" placeholder="Nro Factura">

                                    </div>
                                    
                                    <!-- Con Recibo -->
                                    <div class="col-md-3">
                                        <label>Recibo:<span style="color: red;">*</span></label>
                                        <select name="recibo" id="recibo" class="form-control input-sm">
                                            <option value="si">Si</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                    
                                    <!--Nro de factura-->
                                    <div class="col-md-4">
                                        <label>Nro Recibo:<span style="color: red;">*</span></label>
                                        <input type="number" name="nro_recibo" id="nro_recibo" class="form-control input-sm" min="0" placeholder="Nro Recibo">

                                    </div>

                                </div><br>

                                <!-- 4er Fila -->
                                <div class="row">
                                    <!-- fecha de vencimiento -->
                                    <div class="col-md-5">
                                        <label>F. Vencimiento: <strong style="color: red;">*</strong></label>
                                        <input type="date" name="fecha_vencimiento" class="form-control input-sm" required>
                                    </div>

                                    <!-- Nit -->
                                    <div class="col-md-5">
                                        <label>Nit: <strong style="color: red;">*</strong></label>
                                        <input type="number" name="nit" class="form-control input-sm" min="0" placeholder="Nro Nit" min="0" required>
                                    </div>


                                </div> <br>
                                <div class="row">
                                    <!-- Nro de autorizacion -->
                                    <div class="col-md-5">
                                        <label>Nro Autorización: <strong style="color: red;">*</strong></label>
                                        <input type="number" name="nro_autorizacion" class="form-control input-sm" min="0" placeholder="Nro  autorizacion" required>
                                    </div>
                                    <!-- Cod control -->
                                    <div class="col-md-5">
                                        <label>Código Control: <strong style="color: red;">*</strong></label>
                                        <input type="number" name="codigo_control" class="form-control input-sm" min="0" placeholder="Nro cod. control" required>
                                    </div>
                                </div><br>

                                <!-- 5da Fila -->
                                <div class="row">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-success" value="Registrar"></button>
                            </div>
                        </form>

                        
                    </div>
                </div>

            </div>

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