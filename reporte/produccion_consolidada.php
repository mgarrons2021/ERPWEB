<html>

<head>
  <title>Produccion Consolidado</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
</head>

<body class="body">
  <?php include "../menu/menu.php";
  date_default_timezone_set('America/La_Paz');
  $usuario = $_SESSION['usuario'];
  $ss = implode(" ", $_SESSION['usuario']);
  /* print $ss; */
  $sucur = $usuario['sucursal_id'];

  $sucursal = $db->GetAll("
select * 
from sucursal 
where idsucursal between '2' and '16' ");


  ?>
  <?php
  if(isset($_POST["sucursal_id"])){
    if (isset($_POST["fechainicial"]) && isset($_POST["fechafinal"])) {
      $fecha_inicial = $_POST["fechainicial"];
      $fecha_fin = $_POST["fechafinal"];
      $fecha_inicial_parse = new DateTime($_POST["fechainicial"]);
      $fecha_fin_parse = new DateTime($_POST["fechafinal"]);
      $sucursal_id = $_POST["sucursal_id"];
      $sucursal_name = $db->GetOne("SELECT s.nombre FROM sucursal s WHERE s.idsucursal=$sucursal_id ");
      $diff = $fecha_fin_parse->diff($fecha_inicial_parse)->format('%d');
    } else {
      $fecha_inicial = date("Y-m-d", strtotime(date("Y-m-d") . "- 1 days"));
      $fecha_fin = date("Y-m-d", strtotime(date("Y-m-d") . "- 1 days"));
      /* $sucursal_name = $db->GetOne("SELECT s.nombre FROM sucursal s WHERE s.idsucursal=$sucursal_id "); */
      $sucursal_id = 2;
      $sucursal_name = $db->GetOne("SELECT s.nombre FROM sucursal s WHERE s.idsucursal=$sucursal_id ");
      $diff = 0;
    }
  }
  


  ?>

  <div class="container">
    <div class="left-sidebar">
      <h2>Reporte Produccion Consolidada por Fecha</h2>
      <h2> 
      <?php 
      if($sucursal_id==20){
        echo "TODA LA EMPRESA";
      }else{
        echo $sucursal_name ;
      }  
      ?> 
      </h2>

      <div class="table-responsive">

        <form method="post" action="">
          <div class="row">
            <div class="col-md-3">
              <div class="input-group">
                <label>Filtrar por Sucursal:</label>
                <select name="sucursal_id" id="sucursal_id" class="form-control">
                  <option value="">Seleccione una Sucursal</option>
                  <?php foreach ($sucursal as $r) { ?>
                    <option value="<?php echo $r["idsucursal"] ?>"><?php echo $r["nombre"]; ?></option>
                  <?php } ?>
                  <option value="20">TODA LA EMPRESA</option>
                </select>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-6">
              <div class="input-daterange input-group" id="datepicker">
                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                <input type="text" id="fechainicial" class="input-sm form-control" name="fechainicial" />
                <span class="input-group-addon">A</span>
                <input type="text" id="fechafinal" class="input-sm form-control" name="fechafinal" />
                <input type="hidden" id="form_sent" name="form_sent" value="true">
              </div>
            </div>
            <div class="col-md-2">
              <input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
            </div>
          </div>
        </form>
        <br>
        <table class="table table-striped table-hover table-bordered" width="100%">
          <thead style="background-color: #FFCC79;">
            <tr>
              <th style="text-align: center;background-color: #F1A323;">Totales</th>
              <?php
              for ($i = 0; $i <= $diff; $i++) {
                $fecha_actual = date("Y-m-d",  strtotime(date($fecha_inicial) . '+' . $i . ' days'));
                echo '<th style="text-align: center;background-color: #F1A323;">' . $fecha_actual . '</th>';
              }
              ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="text-align: center;" style="width: 10px;">Solicitado</td>
              <?php
              for ($is = 0; $is <= $diff; $is++) {
                $fecha_actual_solicitado = date("Y-m-d",  strtotime(date($fecha_inicial) . '+' . $is . ' days'));
                if($sucursal_id==20){
                  $querySolicitado = $db->GetAll("select SUM(d.cantidad) as CantidadSolicitada, pr.nombre 
                                          from detallepedido d 
                                          inner JOIN pedido p on p.nro = d.nro
                                          inner JOIN producto pr on pr.idproducto = d.producto_id
                                          INNER JOIN sucursal s on s.idsucursal = d.sucursal_id
                                          WHERE p.Fecha_p = '$fecha_actual_solicitado' 
                                          and d.sucursal_id =p.sucursal_id  and pr.idcategoria =2 
                                          group by pr.nombre ORDER BY pr.idproducto");
                }else{
                  $querySolicitado = $db->GetAll("select SUM(d.cantidad) as CantidadSolicitada,pr.nombre
                                          from detallepedido d 
                                          inner JOIN pedido p on p.nro = d.nro 
                                          inner JOIN producto pr on pr.idproducto = d.producto_id 
                                          INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
                                          WHERE p.Fecha_p = '$fecha_actual_solicitado' 
                                          and d.sucursal_id =p.sucursal_id and pr.idcategoria =2 
                                          AND s.idsucursal=$sucursal_id 
                                          group by pr.nombre ORDER BY pr.nombre;");
                }

                $totalSolicitado = 0;
                foreach ($querySolicitado as $item) {
                  if ($item["nombre"] == "POLLO AL HORNO") {
                    $totalSolicitado += ($item["CantidadSolicitada"] / 8) * 1.3;
                  } else if ($item["nombre"] == "KEPERI 0.150G") {
                    $totalSolicitado += $item["CantidadSolicitada"] * 0.15;
                  }else if($item["nombre"] == "BROCHETAS DE POLLO"){
                    $totalSolicitado += $item["CantidadSolicitada"] * 0.140;
                  } else {
                    $totalSolicitado += $item["CantidadSolicitada"];
                  }
                }
                echo '<td style="background-color: #D9EDFC; text-align: center;">' . number_format($totalSolicitado,2) ." "."Kg". '</td>';
              }
              ?>

            </tr>
            <tr>
              <td style="text-align: center;" style="width: 10px;">Enviado</td>
              <?php
              for ($is = 0; $is <= $diff; $is++) {
                $fecha_actual_solicitado = date("Y-m-d",  strtotime(date($fecha_inicial) . '+' . $is . ' days'));
                if($sucursal_id==20){
                  $queryEnviada = $db->GetAll("select SUM(d.cantidad_envio) as CantidadEnviada,pr.nombre
                                      from detallepedido d 
                                      inner JOIN pedido p on p.nro = d.nro 
                                      inner JOIN producto pr on pr.idproducto = d.producto_id 
                                      INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
                                      WHERE p.Fecha_p = '$fecha_actual_solicitado' 
                                      and d.sucursal_id =p.sucursal_id and pr.idcategoria =2
                                      group by pr.nombre ORDER BY pr.nombre ;
                                    ");
                }else{
                  $queryEnviada = $db->GetAll("select SUM(d.cantidad_envio) as CantidadEnviada,pr.nombre
                                      from detallepedido d 
                                      inner JOIN pedido p on p.nro = d.nro 
                                      inner JOIN producto pr on pr.idproducto = d.producto_id 
                                      INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
                                      WHERE p.Fecha_p = '$fecha_actual_solicitado' 
                                      and d.sucursal_id =p.sucursal_id and 
                                      pr.idcategoria =2 AND s.idsucursal=$sucursal_id 
                                      group by pr.nombre ORDER BY pr.nombre ;
                                    ");
                }

                $totalEnviado = 0;
                foreach ($queryEnviada as $item) {
                  if ($item["nombre"] == "POLLO AL HORNO") {
                    $totalEnviado += ($item["CantidadEnviada"] / 8) * 1.3;
                  } else if ($item["nombre"] == "KEPERI 0.150G") {
                    $totalEnviado += $item["CantidadEnviada"] * 0.15;
                  }else if($item["nombre"] == "BROCHETAS DE POLLO"){
                    $totalEnviado += $item["CantidadEnviada"] * 0.140;
                  } else {
                    $totalEnviado += $item["CantidadEnviada"];
                  }  
                }
                echo '<td style="background-color: #D9EDFC; text-align: center;">' . number_format($totalEnviado,2) ." "."Kg". '</td>';
              }
              ?>
            </tr>
            <tr>
              <td style="text-align: center;" style="width: 10px;">Diferencia</td>
              <?php
              for ($is = 0; $is <= $diff; $is++) {
                $fecha_actual_solicitado = date("Y-m-d",  strtotime(date($fecha_inicial) . '+' . $is . ' days'));
                if($sucursal_id==20){
                  $queryEnviada = $db->GetAll("select SUM(d.cantidad) as CantidadSolicitada,SUM(d.cantidad_envio) as CantidadEnviada,pr.nombre
                                      from detallepedido d 
                                      inner JOIN pedido p on p.nro = d.nro 
                                      inner JOIN producto pr on pr.idproducto = d.producto_id 
                                      INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
                                      WHERE p.Fecha_p = '$fecha_actual_solicitado' and d.sucursal_id =p.sucursal_id and 
                                      pr.idcategoria =2  
                                      group by pr.nombre ORDER BY pr.nombre ;
                                    ");
                }else{
                  $queryEnviada = $db->GetAll("select SUM(d.cantidad) as CantidadSolicitada,SUM(d.cantidad_envio) as CantidadEnviada,pr.nombre
                                      from detallepedido d 
                                      inner JOIN pedido p on p.nro = d.nro 
                                      inner JOIN producto pr on pr.idproducto = d.producto_id 
                                      INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
                                      WHERE p.Fecha_p = '$fecha_actual_solicitado' and d.sucursal_id =p.sucursal_id and 
                                      pr.idcategoria =2 AND s.idsucursal=$sucursal_id 
                                      group by pr.nombre ORDER BY pr.nombre ;
                                    ");
                }
                


                $totalEnviado1 = 0;
                $totalSolicitado1 = 0;
                foreach ($queryEnviada as $item) {

                  if ($item["nombre"] == "POLLO AL HORNO") {
                    $totalSolicitado1 += ($item["CantidadSolicitada"] / 8) * 1.3;
                    $totalEnviado1 += ($item["CantidadEnviada"] / 8) * 1.3;
                  } else if ($item["nombre"] == "KEPERI 0.150G") {
                    $totalSolicitado1 += $item["CantidadSolicitada"] * 0.15;
                    $totalEnviado1 += $item["CantidadEnviada"] * 0.15;
                  }else if($item["nombre"] == "BROCHETAS DE POLLO"){
                    $totalSolicitado1 += $item["CantidadSolicitada"] * 0.140;
                    $totalEnviado1 += $item["CantidadEnviada"] * 0.140;
                  } else {
                    $totalSolicitado1 += $item["CantidadSolicitada"];
                    $totalEnviado1 += $item["CantidadEnviada"];
                  }
                 
                }

                $totalDiferencia =  $totalEnviado1 - $totalSolicitado1;
                echo '<td style="background-color: #D9EDFC; text-align: center;">' . number_format($totalDiferencia,2) ." "."Kg". '</td>';
              }
              ?>
            </tr>
            <tr>
              <td style="text-align: center;" style="width: 10px;">Eliminacion</td>
              <?php
              for ($is = 0; $is <= $diff; $is++) {
                $fecha_actual_solicitado = date("Y-m-d",  strtotime(date($fecha_inicial) . '+' . $is . ' days'));
                if($sucursal_id==20){
                  $queryEnviada = $db->GetAll("select SUM(d.cantidad) as CantidadEliminacion,pr.nombre
                                  from detalleeliminacion d 
                                  inner JOIN eliminacion p on p.nro = d.nro 
                                  inner JOIN producto pr on pr.idproducto = d.producto_id 
                                  INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
                                  WHERE p.fecha  = '$fecha_actual_solicitado' and d.sucursal_id =p.sucursal_id and 
                                  pr.idcategoria =2 
                                  group by pr.nombre ORDER BY pr.nombre 
                                    ");
                }else{
                  $queryEnviada = $db->GetAll("select SUM(d.cantidad) as CantidadEliminacion,pr.nombre
                                  from detalleeliminacion d 
                                  inner JOIN eliminacion p on p.nro = d.nro 
                                  inner JOIN producto pr on pr.idproducto = d.producto_id 
                                  INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
                                  WHERE p.fecha  = '$fecha_actual_solicitado' and d.sucursal_id =p.sucursal_id and 
                                  pr.idcategoria =2 AND s.idsucursal=$sucursal_id 
                                  group by pr.nombre ORDER BY pr.nombre 
                                    ");
                }
                
                $totalEnviado = 0;
                foreach ($queryEnviada as $item) {
                  if ($item["nombre"] == "POLLO AL HORNO") {
                    $totalEnviado += ($item["CantidadEliminacion"] / 8) * 1.3;
                  } else if ($item["nombre"] == "KEPERI 0.150G") {
                    $totalEnviado += $item["CantidadEliminacion"] * 0.15;
                  }else if($item["nombre"] == "BROCHETAS DE POLLO"){
                    $totalEnviado += $item["CantidadEliminacion"] * 0.140;
                  } else {
                    $totalEnviado += $item["CantidadEliminacion"];
                  }
                }
                echo '<td style="background-color: #D9EDFC; text-align: center;">' . number_format($totalEnviado,2)  ." "."Kg". '</td>';
              }
              ?>
            </tr>
            <tr>
              <td style="text-align: center;" style="width: 10px;">Reciclaje</td>
              <?php
              for ($is = 0; $is <= $diff; $is++) {
                $fecha_actual_solicitado = date("Y-m-d",  strtotime(date($fecha_inicial) . '+' . $is . ' days'));
                if($sucursal_id==20){
                  $queryReciclaje = $db->GetAll("select SUM(d.cantidad) as CantidadReciclada,p.nombre
                                  from detallereciclaje d 
                                  inner join reciclaje r on r.nro = d.nro 
                                  inner join producto p on p.idproducto = d.producto_id 
                                  inner join sucursal s on s.idsucursal = d.sucursal_id 
                                  where r.fecha = '$fecha_actual_solicitado' and d.sucursal_id = r.sucursal_id 
                                  and p.idcategoria = 2 
                                  group by p.nombre");
                }else{
                  $queryReciclaje = $db->GetAll("select SUM(d.cantidad) as CantidadReciclada,p.nombre
                                  from detallereciclaje d 
                                  inner join reciclaje r on r.nro = d.nro 
                                  inner join producto p on p.idproducto = d.producto_id 
                                  inner join sucursal s on s.idsucursal = d.sucursal_id 
                                  where r.fecha = '$fecha_actual_solicitado' and d.sucursal_id = r.sucursal_id 
                                  and p.idcategoria = 2 and s.idsucursal = $sucursal_id 
                                  group by p.nombre");
                }

                $totalReciclaje = 0;
                foreach ($queryReciclaje as $item) {
                  if ($item["nombre"] == "POLLO AL HORNO") {
                    $totalReciclaje += ($item["CantidadReciclada"] / 8) * 1.3;
                  } else if ($item["nombre"] == "KEPERI 0.150G") {
                    $totalReciclaje += $item["CantidadReciclada"] * 0.15;
                  }else if($item["nombre"] == "BROCHETAS DE POLLO"){
                    $totalReciclaje += $item["CantidadReciclada"] * 0.140;
                  } else {
                    $totalReciclaje += $item["CantidadReciclada"];
                  }
                }
                echo '<td style="background-color: #D9EDFC; text-align: center;">' . number_format( $totalReciclaje,2) ." "."Kg". '</td>';
              }
              ?>
            </tr>
            <tr>
              <td style="text-align: center;" style="width: 10px;">Total Uso</td>
              <?php
              for ($is = 0; $is <= $diff; $is++) {
                $fecha_actual_solicitado = date("Y-m-d",  strtotime(date($fecha_inicial) . '+' . $is . ' days'));
                if($sucursal_id==20){
                  $queryPrincipal = $db->GetAll("select SUM(d.cantidad_envio) as CantidadEnviada,pr.nombre
                                      from detallepedido d 
                                      inner JOIN pedido p on p.nro = d.nro 
                                      inner JOIN producto pr on pr.idproducto = d.producto_id 
                                      INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
                                      WHERE p.Fecha_p = '$fecha_actual_solicitado' and d.sucursal_id =p.sucursal_id and 
                                      pr.idcategoria =2 group by pr.nombre ORDER BY pr.nombre ;
                                    ");
                }else{
                  $queryPrincipal = $db->GetAll("select SUM(d.cantidad_envio) as CantidadEnviada,pr.nombre
                                      from detallepedido d 
                                      inner JOIN pedido p on p.nro = d.nro 
                                      inner JOIN producto pr on pr.idproducto = d.producto_id 
                                      INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
                                      WHERE p.Fecha_p = '$fecha_actual_solicitado' and d.sucursal_id =p.sucursal_id and 
                                      pr.idcategoria =2 AND s.idsucursal=$sucursal_id group by pr.nombre ORDER BY pr.nombre ;
                                    ");
                }
                

                $totalEnviado = 0;
                foreach ($queryPrincipal as $item) {
                  if ($item["nombre"] == "POLLO AL HORNO") {
                    $totalEnviado += ($item["CantidadEnviada"] / 8) * 1.3;
                  } else if ($item["nombre"] == "KEPERI 0.150G") {
                    $totalEnviado += $item["CantidadEnviada"] * 0.15;
                  }else if($item["nombre"] == "BROCHETAS DE POLLO"){
                    $totalEnviado += $item["CantidadEnviada"] * 0.140;
                  } else {
                    $totalEnviado += $item["CantidadEnviada"];
                  }
                }
                $queryReciclaje = $db->GetAll("select SUM(d.cantidad) as CantidadReciclada,p.nombre
                                    from detallereciclaje d 
                                    inner join reciclaje r on r.nro = d.nro 
                                    inner join producto p on p.idproducto = d.producto_id 
                                    inner join sucursal s on s.idsucursal = d.sucursal_id 
                                    where r.fecha = '$fecha_actual_solicitado' and d.sucursal_id = r.sucursal_id 
                                    and p.idcategoria = 2 and s.idsucursal = $sucursal_id 
                                    group by p.nombre ");

                $totalReciclaje = 0;
                foreach ($queryReciclaje as $item) {
                  if ($item["nombre"] == "POLLO AL HORNO") {
                    $totalReciclaje += ($item["CantidadReciclada"] / 8) * 1.3;
                  } else if ($item["nombre"] == "KEPERI 0.150G") {
                    $totalReciclaje += $item["CantidadReciclada"] * 0.15;
                  }else if($item["nombre"] == "BROCHETAS DE POLLO"){
                    $totalReciclaje += $item["CantidadReciclada"] * 0.140;
                  } else {
                    $totalReciclaje += $item["CantidadReciclada"];
                  }
                }
                if($sucursal_id==20){
                  $queryEliminacion = $db->GetAll("select SUM(d.cantidad) as CantidadEliminacion,pr.nombre
                  from detalleeliminacion d 
                  inner JOIN eliminacion p on p.nro = d.nro 
                  inner JOIN producto pr on pr.idproducto = d.producto_id 
                  INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
                  WHERE p.fecha  = '$fecha_actual_solicitado' and d.sucursal_id =p.sucursal_id and 
                  pr.idcategoria =2 
                  group by pr.nombre ORDER BY pr.nombre 
                    ");
                }else{
                  $queryEliminacion = $db->GetAll("select SUM(d.cantidad) as CantidadEliminacion,pr.nombre
                  from detalleeliminacion d 
                  inner JOIN eliminacion p on p.nro = d.nro 
                  inner JOIN producto pr on pr.idproducto = d.producto_id 
                  INNER JOIN sucursal s on s.idsucursal = d.sucursal_id 
                  WHERE p.fecha  = '$fecha_actual_solicitado' and d.sucursal_id =p.sucursal_id and 
                  pr.idcategoria =2 AND s.idsucursal=$sucursal_id 
                  group by pr.nombre ORDER BY pr.nombre 
                    ");
                }

                $totalEliminacion = 0;
                foreach ($queryEliminacion as $item) {
                  if ($item["nombre"] == "POLLO AL HORNO") {
                    $totalEliminacion += ($item["CantidadEliminacion"] / 8) * 1.3;
                  } else if ($item["nombre"] == "KEPERI 0.150G") {
                    $totalEliminacion += $item["CantidadEliminacion"] * 0.15;
                  }else if($item["nombre"] == "BROCHETAS DE POLLO"){
                    $totalEliminacion += $item["CantidadEliminacion"] * 0.140;
                  } else {
                    $totalEliminacion += $item["CantidadEliminacion"];
                  }
                }




                $totalUso = $totalEnviado - $totalEliminacion + $totalReciclaje;

                echo '<td style="background-color: #D9EDFC; text-align: center;">' . number_format($totalUso,2)  ." "."Kg". '</td>';
              }
              ?>

            </tr>
            <tr>
              <td style="text-align: center;" style="width: 10px;">DETALLES</td>
              <?php
              /* for ($i = 0; $i <= $diff; $i++) {
                $fecha_actual = date("Y-m-d",  strtotime(date($fecha_inicial) . '+' . $i . ' days'));
                echo $fecha_actual;
                echo '<td style="text-align: center;">
                        <form action="detalle_Consolidado.php" method="GET">
                          <input type="hidden" name="fecha_actual" value="<?php echo $fecha_actual ?>">
                          <input type="hidden" name="sucursal_id" value="<?php echo $sucur ?>">
                          <input type="submit" class="btn btn-link" value="Ver Detalle"></input>
                        </form>
                      </td>';
              } */
              ?>
              <?php
              for ($i = 0; $i <= $diff; $i++) {
                $fecha_actual = date("Y-m-d",  strtotime(date($fecha_inicial) . '+' . $i . ' days'));
              ?>
                <td style="text-align: center;">
                  <form action="detalle_Consolidado.php" method="GET" target="detalle_Consolidado.php">
                    <input type="hidden" name="fecha_actual" value="<?php echo $fecha_actual ?>">
                    <input type="hidden" name="sucursal_id" value="<?php echo  $_POST["sucursal_id"] ?>">
                    <input type="submit" class="btn btn-link" value="Ver Detalle"></input>
                  </form>
                </td>
              <?php
              }
              ?>


            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div> <!-- Start WOWSlider.com BODY section -->
  <script src="../js/jquery.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap.min.js"></script>
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

  <script src="../data/librerias/calendario2/js/bootstrap-datepicker.min.js"></script>
  <script src="../data/librerias/calendario2/locales/bootstrap-datepicker.es.min.js"></script>
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