<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Credentials: false');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

if (isset($_GET['fecha'])) {
    $fechade = $_GET['fecha'];
    $fechaa = $_GET['fecha_a'];
    $retorno =  obtenerProduccion($fechade, $fechaa);
    $gaseosas = obtenerGaseosas($fechade, $fechaa);
    $platos = obtenerplatos();
    $sucursales = sucursales();
    $produccion = formatear($retorno, $gaseosas);
    echo json_encode([
        'status' => true, 'data' => $produccion, 'platos' => $platos,
        'sucursales' => $sucursales, 'gaseosas' => $gaseosas
    ]);
} else {
    echo json_encode(['status' => false]);
}

exit();

function obtenerProduccion($fecha1, $fecha2)
{

    include "../config/conexion.inc.php";
    $sql = "SELECT plato.nombre, sum(detalleventa.cantidad) as cantidad, sucursal.nombre as sucursal ,sucursal.idsucursal,plato.idplato 
    FROM `detalleventa` 
        inner join sucursal on sucursal.idsucursal =  detalleventa.sucursal_id    
    inner join plato on plato.idplato = detalleventa.plato_id 
    where ( plato.categoria ='hamburguesas' or plato.categoria = 'pollos'
     or plato.categoria = 'platos servidos' or plato.categoria = 'parrilla' or plato.categoria = 'menu ejecutivo' 
     or plato.categoria= 'Venta Externa' or plato.categoria= 'platos a la carta' or plato.categoria= 'combos') 

     and (plato.nombre LIKE '%Milanesa%' or plato.nombre LIKE '%Silpancho%'
      or plato.nombre LIKE '%pollo%' or plato.nombre = 'filete de Pollo'   or plato.categoria LIKE '%pollos%' 
      or plato.categoria LIKE '%hamburguesas%' or (plato.categoria = 'menu ejecutivo' and (plato.nombre = 'Chorellana' 
                                                                                           
       or plato.nombre = 'Pique Macho' ) ) or ( plato.categoria = 'parrilla' and ( plato.nombre = 'Cuadril Completo'
        or plato.nombre = 'Cuadril Simple' ) ) )
        
         and ( detalleventa.fecha_v BETWEEN '$fecha1' and '$fecha2 ')
         group by sucursal.idsucursal, plato.categoria,plato.nombre
         order by sucursal.idsucursal asc ";
    $resultado = $db->GetAll($sql);
    return $resultado;
}

function obtenerGaseosas($fecha1, $fecha2)
{
    include "../config/conexion.inc.php";
    $sql = "SELECT plato.categoria , detalleventa.sucursal_id ,sucursal.nombre as sucursal, sum( detalleventa.cantidad ) as cantidad  
    FROM `detalleventa`
    inner join plato on plato.idplato = detalleventa.plato_id 
    inner join sucursal on sucursal.idsucursal =  detalleventa.sucursal_id
    where (plato.categoria='gaseosas' or plato.categoria='refrescos') 
    and detalleventa.fecha_v BETWEEN '$fecha1' and '$fecha2'
    group by plato.categoria,detalleventa.sucursal_id
    order by detalleventa.sucursal_id asc";
    $resultado = $db->GetAll($sql);
    return $resultado;
}

function obtenerplatos()
{

    include "../config/conexion.inc.php";
    $sql = "SELECT plato.nombre, plato.idplato FROM plato where (plato.categoria ='hamburguesas' or plato.categoria = 'pollos'
     or plato.categoria = 'platos servidos' or plato.categoria = 'parrilla' or plato.categoria = 'menu ejecutivo' 
     or plato.categoria= 'Venta Externa'  or plato.categoria= 'platos a la carta' or plato.categoria= 'combos' ) and (plato.nombre LIKE '%Milanesa%' or plato.nombre LIKE '%Silpancho%'
     or plato.nombre = 'filete de Pollo' or plato.nombre LIKE '%pollo%' or plato.categoria LIKE '%pollos%' 
      or plato.categoria LIKE '%hamburguesas%' or (plato.categoria = 'menu ejecutivo' and (plato.nombre = 'Chorellana'
       or plato.nombre = 'Pique Macho' ) ) or ( plato.categoria = 'parrilla' and ( plato.nombre = 'Cuadril Completo'
        or plato.nombre = 'Cuadril Simple' ) ) ) order by plato.categoria asc";

    $resultado = $db->GetAll($sql);

    return $resultado;
}

function sucursales()
{
    include "../config/conexion.inc.php";
    $sql = "SELECT DISTINCT sucursal.idsucursal,sucursal.nombre FROM `sucursal` WHERE sucursal.idsucursal NOT IN  (16,17,18,19,20,21,22) ";
    $resultado = $db->GetAll($sql);
    return $resultado;
}

function formatear($retorno, $retorno2)
{
    $produccion = array();
    $platos = array();
    $id = 0;
    $nombre = '';
    foreach ($retorno as $key => $value) {
        if ($id == $value['idsucursal']) {
            array_push($platos, [
                "idplato" => $value['idplato'],
                "cantidad" => $value['cantidad']
            ]);
            $nombre = $value['sucursal'];
        } else {
            if ($id != 0) {
                foreach ($retorno2 as $key2 => $value2) {
                    if ($value2['sucursal_id'] == $id) {
                        array_push($platos, [
                            "idplato" => $value2['categoria'],
                            "cantidad" => $value2['cantidad']
                        ]);
                        array_shift($retorno2);
                    } else {
                        break;
                    }
                }

                array_push($produccion, [
                    "nombre_sucursal" => $nombre,
                    "platos" => $platos
                ]);

                $platos = array();
                array_push($platos, [
                    "idplato" => $value['idplato'],
                    "cantidad" => $value['cantidad']
                ]);
            } else {
                array_push($platos, [
                    "idplato" => $value['idplato'],
                    "cantidad" => $value['cantidad']
                ]);
            }
            $id = $value['idsucursal'];
            $nombre = $value['sucursal'];
        }
    }

    $platos = array();
    $id = 0;
    if (sizeof($retorno2) > 0) {
        foreach ($retorno2 as $key => $value) {
            if ($id == $value['categoria']) {
                array_push($platos, [
                    "idplato" => $value['categoria'],
                    "cantidad" => $value['cantidad']
                ]);
                $nombre = $value['sucursal'];
            } else {
                if ($id != 0) {
                    array_push($produccion, [
                        "nombre_sucursal" => $nombre,
                        "platos" => $platos
                    ]);
                    $platos = array();
                } else {
                    array_push($platos, [
                        "idplato" => $value['categoria'],
                        "cantidad" => $value['cantidad']
                    ]);
                }
                $id = $value['categoria'];
                $nombre = $value['sucursal'];
            }
        }
    }

    return $produccion;
}
