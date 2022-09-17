<html>

<head>
    <title>Comparacion de Produccion </title>
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
    $sucur = $usuario['sucursal_id'];


    ?>
    <div class="container">
        <div class="left-sidebar">
            <h2>Comparacion de Insumos Solicitados </h2>
            <div class="table-responsive">
                <form action="">
                    <div class="row">
                   
                        <div class="col-md-3">
                        
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon"><strong>Fecha Del:</strong> </span>
                                <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" />


                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
                        </div>
                        
                    </div>
                    <br>
                    <div>
                    <a href="produccion_detalle.php" class="btn btn-info" role="button"><strong>Ver Detalle</strong><span class="glyphicon glyphicon-plus"></span></a>
                    </div>
                    
                </form>
                <br>
                <?php $min = 0;
                $max = 0;
                if (isset($_GET['fechaini'])) {
                    $fecha_actual = $_GET["fechaini"];
                    $query1 = $db->GetAll("
                    select  pr.idcategoria  ,pr.nombre as NombreProducto , pr.idproducto  ,pr.idunidad_medida  , SUM(d.cantidad) as CantidadSolicitada,  SUM(d.cantidad_envio) as CantidadEnviada , SUM(d.cantidad-d.cantidad_envio) as CantidadRestante, (sum(d.cantidad_envio)/(sum(d.cantidad) )*100) as Efectividad 
                    from detallepedido d 
                    inner JOIN pedido p on p.nro = d.nro
                    inner JOIN producto pr on pr.idproducto = d.producto_id
                    INNER JOIN sucursal s on s.idsucursal = d.sucursal_id
                    WHERE p.Fecha_p = '$fecha_actual'  and d.sucursal_id =p.sucursal_id  and pr.idcategoria =2 
                    group by pr.nombre ORDER BY pr.idproducto  ASC"
                );

                    /*-------------------------------QUERY ELIMINACION GENERAL----------------------------------- */
                    $fecha_eliminacion  = date("Y-m-d",  strtotime(date($fecha_actual) . "+ 1 days"));

                    $query_eliminacion= $db->GetAll(" select p.nombre as ProductoNombre , sum(d.cantidad)  as CantidadEliminacion
                    from eliminacion e 
                    inner join detalleeliminacion d on d.nro = e.nro 
                    inner join producto p on p.idproducto = d.producto_id 
                    inner join sucursal s on s.idsucursal = d.sucursal_id 
                    WHERE e.fecha  = '$fecha_eliminacion' and d.sucursal_id = e.sucursal_id 
                    and p.idcategoria = 2 
                    group by p.nombre ");
                    $arrayEliminacionValor = array();
                    $arrayEliminacionNombre = array();
                    $totaleliminado=0;


                    foreach ($query_eliminacion as $item) {
                        array_push($arrayEliminacionValor, $item["CantidadEliminacion"]);
                        array_push($arrayEliminacionNombre, $item["ProductoNombre"]);
                    }


                    foreach ($query_eliminacion as $query) {
                        if ($query["ProductoNombre"] == "POLLO AL HORNO") {
                            $totaleliminado += ($query["CantidadEliminacion"] / 8) * 1.3;
                        

                        } else if ($query["ProductoNombre"] == "KEPERI 0.150G") {
                            $totaleliminado += ($query["CantidadEliminacion"]  * 0.15);
                        

                        } else if ($query["ProductoNombre"] == "BROCHETAS DE POLLO") {
                            $totaleliminado += ($query["CantidadEliminacion"]  * 0.140);
                        

                        } else {
                            $totaleliminado += $query["CantidadEliminacion"];
                        
                        }
                     
                    }

                    /*-------------------------------QUERY RECICLAJE GENERAL----------------------------------- */
                    $fecha_reciclaje  = date("Y-m-d",  strtotime(date($fecha_actual) . "+ 1 days"));
                    
                    $query_reciclaje= $db->GetAll("select s.nombre , p.nombre as ProductoNombre , sum(d.cantidad)  as CantidadReciclada
                    from reciclaje r 
                    inner join detallereciclaje  d on d.nro = r.nro 
                    inner join producto p on p.idproducto = d.producto_id 
                    inner join sucursal s on s.idsucursal = d.sucursal_id 
                    WHERE r.fecha  = '$fecha_reciclaje' and d.sucursal_id = r.sucursal_id  
                    and p.idcategoria = 2 
                    group by p.nombre
                    ");
                    $arrayReciclajeValor = array();
                    $arrayReciclajeNombre = array();
                    $totalReciclaje=0;
                    foreach ($query_reciclaje as $item) {
                        array_push($arrayReciclajeValor, $item["CantidadReciclada"]);
                        array_push($arrayReciclajeNombre, $item["ProductoNombre"]);
                    }

                    foreach ($query_reciclaje as $query) {
                        if ($query["ProductoNombre"] == "POLLO AL HORNO") {
                            $totalReciclaje += ($query["CantidadReciclada"] / 8) * 1.3;
                        

                        } else if ($query["ProductoNombre"] == "KEPERI 0.150G") {
                            $totalReciclaje += ($query["CantidadReciclada"]  * 0.15);
                        

                        } else if ($query["ProductoNombre"] == "BROCHETAS DE POLLO") {
                            $totalReciclaje += ($query["CantidadReciclada"]  * 0.140);
                        

                        } else {
                            $totalReciclaje += $query["CantidadReciclada"];
                        
                        }
                     
                    }


                    
                    $totalSolicitado=0;
                    $totalEnviado=0;
                    $totalUso=0;
                 
                    foreach ($query1 as $query) {
                        if ($query["NombreProducto"] == "POLLO AL HORNO") {
                            $totalSolicitado += ($query["CantidadSolicitada"] / 8) * 1.3;
                            $totalEnviado += ($query["CantidadEnviada"] / 8) * 1.3;
                            

                        } else if ($query["NombreProducto"] == "KEPERI 0.150G") {
                            $totalSolicitado += ($query["CantidadSolicitada"]  * 0.15);
                            $totalEnviado += ($query["CantidadEnviada"]  * 0.15);
                        
                        
                        } else if ($query["NombreProducto"] == "BROCHETAS DE POLLO") {
                            $totalSolicitado += ($query["CantidadSolicitada"]  * 0.140);
                            $totalEnviado += ($query["CantidadEnviada"]  * 0.140);
                        

                        } else {
                            $totalSolicitado += $query["CantidadSolicitada"];
                            $totalEnviado += $query["CantidadEnviada"];
                           
                        }
                        
                     
                    }
                    $totalUso= ($totalEnviado- $totaleliminado) - $totalReciclaje;



                   /*-----------------------Fecha Anterior--------------------------------- */
                    $fecha_anterior = date("Y-m-d",  strtotime(date($fecha_actual) . "- 7 days"));

                    $query2 = $db->getAll("select  pr.idcategoria  ,pr.nombre as NombreProducto, pr.idproducto  ,pr.idunidad_medida  , SUM(d.cantidad) as CantidadSolicitada,  SUM(d.cantidad_envio) as CantidadEnviada , SUM(d.cantidad-d.cantidad_envio) as CantidadRestante, (sum(d.cantidad_envio)/(sum(d.cantidad) )*100) as Efectividad 
                    from detallepedido d 
                    inner JOIN pedido p on p.nro = d.nro
                    inner JOIN producto pr on pr.idproducto = d.producto_id
                    INNER JOIN sucursal s on s.idsucursal = d.sucursal_id
                    WHERE p.Fecha_p = '$fecha_anterior'  and d.sucursal_id =p.sucursal_id  and pr.idcategoria =2 
                    group by pr.nombre ORDER BY pr.idproducto  ASC");

                    /*-------------------------------QUERY ELIMINACION GENERAL----------------------------------- */
                    $fecha_eliminacion_anterior = date("Y-m-d",  strtotime(date($fecha_actual) . "- 6 days"));

                    $query_eliminacion_anterior= $db->GetAll(" p.nombre as ProductoNombre , sum(d.cantidad)  as CantidadEliminacion
                    from eliminacion e 
                    inner join detalleeliminacion d on d.nro = e.nro 
                    inner join producto p on p.idproducto = d.producto_id 
                    inner join sucursal s on s.idsucursal = d.sucursal_id 
                    WHERE e.fecha  = '$fecha_eliminacion_anterior' and d.sucursal_id = e.sucursal_id 
                    and p.idcategoria = 2 
                    group by p.nombre ");

                    $total_eliminado_anterior=0;
                    $arrayEliminacionValor2 = array();
                    $arrayEliminacionNombre2 = array();
                    

                    foreach ($query_eliminacion_anterior as $item) {
                        array_push($arrayEliminacionValor2, $item["CantidadEliminacion"]);
                        array_push($arrayEliminacionNombre2, $item["ProductoNombre"]);
                    }

                    foreach ($query_eliminacion_anterior as $query) {
                        if ($query["ProductoNombre"] == "POLLO AL HORNO") {
                            $total_eliminado_anterior += ($query["CantidadEliminacion"] / 8) * 1.3;
                        

                        } else if ($query["ProductoNombre"] == "KEPERI 0.150G") {
                            $total_eliminado_anterior += ($query["CantidadEliminacion"]  * 0.15);
                        

                        } else if ($query["ProductoNombre"] == "BROCHETAS DE POLLO") {
                            $total_eliminado_anterior += ($query["CantidadEliminacion"]  * 0.140);
                        

                        } else {
                            $total_eliminado_anterior += $query["CantidadEliminacion"];
                        
                        }
                     
                    }

                    
                    /*-------------------------------QUERY RECICLAJE GENERAL ANTERIOR ----------------------------------- */
                    $fecha_reciclaje_anterior = date("Y-m-d",  strtotime(date($fecha_actual) . "- 6 days"));

                    $query_reciclaje_anterior= $db->GetAll("select s.nombre , p.nombre as ProductoNombre , sum(d.cantidad)  as CantidadReciclada
                    from reciclaje r 
                    inner join detallereciclaje  d on d.nro = r.nro 
                    inner join producto p on p.idproducto = d.producto_id 
                    inner join sucursal s on s.idsucursal = d.sucursal_id 
                    WHERE r.fecha  = '$fecha_reciclaje_anterior' and d.sucursal_id = r.sucursal_id  
                    and p.idcategoria = 2 
                    group by p.nombre
                    ");

                    $total_reciclaje_anterior=0;
                    $arrayReciclajeValor2 = array();
                    $arrayReciclajeNombre2 = array();
                    
                    foreach ($detalle_reciclaje_anterior as $item3) {
                        array_push($arrayReciclajeValor2, $item3["CantidadReciclada"]);
                        array_push($arrayReciclajeNombre2, $item3["ProductoNombre"]);
                    }

                    foreach ($query_reciclaje_anterior as $query) {
                        if ($query["ProductoNombre"] == "POLLO AL HORNO") {
                            $total_reciclaje_anterior += ($query["CantidadReciclada"] / 8) * 1.3;
                        

                        } else if ($query["ProductoNombre"] == "KEPERI 0.150G") {
                            $total_reciclaje_anterior += ($query["CantidadReciclada"]  * 0.15);
                        

                        } else if ($query["ProductoNombre"] == "BROCHETAS DE POLLO") {
                            $total_reciclaje_anterior += ($query["CantidadReciclada"]  * 0.140);
                        

                        } else {
                            $total_reciclaje_anterior += $query["CantidadReciclada"];
                        
                        }
                        echo $total_reciclaje_anterior;
                     
                    }



                    
                    $totalSolicitado_anterior=0;
                    $totalEnviado_anterior=0;
                    $totalUso_anterior=0;
                    foreach ($query2 as $query_anterior) {
                        if ($query_anterior["NombreProducto"] == "POLLO AL HORNO") {
                            $totalSolicitado_anterior += ($query_anterior["CantidadSolicitada"] / 8) * 1.3;
                            $totalEnviado_anterior += ($query_anterior["CantidadEnviada"] / 8) * 1.3;
                            

                        } else if ($query_anterior["NombreProducto"] == "KEPERI 0.150G") {
                            $totalSolicitado_anterior += ($query_anterior["CantidadSolicitada"]  * 0.15);
                            $totalEnviado_anterior += ($query_anterior["CantidadEnviada"]  * 0.15);
                           

                        } else if ($query_anterior["NombreProducto"] == "BROCHETAS DE POLLO") {
                            $totalSolicitado_anterior += ($query_anterior["CantidadSolicitada"]  * 0.140);
                            $totalEnviado_anterior += ($query_anterior["CantidadEnviada"]  * 0.140);
                        } else {
                            $totalSolicitado_anterior += $query_anterior["CantidadSolicitada"];
                            $totalEnviado_anterior += $query_anterior["CantidadEnviada"];
                            
                        }
                       
                     
                    }
                    
                    $totalUso_anterior =  ($totalEnviado_anterior-$total_eliminado_anterior) - $total_reciclaje_anterior ;
              

         
                }
                ?>
                <h2><?php if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
                            
                    } else {
                      
                    } ?></h2>
                <div class="row" style="margin: auto; height: 100%">
                    <div class="col-lg-6">
                        <table  class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <h2>Produccion Consolidada Comparativa De la Fecha: <?php echo $fecha_actual ?></h2>
                                </tr>
                                <tr>
                                    <th>Insumo</th>
                                    <th>Cantidad Solicitada</th>
                                    <th>Cantidad Enviada</th>
                                    <th>Porcentaje %</th>
                                    <th>Eliminacion</th>
                                    <th>Reciclaje</th>
                                   
                                    
                                    
                                   

                                </tr>
                            </thead>
                            <tbody>
                               
                                <?php  
                                 
                                foreach ($query1 as $r) {

                                    $um = $db->GetOne("select nombre from unidad_medida where idunidad_medida=$r[idunidad_medida]");

                                ?>
                                    <tr class=warning>
                                        <td><?php echo $r["NombreProducto"]; ?></td>
                                        <td><?php echo number_format($r["CantidadSolicitada"], 2) . " " . $um; ?></td>
                                        <td><?php echo number_format($r["CantidadEnviada"], 2) . " " . $um; ?></td>
                                        <td><?php echo number_format($r["Efectividad"], 2) . "%"; ?></td>

                                         <!-- Query Eliminacion-->
                                         <?php $sw = false;
                                        for ($i = 0; $i < sizeof($arrayEliminacionValor); $i++) {
                                            if ($r["NombreProducto"] == $arrayEliminacionNombre[$i]) {
                                                echo '<td>' . number_format($arrayEliminacionValor[$i], 2) . " " .$um. '</td>';
                                                $sw = true;
                                            }
                                        }
                                        if ($sw == false) {
                                            echo '<td>' . '0.00' . '</td>';
                                        } ?>

                                        <!-- Query RECICLAJE -->
                                        <?php $sw = false;
                                        for ($i = 0; $i < sizeof($arrayReciclajeValor); $i++) {
                                            if ($r["NombreProducto"] == $arrayReciclajeNombre[$i]) {
                                                echo '<td>' . number_format($arrayReciclajeValor[$i], 2) . " " .$um.   '</td>';
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
                        <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                            <tr>
                                <td>
                                    <h4>Totales insumos</h4>
                                </td>
                                <td>
                                <h4>Total Solicitado: <?php echo  number_format($totalSolicitado,2)  ?> Kg</h4>
                                </td>
                                <td>
                                    <h4>Total Enviado: <?php echo number_format($totalEnviado,2)  ?> Kg</h4>
                                </td>
                                <td>
                                     <h4>Total Eliminado: <?php echo number_format($totaleliminado,2)  ?> Kg</h4>
                                </td>
                                <td>
                                     <h4>Total Reciclado: <?php echo number_format($totalReciclaje,2)  ?> Kg</h4>
                                </td>
                                <td>
                                     <h4>Total Uso: <?php echo number_format($totalUso,2)  ?> Kg</h4>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                  
                                    <h2>Produccion Consolidada Comparativa De la Fecha: <?php echo $fecha_anterior ?></h2>
                                
                                </tr>
                                <tr>
                                     <th>Insumo</th>
                                    <th>Cantidad Solicitada</th>
                                    <th>Cantidad Enviada</th>
                                    <th>Porcentaje %</th>
                                    <th>Eliminacion</th>
                                    <th>Reciclaje</th>
                                    
                                
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                foreach ($query2 as $r1) {

                                    $um = $db->GetOne("select nombre from unidad_medida where idunidad_medida=$r1[idunidad_medida]");

                                ?>
                                    <tr class=warning>
                                        <td><?php echo $r1["NombreProducto"]; ?></td>
                                        <td><?php echo number_format($r1["CantidadSolicitada"], 2) . " " . $um; ?></td>
                                        <td><?php echo number_format($r1["CantidadEnviada"], 2) . " " . $um; ?></td>
                                      
                                        <td><?php echo number_format($r1["Efectividad"], 2) . "%"; ?></td>

                                          <!-- ELIMINACION -->
                                          <?php $sw = false;
                                        for ($i = 0; $i < sizeof($arrayEliminacionValor2); $i++) {
                                            if ($r1["NombreProducto"] == $arrayEliminacionNombre2[$i]) {
                                                echo '<td>' . number_format($arrayEliminacionValor2[$i], 2)  . '</td>';
                                                $sw = true;
                                            }
                                        }
                                        if ($sw == false) {
                                            echo '<td>' . '0.00' . '</td>';
                                        } ?>

                                        <!-- RECICLAJE -->
                                        <?php $sw = false;
                                        for ($i = 0; $i < sizeof($arrayReciclajeValor2); $i++) {
                                            if ($r1["NombreProducto"] == $arrayReciclajeNombre2[$i]) {
                                                echo '<td>' . number_format($arrayReciclajeValor2[$i], 2)  . '</td>';
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
                        <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                            <tr>
                                <td>
                                    <h4>Totales insumos</h4>
                                </td>
                                <td>
                                <h4>Total Solicitado: <?php echo number_format($totalSolicitado_anterior,2)  ?> Kg</h4>
                                </td>
                                <td>
                                <h4>Total Enviado: <?php echo number_format($totalEnviado_anterior,2)  ?> Kg</h4>
                                </td>
                                <td>
                                    <h4>Total Eliminacion:  <?php echo number_format($total_eliminado_anterior,2)  ?> Kg</h4>
                                </td>
                                <td>
                                    <h4>Total Reciclado:  <?php echo number_format($total_reciclaje_anterior,2)  ?> Kg</h4>
                                </td>
                                <td>
                                    <h4>Total Uso:  <?php echo number_format($totalUso_anterior,2)  ?> Kg</h4>
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