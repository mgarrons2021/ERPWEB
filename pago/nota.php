<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nota de pago</title>
    <link rel="stylesheet" href="nota_pago/style.css">
</head>

<body>
    <?php require_once '../config/conexion.inc.php';
    //Consulta para sacar los datos del pago seleccionado 
    $id_pago = $_GET['id'];
    // var_dump($id_pago);
    // die();
    $pago = $db->Execute("SELECT p.compra_id, p.fecha as Fecha_Pago, p.monto, p.tipo_pago, p.deuda as Deuda_Pago, p.nro_factura, p.nit, p.fecha_vencimiento, p.banco, p.nro_cuenta, p.nro_cheque, p.nro_comprobante, p.nro_recibo, p.nro_autorizacion, p.cod_control, c.*, pro.*  
        FROM pago p 
        INNER JOIN compra c ON c.nro = p.compra_id  
        INNER JOIN proveedor pro ON c.proveedor_id = pro.idproveedor
        WHERE id_pago = '$id_pago'");
    foreach ($pago as $p) {
        $empreza = $p['empreza'];
        $codigo_empreza = $p['codigo'];
        $nit_proveedor  = $p['nit'];
        $celular_proveedor = $p['celular'];
        $nro    = $p['compra_id'];
        $fecha_pago  = $p['Fecha_Pago'];
        $monto   = $p['monto'];
        $tipo_pago = $p['tipo_pago'];
        $deuda   = $p['Deuda_Pago'];
        $nro_factura = $p['nro_factura'];
        $nit     = $p['nit'];
        $fecha_vencimiento = $p['fecha_vencimiento'];
        $banco   = $p['banco'];
        $nro_cuenta = $p['nro_cuenta'];
        $nro_comprobante = $p['nro_comprobante'];
        $nro_cheque     = $p['nro_cheque'];
        $nro_autorizacion = $p['nro_autorizacion'];
        $cod_control = $p['cod_control'];
        $nro_recibo  = $p['nro_recibo'];
    }
    ?>
    <!-- <img class="pagada" src="nota_pago/img/pagada_actual.png" alt="Pagada" style="background-color: transparent !important;"> -->
    <div id="page_pdf">
        <!-- Cabecera -->
        <br>
        <table id="factura_head">
            <tr>
                <td class="logo_factura">
                    <div>
                        <img src="nota_pago/img/Logo_Correo.jpg" height="30%;" width="200px;">
                    </div>
                </td>
                <td class="info_empresa">
                    <div>
                        <h1>Donesco SRL</h1>
                        <h2>Av. 3er anillo externo y Av. Santos Dumont</h2>
                        <h3>Santa Cruz-Bolivia</h3>
                        <h4>Teléfono: +(591) 78555410</h4>
                        <h4>Email: donesco@gmail.com</h4>
                    </div>
                </td>
                <!-- Datos de la factura -->
                <td class="info_empresa">
                    <div class="round">
                        <span class="h3">Datos Compra</span>
                        <?php if($nro_factura != 0){?>
                        	<p> <strong>No. Factura: <?= $nro_factura ?></strong></p>
                        <?php } else { ?>
                        	<p> <strong>No. Recibo: <?= $nro_recibo ?></strong></p>
                        <?php }?>
                        <p>F. Emision: <?= date('d/m/Y H:i:s', strtotime($fecha_pago)) ?></p>
                        <p>F. Vencimiento: <?= date('d/m/Y', strtotime($fecha_vencimiento)) ?></p>
                        <p>No. Autorización: <?= $nro_autorizacion ?></p>
                        <p>Cod. Control: <?= $cod_control ?></p>
                    </div>
                </td>
            </tr>
        </table> <br>

        <table id="factura_cliente">
            <tr>
                <td class="info_cliente">
                    <div class="round">
                        <span class="h3">Empresa</span>
                        <!-- 1eros datos para la factura -->
                        <table class="datos_cliente">
                            <tr>
                                <td>
                                    <label>Nit/Ci:</label>
                                    <?php if ($nit_proveedor == '') { ?>
                                        <p style="color: black;">S/Nit</p>
                                    <?php } else { ?>
                                        <p><?= $nit_proveedor  ?></p>
                                    <?php } ?>
                                </td>

                                <td>
                                    <label>Celular:</label>
                                    <?php if ($celular_proveedor == 0) { ?>
                                        <p style="color: black;">S/celular</p>
                                    <?php } else { ?>
                                        <p><?= $celular_proveedor ?></p>
                                    <?php } ?>
                                </td>

                                <td>
                                    <label>Cod. empresa</label>
                                    <?php if ($codigo_empreza == '') { ?>
                                        <p style="color: black;">S/C</p>
                                    <?php } else { ?>
                                        <p><?= $codigo_empreza ?></p>
                                    <?php } ?>
                                </td>

                                <td>
                                    <label>Empreza</label>
                                    <p><?= $empreza ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <br>
        <!-- Items -->
        <div class="row justify-content-center">
            <div class="col-md-auto text-center">
                <div class="table-responsive">
                    <div class="round">
                        <table id="customers">
                            <thead>
                                <tr>
                                    <th>Nro de Compra</th>
                                    <th>Banco</th>
                                    <th>No. Cuenta</th>
                                    <th>Tipo Pago</th>
                                    <th>No. Cheque</th>
                                    <th>Monto Pagado</th>
                                    <th>Deuda</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                <tr>
                                    <td><?=$nro?></td>
                                    <td><?=$banco?></td>
                                    <td><?=$nro_cuenta?></td>
                                    <td><?=$tipo_pago?></td>
                                    <td><?=$nro_cheque?></td>
                                    <td><?=$monto?> Bs.</td>
                                    <td><?=$deuda?> Bs.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div>
			<p class="nota">Si usted tiene preguntas sobre esta factura, <br>pongase en contacto con el proveedor</p>
			<?php if($deuda == 0){  ?>
                <h4 class="label_gracias" style="color: green;">¡Pago Realizado!</h4>
            <?php } else { ?>
                <h4 class="label_gracias" style="color: red;">¡Verifique su deuda, <br>Faltan pago por realizar!</h4>
            <?php } ?>
		</div>
    </div>
</body>

</html>