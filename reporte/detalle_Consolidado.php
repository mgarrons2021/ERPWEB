<html>

<head>
    <title>Detalle Consolidado</title>
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
    $sucursal_name = $db->GetOne("SELECT s.nombre FROM sucursal s WHERE s.idsucursal = $sucur");

    $fecha = $_GET['fecha_actual'];
    $min = 0;
    $max = 0;
    //SOLICITADO Y ENVIADO//

    if($sucur==20){
        $queryPedidos2 = $db->GetAll("
        select  pr.idcategoria  ,pr.nombre as ProductoNombre , SUM(d.cantidad) as CantidadSolicitada, SUM(d.cantidad_envio) as CantidadEnviada , SUM(d.cantidad-d.cantidad_envio) as Diferencia, pr.idunidad_medida 
        from detallepedido d 
        inner JOIN pedido p on p.nro = d.nro
        inner JOIN producto pr on pr.idproducto = d.producto_id
        INNER JOIN sucursal s on s.idsucursal = d.sucursal_id
        WHERE p.Fecha_p = '$fecha'  and d.sucursal_id =p.sucursal_id  and pr.idcategoria =2 
        group by pr.nombre ;
        "); 
    }else{
        $queryPedidos2 = $db->GetAll("
        select s.nombre as NombreSucursal ,pr.nombre as ProductoNombre, d.cantidad  as CantidadSolicitada , d.cantidad_envio as CantidadEnviada ,pr.idunidad_medida
        from pedido p , producto pr, detallepedido d , unidad_medida um ,sucursal s 
        where pr.idunidad_medida = um.idunidad_medida and d.sucursal_id = p.sucursal_id  and d.producto_id = pr.idproducto 
        and d.nro = p.nro and s.idsucursal = p.sucursal_id 
        and d.sucursal_id = $sucur and pr.idcategoria =2 and p.fecha_p = '$fecha'
        group by pr.idproducto  
        ");
    }

   
    // ELIMINACION //
    if($sucur==20){
        $queryEliminacion= $db->GetAll(" p.nombre as ProductoNombre , sum(d.cantidad)  as CantidadEliminada
        from eliminacion e 
        inner join detalleeliminacion d on d.nro = e.nro 
        inner join producto p on p.idproducto = d.producto_id 
        inner join sucursal s on s.idsucursal = d.sucursal_id 
        WHERE e.fecha  = '$fecha' and d.sucursal_id = e.sucursal_id 
        and p.idcategoria = 2 
        group by p.nombre ");
    }else{
        $queryEliminacion = $db->GetAll("
        select s.nombre as NombreSucursal,p.fecha as Fecha ,pr.nombre as ProductoNombre, sum(d.cantidad) as CantidadEliminada
        from detalleeliminacion d 
        inner JOIN eliminacion p on p.nro = d.nro 
        inner JOIN producto pr on pr.idproducto = d.producto_id 
        INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
        WHERE p.fecha  = '$fecha' and pr.idcategoria =2 and d.sucursal_id = p.sucursal_id 
        and s.idsucursal=$sucur 
        group by s.idsucursal, pr.nombre
        ");
    }
    
    $arrayEliminacionValor = array();
    $arrayEliminacionNombre = array();
    foreach ($queryEliminacion as $item) {
        array_push($arrayEliminacionValor, $item["CantidadEliminada"]);
        array_push($arrayEliminacionNombre, $item["ProductoNombre"]);
    }


    // RECICLAJE //
    if($sucur==20){
        $queryReciclaje= $db->GetAll("select s.nombre , p.nombre as ProductoNombre , sum(d.cantidad)  as CantidadReciclada
        from reciclaje r 
        inner join detallereciclaje  d on d.nro = r.nro 
        inner join producto p on p.idproducto = d.producto_id 
        inner join sucursal s on s.idsucursal = d.sucursal_id 
        WHERE r.fecha  = '$fecha_anterior' and d.sucursal_id = r.sucursal_id  
        and p.idcategoria = 2 
        group by p.nombre
        ");
    }else{
        $queryReciclaje = $db->GetAll("
        select s.nombre ,r.fecha as Fecha ,p.nombre as ProductoNombre, sum(d.cantidad) as CantidadReciclada
        from detallereciclaje d 
        inner join reciclaje r on r.nro = d.nro 
        inner join producto p on p.idproducto = d.producto_id 
        inner join sucursal s on s.idsucursal = r.sucursal_id 
        where r.fecha = '$fecha' and p.idcategoria =2 and d.sucursal_id = r.sucursal_id 
        and s.idsucursal = $sucur 
        group by p.nombre
        ");
    }
    
    $arrayReciclajeValor = array();
    $arrayReciclajeNombre = array();
    foreach ($queryReciclaje as $item) {
        array_push($arrayReciclajeValor, $item["CantidadReciclada"]);
        array_push($arrayReciclajeNombre, $item["ProductoNombre"]);
    }

    ?>
    <div class="container">
        <div class="left-sidebar">
            <h2>Detalle Consolidado </h2>
            <div class="table-responsive">
                <div class="row" style="margin: auto; height: 100%">


                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>

                                <h2><?php echo $sucursal_name ?> de la fecha <?php echo $fecha ?> </h2>

                            </tr>
                            <tr>
                                <!-- <th>SUCURSAL</th>
                                <th>FECHA</th> -->
                                <th>ITEM</th>
                                <th>CANTIDAD SOLICITADA</th>
                                <th>CANTIDAD ENVIADA</th>
                                <th>DIFERENCIA</th>
                                <th>ELIMINACION</th>
                                <th>RECICLAJE</th>
                                <th>TOTAL USO</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totalSolicitado=0;
                            $totalEnviado=0;
                            $totalDiferencia=0;
                            $totalEliminacion=0;
                            $totalReciclaje=0;
                            $totalTotalUso=0;
                            foreach ($queryPedidos2 as $r) {
                                
                                $um = $db->GetOne("select nombre from unidad_medida where idunidad_medida=$r[idunidad_medida]");

                            ?>
                                <tr class=warning>
                                    <td><?php echo $r["ProductoNombre"]; ?></td>
                                    <td>
                                    <?php 
                                    if ($r["ProductoNombre"] == "POLLO AL HORNO") {
                                            echo  number_format((($r["CantidadSolicitada"] / 8) * 1.3),2)." "."Kg"." | ".number_format($r["CantidadSolicitada"], 2) . " " . $um; 
                                            $totalSolicitado+=(($r["CantidadSolicitada"] / 8) * 1.3);
                                        } else if ($r["ProductoNombre"] == "KEPERI 0.150G") {
                                            echo  number_format($r["CantidadSolicitada"] * 0.15,2)." "."Kg"." | ".number_format($r["CantidadSolicitada"], 2) . " " . $um; 
                                            $totalSolicitado+=($r["CantidadSolicitada"] * 0.15);
                                        } else if($r["ProductoNombre"] == "BROCHETAS DE POLLO"){
                                            echo  number_format($r["CantidadSolicitada"] *  0.140,2)." "."Kg"." | ".number_format($r["CantidadSolicitada"], 2) . " " . $um; 
                                            $totalSolicitado+=($r["CantidadSolicitada"] * 0.140);
                                        } else {
                                            echo number_format($r["CantidadSolicitada"], 2) . " " . $um; 
                                            $totalSolicitado+=($r["CantidadSolicitada"]);
                                        }
                                    ?>
                                    </td>
                                    <td>
                                    <?php 
                                    if ($r["ProductoNombre"] == "POLLO AL HORNO") {
                                            echo  number_format((($r["CantidadEnviada"] / 8) * 1.3),2)." "."Kg"." | ".number_format($r["CantidadEnviada"], 2) . " " . $um; 
                                            $totalEnviado+=(($r["CantidadEnviada"] / 8) * 1.3);
                                        } else if ($r["ProductoNombre"] == "KEPERI 0.150G") {
                                            echo  number_format($r["CantidadEnviada"] * 0.15,2)." "."Kg"." | ".number_format($r["CantidadEnviada"], 2) . " " . $um; 
                                            $totalEnviado+=($r["CantidadEnviada"] * 0.15); 
                                        }else if($r["ProductoNombre"] == "BROCHETAS DE POLLO"){
                                            echo  number_format($r["CantidadEnviada"] *  0.140,2)." "."Kg"." | ".number_format($r["CantidadEnviada"], 2) . " " . $um; 
                                            $totalEnviado+=($r["CantidadEnviada"]* 0.140);
                                        } else {
                                            echo number_format($r["CantidadEnviada"], 2) . " " . $um; 
                                            $totalEnviado+=($r["CantidadEnviada"]);
                                        }
                                    ?>
                                    </td>
                                    <td>
                                    <?php 
                                    if ($r["ProductoNombre"] == "POLLO AL HORNO") {
                                            echo  number_format(((($r["CantidadEnviada"] - $r["CantidadSolicitada"]) / 8) * 1.3),2)." "."Kg"." | ".number_format(($r["CantidadEnviada"] - $r["CantidadSolicitada"]), 2) . " " . $um; 
                                            $totalDiferencia+=((($r["CantidadEnviada"] - $r["CantidadSolicitada"]) / 8) * 1.3);
                                        } else if ($r["ProductoNombre"] == "KEPERI 0.150G") {
                                            echo  number_format(($r["CantidadEnviada"] - $r["CantidadSolicitada"]) * 0.15,2)." "."Kg"." | ".number_format(($r["CantidadEnviada"] - $r["CantidadSolicitada"]), 2) . " " . $um; 
                                            $totalDiferencia+=(($r["CantidadEnviada"] - $r["CantidadSolicitada"]) * 0.15);
                                        }else if($r["ProductoNombre"] == "BROCHETAS DE POLLO"){
                                            echo  number_format(($r["CantidadEnviada"] - $r["CantidadSolicitada"]) * 0.140,2)." "."Kg"." | ".number_format(($r["CantidadEnviada"] - $r["CantidadSolicitada"]), 2) . " " . $um; 
                                            $totalDiferencia+=(($r["CantidadEnviada"] - $r["CantidadSolicitada"]) * 0.140);
                                        } else {
                                            echo number_format($r["CantidadEnviada"] - $r["CantidadSolicitada"], 2) . " " . $um;
                                            $totalDiferencia+=($r["CantidadEnviada"] - $r["CantidadSolicitada"]); 
                                        }
                                    ?>
                                    </td>


                                    <!-- TOTALES DE SOLICITADOS, ENVIADOS,..... -->


                                    <!-- ELIMINACION -->
                                    <?php $eliminacionValor=0; $sw = false;
                                    for ($i = 0; $i < sizeof($arrayEliminacionValor); $i++) {
                                        if ($r["ProductoNombre"] == $arrayEliminacionNombre[$i]) {

                                            if ($r["ProductoNombre"] == "POLLO AL HORNO") {
                                                echo '<td>'.number_format((($arrayEliminacionValor[$i]/ 8) * 1.3),2)." "."Kg"." | ". number_format($arrayEliminacionValor[$i], 2)  . " " .$um. '</td>';
                                                $totalEliminacion+=(($arrayEliminacionValor[$i] / 8) * 1.3);
                                            } else if ($r["ProductoNombre"] == "KEPERI 0.150G") {
                                                echo  '<td>'. number_format($arrayEliminacionValor[$i] * 0.15,2)." "."Kg"." | ".number_format($arrayEliminacionValor[$i], 2) . " " . $um. '</td>'; 
                                                $totalEliminacion+=($arrayEliminacionValor[$i] * 0.15);
                                            }else if($r["ProductoNombre"] == "BROCHETAS DE POLLO"){
                                                echo  '<td>'.number_format($arrayEliminacionValor[$i] *  0.140,2)." "."Kg"." | ".number_format($arrayEliminacionValor[$i], 2) . " " . $um. '</td>'; 
                                                $totalEliminacion+=($arrayEliminacionValor[$i]* 0.140);
                                            } else {
                                                echo '<td>'.number_format($arrayEliminacionValor[$i], 2) . " " . $um. '</td>'; 
                                                $totalEliminacion+=($arrayEliminacionValor[$i]);
                                            }

                                           
                                            $sw = true;
                                            $eliminacionValor=$arrayEliminacionValor[$i];
                                        }
                                    }
                                    if ($sw == false) {
                                        if($um=="Und"){
                                            echo '<td>'.'0.00'." "."Kg"." | ". '0.00' ." ".$um. '</td>';
                                        }else{
                                            echo '<td>'.'0.00' ." ".$um. '</td>';
                                        }
                                    } ?>


                                    <!-- RECICLAJE -->
                                    <?php $reciclajeValor=0; $sw = false;
                                    for ($i = 0; $i < sizeof($arrayReciclajeValor); $i++) {
                                        if ($r["ProductoNombre"] == $arrayReciclajeNombre[$i]) {

                                            if ($r["ProductoNombre"] == "POLLO AL HORNO") {
                                                echo  '<td>'.number_format((($arrayReciclajeValor[$i]/ 8) * 1.3),2)." "."Kg"." | ".number_format($arrayReciclajeValor[$i], 2) . " " . $um.'</td>'; 
                                                $totalReciclaje+=(($arrayReciclajeValor[$i] / 8) * 1.3);
                                            } else if ($r["ProductoNombre"] == "KEPERI 0.150G") {
                                                echo  '<td>'.number_format($arrayReciclajeValor[$i] * 0.15,2)." "."Kg"." | ".number_format($arrayReciclajeValor[$i], 2) . " " . $um.'</td>'; 
                                                $totalReciclaje+=($arrayReciclajeValor[$i] * 0.15);
                                            }else if($r["ProductoNombre"] == "BROCHETAS DE POLLO"){
                                                echo  '<td>'.number_format($arrayReciclajeValor[$i] *  0.140,2)." "."Kg"." | ".number_format($arrayReciclajeValor[$i], 2) . " " . $um.'</td>'; 
                                                $totalReciclaje+=($arrayReciclajeValor[$i]* 1.140);
                                            } else {
                                                echo '<td>'.number_format($arrayReciclajeValor[$i], 2) . " " . $um.'</td>'; 
                                                $totalReciclaje+=($arrayReciclajeValor[$i]);
                                            }


                                            /* echo '<td>' . number_format($arrayReciclajeValor[$i], 2) ." ".$um. '</td>'; */
                                            $sw = true;
                                            $reciclajeValor=$arrayReciclajeValor[$i];
                                        }
                                    }
                                    if ($sw == false) {
                                        if($um=="Und"){
                                            echo '<td>'.'0.00'." "."Kg"." | ". '0.00' ." ".$um. '</td>';
                                        }else{
                                            echo '<td>'.'0.00' ." ".$um. '</td>';
                                        }
                                    } ?>

                                    <!-- TOTAL USO -->

                                    <?php
                                        $total_uso_unidades=0;
                                        if ($r["ProductoNombre"] === "POLLO AL HORNO") {
                                            $total_uso = (($r["CantidadEnviada"] / 8) * 1.3)+(($reciclajeValor/8)*1.3)-(($eliminacionValor/8)*1.3);
                                            $total_uso_unidades = $r["CantidadEnviada"]+$reciclajeValor-$eliminacionValor;
                                        } else if ($r["ProductoNombre"] === "KEPERI 0.150G") {
                                            $total_uso = ($r["CantidadEnviada"] * 0.15)+($reciclajeValor*0.15)-($eliminacionValor*0.15);
                                            $total_uso_unidades = $r["CantidadEnviada"]+$reciclajeValor-$eliminacionValor;
                                        }else if($r["ProductoNombre"] === "BROCHETAS DE POLLO"){
                                            $total_uso = ($r["CantidadEnviada"] * 0.140)+($reciclajeValor*0.140)-($eliminacionValor*0.140);
                                            $total_uso_unidades = $r["CantidadEnviada"]+$reciclajeValor-$eliminacionValor;
                                        } else {
                                            $total_uso = $r["CantidadEnviada"]+$reciclajeValor-$eliminacionValor;
                                            $sw=false;
                                        }
                                        $totalTotalUso+= $total_uso;
                                    ?>
                                    <td>
                                    <?php
                                    if($total_uso_unidades===0){
                                        echo number_format( $total_uso, 2) . " "." Kg"; 
                                    }else{
                                        echo number_format( $total_uso, 2) . " "." Kg"." | ".number_format( $total_uso_unidades, 2)." ".$um; 
                                    } 
                                    ?>
                                    </td>


                                </tr>
                            <?php }
                            ?>
                        </tbody>

                    </table>



                    <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <h4>Totales Produccion</h4>
                            </td>
                            <td>
                                <h4>Total Solicitado: <?php echo number_format($totalSolicitado,2) ?> Kg</h4>
                            </td>
                            <td>
                                <h4>Total Enviado: <?php echo number_format($totalEnviado,2)  ?> Kg</h4>
                            </td>
                            <td>
                                <h4>Total Diferencia: <?php echo number_format($totalDiferencia,2)  ?> Kg</h4>
                            </td>
                            <td>
                                <h4>Total Eliminado: <?php echo number_format($totalEliminacion,2)  ?> Kg</h4>
                            </td>
                            <td>
                                <h4>Total Reciclado: <?php echo number_format($totalReciclaje,2)  ?> Kg</h4>
                            </td>
                            <td>
                                <h4>Total de Uso: <?php echo number_format($totalTotalUso,2)  ?> Kg</h4>
                            </td>
                        </tr>
                    </table>
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