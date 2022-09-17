<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nota de pago</title>
    <link rel="stylesheet" href="nota_pago/style.css">
</head>

<body>

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
        </table> <br>
        <br>
        <table id="factura_cliente">
            <tr>
                <td class="info_cliente">
                    <div class="round">
                        <span class="h3">Empresa</span>
                        <table class="datos_cliente">
                            <tr>
                                <td>
                                    <label> Fecha de pago:</label>
                                </td>
                                <td>
                                    <label>Nit/Ci:</label>
                                </td>
                                <td>
                                    <label>Celular:</label>
                                </td>
                                <td>
                                    <label>Cod. empresa</label>
                                </td>
                                <td>
                                    <label>Empreza</label>
                                </td>
                            </tr>
                            <?php
                            require_once '../config/conexion.inc.php';
                            $nro = $_GET["nro"];
                            $sucursal = $_GET["sucursal"];
                            $pago = $db->Execute("SELECT p.compra_id, p.fecha as Fecha_Pago, p.monto, p.tipo_pago, p.deuda as Deuda_Pago, p.nro_factura, p.nit, p.fecha_vencimiento, p.banco, p.nro_cuenta, p.nro_cheque, p.nro_comprobante, p.nro_recibo, p.nro_autorizacion, p.cod_control, c.*, pro.*  
        FROM pago p 
        INNER JOIN compra c ON c.nro = p.compra_id  
        INNER JOIN proveedor pro ON c.proveedor_id = pro.idproveedor
        WHERE  p.id_pago = (SELECT MAX(id_pago) AS ids from pago WHERE compra_id = $nro)");
                            foreach ($pago as $p) {
                            ?>
                                <table id="factura_cliente">
                                    <tr>
                                        <td class="info_cliente">
                                            <div class="round">
                                                <table class="datos_cliente">
                                                    <tr>
                                                        <td>
                                                            <?php
                                                            $originalDate = $p['Fecha_Pago'];
                                                            $timestamp = strtotime($originalDate);
                                                            $newDate = date("m-d-Y", $timestamp); ?>
                                                            <p class="textcenter"><?php echo $newDate; ?>
                                                        </td>
                                                        <?php  ?>
                                        </td>
                                        <td>
                                            <?php if ($p['nit'] == '') { ?>
                                                <p style="color: black;">S/Nit</p>
                                            <?php } else { ?>
                                                <p><?php echo $p['nit'];  ?></p>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($p['celular'] == 0) { ?>
                                                <p style="color: black;">S/celular</p>
                                            <?php } else { ?>
                                                <p><?php echo $p['celular']; ?></p>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($p['codigo'] == '') { ?>
                                                <p style="color: black;">S/C</p>
                                            <?php } else { ?>
                                                <p><?php $p['codigo']; ?></p>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <p><?php echo $p['empreza']; ?></p>
                                        </td>
                                    </tr>
                                </table>
                    </div>
                </td>
            </tr>
        </table>
    <?php } ?>
    <div class="row justify-content-center">
        <div class="col-md-auto text-center">
            <div class="table-responsive">
                <div class="round">
                    <table id="customers">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Fecha</th>
                                <th>Banco</th>
                                <th>No. Cuenta</th>
                                <th>Tipo Pago</th>
                                <th>No. Cheque</th>
                                <th>Monto Pagado</th>
                                <th>Deuda</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            <?php
                            $pago = $db->Execute("SELECT p.compra_id, p.fecha as Fecha_Pago, p.monto, p.tipo_pago, p.deuda as Deuda_Pago, p.nro_factura, p.nit, p.fecha_vencimiento, p.banco, p.nro_cuenta, p.nro_cheque, p.nro_comprobante, p.nro_recibo, p.nro_autorizacion, p.cod_control, c.*, pro.*  
                FROM pago p 
                INNER JOIN compra c ON c.nro = p.compra_id  
                INNER JOIN proveedor pro ON c.proveedor_id = pro.idproveedor
                WHERE p.compra_id = $nro");
                            foreach ($pago as $p) {
                            ?>
                                <tr>
                                    <?php if ($p['nro_factura'] != 0) { ?>
                                        <td> <strong>Nro. Factura: </strong><?php echo $p['nro_factura']; ?></td>
                                    <?php } else { ?>
                                        <td> <strong>Nro. Recibo: </strong><?php echo $p['nro_recibo']; ?></td>
                                    <?php } ?>
                                    <td><?php echo $p['Fecha_Pago']; ?></td>
                                    <td><?php echo $p['banco']; ?></td>
                                    <td><?php echo $p['nro_cuenta']; ?></td>
                                    <td><?php echo $p['tipo_pago']; ?></td>
                                    <td><?php echo $p['nro_cheque']; ?></td>
                                    <td><?php echo $p['monto']; ?> Bs.</td>
                                    <td><?php echo $p['Deuda_Pago']; ?> Bs.</td>
                                </tr>
                                <div>
                                <?php
                            }
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</body>

</html>