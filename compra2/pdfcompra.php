<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nota de Compra</title>
    <link rel="stylesheet" href="../pago2/nota_pago/style.css">
</head>

<body>
    <?php require_once '../config/conexion.inc.php';
    //Consulta para sacar los datos del pago seleccionado 
    $nro = $_GET['nro'];
    $sucursal = $_GET['sucursal'];
    $compra = $db->Execute("select p.nombre as Producto, dc.cantidad as Cantidad, dc.precio_compra as Precio_Unitario, dc.subtotal as Subtotal
                    from detallecompra dc,producto p
                    where dc.nro ='$nro' and p.idproducto = dc.producto_id and dc.sucursal_id= '$sucursal'");
    
    $total_compra = $db->GetOne("SELECT SUM(subtotal) FROM detallecompra WHERE nro = $nro and sucursal_id = $sucursal");
    
    $datos = $db->Execute("SELECT  pro.empreza as Empreza, pro.nit, pro.celular, pro.codigo  
    FROM compra c 
    INNER JOIN proveedor pro ON pro.idproveedor = c.proveedor_id 
    where c.nro = $nro AND c.sucursal_id = $sucursal");
     foreach ($datos as $a) {
        $empreza 	   = $a['Empreza'];
        $codigo_empreza    = $a['codigo'];
        $nit_proveedor     = $a['nit'];
        $celular_proveedor = $a['celular'];
    }
    ?>
    <div id="page_pdf">
        <!-- Cabecera -->
        <br>
        <table id="factura_head">
            <tr>
                <td class="logo_factura">
                    <div>
                        <img src="../pago2/nota_pago/img/Logo_Correo.jpg" height="30%;" width="200px;">
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
                                    <label> Nit/Ci:</label>
                                    <?php if ($nit_proveedor == '') { ?>
                                        <p style="color: black;">S/ nit</p>
                                    <?php } else { ?>
                                        <p><?= $nit_proveedor  ?></p>
                                    <?php } ?>
                                </td>

                                <td>
                                    <label>Celular:</label>
                                    <?php if ($celular_proveedor == 0) { ?>
                                        <p style="color: black;">S/ celular</p>
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
            <div class="col-md-auto">
                <div class="table-responsive">
                    <div class="round">
                        <table id="customers">
                            <thead>
                                <tr>
                                    <th>Cod. Compra</th>
                                    <th>Producto</th>
                                    <th >Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody 	>
                               <?php foreach($compra as $c){ ?>
								<tr>
									<td class="textcenter"><?=$nro?></td>
									<td class="textcenter"><?=$c['Producto']?></td>
									<td class="textcenter"><?=$c['Cantidad']?></td>
									<td class="textcenter"><?= number_format($c['Precio_Unitario'], 2) ?> Bs.</td>
									<td class="textcenter"><?= number_format($c['Subtotal'], 2) ?> Bs.</td>
								</tr>
								<?php } ?>
                            </tbody>					
							<tfoot id="detalle_totales">
								<tr>
									<td colspan="4" class="textright">Precio Total Compra</td>
									<td class="textcenter" ><?=number_format($total_compra,2) ?>Bs.</td>
								</tr>
							</tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div>
			<p class="nota">Si usted tiene preguntas sobre esta nota, <br>pongase en contacto con el proveedor</p>
            <h4 >Precio Compra <?= number_format($total_compra,2) ?>Bs.</h4>
		</div>
    </div>
</body>

</html>