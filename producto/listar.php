<html>
<head>
  <title>Productos</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <!-- Required meta tags -->
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body class="body">

  <?php include "../menu/menu.php";
  require_once '../config/conexion.inc.php';
  $ventas = $db->GetAll('select p.*, pro.empreza as nombrepro,  a.nombre as articulo, i.nombre as impuesto, u.nombre as unidad, c.nombre as categoria  from producto p,  categoria c,  tipo_articulo a,  tipo_impuesto i,  unidad_medida u, proveedor pro
      where p.idcategoria=c.idcategoria and
      p.idtipo_articulo=a.idtipo_articulo and
      p.idunidad_medida=u.idunidad_medida  and
      p.idtipo_impuesto=i.idtipo_impuesto  and
      p.idproveedor=pro.idproveedor ORDER BY idproducto');
  $query = $ventas;
  ?>
  <div class="container">
    <div class="left-sidebar">
      <h2>listado de producto</h2>
      <div class="table-responsive">
        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap.min.js"></script>
        <!--    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js">
    </script>
  <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
  <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
  <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

-->
        <script type="text/javascript">
          $(document).ready(function() {
            $('#producto').DataTable({
              /* dom: 'Bfrtip',
               buttons: [
                   'copy', 'csv', 'excel', 'print',
                   {
                       extend: 'pdfHtml5',
                       title: 'Reporte de ventas',
                       message: 'listado de reporte de ventas',
                       image: '404.png'
                   }
               ],
               */
              "order": [
                [0, 'desc'],
                [1, 'desc']
              ],
              "aLengthMenu": [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
              ],
              "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningun dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                  "sFirst": "Primero",
                  "sLast": "Ãšltimo",
                  "sNext": "Siguiente",
                  "sPrevious": "Anterior"
                },
                "oAria": {
                  "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                  "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
              },
            });
          });
        </script>

        <table id="producto" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Proveedor</th>
               <th>Producto</th>
               <th>Precio</th>
               <th>U. Medida</th>
               <th>Categoria</th>
               <th>Tipo Articulo</th>
               <th>Opciones</th>
               <th>Estado</th>
               <th>Acciòn</th>
               <th>Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            
             foreach ($query as $r) { 
              $pro=$r["idproducto"];
            ?>
            
              <tr class=warning>
                <td><?php echo $r["nombrepro"]; ?></td>
                <td><?php echo $r["nombre"]; ?></td>
                <td><?php echo number_format($r["precio_compra"], 3); ?></td>
                <td><?php echo $r["unidad"]; ?></td>
                <td><?php echo $r["categoria"]; ?></td>
                <td><?php echo $r["articulo"]; ?></td>
                <td><a href="#" data-toggle="modal" data-target="#verModal<?php echo $r["idproducto"]; ?>">              
                <img src="../images/verm.png" width="37" height="37" alt="" title="ver detalle">Ver</a>
                <a href="editar.php?id=<?php echo $r["idproducto"]; ?>">
                <img src="../images/editarm.png" width="37" height="37" alt="" title="Modificar">Editar</a>
                </td>
                <td>
               
                          <br>
                            <?php if($r["estado"]=="activo") {?>
                            <button type="button" class="btn btn-sm btn-success">Activo</button>
                            <?php } ?>
                            <?php if($r["estado"]=="inactivo") {?>
                            <button type="button" class="btn btn-sm btn-danger">Inactivo</button>
                            <?php } ?>
                        
                        </td>
                        <td>
                            
                            <a href="actualizapro.php?id=<?php echo $r["idproducto"]; ?>">
                            <img src="../images/no3.png" width="37" height="37" alt="" title="desactivar">
                            <br>
                            
                            <a href="actualizapro2.php?id=<?php echo $r["idproducto"]; ?>">
                            <img src="../images/si3.png" width="37" height="37" alt="" title="activar">
                        </td>
                        <td >
                        <a href="javascript:check_eliminar(<?php echo $r["idproducto"]; ?>)">
                        <img src="../images/delete.png" width="37" height="37" alt="" title="eliminar">
                        <a >
              
                        </td>
                        
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

                

              </tr>
              <div class="modal fade" id="verModal<?php echo $r["idproducto"]; ?>" data-backdrop="static" data-keyboard="false" draggable="modal-header" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">PRODUCTO</h4>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-xs-4">Codigo: </div>
                        <div class="col-xs-8"><?php echo $r["codigo_producto"]; ?></div>
                      </div>

                      <div class="row">
                        <div class="col-xs-4">Nombre: </div>
                        <div class="col-xs-8"> <?php echo $r["nombre"]; ?> &nbsp;</div>
                      </div>

                      <div class="row">
                        <div class="col-xs-4">Descripcion: </div>
                        <div class="col-xs-8"><?php echo $r["descripcion"]; ?></div>
                      </div>

                      <div class="row">
                        <div class="col-xs-4">Precio: </div>
                        <div class="col-xs-8"><?php echo $r["precio_compra"]; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-4">Estado: </div>
                        <div class="col-xs-8"><?php echo $r["estado"]; ?></div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                </div>
              </div>
      </div>
      
    <?php }?>

    </table>
    
    </div>
  </div>
  </div>

</body>
</html>