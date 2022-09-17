<html>

<head>
    <title>Pedidos Produccion </title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">
</head>

<body class="body">
    <?php include "../menu/menu.php";
    $usuario = $_SESSION['usuario'];
    $sucur = $usuario['sucursal_id'];
    if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
        $min = $_GET["fechaini"];
        $max = $_GET["fechamax"];
        $view = $db->GetOne("CREATE OR REPLACE VIEW  SUMA_AUTOMATICO AS
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 2 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 3 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 4 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 5 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 6 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 7 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 8 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 9 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 10 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 11 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 12 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 13 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 14 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 15 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max'  group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 16 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto;
");
        $query2 = $db->GetAll("SELECT produccion, idproducto, idsucursal, SUM(inventariofinal) as inventariofinal, SUM(stockideal) as stockideal FROM suma_automatico GROUP BY idproducto;");
        $query3 = $db->GetAll("SELECT s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 2 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
UNION
select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 3 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
UNION
select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 4 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
UNION
select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 5 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
UNION
select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 6 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
UNION
select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 7 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
UNION
select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 8 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
UNION
select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 9 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
UNION
select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 10 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
UNION
 select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 11 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
UNION
 select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 12 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
UNION
 select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 13 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
 UNION
  select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 14 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
UNION
 select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 15 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
UNION
 select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 16 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal;");
    } else {
        $min = date("Y-m-d", strtotime(date('Y-m-d') . "- 1 days"));
        $max = date("Y-m-d", strtotime(date('Y-m-d') . "- 1 days"));

        $view = $db->GetOne("CREATE OR REPLACE VIEW  SUMA_AUTOMATICO AS
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 2 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 3 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 4 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 5 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 6 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 7 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 8 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 9 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 10 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 11 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 12 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 13 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 14 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 15 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max'  group by p.idproducto
UNION
select s.idsucursal, p.idproducto, i.fecha, p.nombre as produccion, sum(di.cantidad) as inventariofinal, sum(ii.cantidad) as stockideal , max(i.nro)as nro  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and di.nro = (
    select MAX(nro) 
    from inventario where sucursal_id = 16 and fecha BETWEEN '$min' and '$max')
and i.fecha BETWEEN '$min' and '$max' group by p.idproducto;
");
        $query2 = $db->GetAll("SELECT produccion, idproducto, idsucursal, 
                                SUM(inventariofinal) as inventariofinal, SUM(stockideal) as stockideal 
                                FROM suma_automatico 
                                GROUP BY idproducto;");



        $query3 = $db->GetAll("SELECT s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
        from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 2 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 3 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 4 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 5 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 6 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 7 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 8 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 9 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 10 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 11 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 12 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 13 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 14 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 15 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal
                                UNION
                                select s.idsucursal, i.nro, p.idproducto, i.hora as hora, s.nombre as sucursal, i.fecha, p.nombre as produccion, di.cantidad as inventariofinal, ii.cantidad as stockideal  
                                from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii
                                where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and i.nro = (
                                    select MAX(nro) 
                                    from inventario where sucursal_id = 16 and fecha BETWEEN '$min' and '$max') and i.fecha BETWEEN '$min' and '$max' GROUP by s.idsucursal;");
    }
    function verificar($sucur, $idproducto)
    {
        /* $conexion = new mysqli('localhost', 'root', '', 'donesco'); */
        $conexion = ADONewConnection('mysqli');
        $conexion->PConnect('localhost','donesco_erpwebdonesco','unDuNM619!','donesco_erpwebdonesco');
        $cantidad = 0;
        if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
            $min = $_GET["fechaini"];
            $max = $_GET["fechamax"];

            $max_id = $conexion->GetOne("SELECT max(nro)as nro FROM inventario where sucursal_id=$sucur");

            /* print $max_id."fadsfas"; */

            $query3 = $conexion->GetAll("SELECT DISTINCT s.idsucursal, s.nombre as sucursal, i.fecha, p.idproducto, p.nombre  as produccion,  
                            di.cantidad as inventariofinal, ii.cantidad as stockideal, um.nombre as um  
                        from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii, unidad_medida um
                        where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and 
                            ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and um.idunidad_medida = p.idunidad_medida
                            and i.fecha BETWEEN '$min' and '$max' and di.sucursal_id = $sucur and p.idproducto = $idproducto;");

            $query5 = $conexion->GetAll("SELECT p.*,di.*,
                            ifnull(di.totali, 0)as entrads,
                            ifnull(dc.total, 0)as entrad,
                            ifnull(dpv.totalv, 0)as salidav,
                            ifnull(dpro.totalpro, 0)as salidapro,
                            ifnull(di.totali, 0)-ifnull(dpv.totalv, 0)as stock
                            from producto p left join
                            (select producto_id,sum(cantidad) totali from detalleinventario where sucursal_id='$sucur' and nro='$max_id' group by producto_id) di on $idproducto= di.producto_id
                            left join(select producto_id,sum(cantidad) total from inv_ideal where sucursal_id='$sucur' group by producto_id) dc on $idproducto = dc.producto_id
                            left join(select producto_id,sum(d.cantidad) totalpro from detalleproduccion d, produccion pro where d.sucursal_id='$sucur' and d.sucursal_id=pro.sucursal_id and pro.fecha='$min' and pro.nro=d.nro group by producto_id) dpro on  $idproducto = dpro.producto_id 
                            left join(select dv.plato_id,pro.nombre as insumo,dpv.producto_id ,sum(dv.cantidad*dpv.cantidad)as totalv
                            from detalleventa dv,venta v,plato pla,detalleplato dpv, producto pro
                            where dv.sucursal_id='$sucur' and  v.fecha='$min' and
                            v.sucursal_id=dv.sucursal_id and 
                            v.idturno=dv.idturno and dv.nro=v.nro and 
                            dv.plato_id=pla.idplato and pla.nro=dpv.nro 
                            and dpv.producto_id=$idproducto
                            GROUP BY producto_id
                            ) dpv on  $idproducto = dpv.producto_id
                 ;");


            /* $resultado = $conexion->GetAll($query3); */
            foreach ($query5 as $r) {
                if ($r["entrad"] - $r["entrads"] >= 0) {
                    $cantidad = $r["entrads"] . "/" . $r["entrad"] . "=" . ($r["entrad"] - $r["entrads"]);
                } else {
                    $cantidad = $r["entrads"] . "/" . $r["entrad"] . "=" . "0";
                }
            }
            /* foreach ($query3 as $r) {
                $cantidad = $r["entrads"] . "/" . $r["entrad"] . "=" . ($r["entrad"] - $r["entrads"]);
                 echo json_encode($r);
            } */
        } else {
            $min = date("Y-m-d", strtotime(date('Y-m-d') . "- 1 days"));
            $max = date("Y-m-d", strtotime(date('Y-m-d') . "- 1 days"));
            $query3 = $conexion->GetAll("select DISTINCT s.idsucursal, s.nombre as sucursal, i.fecha, p.idproducto, p.nombre  as produccion,di.cantidad as inventariofinal, ii.cantidad as stockideal, um.nombre as um  from inventario i, detalleinventario di, producto p, sucursal s, inv_ideal ii, unidad_medida um
            where i.nro = di.nro and di.producto_id = p.idproducto  and di.sucursal_id = s.idsucursal and ii.producto_id = p.idproducto and ii.sucursal_id = di.sucursal_id and ii.sucursal_id = s.idsucursal and ii.sucursal_id = i.sucursal_id and um.idunidad_medida = p.idunidad_medida
            and i.fecha BETWEEN '$min' and '$max' and di.sucursal_id = $sucur and p.idproducto = $idproducto;");
            $resultado = $conexion->query($query3);
            $max_id = $conexion->GetOne("SELECT max(nro)as nro FROM inventario where sucursal_id=$sucur");
            $query5 = $conexion->GetAll("SELECT p.*,di.*,
                            ifnull(di.totali, 0)as entrads,
                            ifnull(dc.total, 0)as entrad,
                            ifnull(dpv.totalv, 0)as salidav,
                            ifnull(dpro.totalpro, 0)as salidapro,
                            ifnull(di.totali, 0)-ifnull(dpv.totalv, 0)as stock
                            from producto p left join
                            (select producto_id,sum(cantidad) totali from detalleinventario where sucursal_id='$sucur' and nro='$max_id' group by producto_id) di on $idproducto= di.producto_id
                            left join(select producto_id,sum(cantidad) total from inv_ideal where sucursal_id='$sucur' group by producto_id) dc on $idproducto = dc.producto_id
                            left join(select producto_id,sum(d.cantidad) totalpro from detalleproduccion d, produccion pro where d.sucursal_id='$sucur' and d.sucursal_id=pro.sucursal_id and pro.fecha='$min' and pro.nro=d.nro group by producto_id) dpro on  $idproducto = dpro.producto_id 
                            left join(select dv.plato_id,pro.nombre as insumo,dpv.producto_id ,sum(dv.cantidad*dpv.cantidad)as totalv
                            from detalleventa dv,venta v,plato pla,detalleplato dpv, producto pro
                            where dv.sucursal_id='$sucur' and  dv.fecha_v='$min' and
                            v.sucursal_id=dv.sucursal_id and 
                            v.idturno=dv.idturno and dv.nro=v.nro and 
                            dv.plato_id=pla.idplato and pla.nro=dpv.nro 
                            and dpv.producto_id=$idproducto
                            GROUP BY producto_id
                            ) dpv on  $idproducto = dpv.producto_id
                 ;");

            foreach ($query5 as $r) {
                if ($r["entrad"] - $r["entrads"] >= 0) {
                    $cantidad = $r["entrads"] . "/" . $r["entrad"] . "=" . ($r["entrad"] - $r["entrads"]);
                } else {
                    $cantidad = $r["entrads"] . "/" . $r["entrad"] . "=" . "0";
                } 
            }

            /* foreach ($query5 as $r) {
                $cantidad = $r["inventariofinal"] . "/" . $r["stockideal"] . "=" . ($r["stockideal"] - $r["inventariofinal"]);
            } */
        }
        return $cantidad;
    }

    ?>
    <div class="container">
        <div class="left-sidebar">
            <h2>Programacion pedidos automaticos a tiendas cabernet</h2>
            <h2><?php if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
                    echo "De: " . $_GET["fechaini"] . " a " . $_GET["fechamax"];
                } else {
                    echo "De: " . date("Y-m-d", strtotime(date('Y-m-d') . "- 1 days")) . " a " . date("Y-m-d", strtotime(date('Y-m-d') . "- 1 days"));
                } ?></h2>
            <div class="table-responsive">
                <script src="../js/jquery.js"></script>
                <script src="../js/bootstrap.min.js"></script>
                <script src="../js/jquery.dataTables.min.js"></script>
                <script src="../js/dataTables.bootstrap.min.js"></script>
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
                <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js">
                </script>
                <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
                <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
                <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
                <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
                <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
                <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
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
                <script type="text/javascript">
                    $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                            var min = Date.parse($('#min').val(), 10);
                            var max = Date.parse($('#max').val(), 10);
                            var age = Date.parse(data[0]) || 0; // use data for the age column
                            if ((isNaN(min) && isNaN(max)) ||
                                (isNaN(min) && age <= max) ||
                                (min <= age && isNaN(max)) ||
                                (min <= age && age <= max)) {
                                return true;
                            }
                            return false;
                        }
                    );

                    $(document).ready(function() {
                        // Setup - add a text input to each footer cell
                        $('#usuario2 tfoot th').each(function() {
                            var title = $(this).text();
                            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
                        });
                        // DataTable
                        var table = $('#usuario2').DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                'print',
                                {
                                    extend: 'pdfHtml5',
                                    title: 'Envio de produccion',
                                    message: ''
                                }
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
                                    "sPrevious": "Anterior",
                                },
                                "oAria": {
                                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                }
                            }
                        }); // Apply the search
                        table.columns().every(function() {
                            var that = this;
                            $('input', this.footer()).on('keyup change', function() {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            });
                        });
                    });
                </script>
                <form action="">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon"><strong>Fecha De:</strong> </span>
                                <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" />
                                <span class="input-group-addon">A</span>
                                <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" />
                                <input type="hidden" id="form_sent" name="form_sent" value="true">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control btn-success" type="submit" value="filtrar" id="filtrar" name="filtrar">
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table id="usuario2" class="table table-responsive table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>SUCURSAL</th>
                                <th> HORA INVENTARIO
                                </th>
                                <?php foreach ($query2 as $key) { ?>
                                    <th> <?php echo $key['produccion'] ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($query3 as $suc) {
                            ?>
                                <tr class=warning>
                                    <td><?php echo $suc['sucursal']; ?></td>
                                    <td><?php echo $suc['hora']; ?></td>
                                    <?php foreach ($query2 as $key) { ?>
                                        <td><?php echo verificar($suc['idsucursal'], $key['idproducto']); ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            <tr class=warning>
                                <td>
                                    <h2><?php echo "Total"; ?></h2>
                                </td>
                                <td>
                                    <h2><?php echo "Total"; ?></h2>
                                </td>
                                <?php foreach ($query2 as $key) { ?>
                                    <td>
                                        <h4><?php echo $cantidad = $key["inventariofinal"] . "/" . $key["stockideal"] . "=" . ($key["stockideal"] - $key["inventariofinal"]); ?></h4>
                                    </td>
                                <?php } ?>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>