<html>

<head>
    <title>Comparacion Produccion Detalle</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="../js/jquery.js"></script>
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
    <style>

    </style>
</head>

<body class="body">
    <?php include "../menu/menu.php";
    $usuario = $_SESSION['usuario'];
    $sucur = $_GET['sucursal_id'];
    $sucursal = $db->GetAll("
select * 
from sucursal 
where idsucursal between '2' and '16' ");
    $sucursal_name = $db->GetOne("SELECT s.nombre FROM sucursal s WHERE s.idsucursal = $sucur");

    ?>
    <div class="container">
        <div class="left-sidebar">
            <h2>Detalle Produccion Comparativa de: <?php echo $sucursal_name ?> </h2>
            <div class="table-responsive">
                <form action="">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group">
                                <label>Filtrar por Sucursal:</label>
                                <select name="sucursal_id" id="sucursal_id" class="form-control">
                                    <option value="">Seleccione una Sucursal</option>
                                    <?php foreach ($sucursal as $r) { ?>
                                        <option value="<?php echo $r["idsucursal"] ?>"><?php echo $r["nombre"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                                <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" />

                            </div>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
                        </div>
                    </div>
                </form>
                <br>
                <?php $min = 0;
                $max = 0;
                if (isset($_GET['fechaini'])) {
                    $fecha_actual = $_GET["fechaini"];

                    /*---------------------------------Fecha Actual------------------------------------- */
                    $querydetalle = $db->GetAll("
                    select s.nombre as NombreSucursal  ,pr.nombre  as NombreProducto, d.cantidad  as CantidadSolicitada , d.cantidad_envio as CantidadEnviada ,pr.idunidad_medida
                    from pedido p , producto pr, detallepedido d , unidad_medida um ,sucursal s 
                    where pr.idunidad_medida = um.idunidad_medida and d.sucursal_id = p.sucursal_id  and d.producto_id = pr.idproducto 
                    and d.nro = p.nro and s.idsucursal = p.sucursal_id 
                    and d.sucursal_id = $sucur and pr.idcategoria =2 and p.fecha_p = '$fecha_actual'
                    group by pr.idproducto 
                    ");
                    $arraySolicitado = array();
                    $arrayEnviado = array();
                    $totalsolicitado=0;
                    $totalEnviado=0;
                    foreach ($querydetalle as $query) {
                        if ($query["NombreProducto"] == "POLLO AL HORNO") {
                            $totalsolicitado += ($query["CantidadSolicitada"] / 8) * 1.3;
                            $totalEnviado += ($query["CantidadSolicitada"] / 8) * 1.3;

                        } else if ($query["NombreProducto"] == "KEPERI 0.150G") {
                            $totalsolicitado += ($query["CantidadSolicitada"]  * 0.15);
                            $totalEnviado += ($query["CantidadSolicitada"]  * 0.15);

                        } else if ($query["NombreProducto"] == "BROCHETAS DE POLLO") {
                            $totalsolicitado += ($query["CantidadSolicitada"]  * 0.140);
                            $totalEnviado += ($query["CantidadEnviada"]  * 0.140);

                        } else {
                            $totalsolicitado += $query["CantidadSolicitada"];
                            $totalEnviado += $query["CantidadEnviada"];
                        }
                     
                    }

                    $fecha_eliminacion  = date("Y-m-d",  strtotime(date($fecha_actual) . "+ 1 days"));

                    $detalle_eliminacion = $db->GetAll("select pr.nombre as ProductoNombre, SUM(d.cantidad) as CantidadEliminacion
                    from detalleeliminacion d 
                    inner JOIN eliminacion e on e.nro  = d.nro 
                    inner JOIN producto pr on pr.idproducto = d.producto_id 
                    INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
                    WHERE e.fecha  = '$fecha_eliminacion' and d.sucursal_id = e.sucursal_id  and 
                    pr.idcategoria =2 AND s.idsucursal=$sucur
                    group by pr.nombre");
                    
                    $totalEliminacion=0;

                    $arrayEliminacionValor = array();
                    $arrayEliminacionNombre = array();

                    foreach ($detalle_eliminacion as $item) {
                        array_push($arrayEliminacionValor, $item["CantidadEliminacion"]);
                        array_push($arrayEliminacionNombre, $item["ProductoNombre"]);
                    }

                    foreach ($detalle_eliminacion as $query) {
                        if ($query["ProductoNombre"] == "POLLO AL HORNO") {
                            $totalEliminacion += ($query["CantidadEliminacion"] / 8) * 1.3;
                        

                        } else if ($query["ProductoNombre"] == "KEPERI 0.150G") {
                            $totalEliminacion += ($query["CantidadEliminacion"]  * 0.15);
                        

                        } else if ($query["ProductoNombre"] == "BROCHETAS DE POLLO") {
                            $totalEliminacion += ($query["CantidadEliminacion"]  * 0.140);
                        

                        } else {
                            $totalEliminacion += $query["CantidadEliminacion"];
                        
                        }
                     
                    }

                    $fecha_reciclaje  = date("Y-m-d",  strtotime(date($fecha_actual) . "+ 1 days"));

                    $detalle_reciclaje = $db->GetAll("
                    select s.nombre as NombreSucursal,r.fecha as Fecha ,p.nombre as ProductoNombre, sum(d.cantidad) as CantidadReciclada
                    from detallereciclaje d 
                    inner join reciclaje r on r.nro = d.nro 
                    inner join producto p on p.idproducto = d.producto_id 
                    inner join sucursal s on s.idsucursal = r.sucursal_id 
                    where r.fecha = '$fecha_reciclaje' and p.idcategoria =2 and d.sucursal_id = r.sucursal_id 
                    and s.idsucursal =$sucur
                    group by p.nombre 
                    ");
                    $totalreciclaje=0;
                    $arrayReciclajeValor = array();
                    $arrayReciclajeNombre = array();
                    foreach ($detalle_reciclaje as $item) {
                        array_push($arrayReciclajeValor, $item["CantidadReciclada"]);
                        array_push($arrayReciclajeNombre, $item["ProductoNombre"]);
                    }
                    foreach ($detalle_reciclaje as $query) {
                        if ($query["ProductoNombre"] == "POLLO AL HORNO") {
                            $totalreciclaje += ($query["CantidadReciclada"] / 8) * 1.3;
                        

                        } else if ($query["ProductoNombre"] == "KEPERI 0.150G") {
                            $totalreciclaje += ($query["CantidadReciclada"]  * 0.15);
                        

                        } else if ($query["ProductoNombre"] == "BROCHETAS DE POLLO") {
                            $totalreciclaje += ($query["CantidadReciclada"]  * 0.140);
                        

                        } else {
                            $totalreciclaje += $query["CantidadEliminacion"];
                        
                        }
                     
                    }



                    /*-------------------------------------Fecha Fin--------------------------------- */
                    $fecha_anterior = date("Y-m-d",  strtotime(date($fecha_actual) . "- 7 days"));

                    $querydetalle_anterior = $db->GetAll("
                    select s.nombre as NombreSucursal  ,pr.nombre  as NombreProducto, d.cantidad  as CantidadSolicitada , d.cantidad_envio as CantidadEnviada,pr.idunidad_medida 
                    from pedido p , producto pr, detallepedido d , unidad_medida um ,sucursal s 
                    where pr.idunidad_medida = um.idunidad_medida and d.sucursal_id = p.sucursal_id  and d.producto_id = pr.idproducto 
                    and d.nro = p.nro and s.idsucursal = p.sucursal_id 
                    and d.sucursal_id = $sucur and pr.idcategoria =2 and p.fecha_p = '$fecha_anterior'
                    group by pr.idproducto  
                ");
                $totalsolicitado_anterior=0;
                $totalenviado_anterior=0;
                foreach ($querydetalle_anterior as $query_anterior) {
                    if ($query_anterior["NombreProducto"] == "POLLO AL HORNO") {
                        $totalsolicitado_anterior += ($query_anterior["CantidadSolicitada"] / 8) * 1.3;
                        $totalenviado_anterior += ($query_anterior["CantidadSolicitada"] / 8) * 1.3;

                    } else if ($query_anterior["NombreProducto"] == "KEPERI 0.150G") {
                        $totalsolicitado_anterior += ($query_anterior["CantidadSolicitada"]  * 0.15);
                        $totalenviado_anterior += ($query_anterior["CantidadSolicitada"]  * 0.15);

                    } else if ($query_anterior["NombreProducto"] == "BROCHETAS DE POLLO") {
                        $totalsolicitado_anterior += ($query_anterior["CantidadSolicitada"]  * 0.140);
                        $totalenviado_anterior += ($query_anterior["CantidadEnviada"]  * 0.140);

                    } else {
                        $totalsolicitado_anterior += $query_anterior["CantidadSolicitada"];
                        $totalenviado_anterior += $query_anterior["CantidadEnviada"];
                    }
                    }



                    $fecha_eliminacion_anterior = date("Y-m-d",  strtotime(date($fecha_actual) . "- 6 days"));

                    $detalle_eliminacion_anterior = $db->GetAll("select pr.nombre as ProductoNombre, SUM(d.cantidad) as CantidadEliminacion
                    from detalleeliminacion d 
                    inner JOIN eliminacion e on e.nro  = d.nro 
                    inner JOIN producto pr on pr.idproducto = d.producto_id 
                    INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
                    WHERE e.fecha  = '$fecha_eliminacion_anterior' and d.sucursal_id = e.sucursal_id  and 
                    pr.idcategoria =2 AND s.idsucursal=$sucur
                    group by pr.nombre"
                );

               /*       echo json_encode($detalle_eliminacion_anterior); */
                    $totalEliminacion_anterior =0;
                    $arrayEliminacionValor_anterior = array();
                    $arrayEliminacionNombre_anterior = array();

                    foreach ($detalle_eliminacion_anterior as $item2) {
                        array_push($arrayEliminacionValor_anterior, $item2["CantidadEliminacion"]);
                        array_push($arrayEliminacionNombre_anterior, $item2["ProductoNombre"]);
                    }
                    foreach ($detalle_eliminacion_anterior as $query) {
                        if ($query["ProductoNombre"] == "POLLO AL HORNO") {
                            $totalEliminacion_anterior += ($query["CantidadEliminacion"] / 8) * 1.3;
                        

                        } else if ($query["ProductoNombre"] == "KEPERI 0.150G") {
                            $totalEliminacion_anterior += ($query["CantidadEliminacion"]  * 0.15);
                        

                        } else if ($query["ProductoNombre"] == "BROCHETAS DE POLLO") {
                            $totalEliminacion_anterior += ($query["CantidadEliminacion"]  * 0.140);
                        

                        } else {
                            $totalEliminacion_anterior += $query["CantidadEliminacion"];
                        
                        }
                     
                    }
                    

                    $fecha_reciclaje_anterior = date("Y-m-d",  strtotime(date($fecha_actual) . "- 6 days"));

                    $detalle_reciclaje_anterior = $db->GetAll("
                    select s.nombre as NombreSucursal,r.fecha as Fecha ,p.nombre as ProductoNombre, sum(d.cantidad) as CantidadReciclada
                    from detallereciclaje d 
                    inner join reciclaje r on r.nro = d.nro 
                    inner join producto p on p.idproducto = d.producto_id 
                    inner join sucursal s on s.idsucursal = r.sucursal_id 
                    where r.fecha = '$fecha_reciclaje_anterior' and p.idcategoria =2 and d.sucursal_id = r.sucursal_id 
                    and s.idsucursal =$sucur
                    group by p.nombre 
             
                    ");

                    $totalReciclaje_anterior=0;
                    $arrayReciclajeValor_anterior = array();
                    $arrayReciclajeNombre_anterior = array();
                    foreach ($detalle_reciclaje_anterior as $item3) {
                        array_push($arrayReciclajeValor_anterior, $item3["CantidadReciclada"]);
                        array_push($arrayReciclajeNombre_anterior, $item3["ProductoNombre"]);
                    }

                    foreach ($detalle_reciclaje_anterior as $query) {
                        if ($query["ProductoNombre"] == "POLLO AL HORNO") {
                            $totalReciclaje_anterior += ($query["CantidadReciclada"] / 8) * 1.3;
                        

                        } else if ($query["ProductoNombre"] == "KEPERI 0.150G") {
                            $totalReciclaje_anterior += ($query["CantidadReciclada"]  * 0.15);
                        

                        } else if ($query["ProductoNombre"] == "BROCHETAS DE POLLO") {
                            $totalReciclaje_anterior += ($query["CantidadReciclada"]  * 0.140);
                        

                        } else {
                            $totalReciclaje_anterior += $query["CantidadReciclada"];
                        
                        }
                     
                    }
                }
                ?>
                <h2><?php if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
                    } else {
                    } ?></h2>
                <div class="row" style="margin: auto; height: 100%">

                    <div class="col-lg-6">


                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>

                                    <h2>Produccion Comparativa Detalle De la Fecha: <?php echo $fecha_actual ?></h2>

                                </tr>
                                <tr>
                                    <th>ITEM</th>
                                    <th>CANTIDAD SOLICITADA</th>
                                    <th>CANTIDAD ENVIADA</th>
                                    <th>ELIMINACION</th>
                                    <th>RECICLAJE</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($querydetalle as $r) {
                                  
                                    $totalEliminado =  array_sum($arrayEliminacionValor);
                                    $totalReciclado =  array_sum($arrayReciclajeValor);



                                    $um = $db->GetOne("select nombre from unidad_medida where idunidad_medida=$r[idunidad_medida]");

                                ?>
                                    <tr class=warning>


                                        <td><?php echo $r["NombreProducto"]; ?></td>
                                        <td><?php echo number_format($r["CantidadSolicitada"], 2) . " " . $um; ?></td>
                                        <td><?php echo number_format($r["CantidadEnviada"], 2) . " " . $um; ?></td>

                                        <!-- ELIMINACION -->
                                        <?php $sw = false;
                                        for ($i = 0; $i < sizeof($arrayEliminacionValor); $i++) {
                                            if ($r["NombreProducto"] == $arrayEliminacionNombre[$i]) {
                                                echo '<td>' . number_format($arrayEliminacionValor[$i], 2). " " .$um. '</td>';
                                                $sw = true;
                                            }
                                        }
                                        if ($sw == false) {
                                            echo '<td>' . '0.00' . '</td>';
                                        } ?>

                                        <!-- RECICLAJE -->
                                        <?php $sw = false;
                                        for ($i = 0; $i < sizeof($arrayReciclajeValor); $i++) {
                                            if ($r["NombreProducto"] == $arrayReciclajeNombre[$i]) {
                                                echo '<td>' . number_format($arrayReciclajeValor[$i], 2). " " .$um.   '</td>';
                                                $sw = true;
                                            }
                                        }
                                        if ($sw == false) {
                                            echo '<td>' . '0.00' . '</td>';
                                        } ?>

                                   </tr>
                                <?php }

                                ?>
                            </tbody>

                        </table>

                        <table id="" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                            <tr>
                                <td>
                                    <h4>DETALLE TOTAL</h4>
                                </td>
                                <td>
                                    <h4>Total Solicitado: <?php echo number_format($totalsolicitado,2)  ?> Kg</h4>
                                </td>
                                <td>
                                    <h4>Total Enviado:  <?php echo number_format($totalEnviado,2)  ?> Kg</h4>
                                </td>
                                <td>
                                    <h4>Total Eliminado: <?php echo number_format($totalEliminacion,2)  ?> Kg</h4>
                                </td>
                                <td>
                                    <h4>Total Reciclado: <?php echo number_format($totalreciclaje,2)  ?> Kg</h4>
                                </td>

                            </tr>
                        </table>
                       
                     
                    </div>

                    <div class="col-lg-6">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>

                                    <h2>Produccion Comparativa Detalle De la Fecha: <?php echo $fecha_anterior ?></h2>

                                </tr>
                                <tr>
                                    <th>ITEM</th>
                                    <th>CANTIDAD SOLICITADA</th>
                                    <th>CANTIDAD ENVIADA</th>
                                    <th>ELIMINACION</th>
                                    <th>RECICLAJE</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($querydetalle_anterior as $r2) {
                                    $totalEliminado_anterior =  array_sum($arrayEliminacionValor_anterior);
                                    $totalReciclado_anterior =  array_sum($arrayReciclajeValor_anterior);

                                    $um = $db->GetOne("select nombre from unidad_medida where idunidad_medida=$r2[idunidad_medida]");
                                ?>
                                    <tr class=warning>
                                        <td><?php echo $r2["NombreProducto"]; ?></td>
                                        <td><?php echo number_format($r2["CantidadSolicitada"], 2) . " " . $um; ?></td>
                                        <td><?php echo number_format($r2["CantidadEnviada"], 2) . " " . $um; ?></td>

                                        <!-- ELIMINACION -->
                                        <?php $sw = false;
                                        for ($i = 0; $i < sizeof($arrayEliminacionValor_anterior); $i++) {
                                            if ($r2["NombreProducto"] == $arrayEliminacionNombre_anterior[$i]) {
                                                echo '<td>' . number_format($arrayEliminacionValor_anterior[$i], 2). " " .$um. '</td>';
                                                $sw = true;
                                            }
                                        }
                                        if ($sw == false) {
                                            echo '<td>' . '0.00' . '</td>';
                                        } ?>

                                        <!-- RECICLAJE -->
                                        <?php $sw = false;
                                        for ($i = 0; $i < sizeof($arrayReciclajeValor_anterior); $i++) {
                                            if ($r2["NombreProducto"] == $arrayReciclajeNombre_anterior[$i]) {
                                                echo '<td>' . number_format($arrayReciclajeValor_anterior[$i], 2). " " .$um.'</td>';
                                                $sw = true;
                                            }
                                        }
                                        if ($sw == false) {
                                            echo '<td>' . '0.00' . '</td>';
                                        } ?>





                                    </tr>

                                <?php }

                                ?>
                            </tbody>
                           
                        </table>
                    

                        
                        <table id="" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <h4>DETALLE TOTAL</h4>

                                    </td>
                                    <td>
                                        <h4>Total Solicitado: <?php echo number_format($totalsolicitado_anterior,2) ?> Kg</h4>

                                    </td>
                                    <td>
                                        <h4>Total Enviado: <?php echo number_format($totalenviado_anterior,2)  ?> Kg</h4>
                                    </td>
                                    <td>
                                        <h4>Total Eliminado: <?php echo number_format($totalEliminacion_anterior,2)  ?> Kg</h4>
                                    </td>
                                    <td>
                                        <h4>Total Reciclado: <?php echo number_format($totalReciclaje_anterior,2)  ?> Kg</h4>
                                    </td>

                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
                <!-- Include all compiled plugins (below), or include individual files as needed -->
            </div>
        </div> <!-- Start WOWSlider.com BODY section -->
        <!-- End WOWSlider.com 
  BODY section -->
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
</body>

</html>