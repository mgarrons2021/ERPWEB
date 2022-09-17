﻿<html>
<head>
  <title>Platos</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/bootstrap.min.css">

</head>

<body class="body">

  <?php include "../menu/menu.php";

  $ventas = $db->GetAll("select * from pre_pla ");
  $query = $ventas;
  ?>
  <div class="container">
    <div class="left-sidebar">
      <h2>Listado de platos</h2>
      <div class="table-responsive">
        <script src="../js/jquery.js"></script>
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
        <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Cod_plato</th>
              <th>fecha</th>
              <th>Sucursal</th>
              <th>Nombre</th>
              <th>Precio normal</th>
              <th>Precio Delivery</th>
          <!--     <th>Imagen</th> -->
              <th>Categoria</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($query as $r) { ?>
              <tr class=warning>
                <td><?php echo $r["idpre_pla"]; ?></td>
                <td><?php echo $r["fecha"]; ?></td>
                <td><?php echo $db->GetOne('SELECT nombre FROM sucursal where idsucursal = '.$r['sucursal_id']);  ?></td>
                <td><?php echo $db->GetOne('SELECT nombre FROM plato where idplato = '.$r['plato_id']);  ?></td>
                <td><?php echo $r["precio"] . " bs."; ?></td>
                <td><?php echo $r["precio_d"] . " bs."; ?></td>
                <td><?php echo $r["categoria"]; ?></td>
                <td style="width:210px;">
                
                  <a href="editar.php?nro=<?php echo $r["idpre_pla"]; ?>&plato_id=<?php echo $r["plato_id"]; ?>"><img src="../images/edit.png" alt="" title="Modificar">Edit</a>
                  <a href="javascript:check_eliminar(<?php echo $r["idpre_pla"]; ?>)"><img src="../images/eliminar2.jpg" alt="" title="eliminar">Eliminar<a>
              
                </td>
              </tr>

              <script type="text/javascript">

function check_eliminar(id){
  var proid = id;
if(confirm('Está seguro que desea eliminar ese producto?'+proid)){
  
  window.location="eliminar.php?id="+proid;
  
  
}else{
return false;
}
}

</script>

              <div class="modal fade" id="ver<?php echo $r["idpre_pla"]; ?>" data-backdrop="static" data-keyboard="false" draggable="modal-header" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Detalle insumos de<?php echo " " . $r["nombre"]; ?></h4>
                    </div>
                    <div class="modal-body">
                      <div class="row panel panel-primary">
                        <div class="col-md-4">
                          Insumo
                        </div>
                        <div class="col-md-2">
                          Cantidad
                        </div>
                        <div class="col-md-2">
                          U.Medida
                        </div>
                      </div>
                      <?php
                      $consul = $db->GetAll("select * from detalleplato dp,producto p where dp.nro = $r[nro] and p.idproducto = dp.producto_id ");
                      foreach ($consul as $key) { ?>
                        <div class="row">
                          <div class="col-md-4">
                            <?php echo $db->GetOne('SELECT nombre FROM producto where idproducto =' . $key['producto_id']); ?>
                          </div>
                          <div class="col-md-2">
                            <?php echo $key["cantidad"]; ?>
                          </div>
                          <div class="col-md-2">
                            <?php echo $db->GetOne('SELECT u.nombre FROM unidad_medida u , producto p where  u.idunidad_medida =p.idunidad_medida and p.idproducto =' . $key['producto_id']); ?>
                          </div>
                        </div>
                      <?php } ?>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
        </table>

        
      </div>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
    </div>
  </div> <!-- Start WOWSlider.com BODY section -->
  <!-- End WOWSlider.com 
  BODY section -->
</body>
</html>