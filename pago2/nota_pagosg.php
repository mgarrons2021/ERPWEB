<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nota de Pagos Realizados</title>
    <link rel="stylesheet" href="nota_pago/style.css">
</head>

<body>
    <?php require_once '../config/conexion.inc.php';
    $id_compra = $_GET['id'];
    $pago = $db->Execute("SELECT p.compra_id, p.fecha as Fecha_Pago, p.monto, p.tipo_pago, p.deuda as Deuda_Pago, p.nro_factura, p.nit, p.fecha_vencimiento, p.banco, p.nro_cuenta, p.nro_cheque, p.nro_comprobante, p.nro_autorizacion, p.cod_control, c.*, pro.*  FROM pago p 
        INNER JOIN compra c ON c.nro = p.compra_id  
        INNER JOIN proveedor pro ON c.proveedor_id = pro.idproveedor WHERE p.compra_id = '$id_compra' ORDER BY p.id_pago DESC");
    $empreza = '';
    $codigo_empreza = 0;
    $nit_proveedor = 0;
    $celular_proveedor = 0;
    $total_compra = 0;

    if($pago){
        foreach ($pago as $p) {
            $empreza = $p['empreza'];
            $codigo_empreza = $p['codigo'];
            $nit_proveedor  = $p['nit'];
            $celular_proveedor = $p['celular'];
            $total_compra = $p['total'];
        }
    }

    ?>  
    <!-- <img class="pagada" src="nota_pago/img/pagada_actual.png" alt="Pagada" style="background-color: transparent !important;"> -->
    <div id="page_pdf">
        <!-- Cabecera -->
        <br>
        <table id="factura_head">
            <tr >
                <td class="logo_factura">
                    <div>
                        <img src="nota_pago/img/Logo_Correo.jpg" height="30%;" width="200px;">
                    </div>
                </td>
                <td style="text-align: center;">
                    <div>
                        <h1>DONESCO S.R.L.</h1>
                        <h2>Av. 3er anillo externo y Av. Santos Dumont</h2>
                        <h3>Santa Cruz-Bolivia</h3>
                        <h4>Teléfono: +(591) 78555410</h4>
                        <!-- <h4>Email: donesco@gmail.com</h4>-->
                    </div>
                </td>
                <!-- Datos de la factura -->
            </tr>
        </table>
        <div class="row justify-content-center">
            <h4 class="label_gracias">Pagos Realizados</h4>
        </div><br>

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
        <!-- Items -->
        <div class="row justify-content-center">
            <div class="col-md-auto text-center">
                <div class="table-responsive">
                    <div class="round">
                        <table id="customers">
                            <thead>
                                <tr>
                                    <th>No. Compra</th>
                                    <th>Banco</th>
                                    <th>No. Cuenta</th>
                                    <th>Fecha Pago</th>
                                    <th>No Factura</th>
                                    <th>Tipo Pago</th>
                                    <th>No. Cheque</th>
                                    <th>Monto Pagado</th>
                                    <th>Deuda</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                <?php 
                                if($pago){
                                    foreach($pago as $p){?>
                                <tr>
                                    <td><?=$p['compra_id']?></td>
                                    <td><?=$p['banco']?></td>
                                    <td><?=$p['nro_cuenta']?></td>
                                    <td><?=date('d/m/Y H:i:s', strtotime($p['Fecha_Pago']))?></td>
                                    <td><?=$p['nro_factura']?></td>
                                    <td><?=$p['tipo_pago']?></td>
                                    <td><?=$p['nro_cheque']?></td>
                                    <td><?=$p['monto']?> Bs.</td>
                                    <td><?=$p['Deuda_Pago']?> Bs.</td>
                                </tr>
                                <?php } }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div>
			<p class="nota">Si usted tiene preguntas sobre esta factura, <br>pongase en contacto con el proveedor</p>
                <?php if($pago){?>
                    <h4 class="label_gracias" style="color: green;">Total Compra: <?= number_format($total_compra,2)?> Bs.</h4>
                <?php }?>
		</div>
    </div>
</body>
</html>