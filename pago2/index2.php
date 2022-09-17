<?php include "../menu/menu.php";
require_once '../config/conexion.inc.php';
if(isset($_POST["pagar"])){
    $sts = $_POST["pagar"]."FFF";
    }
$id_proveedor  = $_POST['nro'];
$min  = $_POST['fechaa'];
$max  = $_POST['fechap'];
$sucursal  = $_POST['suc_id'];
$usuario = $_SESSION['usuario'];
$sucur = $usuario['sucursal_id'];
$datos=$db -> GetAll("SELECT c.fecha, c.nro, suc.nombre, c.total as total, c.deuda, us.nombre ,pro.empreza as proveedor, c.estado as estadocompra   FROM compra c
INNER JOIN sucursal suc on suc.idsucursal = c.sucursal_id
INNER JOIN usuario us on us.idusuario = c.usuario_id
INNER JOIN proveedor pro on c.proveedor_id = pro.idproveedor
WHERE  pro.idproveedor = $id_proveedor and c.fecha BETWEEN '$min' and '$max' and c.sucursal_id= $sucursal;");
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
            <h2>Listado de compras y pagos </h2>
            <!-- Boton para agregar el pago -->
            <button class="btn btn-success" data-toggle="modal" data-target="#modalpago"> Pagar </button>
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                </div>
            </div>&nbsp;
            <!-- Modal  para agregar pago-->

            <form id="formulario" name="formulario" method="post" action="posting.php">
            <div class="modal fade" id="modalpago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel" style="text-align: center; color: #008080;;">Registrar Pago <br> </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Formulario para agregar el pago -->
                            <div class="modal-body">
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
                                    
                                </div><br>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" id="btn_enviar" class="btn btn-success" value="Registrar"></button>
                            </div>
                        
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
                            <th>Seleccionar</th>
                            <th>Nro.Compra</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Deuda</th>
                            <th>Usuario</th>
                            <th>Proveedor</th>
                            <th>Pagar</th>
                            <th>Estado</th>
                            <th>Opcion</th>
                        </tr>
                    </thead>
                    
                    <?php
$i = 1;

                    foreach ($datos as $compra){ 

                        
                        ?>
                    <tbody>



                            <tr class=warning>  



    
                                <td><input type="hidden" id="maximo" name="maximo"  value="<?php echo $i; ?>"><input type="checkbox" id=<?php echo "seleccionar".$i;?> name=<?php echo "seleccionar".$i; ?>></td> 
                                <td><input type="hidden" id=<?php echo "nro".$i;?> name=<?php echo "nro".$i;?>  value="<?php echo $compra["nro"]; ?>"><?php echo $compra["nro"];?></td>
                                <td><input type="hidden" id=<?php echo "fecha".$i;?> name=<?php echo "fecha".$i;?> value="<?php echo $compra["fecha"]; ?>"><?php echo $compra["fecha"];?></td>
                                <td><input type="hidden" id=<?php echo "total".$i;?> name=<?php echo "total".$i;?> value="<?php echo $compra["total"]; ?>"><?php echo $compra["total"];?></td>
                                <td><input type="hidden" id=<?php echo "deuda".$i;?> name=<?php echo "deuda".$i;?>    value="<?php echo $compra["deuda"]; ?>"><?php echo $compra["deuda"];?></td>
                                <td><input type="hidden" id=<?php echo "nombre".$i;?> name=<?php echo "nombre".$i;?>    value="<?php echo $compra["nombre"]; ?>" ><?php echo $compra["nombre"];?></td>
                                <td><input type="hidden" id=<?php echo "proveedor".$i;?> name=<?php echo "proveedor".$i;?> value="<?php echo $compra["proveedor"]; ?>"><?php echo $compra["proveedor"];?></td>
                                <td><input type='number' colsa class="form-control" style="display:none"  step='0.01' id=<?php echo "pagar".$i;?> name=<?php echo "pagar".$i;?> value="<?php echo $compra["deuda"]; ?>" placeholder="Inserte la cantidad a pagar"></td>
                                <td style="color: red;"><?php echo $compra["estadocompra"]; ?></td>
                                <td style="width:210px;">
                                    <a href="#" data-toggle="modal"
                                                data-target="#ver<?php echo $compra["nro"];?>"><img src="../images/ver.png" alt="" title="ver detalle">Detalle</a>
                                    <?php
                                    echo "<a class='' href='pdfcompra.php?nro=$compra[nro]&sucursal=$sucur' target='_blank' role='button'><img src='../images/pdf.png' alt=''>PDF</a>"; 
                                    ?>
                                </td>
                                <td style="width:80px;">

                                    <?php
                                    echo "<a class='' href='pagoscompra.php?nro=$compra[nro]&sucursal=$sucur' target='_blank' role='button'><img src='../images/pago.jpg' alt=''>Pagos</a>"; 
                                    ?>
                                </td>

                            </tr>      



                    </tbody>   
                    </div>
                </div>
            </div>   
        <div class="modal fade" id="ver<?php echo $compra["nro"];?>"
            data-backdrop="static" data-keyboard="false"
            draggable="modal-header"
            tabindex="-1" role="dialog" 
            aria-labelledby="myModalLabel" 
            aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Detalle Compra - <?php echo $compra["nro"]; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row panel panel-primary">                  
                        <div class="col-md-4">
                            producto
                        </div>
                        <div class="col-md-2">
                            cantidad
                        </div>
                        <div class="col-md-2">
                            precio
                        </div>                    
                        <div class="col-md-2">
                            subtotal
                        </div>
                    </div>
                    <?php 
                        $consul = $db->GetAll("select p.codigo_producto,p.nombre,dc.cantidad,dc.precio_compra,dc.subtotal
                        from detallecompra dc,producto p 
                        where dc.nro = $compra[nro] and p.idproducto = dc.producto_id and dc.sucursal_id= $sucur");
                            foreach ($consul as $key) { ?>
                            <div class="row" >
                                <div class="col-md-4">
                                    <?php echo $key["nombre"];?>
                                </div>
                                <div class="col-md-2">
                                    <?php echo $key["cantidad"]; ?> 
                                </div>
                                <div class="col-md-2">
                                    <?php echo $key["precio_compra"], ' Bs'; ?>  
                                </div>
                                <div class="col-md-2">
                                    <?php echo $key["subtotal"], ' Bs'; ?>     
                                </div>
                            </div>  
                            <?php }?>
                            <br>
                            <div class="row panel panel-primary" >
                                <div class="col-md-8">TOTAL</div>
                                    <div class="col-md-2">
                                        <?php echo number_format($compra["total"],2), ' Bs'; ?>
                                    </div>
                                </div>         
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        </div>
                        </div>
                    </div>
                    </div>  
    <?php $i++;  }?>         
</table>



</form>
<script>
    var compra_list= {
            items: {
            compra: [],
        },
        add: function(item) {
        this.items.compra.push(item);
    }}
</script>
<script>
    $(document).ready(function() {
            var m = '';
            for (let i = 1; i <1000; i++) {
                if($('#deuda'+ i).val() == 0){
                        $("#seleccionar" + i).prop('disabled', true);
                    }else{
                        $("#seleccionar" + i).click(function() {        
                        if ($(this).is(":checked")) { 
                        $("#nro" + i).prop('disabled', false); 
                        $("#pagar" + i).show();
                        $("#pagar" + i).prop('disabled', false);
                        //console.log(m);
                        } else if ($(this).is(":not(:checked)")) {
                            var m = '';
                            $("#pagar" + i).hide();
                            $("#pagar" + i).prop('disabled', true);
                            $("#nro" + i).prop('disabled', true);
                        }
                    });
                    }  
                }
    });       
</script>
</body>
</html>