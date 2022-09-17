<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="#" />
    <title>Reporte general de consumo electrico</title>

    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css" />
    <!--datables estilo bootstrap 4 CSS-->
    <link rel="stylesheet" type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">

    <!--font awesome con CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

</head>

<body class="body">
    <?php
    
    
    include "../menu/menu.php";
    include 'conexion.php';
  
    $totalconsumo = 0;
    if (isset($_POST['fechaini']) && isset($_POST['horaini']) && isset($_POST['fechamax']) && isset($_POST['horamax'])) {
        $fecha_min = $_POST["fechaini"];
        $hora_min  = $_POST["horaini"];
        $fecha_max = $_POST["fechamax"];
        $hora_max  = $_POST["horamax"];
        
        $consulta = "select sum(t.consumo) as totalsuma, avg(t.consumo) as promedio, fecha, hora, s.nombre as sucursal
        from consumoelectrico t inner join sucursal s on t.sucursal_id = s.idsucursal
        where t.fecha BETWEEN  '$fecha_min' and '$fecha_max' and hora BETWEEN '$hora_min' and '$hora_max'
        GROUP by s.nombre;
";

   
        $datosglobales = "select sum(t.consumo) as consumototal, sum(t.consumo*1.66)  as totalgasto,
        sum(t.consumo/24) as costohora
                from consumoelectrico t inner join sucursal s on t.sucursal_id = s.idsucursal
                where t.fecha BETWEEN  '$fecha_min' and '$fecha_max ' and hora BETWEEN '$hora_min' and '$hora_max';";


    } else {
        $fecha_min = date('d-m-Y');
        $hora_min  = time();
        $fecha_max = date('d-m-Y');
        $hora_max  = time();

        $consulta = "select sum(t.consumo) as totalsuma, avg(t.consumo) as promedio, fecha, hora, s.nombre as sucursal
        from consumoelectrico t inner join sucursal s on t.sucursal_id = s.idsucursal
        where t.fecha BETWEEN  '$fecha_min' and '$fecha_max' and hora BETWEEN '$hora_min' and '$hora_max'
        GROUP by s.nombre;
";

        $datosglobales = "select sum(t.consumo) as consumototal, sum(t.consumo*1.66)  as totalgasto,
        sum(t.consumo/24) as costohora
                from consumoelectrico t inner join sucursal s on t.sucursal_id = s.idsucursal
                where t.fecha BETWEEN  '$fecha_min' and '$fecha_max ' and hora BETWEEN '$hora_min' and '$hora_max';";

    }
    

    $genergia = mysqli_query($db, $consulta);
    $datosgenrales = mysqli_query($db, $datosglobales);
 
  

    $resultado = array();
    if ($genergia && mysqli_num_rows($genergia) >= 1) {
        $resultado = $genergia;
    }
    

    

    ?>

    <div class="container">
        <div class="left-sidebar">
            <h2>Reporte general de consumo eléctrico</h2>

            <div class="table-responsive">
                <form action="reporte.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                                <input type="date" id="fechaini" class="input-sm form-control" name="fechaini" required />
                                <input id="appt-time" type="time" id="horaini" class="input-sm form-control" name="horaini" step="2" required/>
                                <span class="input-group-addon">A</span>
                                <input type="date" id="fechamax" class="input-sm form-control" name="fechamax" required />
                                <input id="appt-time" type="time" id="horamax" class="input-sm form-control" name="horamax" step="2" required />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="submit" value="filtrar">
                        </div>
                    </div>
                </form>
                <br>
                <table id="energia" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sucursal</th>    
                            <th>Lecturación</th>
                            <th>Promedio</th>
                            <th>Costo</th>
                                              
                        </tr>
                    </thead>
                    <tbody>

                        <?php 
                        foreach ($resultado as $genergia) {      
                            ?>  
                            <tr class=warning>
                                <td><?= $genergia['sucursal'] ?></td>
                                <td> KW. <?= number_format($genergia['totalsuma'],2) ?></td>
                                <td> KW. <?= number_format($genergia['promedio']) ?></td>
                                <td> Bs. <?= number_format($genergia['totalsuma'] * 1.66,2) ?></td>
                            </tr>
                        <?php } ?>
                    
                    </tbody>
                    </div>
                </table>
                 <br>
               
        </div>
    </div>

    </table>
    
    <?php 
                        foreach ($datosgenrales as $genergia) {     
                            ?>  
                               
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
   <tr>
   <td><h4>Total Lecturación (todas las sucursales) </h4></td><td><h4> <?php echo number_format($genergia['consumototal'],2). " KW"; ?></h4>
   </td></tr>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="100%">
   <tr>
   <td><h4>Gasto total</h4></td> <td><h4><?php echo number_format( $genergia['totalgasto'], 2). " Bs"; ?> </h4>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="100%">
   <tr>
   <td><h4>Costo energia</h4></td> <td><h4> 1.66 kWH</h4>
   </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="2" width="100%">
   <tr>
   <td><h4>Costo por hora</h4></td> <td><h4> <?php echo number_format($genergia['costohora'], 2). " Bs"; ?> </h4>
   </td></tr>
    </table>
   <?php } ?>
    </div>
</body>

<!-- jQuery, Popper.js, Bootstrap JS -->
<script src="jquery/jquery-3.3.1.min.js"></script>
<script src="popper/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- datatables JS -->
<script type="text/javascript" src="datatables/datatables.min.js"></script>

<!-- para usar botones en datatables JS -->
<script src="datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>

<!-- código JS propìo-->
<script type="text/javascript" src="main.js"></script>

</html>