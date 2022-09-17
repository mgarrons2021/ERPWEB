<html>

<head>
    <title>Listado de Ventas promedio/mes</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="../js/jquery.js"></script>
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
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
            <h2>listado de Ventas por Fechas de la Sucursal: <?= $sucursal_name ?> </h2>
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
               
                <form action="rv_promedio_mes.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Sucursal:</label>
                            <div class="input-group">
                                <select name="sucursal" id="sucursal">
                                    <?php foreach ($resultado_sucursal as $sucursal) { ?>
                                        <option value="<?= $sucursal['idsucursal'] ?>"> <?= $sucursal['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div> <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                                <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" value="<?php if (isset($_POST['fechaini'])) {
                                                                                                                            echo $_POST['fechaini'];
                                                                                                                        } ?>" />
                                <span class="input-group-addon">A</span>
                                <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" value="<?php if (isset($_POST['fechamax'])) {
                                                                                                                            echo $_POST['fechamax'];
                                                                                                                        } ?>" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
                        </div>
                    </div>
                </form>
                <br>
                <button onclick="exceller();"  class="btn btn-success" id="export">Export</button><br>

                <?php

                if (isset($_POST['fechaini']) && isset($_POST['fechamax']) && isset($_POST['sucursal'])) {
                    $fechaInicio = $_POST['fechaini'];
                    $fechaFin    = $_POST['fechamax'];
                    $sucur       = $_POST['sucursal'];
           		
           		if($sucur == "20"){
           		   	$sucursal_name = $db->GetOne("SELECT nombre FROM sucursal WHERE idsucursal = '$sucur'");
           		   	$fecha = $db->GetAll("SELECT fecha FROM venta WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha");
                    	   	$dias =  $db->GetOne("SELECT TIMESTAMPDIFF(DAY, '$fechaInicio', '$fechaFin')"); //Sacar la cantidad de dias que pasan del rango de fecha para calcular el %
                    	   	$dias_max = $dias + 1;
           		   
           		   	$sql_am = $db->GetAll("SELECT sum(total) AS total, fecha, count(nro) as tt FROM venta WHERE pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'  AND turno = 1 AND estado = 'V' GROUP BY fecha");
                    	  	$sql_am_total             = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND turno = 1 AND estado = 'V'");
                    	   	$sql_pm_total             = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND turno = 2 AND estado = 'V'");
                    	   	$sql_ampm_total           = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND estado = 'V'");
                    
                    	   	$total_am_tt              = $db->GetOne("SELECT COUNT(nro) FROM venta where pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND estado = 'V' AND turno = 1");
                    	   	$total_pm_tt              = $db->GetOne("SELECT COUNT(nro) FROM venta where pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND estado = 'V' AND turno = 2");
                    	   	$total_tt                 = $db->GetOne("SELECT COUNT(nro) FROM venta where pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND estado = 'V'");
                       
                    	   	//Total de tt en el rango requerido
                    	   	$sql_total_rango_am_tt = $db->GetOne("SELECT COUNT(nro) as tt FROM venta WHERE  estado = 'V' and fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND pago != 'comida_personal' AND turno = 1");

                    	   	$sql_total_rango_am = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE  estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' AND turno = 1");
                    
                    	   	//$sql_total_rango_tt = 12;
                    	   	$dato_am = ($sql_total_rango_am / $dias_max);
                    	   	$tt_am   = ($sql_total_rango_am_tt / $dias_max);
                    	   	$operacion_am = ($dato_am / $tt_am);
                    	   	$d_am    = number_format($operacion_am, 2); 
                    
                    
                    	   	$sql_pm          = $db->GetAll("SELECT sum(total) AS total, fecha, count(nro) as tt FROM venta WHERE pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND turno = 2 AND estado = 'V' GROUP BY fecha");
                    	   	$sql_total_rango_pm = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE  estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' AND turno = 2");
                    	   	$sql_total_rango    = $db->GetAll("SELECT sum(total) AS total, count(nro) as tt FROM venta WHERE  estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' GROUP BY fecha");
                    	   	$sql_total_rango_pro    = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE  estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal'");
		    	   	$sql_total_rango_pm_tt = $db->GetOne("SELECT COUNT(nro) as tt FROM venta WHERE  estado = 'V' and fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND pago != 'comida_personal' AND turno = 2");
		    
		    	   	//$sql_total_rango_tt = 12;
                    	   	$dato_pm = ($sql_total_rango_pm / $dias_max);
                    	   	$tt_pm   = ($sql_total_rango_pm_tt / $dias_max);
                    	   	$operacion_pm = ($dato_pm / $tt_pm);
                    	   	$d_pm    = number_format($operacion_pm, 2); 
		    
		    	   	$sql_total_rango_tt = $db->GetOne("SELECT COUNT(nro) as tt FROM venta WHERE  estado = 'V' and fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND pago != 'comida_personal'");
		    
		    	   	$dato_g = ($sql_total_rango_pro / $dias_max);
                    	   	$tt_g   = ($sql_total_rango_tt / $dias_max);
                    	   	$operacion_g = ($dato_g / $tt_g);
                    	   	$d_g    = number_format($operacion_g, 2);
           			
           		}else{
           			$sucursal_name = $db->GetOne("SELECT nombre FROM sucursal WHERE idsucursal = '$sucur'");

                    		$fecha = $db->GetAll("SELECT fecha FROM venta WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha");
                    		$dias =  $db->GetOne("SELECT TIMESTAMPDIFF(DAY, '$fechaInicio', '$fechaFin')"); //Sacar la cantidad de dias que pasan del rango de fecha para calcular el %
                    		$dias_max = $dias + 1;

                    		$sql_am  = $db->GetAll("SELECT sum(total) AS total, fecha, count(nro) as tt FROM venta WHERE pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND sucursal_id = '$sucur'  AND turno = 1 AND estado = 'V' GROUP BY fecha");
                    		$sql_am_total             = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND sucursal_id = '$sucur'  AND turno = 1 AND estado = 'V'");
                    		$sql_pm_total             = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND sucursal_id = '$sucur'  AND turno = 2 AND estado = 'V'");
                    		$sql_ampm_total           = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND sucursal_id = '$sucur'  AND estado = 'V'");
                    
                    		$total_am_tt              = $db->GetOne("SELECT COUNT(nro) FROM venta where pago != 'comida_personal' AND sucursal_id = '$sucur' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND estado = 'V' AND turno = 1");
                    		$total_pm_tt              = $db->GetOne("SELECT COUNT(nro) FROM venta where pago != 'comida_personal' AND sucursal_id = '$sucur' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND estado = 'V' AND turno = 2");
                    		$total_tt                 = $db->GetOne("SELECT COUNT(nro) FROM venta where pago != 'comida_personal' AND sucursal_id = '$sucur' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND estado = 'V'");
                       
                    		//Total de tt en el rango requerido
                    		$sql_total_rango_am_tt = $db->GetOne("SELECT COUNT(nro) as tt FROM venta WHERE sucursal_id = '$sucur' AND estado = 'V' and fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND pago != 'comida_personal' AND turno = 1");

                    		$sql_total_rango_am = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE sucursal_id = '$sucur' AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' AND turno = 1");
                    
                    		//$sql_total_rango_tt = 12;
                    		$dato_am = ($sql_total_rango_am / $dias_max);
                    		$tt_am   = ($sql_total_rango_am_tt / $dias_max);
                    		$operacion_am = ($dato_am / $tt_am);
                    		$d_am    = number_format($operacion_am, 2); 
                    
                    
                    		$sql_pm  = $db->GetAll("SELECT sum(total) AS total, fecha, count(nro) as tt FROM venta WHERE pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND sucursal_id = '$sucur'  AND turno = 2 AND estado = 'V' GROUP BY fecha");
                    		$sql_total_rango_pm = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE sucursal_id = '$sucur' AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' AND turno = 2");
                    		$sql_total_rango    = $db->GetAll("SELECT sum(total) AS total, count(nro) as tt FROM venta WHERE sucursal_id = '$sucur' AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' GROUP BY fecha");
                    		$sql_total_rango_pro    = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE sucursal_id = '$sucur' AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal'");
		    		$sql_total_rango_pm_tt = $db->GetOne("SELECT COUNT(nro) as tt FROM venta WHERE sucursal_id = '$sucur' AND estado = 'V' and fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND pago != 'comida_personal' AND turno = 2");
		    
		    		//$sql_total_rango_tt = 12;
                    		$dato_pm = ($sql_total_rango_pm / $dias_max);
                    		$tt_pm   = ($sql_total_rango_pm_tt / $dias_max);
                    		$operacion_pm = ($dato_pm / $tt_pm);
                    		$d_pm    = number_format($operacion_pm, 2); 
		    
		    		$sql_total_rango_tt = $db->GetOne("SELECT COUNT(nro) as tt FROM venta WHERE sucursal_id = '$sucur' AND estado = 'V' and fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND pago != 'comida_personal'");
		    
		    		$dato_g = ($sql_total_rango_pro / $dias_max);
                    		$tt_g   = ($sql_total_rango_tt / $dias_max);
                    		$operacion_g = ($dato_g / $tt_g);
                    		$d_g    = number_format($operacion_g, 2); 
           		}     
                
                } else {
                    $sucur = 0;
                    $fechaInicio = date('Y-m-d');
                    $fechaFin    = date('Y-m-d');
                    $fecha = $db->GetAll("SELECT fecha FROM venta WHERE  fecha BETWEEN '$fechaInicio' AND '$fechaFin'  GROUP BY fecha");
                    $dias =  $db->GetOne("SELECT TIMESTAMPDIFF(DAY, '$fechaInicio', '$fechaFin')");
                    $dias_max = $dias + 1;

                    $sql_am             = $db->GetAll("SELECT sum(total) AS total, fecha, count(nro) as tt FROM venta WHERE pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND sucursal_id = '$sucur'  AND turno = 1 AND estado = 'V' GROUP BY fecha");
                     
                    
                    $sql_am_total       = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND sucursal_id = '$sucur'  AND turno = 1 AND estado = 'V'");
                    $sql_total_rango_am = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE sucursal_id = '$sucur' AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' AND turno = 1");
                    
                    
                    
                    
                    $sql_pm             = $db->GetAll("SELECT sum(total) AS total, fecha FROM venta WHERE pago != 'comida_personal' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND sucursal_id = '$sucur'  AND turno = 2 AND estado = 'V' GROUP BY fecha");
                    $sql_total_rango_pm = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE sucursal_id = '$sucur' AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' AND turno = 2");
                    $sql_total_rango    = $db->GetAll("SELECT sum(total) AS total, count(nro) as tt FROM venta WHERE sucursal_id = '$sucur' AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal' GROUP BY fecha");
                   
                   
                    $sql_total_rango_pro    = $db->GetOne("SELECT sum(total) AS total FROM venta WHERE sucursal_id = '$sucur' AND estado = 'V' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin ' AND pago != 'comida_personal'");
                    
                  
                }

                ?>
                <div id="primertabla">
                <table border="1" style="float: left;" width="30%" id="tblventas">
                    <thead style="background-color: #F6D092;">
                        <tr>
                            <th>FECHA</th>
                            <th>AM</th>
                            <th>T.T.</th>
                            <th>T.P.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sql_am as $dato) { ?>
                            <tr>
                                <td style="text-align: center;"><?= date('d', strtotime($dato['fecha'])) ?></td>
                                <td style="text-align: center;"><?= number_format($dato['total'], 2, ',', '.'); ?></td>
                                <td style="text-align: center;"><?= $dato['tt'] ?></td>
                                <td style="text-align: center;"><?= number_format(($dato['total'] / $dato['tt']), 2) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot style="background-color: #F6D092 ;">
                    	<tr>
                            <td style="text-align: center;">Suma</td>
                            <td style="text-align: center;"><?=  number_format(($sql_am_total), 2, ',', '.') ?></td>
                            <td style="text-align: center;"><?= number_format( $total_am_tt ,2)  ?></td>
                            <td style="text-align: center;"><?= $d_am?></td>
                    	</tr>
                        <tr>
                            <td style="text-align: center;">Promedio</td>
                            <td style="text-align: center;"><?=  number_format(($sql_total_rango_am / $dias_max), 2, ',', '.') ?></td>
                             <td style="text-align: center;"><?= number_format(($sql_total_rango_am_tt / $dias_max),2)  ?></td>
                             <td style="text-align: center;"><?= $d_am?></td>
                        </tr>
                    </tfoot>
                </table>
                </div>
                
                <div id="segundatabla">
                <table border="1" style="float: left;" width="30%" id="tblpm">
                    <thead style="background-color: #F6D092  ;">
                        <tr>
                            <th>PM</th>
                       	    <th>T.T.</th>
                       	    <th>T.P.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sql_pm as $dato) { ?>
                            <tr>
                                <td style="text-align: center;"><?=  number_format($dato['total'], 2, ',', '.'); ?></td>
                                 <td style="text-align: center;"><?= $dato['tt']; ?></td>
                                 <td style="text-align: center;"><?= number_format(($dato['total'] / $dato['tt']), 2) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot style="background-color: #F6D092  ;">
                        <tr>
                            <td style="text-align: center;"><?= number_format($sql_pm_total , 2, ',', '.') ?></td>
                            <td style="text-align: center;"><?= number_format($total_pm_tt,2)  ?></td>
                            <td style="text-align: center;"><?= $d_pm?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><?= number_format(($sql_total_rango_pm / $dias_max), 2, ',', '.') ?></td>
                            <td style="text-align: center;"><?= number_format(($sql_total_rango_pm_tt / $dias_max),2)  ?></td>
                            <td style="text-align: center;"><?= $d_pm?></td>
                        </tr>
                    </tfoot>
                </table>
                </div>
                
                <div id="tercertabla"></div>
                <table border="1" width="30%" id="tbtotal">
                    <thead style="background-color: #F6D092;">
                        <tr>
                            <th>TOTAL</th>
                            <th>T.T.</th>
                            <th>T.P</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sql_total_rango as $dato) { ?>
                            <tr>
                                <td style="text-align: center; background-color: #B7E8DF;"><?= number_format($dato['total'], 2, ',', '.'); ?></td>
                                <td style="text-align: center; background-color: #B7E8DF;"><?= $dato['tt']; ?></td>
                                <td style="text-align: center; background-color: #B7E8DF;"><?= number_format(($dato['total'] / $dato['tt']), 2) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot style="background-color: #F6D092;">
                        <tr>
                        
                            <td style="text-align: center;"><?=  number_format($sql_ampm_total, 2, ',', '.');  ?></td>
                            <td style="text-align: center;"><?=  number_format($total_tt, 2);  ?></td>
                            <td style="text-align: center;"><?= $d_g?></td>
                        </tr>
                        <tr>
                        
                            <td style="text-align: center;"><?=  number_format(($sql_total_rango_pro/$dias_max), 2, ',', '.');  ?></td>
                            <td style="text-align: center;"><?=  number_format(($sql_total_rango_tt/$dias_max), 2);  ?></td>
                            <td style="text-align: center;"><?= $d_g?></td>
                        </tr>
                    </tfoot>
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
            var toExcel = document.getElementById("tblventas").innerHTML;
            var tblpm   = document.getElementById("tblpm").innerHTML;
            var tbtotal = document.getElementById("tbtotal").innerHTML;
            var ctx = {
                worksheet: name || '',
                table: [toExcel +  tblpm + tbtotal]
            };
            var link = document.createElement("a");
            link.download = "ventas.xls";
            link.href = uri + base64(format(template, ctx))
            link.click();
        }
    </script>
    
</script>
</body>

</html>