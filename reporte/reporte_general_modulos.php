<html>

<head>
    <title>Reporte General Modulos </title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="../js/jquery.js"></script>
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
    <style>
        td {
            font-size: 20px;
            height: 8px;
            width: 150px;
        }
        th {
            font-size: 20px;
            height: 8px;
            width: 150px;
            text-align: center !important;
        }
    </style>
</head>

<body class="body">
    <?php include "../menu/menu.php";
    $usuario = $_SESSION['usuario'];
    $sucur = $usuario['sucursal_id'];
    $resultado_sucursal = $db->GetAll("SELECT * FROM sucursal ORDER BY idsucursal DESC");
    
    if(isset($_POST['sucursal'])){
        $sucur       = $_POST['sucursal']; 
        $sucursal_name = $db->GetOne("SELECT nombre FROM sucursal WHERE idsucursal = '$sucur'");
    }else{
        $sucursal_name = 'Sin Suc.';
    }

    ?>
    <div class="container">
        <div class="left-sidebar">
            <h2>Reporte General Modulos </h2>
            <div class="table-responsive">
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
                
       
               
                <form action="reporte_general_modulos.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                                <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" value="<?php if (isset($_POST['fechaini'])) {
                                                                                                                            echo $_POST['fechaini'];
                                                                                                                        } ?>" />                              
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
                        </div>
                    </div>
                </form>
                <br>
                <button onclick="exceller()" class="btn btn-success">Export</button><br>

                <?php

                if (isset($_POST['fechaini'])) {
                    $fechaInicio = $_POST['fechaini'];

                    $total_am_sur           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 2 and pago != 'comida_personal' AND estado = 'V' AND turno = 1");
                    $total_pm_sur           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 2 and pago != 'comida_personal' AND estado = 'V' AND turno = 2");
                    $produccion_enviada_sur = $db->GetOne("SELECT SUM(total_envio2) FROM pedido WHERE fecha_e = '$fechaInicio' AND sucursal_id = 2");
                    $parte_produccion_sur   = $db->GetOne("SELECT total FROM parte_produccion WHERE fecha = '$fechaInicio' AND sucursal_id = 2");
                    $eliminacion_sur        = $db->GetOne("SELECT SUM(total) FROM eliminacion WHERE fecha = '$fechaInicio' AND sucursal_id = 2");
                    $comidapersonal_am_sur  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 2 and pago = 'comida_personal' AND estado = 'V' AND turno = 1");
                    $comidapersonal_pm_sur  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 2 and pago = 'comida_personal' AND estado = 'V' AND turno = 2");
                    $inventario_am_sur      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 2 AND fecha = '$fechaInicio' and turno = 1");
                    $inventario_pm_sur      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 2 AND fecha = '$fechaInicio' and turno = 2");
                    $kilos_solicitados_sur  = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_p = '$fechaInicio' AND t.sucursal_id = 2");
 		    $kilos_enviados_sur     = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_e = '$fechaInicio' AND t.sucursal_id = 2");
                    
                    
                    $total_am_tres_pasos           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 5 and pago != 'comida_personal' AND estado = 'V' AND turno = 1");
                    $total_pm_tres_pasos           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 5 and pago != 'comida_personal' AND estado = 'V' AND turno = 2");
                    $produccion_enviada_tres_pasos = $db->GetOne("SELECT SUM(total_envio2) FROM pedido WHERE fecha_e = '$fechaInicio' AND sucursal_id = 5");
                    $parte_produccion_tres_pasos   = $db->GetOne("SELECT total FROM parte_produccion WHERE fecha = '$fechaInicio' AND sucursal_id = 5");
                    $eliminacion_tres_pasos        = $db->GetOne("SELECT SUM(total) FROM eliminacion WHERE fecha = '$fechaInicio' AND sucursal_id = 5");
                    $comidapersonal_am_tres_pasos  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 5 and pago = 'comida_personal' AND estado = 'V' AND turno = 1");
                    $comidapersonal_pm_tres_pasos  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 5 and pago = 'comida_personal' AND estado = 'V' AND turno = 2");
                    $inventario_am_tres_pasos      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 5 AND fecha = '$fechaInicio' and turno = 1");
                    $inventario_pm_tres_pasos      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 5 AND fecha = '$fechaInicio' and turno = 2");
                    $kilos_solicitados_tres_pasos  = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_p = '$fechaInicio' AND t.sucursal_id = 5");
 		    $kilos_enviados_tres_pasos     = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_e = '$fechaInicio' AND t.sucursal_id = 5");  
 							  
 							                   
                    
                    $total_am_pampa           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 6 and pago != 'comida_personal' AND estado = 'V' AND turno = 1");
                    $total_pm_pampa           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 6 and pago != 'comida_personal' AND estado = 'V' AND turno = 2");
                    $produccion_enviada_pampa = $db->GetOne("SELECT SUM(total_envio2) FROM pedido WHERE fecha_e = '$fechaInicio' AND sucursal_id = 6");
                    $parte_produccion_pampa   = $db->GetOne("SELECT total FROM parte_produccion WHERE fecha = '$fechaInicio' AND sucursal_id = 6");
                    $eliminacion_pampa        = $db->GetOne("SELECT SUM(total) FROM eliminacion WHERE fecha = '$fechaInicio' AND sucursal_id = 6");
                    $comidapersonal_am_pampa  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 6 and pago = 'comida_personal' AND estado = 'V' AND turno = 1");
                    $comidapersonal_pm_pampa  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 6 and pago = 'comida_personal' AND estado = 'V' AND turno = 2");
                    $inventario_am_pampa      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 6 AND fecha = '$fechaInicio' and turno = 1");
                    $inventario_pm_pampa      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 6 AND fecha = '$fechaInicio' and turno = 2");
                    $kilos_solicitados_pampa  = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_p = '$fechaInicio' AND t.sucursal_id = 6"); 
 		    $kilos_enviados_pampa     = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_e = '$fechaInicio' AND t.sucursal_id = 6"); 					   
                                        
                    
                    $total_am_radial           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 7 and pago != 'comida_personal' AND estado = 'V' AND turno = 1");
                    $total_pm_radial           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 7 and pago != 'comida_personal' AND estado = 'V' AND turno = 2");
                    $produccion_enviada_radial = $db->GetOne("SELECT SUM(total_envio2) FROM pedido WHERE fecha_e = '$fechaInicio' AND sucursal_id = 7");
                    $parte_produccion_radial   = $db->GetOne("SELECT total FROM parte_produccion WHERE fecha = '$fechaInicio' AND sucursal_id = 7");
                    $eliminacion_radial        = $db->GetOne("SELECT SUM(total) FROM eliminacion WHERE fecha = '$fechaInicio' AND sucursal_id = 7");
                    $comidapersonal_am_radial  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 7 and pago = 'comida_personal' AND estado = 'V' AND turno = 1");
                    $comidapersonal_pm_radial  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 7 and pago = 'comida_personal' AND estado = 'V' AND turno = 2");
                    $inventario_am_radial      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 7 AND fecha = '$fechaInicio' and turno = 1");
                    $inventario_pm_radial      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 7 AND fecha = '$fechaInicio' and turno = 2");
                    $kilos_solicitados_radial  = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_p = '$fechaInicio' AND t.sucursal_id = 7");
                    $kilos_enviados_radial     = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_e = '$fechaInicio' AND t.sucursal_id = 7");  
                                        
                    
                    $total_am_qd_villa           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 8 and pago != 'comida_personal' AND estado = 'V' AND turno = 1");
                    $total_pm_qd_villa           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 8 and pago != 'comida_personal' AND estado = 'V' AND turno = 2");
                    $produccion_enviada_qd_villa = $db->GetOne("SELECT SUM(total_envio2) FROM pedido WHERE fecha_e = '$fechaInicio' AND sucursal_id = 8");
                    $parte_produccion_qd_villa   = $db->GetOne("SELECT total FROM parte_produccion WHERE fecha = '$fechaInicio' AND sucursal_id = 8");
                    $eliminacion_qd_villa        = $db->GetOne("SELECT SUM(total) FROM eliminacion WHERE fecha = '$fechaInicio' AND sucursal_id = 8");
                    $comidapersonal_am_qd_villa  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 8 and pago = 'comida_personal' AND estado = 'V' AND turno = 1");
                    $comidapersonal_pm_qd_villa  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 8 and pago = 'comida_personal' AND estado = 'V' AND turno = 2");
                    $inventario_am_qd_villa      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 8 AND fecha = '$fechaInicio' and turno = 1");
                    $inventario_pm_qd_villa      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 8 AND fecha = '$fechaInicio' and turno = 2"); 
                    $kilos_solicitados_qd_villa  = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_p = '$fechaInicio' AND t.sucursal_id = 8"); 
 		    $kilos_enviados_qd_villa     = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_e = '$fechaInicio' AND t.sucursal_id = 8"); 					   
                    
                    $total_am_bajio           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 9 and pago != 'comida_personal' AND estado = 'V' AND turno = 1");
                    $total_pm_bajio           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 9 and pago != 'comida_personal' AND estado = 'V' AND turno = 2");
                    $produccion_enviada_bajio = $db->GetOne("SELECT SUM(total_envio2) FROM pedido WHERE fecha_e = '$fechaInicio' AND sucursal_id = 9");
                    $parte_produccion_bajio   = $db->GetOne("SELECT total FROM parte_produccion WHERE fecha = '$fechaInicio' AND sucursal_id = 9");
                    $eliminacion_bajio        = $db->GetOne("SELECT SUM(total) FROM eliminacion WHERE fecha = '$fechaInicio' AND sucursal_id = 9");
                    $comidapersonal_am_bajio  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 9 and pago = 'comida_personal' AND estado = 'V' AND turno = 1");
                    $comidapersonal_pm_bajio  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 9 and pago = 'comida_personal' AND estado = 'V' AND turno = 2");
                    $inventario_am_bajio      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 9 AND fecha = '$fechaInicio' and turno = 1");
                    $inventario_pm_bajio      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 9 AND fecha = '$fechaInicio' and turno = 2");
                    $kilos_solicitados_bajio  = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_p = '$fechaInicio' AND t.sucursal_id = 9");
 		    $kilos_enviados_bajio     = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_e = '$fechaInicio' AND t.sucursal_id = 9");  
                                          
                    
                    $total_am_arenal           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 10 and pago != 'comida_personal' AND estado = 'V' AND turno = 1");
                    $total_pm_arenal           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 10 and pago != 'comida_personal' AND estado = 'V' AND turno = 2");
                    $produccion_enviada_arenal = $db->GetOne("SELECT SUM(total_envio2) FROM pedido WHERE fecha_e = '$fechaInicio' AND sucursal_id = 10");
                    $parte_produccion_arenal   = $db->GetOne("SELECT total FROM parte_produccion WHERE fecha = '$fechaInicio' AND sucursal_id = 10");
                    $eliminacion_arenal        = $db->GetOne("SELECT SUM(total) FROM eliminacion WHERE fecha = '$fechaInicio' AND sucursal_id = 10");
                    $comidapersonal_am_arenal  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 10 and pago = 'comida_personal' AND estado = 'V' AND turno = 1");
                    $comidapersonal_pm_arenal  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 10 and pago = 'comida_personal' AND estado = 'V' AND turno = 2");  
                    $inventario_am_arenal      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 10 AND fecha = '$fechaInicio' and turno = 1");
                    $inventario_pm_arenal      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 10 AND fecha = '$fechaInicio' and turno = 2");
                    $kilos_solicitados_arenal  = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_p = '$fechaInicio' AND t.sucursal_id = 10"); 
 		    $kilos_enviados_arenal     = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_e = '$fechaInicio' AND t.sucursal_id = 10"); 					                       
                    
                    $total_am_plan           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 11 and pago != 'comida_personal' AND estado = 'V' AND turno = 1");
                    $total_pm_plan           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 11 and pago != 'comida_personal' AND estado = 'V' AND turno = 2");
                    $produccion_enviada_plan = $db->GetOne("SELECT SUM(total_envio2) FROM pedido WHERE fecha_e = '$fechaInicio' AND sucursal_id = 11");
                    $parte_produccion_plan   = $db->GetOne("SELECT total FROM parte_produccion WHERE fecha = '$fechaInicio' AND sucursal_id = 11");
                    $eliminacion_plan        = $db->GetOne("SELECT SUM(total) FROM eliminacion WHERE fecha = '$fechaInicio' AND sucursal_id = 11");
                    $comidapersonal_am_plan  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 11 and pago = 'comida_personal' AND estado = 'V' AND turno = 1");
                    $comidapersonal_pm_plan  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 11 and pago = 'comida_personal' AND estado = 'V' AND turno = 2"); 
                    $inventario_am_plan      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 11 AND fecha = '$fechaInicio' and turno = 1");
                    $inventario_pm_plan      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 11 AND fecha = '$fechaInicio' and turno = 2");
                    $kilos_solicitados_plan  = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_p = '$fechaInicio' AND t.sucursal_id = 11");
 		    $kilos_enviados_plan     = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_e = '$fechaInicio' AND t.sucursal_id = 11"); 
                                                             
                    
                    $total_am_villa           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 13 and pago != 'comida_personal' AND estado = 'V' AND turno = 1");
                    $total_pm_villa           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 13 and pago != 'comida_personal' AND estado = 'V' AND turno = 2");
                    $produccion_enviada_villa = $db->GetOne("SELECT SUM(total_envio2) FROM pedido WHERE fecha_e = '$fechaInicio' AND sucursal_id = 13");
                    $parte_produccion_villa   = $db->GetOne("SELECT total FROM parte_produccion WHERE fecha = '$fechaInicio' AND sucursal_id = 13");
                    $eliminacion_villa        = $db->GetOne("SEL   ECT SUM(total) FROM eliminacion WHERE fecha = '$fechaInicio' AND sucursal_id = 13");
                    $comidapersonal_am_villa  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 13 and pago = 'comida_personal' AND estado = 'V' AND turno = 1");
                    $comidapersonal_pm_villa  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 13 and pago = 'comida_personal' AND estado = 'V' AND turno = 2");
                    $inventario_am_villa      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 13 AND fecha = '$fechaInicio' and turno = 1");
                    $inventario_pm_villa      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 13 AND fecha = '$fechaInicio' and turno = 2");
                    $kilos_solicitados_villa  = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_p = '$fechaInicio' AND t.sucursal_id = 13");
 		    $kilos_enviados_villa     = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_e = '$fechaInicio' AND t.sucursal_id = 13"); 
                    
                    
                    $total_am_cine           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 15 and pago != 'comida_personal' AND estado = 'V' AND turno = 1");
                    $total_pm_cine           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 15 and pago != 'comida_personal' AND estado = 'V' AND turno = 2");
                    $produccion_enviada_cine = $db->GetOne("SELECT SUM(total_envio2) FROM pedido WHERE fecha_e = '$fechaInicio' AND sucursal_id = 15");
                    $parte_produccion_cine   = $db->GetOne("SELECT total FROM parte_produccion WHERE fecha = '$fechaInicio' AND sucursal_id = 15");
                    $eliminacion_cine        = $db->GetOne("SELECT SUM(total) FROM eliminacion WHERE fecha = '$fechaInicio' AND sucursal_id = 15");
                    $comidapersonal_am_cine  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 15 and pago = 'comida_personal' AND estado = 'V' AND turno = 1");
                    $comidapersonal_pm_cine  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 15 and pago = 'comida_personal' AND estado = 'V' AND turno = 2");
                    $inventario_am_cine      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 15 AND fecha = '$fechaInicio' and turno = 1");
                    $inventario_pm_cine      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 15 AND fecha = '$fechaInicio' and turno = 2");
                    $kilos_solicitados_cine  = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_p = '$fechaInicio' AND t.sucursal_id = 15");
 		    $kilos_enviados_cine     = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_e = '$fechaInicio' AND t.sucursal_id = 15"); 					  
                    
                    
                    $total_am_boulevar           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 16 and pago != 'comida_personal' AND estado = 'V' AND turno = 1");
                    $total_pm_boulevar           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 16 and pago != 'comida_personal' AND estado = 'V' AND turno = 2");
                    $produccion_enviada_boulevar = $db->GetOne("SELECT SUM(total_envio2) FROM pedido WHERE fecha_e = '$fechaInicio' AND sucursal_id = 16");
                    $parte_produccion_boulevar   = $db->GetOne("SELECT total FROM parte_produccion WHERE fecha = '$fechaInicio' AND sucursal_id = 16");
                    $eliminacion_boulevar        = $db->GetOne("SELECT SUM(total) FROM eliminacion WHERE fecha = '$fechaInicio' AND sucursal_id = 16");
                    $comidapersonal_am_boulevar  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 16 and pago = 'comida_personal' AND estado = 'V' AND turno = 1");
                    $comidapersonal_pm_boulevar  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 16 and pago = 'comida_personal' AND estado = 'V' AND turno = 2");
                    $inventario_am_boulevar      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 16 AND fecha = '$fechaInicio' and turno = 1");
                    $inventario_pm_boulevar      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 16 AND fecha = '$fechaInicio' and turno = 2");
                    $kilos_solicitados_boulevar  = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_p = '$fechaInicio' AND t.sucursal_id = 16");
 		    $kilos_enviados_boulevar     = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_e = '$fechaInicio' AND t.sucursal_id = 16");    
 							  
 							
 							
                    $total_am_mutu           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 14 and pago != 'comida_personal' AND estado = 'V' AND turno = 1");
                    $total_pm_mutu           = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 14 and pago != 'comida_personal' AND estado = 'V' AND turno = 2");
                    $produccion_enviada_mutu = $db->GetOne("SELECT SUM(total_envio2) FROM pedido WHERE fecha_e = '$fechaInicio' AND sucursal_id = 14");
                    $parte_produccion_mutu   = $db->GetOne("SELECT total FROM parte_produccion WHERE fecha = '$fechaInicio' AND sucursal_id = 14");
                    $eliminacion_mutu        = $db->GetOne("SELECT SUM(total) FROM eliminacion WHERE fecha = '$fechaInicio' AND sucursal_id = 14");
                    $comidapersonal_am_mutu  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 14 and pago = 'comida_personal' AND estado = 'V' AND turno = 1");
                    $comidapersonal_pm_mutu  = $db->GetOne("SELECT SUM(total) FROM venta WHERE fecha = '$fechaInicio' AND sucursal_id = 14 and pago = 'comida_personal' AND estado = 'V' AND turno = 2");
                    $inventario_am_mutu      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 14 AND fecha = '$fechaInicio' and turno = 1");
                    $inventario_pm_mutu      = $db->GetOne("SELECT SUM(total) FROM inventario WHERE sucursal_id = 14 AND fecha = '$fechaInicio' and turno = 2");
                    $kilos_solicitados_mutu  = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_p = '$fechaInicio' AND t.sucursal_id = 14");
 		    $kilos_enviados_mutu     = $db->GetOne("SELECT SUM(dt.cantidad)as kG FROM detallepedido dt,pedido t, sucursal s,producto p WHERE p.idcategoria=2 AND p.idproducto=dt.producto_id AND t.sucursal_id=dt.sucursal_id 																								 
 							  AND dt.nro=t.nro AND t.sucursal_id=s.idsucursal AND t.fecha_e = '$fechaInicio' AND t.sucursal_id = 14"); 
                    
                                        
		    

                } else {
                    $sucur = 0;
                    $fechaInicio = date('Y-m-d');
                    $sql_total_rango_pro    = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE sucursal_id = '$sucur' AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal'");
                    
                 
                }

                ?>
             
                <table border="1" id="tblam" >
                     <thead>
                        <tr>
                           <th>Sucur.</th>
                           <th colspan="2">Sur</th>
                           <th colspan="2">Tres. P</th>
                           <th colspan="2">Pampa</th>
                           <th colspan="2">Rd. 26</th>
                           <th colspan="2">QD Villa</th>
                           <th colspan="2">Bajio</th>
                           <th colspan="2">Arenal</th>
                           <th colspan="2">Plan</th>
                           <th colspan="2">Villa</th>
                           <th colspan="2">C. C.</th>
                           <th colspan="2">Bou.</th>
                           <th colspan="2">Mutu.</th>
                           
                        </tr>
                     	<tr>
                     	    <th>Datos</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    
                     	</tr>
                     </thead>
                     <tbody>
                     	<tr>
                     	    <td>Venta am</td>
                     	    <td><?= number_format($total_am_sur,2) ?></td>
                     	    <td></td>
                            <td><?= number_format($total_am_tres_pasos,2) ?></td>
                            <td></td>
                            <td><?= number_format($total_am_pampa,2) ?></td>
                            <td></td>
                            <td><?= number_format($total_am_radial,2) ?></td>
                            <td></td>
                            <td><?= number_format($total_am_qd_villa,2) ?></td>
                            <td></td>
                            <td><?= number_format($total_am_bajio,2) ?></td>
                            <td></td>
                            <td><?= number_format($total_am_arenal,2) ?></td>
                            <td></td>
                            <td><?= number_format($total_am_plan,2) ?></td>
                            <td></td>
                            <td><?= number_format($total_am_villa,2) ?></td>
                            <td></td>
                            <td><?= number_format($total_am_cine,2) ?></td>
                            <td></td>
                            <td><?= number_format($total_am_boulevar,2) ?></td>
                            <td></td>
                            <td><?= number_format($total_am_mutu,2) ?></td>
                            <td></td>
                             
                           
                     	</tr>
                     	<tr>
                     	   <td>Producc. Enviada</td>
                     	    <td><?= number_format($produccion_enviada_sur, 2) ?></td>
                     	    <td><?= number_format($total_am_sur / $produccion_enviada_sur, 2)?></td>
                            <td><?= number_format($produccion_enviada_tres_pasos,2)?></td>
                            <td><?= number_format($total_am_tres_pasos / $produccion_enviada_tres_pasos, 2)?></td>
                            <td><?= number_format($produccion_enviada_pampa, 2)?></td>
                            <td><?= number_format($total_am_pampa / $produccion_enviada_pampa, 2 ) ?></td>
                            <td><?= number_format($produccion_enviada_radial,2)?></td>
                            <td><?= number_format($total_am_radial / $produccion_enviada_radial,2)?></td>
                            <td><?= number_format($produccion_enviada_qd_villa,2)?></td>
                            <td><?= number_format($total_am_qd_villa / $produccion_enviada_qd_villa,2)?></td>
                            <td><?= number_format($produccion_enviada_bajio, 2)?></td>
                            <td><?= number_format($total_am_bajio / $produccion_enviada_bajio, 2)?></td>
                            <td><?= number_format($produccion_enviada_arenal,2)?></td>
                            <td><?= number_format($total_am_arenal / $produccion_enviada_arenal, 2)?></td>
                            <td><?= number_format($produccion_enviada_plan,2)?></td>
                            <td><?= number_format($total_am_plan / $produccion_enviada_plan, 2)?></td>
                            <td><?= number_format($produccion_enviada_villa,2)?></td>
                            <td><?= number_format($total_am_villa / $produccion_enviada_villa, 2)?></td>
                            <td><?= number_format($produccion_enviada_cine,2)?></td>
                            <td><?= number_format($total_am_cine / $produccion_enviada_cine, 2)?></td>
                            <td><?= number_format($produccion_enviada_boulevar,2)?></td>
                            <td><?= number_format($total_am_boulevar / $produccion_enviada_boulevar, 2)?></td>
                            <td><?= number_format($produccion_enviada_mutu,2)?></td>
                            <td><?= number_format($total_am_mutu / $produccion_enviada_mutu, 2)?></td>
                            
                            
                     	</tr>
                     	<tr>
                     	    <td>Parte Produc.</td>
                     	    <td><?= number_format($parte_produccion_sur,2)?></td>
                     	    <td><?= number_format($total_am_sur /  $parte_produccion_sur, 2)?></td>
                            <td><?= number_format($parte_produccion_tres_pasos,2)?></td>
                            <td><?= number_format($total_am_tres_pasos /  $parte_produccion_tres_pasos, 2)?></td>
                            <td><?= number_format($parte_produccion_pampa,2)?> </td>
                            <td><?= number_format($total_am_pampa /  $parte_produccion_pampa, 2)?></td>
                            <td><?= number_format($parte_produccion_radial,2)?></td>
                            <td><?= number_format($total_am_radial /  $parte_produccion_radial, 2)?></td>
                            <td><?= number_format($parte_produccion_qd_villa,2)?></td>
                            <td><?= number_format($total_am_qd_villa / $parte_produccion_qd_villa,2)?></td>
                            <td><?= number_format($parte_produccion_bajio,2) ?></td>
                            <td><?= number_format($total_am_bajio / $parte_produccion_bajio,2)?></td>
                            <td><?= number_format($parte_produccion_arenal,2) ?></td>
                            <td><?= number_format($total_am_arenal / $parte_produccion_arenal,2)?></td>
                            <td><?= number_format($parte_produccion_plan,2) ?></td>
                            <td><?= number_format($total_am_plan / $parte_produccion_plan,2)?></td>
                            <td><?= number_format($parte_produccion_villa,2) ?></td>
                            <td><?= number_format($total_am_villa / $parte_produccion_villa,2)?></td>
                            <td><?= number_format($parte_produccion_cine,2)?></td>
                            <td><?= number_format($total_am_cine / $parte_produccion_cine,2)?></td>
                            <td><?= number_format($parte_produccion_boulevar,2)?></td>
                            <td><?= number_format($total_am_boulevar / $parte_produccion_boulevar,2)?></td>
                            <td><?= number_format($parte_produccion_mutu,2)?></td>
                            <td><?= number_format($total_am_mutu / $parte_produccion_mutu,2)?></td>
                            
                            
                     	</tr>
                     	<tr>
                     	    <td>Eliminación</td>
                     	    <td><?= number_format($eliminacion_sur,2)?></td>
                     	    <td><?= number_format($total_am_sur / $eliminacion_sur,2 )?></td>
                            <td><?= number_format($eliminacion_tres_pasos,2)?></td>
                            <td><?= number_format($total_am_tres_pasos / $eliminacion_tres_pasos,2 )?></td>
                            <td><?= number_format($eliminacion_pampa,2)?></td>
                            <td><?= number_format($total_am_pampa / $eliminacion_pampa,2 )?></td>
                            <td><?= number_format($eliminacion_radial,2)?></td>
                            <td><?= number_format($total_am_radial / $eliminacion_radial,2 )?></td>
                            <td><?= number_format($eliminacion_qd_villa,2)?></td>
                            <td><?= number_format($total_am_qd_villa / $eliminacion_qd_villa,2 )?></td>
                            <td><?= number_format($eliminacion_bajio,2)?></td>
                            <td><?= number_format($total_am_bajio / $eliminacion_bajio,2 )?></td>
                            <td><?= number_format($eliminacion_arenal,2)?></td>
                            <td><?= number_format($total_am_arenal / $eliminacion_arenal,2 )?></td>
                            <td><?= number_format($eliminacion_plan,2)?></td>
                            <td><?= number_format($total_am_plan / $eliminacion_plan,2 )?></td>
                            <td><?= number_format($eliminacion_villa,2)?></td>
                            <td><?= number_format($total_am_villa / $eliminacion_villa,2 )?></td>
                            <td><?= number_format($eliminacion_cine,2)?></td>
                            <td><?= number_format($total_am_cine / $eliminacion_cine,2 )?></td>
                            <td><?= number_format($eliminacion_boulevar,2)?></td>
                            <td><?= number_format($total_am_boulevar / $eliminacion_boulevar,2 )?></td>
                            <td><?= number_format($eliminacion_mutu,2)?></td>
                            <td><?= number_format($total_am_mutu / $eliminacion_mutu,2 )?></td>
                            
                           
                     	</tr>
                     	<tr>
                     	   <td>Comid. Autorizada</td>
                     	    <td><?= number_format($comidapersonal_am_sur,2) ?></td>
                     	    <td><?= number_format($total_am_sur / $comidapersonal_am_sur,2)?></td>
                            <td><?= number_format($comidapersonal_am_tres_pasos,2)?></td>
                            <td><?= number_format($total_am_tres_pasos / $comidapersonal_am_tres_pasos,2)?></td>
                            <td><?= number_format($comidapersonal_am_pampa,2)?></td>
                            <td><?= number_format($total_am_pampa / $comidapersonal_am_pampa,2)?></td>
                            <td><?= number_format($comidapersonal_am_radial,2)?></td>
                            <td><?= number_format($total_am_radial / $comidapersonal_am_radial,2)?></td>
                            <td><?= number_format($comidapersonal_am_qd_villa,2)?></td>
                            <td><?= number_format($total_am_qd_villa / $comidapersonal_am_qd_villa,2)?></td>
                            <td><?= number_format($comidapersonal_am_bajio ,2)?></td>
                            <td><?= number_format($total_am_bajio / $comidapersonal_am_bajio,2)?></td>
                            <td><?= number_format($comidapersonal_am_arenal,2)?></td>
                            <td><?= number_format($total_am_arenal / $comidapersonal_am_arenal,2)?></td>
                            <td><?= number_format($comidapersonal_am_plan,2)?></td>
                            <td><?= number_format($total_am_plan / $comidapersonal_am_plan,2)?></td>
                            <td><?= number_format($comidapersonal_am_villa,2)?></td>
                            <td><?= number_format($total_am_villa / $comidapersonal_am_villa,2)?></td>
                            <td><?= number_format($comidapersonal_am_cine,2)?></td>
                            <td><?= number_format($total_am_cine / $comidapersonal_am_cine,2)?></td>
                            <td><?= number_format($comidapersonal_am_boulevar,2)?></td>
                            <td><?= number_format($total_am_boulevar / $comidapersonal_am_boulevar,2)?></td>
                            <td><?= number_format($comidapersonal_am_mutu,2)?></td>
                            <td><?= number_format($total_am_mutu / $comidapersonal_am_mutu,2)?></td>
                            
                            
                     	</tr>
                     	
                     	
                     	<tr>
                     	    <td>Ajs. de Inven.</td>
                     	    <td>00</td>
                     	    <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                             <td>00</td>
                            <td>%</td>
                            
                            
                     	</tr>
                     	<tr>
                     	   <td>Inven.</td>
                     	    <td><?= number_format($inventario_am_sur, 2)?></td>
                     	    <td><?= number_format($total_am_sur / $inventario_am_sur, 2) ?></td>
                            <td><?= number_format($inventario_am_tres_pasos,2)?></td>
                            <td><?= number_format($total_am_tres_pasos / $inventario_am_tres_pasos, 2) ?></td>
                            <td><?= number_format($inventario_am_pampa,2)?></td>
                            <td><?= number_format($total_am_pampa / $inventario_am_pampa, 2) ?></td>
                            <td><?= number_format($inventario_am_radial,2)?></td>
                            <td><?= number_format($total_am_radial / $inventario_am_radial, 2) ?></td>
                            <td><?= number_format($inventario_am_qd_villa,2)?></td>
                            <td><?= number_format($total_am_qd_villa / $inventario_am_qd_villa, 2) ?></td>
                            <td><?= number_format($inventario_am_bajio,2)?></td>
                            <td><?= number_format($total_am_bajio / $inventario_am_bajio, 2) ?></td>
                            <td><?= number_format($inventario_am_arenal,2)?></td>
                            <td><?= number_format($total_am_arenal / $inventario_am_arenal, 2) ?></td>
                            <td><?= number_format($inventario_am_plan,2)?></td>
                            <td><?= number_format($total_am_plan / $inventario_am_plan, 2) ?></td>
                            <td><?= number_format($inventario_am_villa,2)?></td>
                            <td><?= number_format($total_am_villa / $inventario_am_villa, 2) ?></td>
                            <td><?= number_format($inventario_am_cine,2)?></td>
                            <td><?= number_format($total_am_cine / $inventario_am_cine, 2) ?></td>
                            <td><?= number_format($inventario_am_boulevar,2)?></td>
                            <td><?= number_format($total_am_boulevar / $inventario_am_boulevar, 2) ?></td>
                            <td><?= number_format($inventario_am_mutu,2)?></td>
                            <td><?= number_format($total_am_mutu / $inventario_am_mutu, 2) ?></td>

                            
                     	</tr>
                     	<tr>
                     	    <td>Cost. Comida</td>
                     	    <td>00</td>
                     	    <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                           
                         
                           
                     	</tr>
                     	<tr>
                     	    <td>Cost. Bebida</td>
                     	    <td>00</td>
                     	    <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            
                            
                     	</tr>
                     	<tr>
                     	   <td>Cost. Refresco</td>
                     	    <td>00</td>
                     	    <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                           
                            
                     	</tr>
                     	<tr>
                     	   <td>Cost. total Insumos</td>
                     	    <td>00</td>
                     	    <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            
                     	</tr>
                     	<tr style ="height: 25px;">
                     	    <td style ="color: transparent !important"></td>
                     	    <td style ="color: transparent !important"></td>
                     	    <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>
                            <td style ="color: transparent !important"></td>

                     	</tr>
                     	
                     	<tr>
                     	   <td>Kls. Solicitados</td>
                     	    <td><?= number_format($kilos_solicitados_sur,2)?></td>
                     	    <td><?= number_format($total_am_sur / $kilos_solicitados_sur,2)?></td>
                            <td><?= number_format($kilos_solicitados_tres_pasos,2)?></td>
                            <td><?= number_format($total_am_tres_pasos / $kilos_solicitados_tres_pasos,2)?></td>
                            <td><?= number_format($kilos_solicitados_pampa ,2)?></td>
                            <td><?= number_format($total_am_pampa / $kilos_solicitados_pampa ,2)?></td>
                            <td><?= number_format($kilos_solicitados_radial,2)?></td>
                            <td><?= number_format($total_am_radial / $kilos_solicitados_radial,2)?></td>
                            <td><?= number_format($kilos_solicitados_qd_villa,2)?></td>
                            <td><?= number_format( $total_am_qd_villa / $kilos_solicitados_qd_villa,2)?></td>
                            <td><?= number_format($kilos_solicitados_bajio,2)?></td>
                            <td><?= number_format($total_am_bajio / $kilos_solicitados_bajio,2)?></td>
                            <td><?= number_format($kilos_solicitados_arenal, 2)?></td>
                            <td><?= number_format($total_am_arenal /  $kilos_solicitados_arenal, 2)?></td>
                            <td><?= number_format($kilos_solicitados_plan,2)?></td>
                            <td><?= number_format($total_am_pla /  $kilos_solicitados_plan,2)?></td>
                            <td><?= number_format($kilos_solicitados_villa,2)?></td>
                            <td><?= number_format( $total_am_villa / $kilos_solicitados_villa,2)?></td>
                            <td><?= number_format($kilos_solicitados_cine, 2)?></td>
                            <td><?= number_format($total_am_cine / $kilos_solicitados_cine, 2)?></td>
                            <td><?= number_format($kilos_solicitados_boulevar,2)?></td>
                            <td><?= number_format($total_am_boulevar / $kilos_solicitados_boulevar,2)?></td>
                            <td><?= number_format($kilos_solicitados_mutu,2)?></td>
                            <td><?= number_format($total_am_mutu / $kilos_solicitados_mutu,2)?></td>
                          
                            
                     	</tr>
                     	<tr>
                     	   <td>Kls. Enviados</td>
                     	    <td><?= number_format($kilos_enviados_sur,2)?></td>
                     	    <td><?= number_format($total_am_sur / $kilos_enviados_sur,2)?></td>
                            <td><?= number_format($kilos_enviados_tres_pasos,2)?></td>
                            <td><?= number_format($total_am_tres_pasos / $kilos_enviados_tres_pasos,2)?></td>
                            <td><?= number_format($kilos_enviados_pampa,2)?></td>
                            <td><?= number_format($total_am_pampa / $kilos_enviados_pampa,2)?></td>
                            <td><?= number_format( $kilos_enviados_radial,2)?></td>
                            <td><?= number_format( $total_am_radial / $kilos_enviados_radial,2)?></td>
                            <td><?= number_format( $kilos_enviados_qd_villa,2)?></td>
                            <td><?= number_format( $total_am_qd_villa / $kilos_enviados_qd_villa,2)?></td>
                            <td><?= number_format( $kilos_enviados_bajio,2)?></td>
                            <td><?= number_format( $total_am_bajio / $kilos_enviados_bajio,2)?></td>
                            <td><?= number_format( $kilos_enviados_arenal,2)?></td>
                            <td><?= number_format( $total_am_arenal / $kilos_enviados_arenal,2)?></td>
                            <td><?= number_format( $kilos_enviados_plan,2)?></td>
                            <td><?= number_format( $total_am_plan / $kilos_enviados_plan,2)?></td>
                            <td><?= number_format( $kilos_enviados_villa,2)?></td>
                            <td><?= number_format( $total_am_villa / $kilos_enviados_villa,2)?></td>
                            <td><?= number_format( $kilos_enviados_cine,2)?></td>
                            <td><?= number_format( $total_am_cine / $kilos_enviados_cine,2)?></td>
                            <td><?= number_format( $kilos_enviados_boulevar,2)?></td>
                            <td><?= number_format( $total_am_boulevar / $kilos_enviados_boulevar,2)?></td>
                            <td><?= number_format( $kilos_enviados_mutu,2)?></td>
                            <td><?= number_format( $total_am_mutu / $kilos_enviados_mutu,2)?></td>
                           

                     	</tr>
                     	<tr>
                     	    <td>%. Cumplientos</td>
                     	    <td><?= round($kilos_enviados_sur/ $kilos_solicitados_sur *100)?></td>
                     	    <td>%</td>
                            <td><?= round($kilos_enviados_tres_pasos/ $kilos_solicitados_tres_pasos *100)?></td>
                            <td>%</td>
                            <td><?= round($kilos_enviados_pampa /  $kilos_solicitados_pampa *100) ?></td>
                            <td>%</td>
                            <td><?= round($kilos_enviados_radial / $kilos_solicitados_radial *100)?></td>
                            <td>%</td>
                            <td><?= round($kilos_enviados_qd_villa/ $kilos_solicitados_qd_villa *100)?></td>
                            <td>%</td>
                            <td><?= round($kilos_enviados_bajio/ $kilos_solicitados_bajio *100)?></td>
                            <td>%</td>
                            <td><?= round($kilos_enviados_arenal / $kilos_solicitados_arenal *100)?></td>
                            <td>%</td>
                            <td><?= round($kilos_enviados_plan/ $kilos_solicitados_plan *100)?></td>
                            <td>%</td>
                            <td><?= round($kilos_enviados_villa / $kilos_solicitados_villa *100)?></td>
                            <td>%</td>
                            <td><?= round($kilos_enviados_cine / $kilos_solicitados_cine *100)?></td>
                            <td>%</td>
                            <td><?= round($kilos_enviados_boulevar / $kilos_solicitados_boulevar*100)?></td>
                            <td>%</td>
                            <td><?= round($kilos_enviados_mutu / $kilos_solicitados_mutu *100)?></td>
                            <td>%</td>
                          

                     	</tr>
                         
                     </tbody>
                </table>
                <br>
                
                <table border="1" id="tblpm">
                     <thead>
                        <tr>
                           <th>Sucur.</th>
                           <th colspan="2">Sur</th>
                           <th colspan="2">Tres. P</th>
                           <th colspan="2">Pampa</th>
                           <th colspan="2">Rd. 26</th>
                           <th colspan="2">QD Villa</th>
                           <th colspan="2">Bajio</th>
                           <th colspan="2">Arenal</th>
                           <th colspan="2">Plan</th>
                           <th colspan="2">Villa</th>
                           <th colspan="2">C. C.</th>
                           <th colspan="2">Bou.</th>
                           <th colspan="2">Mutu.</th>
                          
                        </tr>
                     	<tr>
                     	    <th>Datos</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	    <th>Bs.</th>
                     	    <th>%</th>
                     	     <th>Bs.</th>
                     	    <th>%</th>
                     	   

                     	</tr>
                     </thead>
                     <tbody>
                     	<tr>
                     	    <td>Venta pm</td>
                     	    <td><?= number_format($total_pm_sur, 2) ?></td>
                     	    <td></td>
                            <td><?= number_format($total_pm_tres_pasos,2) ?></td>
                            <td></td>
                            <td><?= number_format($total_pm_pampa, 2) ?></td>
                            <td></td>
                            <td><?= number_format($total_pm_radial,2)?></td>
                            <td></td>
                            <td><?= number_format($total_pm_qd_villa,2) ?></td>
                            <td></td>
                            <td><?= number_format($total_pm_bajio,2)?></td>
                            <td></td>
                            <td><?= number_format($total_pm_arenal,2)?></td>
                            <td></td>
                            <td><?= number_format($total_pm_plan,2)?></td>
                            <td></td>
                            <td><?= number_format($total_pm_villa,2)?></td>
                            <td></td>
                            <td><?= number_format($total_pm_cine,2) ?></td>
                            <td></td>
                            <td><?= number_format($total_pm_boulevar,2)?></td>
                            <td></td>
                             <td><?= number_format($total_pm_mutu,2)?></td>
                            <td></td>
                            


                     	</tr>
                     	<tr>
                     	   <td>Producc. Enviada</td>
                     	    <td>00</td>
                     	    <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                             <td>00</td>
                            <td>%</td>
                            
                     	</tr>
                     	<tr>
                     	    <td>Parte Produc.</td>
                     	    <td>00</td>
                     	    <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                           

                     	</tr>
                     	<tr>
                     	    <td>Eliminación</td>
                     	    <td>00</td>
                     	    <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                             <td>00</td>
                            <td>%</td>
                           

                     	</tr>
                     	<tr>
                     	   <td>Comid. Autorizada</td>
                     	    <td><?= number_format($comidapersonal_pm_sur,2) ?></td>
                     	    <td><?= number_format( $total_pm_sur / $comidapersonal_pm_sur,2) ?></td>
                            <td><?= number_format($comidapersonal_pm_tres_pasos,2)?></td>
                            <td><?= number_format( $total_pm_tres_pasos / $comidapersonal_pm_tres_pasos,2) ?></td>
                            <td><?= number_format($comidapersonal_pm_pampa,2)?></td>
                            <td><?= number_format( $total_pm_pampa / $comidapersonal_pm_pampa,2) ?></td>
                            <td><?= number_format($comidapersonal_pm_radial,2)?></td>
                            <td><?= number_format( $total_pm_radial / $comidapersonal_pm_radial,2) ?></td>
                            <td><?= number_format($comidapersonal_pm_qd_villa,2)?></td>
                            <td><?= number_format( $total_pm_qd_villa / $comidapersonal_pm_qd_villa,2) ?></td>
                            <td><?= number_format($comidapersonal_pm_bajio ,2)?></td>
                            <td><?= number_format( $total_pm_bajio / $comidapersonal_pm_bajio,2) ?></td>
                            <td><?= number_format($comidapersonal_pm_arenal,2)?></td>
                            <td><?= number_format( $total_pm_arenal / $comidapersonal_pm_arenal,2) ?></td>
                            <td><?= number_format($comidapersonal_pm_plan,2)?></td>
                            <td><?= number_format( $total_pm_plan / $comidapersonal_pm_plan,2) ?></td>
                            <td><?= number_format($comidapersonal_pm_villa,2)?></td>
                            <td><?= number_format( $total_pm_villa / $comidapersonal_pm_villa,2) ?></td>
                            <td><?= number_format($comidapersonal_pm_cine,2)?></td>
                            <td><?= number_format( $total_pm_cine / $comidapersonal_pm_cine,2) ?></td>
                            <td><?= number_format($comidapersonal_pm_boulevar,2)?></td>
                            <td><?= number_format( $total_pm_boulevar / $comidapersonal_pm_boulevar,2) ?></td>
                            <td><?= number_format($comidapersonal_pm_mutu,2)?></td>
                            <td><?= number_format( $total_pm_mutu / $comidapersonal_pm_mutu,2) ?></td>
                            

                     	</tr>
                     	
                     	
                     	<tr>
                     	    <td>Ajs. de Inven.</td>
                     	    <td>00</td>
                     	    <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            

                     	</tr>
                     	<tr>
                     	   <td>Inven.</td>
                     	    <td><?= number_format($inventario_pm_sur, 2)?></td>
                     	    <td><?= number_format( $total_pm_sur / $inventario_pm_sur, 2)?></td>
                            <td><?= number_format($inventario_pm_tres_pasos,2)?></td>
                            <td><?= number_format( $total_pm_tres_pasos / $inventario_pm_tres_pasos, 2)?></td>
                            <td><?= number_format($inventario_pm_pampa,2)?></td>
                            <td><?= number_format( $total_pm_pampa / $inventario_pm_pampa, 2)?></td>
                            <td><?= number_format($inventario_pm_radial,2)?></td>
                            <td><?= number_format( $total_pm_radial / $inventario_pm_radial, 2)?></td>
                            <td><?= number_format($inventario_pm_qd_villa,2)?></td>
                            <td><?= number_format( $total_pm_qd_villa / $inventario_pm_qd_villa, 2)?></td>
                            <td><?= number_format($inventario_pm_bajio,2)?></td>
                            <td><?= number_format( $total_pm_bajio / $inventario_pm_bajio, 2)?></td>
                            <td><?= number_format($inventario_pm_arenal,2)?></td>
                            <td><?= number_format( $total_pm_arenal / $inventario_pm_arenal, 2)?></td>
                            <td><?= number_format($inventario_pm_plan,2)?></td>
                            <td><?= number_format( $total_pm_plan / $inventario_pm_plan, 2)?></td>
                            <td><?= number_format($inventario_pm_villa,2)?></td>
                            <td><?= number_format( $total_pm_villa / $inventario_pm_villa, 2)?></td>
                            <td><?= number_format($inventario_pm_cine,2)?></td>
                            <td><?= number_format( $total_pm_cine / $inventario_pm_cine, 2)?></td>
                            <td><?= number_format($inventario_pm_boulevar,2)?></td>
                            <td><?= number_format( $total_pm_boulevar / $inventario_pm_boulevar, 2)?></td>
                            <td><?= number_format($inventario_pm_mutu,2)?></td>
                            <td><?= number_format( $total_pm_mutu / $inventario_pm_mutu, 2)?></td>
                           

                     	</tr>
                     	<tr>
                     	    <td>Cost. Comida</td>
                     	    <td>00</td>
                     	    <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                           

                     	</tr>
                     	<tr>
                     	    <td>Cost. Bebida</td>
                     	    <td>00</td>
                     	    <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            

                     	</tr>
                     	<tr>
                     	   <td>Cost. Refresco</td>
                     	    <td>00</td>
                     	    <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                          

                     	</tr>
                     	<tr>
                     	   <td>Cost. total Insumos</td>
                     	    <td>00</td>
                     	    <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            <td>00</td>
                            <td>%</td>
                            

                     	</tr>
                     	
                     	             
                     </tbody>
                </table>
                
            </div>
        </div>
    </div>
    <script>
        function exceller() {
            var uri = 'data:application/vnd.ms-Excel;base64,',
                template = '<html xmlns:o="urn:schemas-Microsoft-com:office:office" xmlns:x="urn:schemas-Microsoft-com:office:Excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
                base64 = function(s) {
                    return window.btoa(unescape(encodeURIComponent(s)))
                },
                format = function(s, c) {
                    return s.replace(/{(\w+)}/g, function(m, p) {
                        return c[p];
                    })
                }
            var tblam = document.getElementById("tblam").innerHTML;
            var tblpm = document.getElementById("tblpm").innerHTML;
            var ctx = {
                worksheet: name || '',
                table: tblam + tblpm
            };
            var link = document.createElement("a");
            link.download = "ventas.xls";
            link.href = uri + base64(format(template, ctx))
            link.click();
        }
    </script>
</body>

</html>