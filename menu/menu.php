<?php
require_once '../config/conexion.inc.php';
session_start();
$usuario = $_SESSION['usuario'];
$id = $usuario['idusuario'];
if ($usuario == "" || $usuario == null) {
	print "<script>alert(\"no exsite usuario vuelva a ingresar.\");window.location='../index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>SISTEMA DONESCO S.R.L.</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/estiloyanbal.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/prettyPhoto.css" rel="stylesheet">
	<link href="../css/price-range.css" rel="stylesheet">
	<link href="../css/animate.css" rel="stylesheet">
	<link href="../css/main.css" rel="stylesheet">
	<link href="../css/responsive.css" rel="stylesheet">
	<link rel="stylesheet" href="../data/alert/css/alertify.min.css" />
	<link rel="stylesheet" href="../data/alert/css/themes/default.min.css" />
	<link rel="stylesheet" href="../css/intlTelInput.css">
	<link rel="shortcut icon" href="../images/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="../images/ico/apple-touch-icon-57-precomposed.png">
	<script src="../js/datavalidacion.js"></script>
	<script src="../js/intlTelInput.js"></script>
</head>
<!--/head-->

<body>
	<header id="header">
		<!--header-->
		<div class="header_top">
			<!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li>
									<br>
									<button type="button" class="btn btn-danger" onclick="window.location.href= '../index.php';">
										<span class="glyphicon glyphicon-off"></span>
									</button>
								</li>
								<li><a href="#"><i class="fa fa-user fa-3x"></i> </a></li>
								<li><a href="#"><i class=""></i><?php echo "$usuario[nombrerol] :  $usuario[nombreusuario]:<br>$usuario[nombresucursal]"; ?></a>
								</li>
							</ul>
							<ul>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
		<div class="header-bottom">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">

								<?php if ($usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario'] == '2304' || $usuario['codigo_usuario'] == '1127' || $usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario']                   == '0077GS' || $usuario['codigo_usuario'] == '0713' || $usuario['codigo_usuario'] == '7777' || $usuario['codigo_usuario'] == '2617' || $usuario['codigo_usuario'] == '1999') { ?>

									<li><a href="" class="active">INICIO</a></li>

									<li class="dropdown"><a href="#">CLIENTE<i class="fa fa-angle-down"></i></a>
										<ul role="menu" class="sub-menu">
											<li><a href="../cliente/nuevo.php">Cliente Nuevo</a></li>
											<li><a href="../cliente/">Clientes Registrados</a></li>
										</ul>
									</li>
								<?php } ?>

								<?php if ($usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario'] == '2304' || $usuario['codigo_usuario'] == '1127' || $usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario'] == '0077GS' || $usuario['codigo_usuario'] == '0713' || $usuario['codigo_usuario'] == '7777' || $usuario['codigo_usuario'] == '2617' || $usuario['codigo_usuario'] == '1999') { ?>

									<li class="dropdown"><a href="#">REGISTRAR<i class="fa fa-angle-down"></i></a>
										<ul role="menu" class="sub-menu">
											<li><a href="../usuario/nuevo.php">Nuevo Usuario</a></li>
											<li><a href="../usuario/listar.php">Usuarios</a></li>
											<li><a href="../provedor/nuevo.php">Nuevo Proveedor</a></li>
											<li><a href="../provedor/listar.php">Proveedores</a></li>
										</ul>
									</li>
								<?php } ?>



								<li class="dropdown"><a href="#">CONSUMOELECTRICO<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										<li><a href="../gastos_energia/nuevo.php">Nuevo Registro</a></li>
										<li><a href="../gastos_energia/index.php">Listar</a></li>
									</ul>
								</li>



								<?php if (
									$usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario'] == '2304' || $usuario['codigo_usuario'] == '1127' || $usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario']
									== 'ric12345' || $usuario['codigo_usuario'] == '0077GS' || $usuario['codigo_usuario'] == '0713' || $usuario['codigo_usuario'] == '7777' || $usuario['codigo_usuario'] == '2617' || $usuario['codigo_usuario'] == '1999'
								) { ?>

									</li>
									<li class="dropdown"><a href="#">PLATO<i class="fa fa-angle-down"></i></a>
										<ul role="menu" class="sub-menu">
											<li><a href="../plato/nuevo.php">Registro Nuevo</a></li>
											<li><a href="../plato/">Platos Registrados</a></li>
									
										</ul>
									</li>
								<?php } ?>

								<?php if (
									$usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario'] == '2304' || $usuario['codigo_usuario'] == '1127' || $usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario']
									== 'ric12345' || $usuario['codigo_usuario'] == '0077GS' || $usuario['codigo_usuario'] == '0713' || $usuario['codigo_usuario'] == '7777' || $usuario['codigo_usuario'] == '2617' || $usuario['codigo_usuario'] == '1999'
								) { ?>

									</li>
									<li class="dropdown"><a href="#">PRECIOS SUCURSALES<i class="fa fa-angle-down"></i></a>
										<ul role="menu" class="sub-menu">
										<li><a href="../pre_pla/nuevo.php">Asignar Precios</a></li>
										<li><a href="../pre_pla/index.php">Editar Precios/eliminar</a></li>
											

										</ul>
									</li>
								<?php } ?>

								<?php if ($usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario'] == '2304' || $usuario['codigo_usuario'] == '1127' || $usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario'] == '0077GS' || $usuario['codigo_usuario'] == '0713' || $usuario['codigo_usuario'] == '7777' || $usuario['codigo_usuario'] == '2617' || $usuario['codigo_usuario'] == '1999') { ?>

									<!--<<li class="dropdown"><a href="#">ORDEN DE COMPRA<i class="fa fa-angle-down"></i></a>
                    <ul role="menu" class="sub-menu">                        
				  <li><a href="../orden_de_compra/nuevo.php">Nuevo</a></li>
				  <li><a href="../orden_de_compra/index.php">Listar</a></li>
										    
			     	    </ul>
		           </li>-->
								<?php } ?>

								<li class="dropdown"><a href="#">MANO DE OBRA<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										<li><a href="../registrar_mo/nuevo.php">Nuevo Registro</a></li>
										<li><a href="../registrar_mo/index.php">Listar</a></li>
									</ul>
								</li>



								<li class="dropdown"><a href="#">SOLICITUDES<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										<li><a href="../insumos/nuevo.php">Solicitud de Insumos y Produccion</a></li>
										<li><a href="../insumos/index.php">Solicitudes Registradas</a></li>
										<li><a href="../control_moviles/nuevo.php">Registro llegada produccion</a></li>
										<!--<li><a href="../pla_elabo/nuevo.php">PRODUCCION</a></li>
			         <li><a href="../pla_elabo/">PRODUCCION SOLICITADO</a></li>-->
									</ul>
								</li>

								<!--<<li class="dropdown"><a href="#">MIX VENTAS<i class="fa fa-angle-down"></i></a>
                    <ul role="menu" class="sub-menu">                        
			        <li><a href="../produccion/nuevo.php">Registro Nuevo</a></li>
				<li><a href="../produccion/index.php">Mix Registrado</a></li>
			     <li><a href="../solicitud/">PRODUCCION</a></li>
				<li><a href="../solicitud/">LISTAR PRODUCCION</a></li>
										</ul>
                       </li>-->

								<li class="dropdown"><a href="#">PARTE PRODUCCION<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										<li><a href="../parte_produccion2/nuevo.php">Registro Nuevo</a></li>
										<li><a href="../parte_produccion/index.php">Datos Registrado</a></li>

									</ul>
								</li>
								<?php if (
									$usuario['codigo_usuario'] == '74444' || $usuario['codigo_usuario'] == '6909' || $usuario['codigo_usuario'] == '12345' || $usuario['codigo_usuario'] == '7029' || $usuario['codigo_usuario'] == '2304' || $usuario['codigo_usuario'] == '1127' || $usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario'] == '0077GS' || $usuario['codigo_usuario']
									== '1531' || $usuario['codigo_usuario'] == '0713' || $usuario['codigo_usuario'] == '1002' || $usuario['codigo_usuario'] == '7777' || $usuario['codigo_usuario'] == '1807' || $usuario['codigo_usuario'] == '2617' || $usuario['codigo_usuario'] == '1999'
								) { ?>
									<li class="dropdown"><a href="#">PEDIDOS<i class="fa fa-angle-down"></i></a>
										<ul role="menu" class="sub-menu">
											<li><a href="../pedidos/">Insumos Solicitados</a></li>
											<li><a href="../pedidos/envio_com.php">Produccion Solicitada</a></li>
											<li><a href="../pedidos/pedidozumos.php"> Solicitud de zumos y salsas </a></li>
											<li><a href="../pedidos/pedido_automatico_carnes.php"> Pedido automatico carnes </a></li>
											<li><a href="../pedidos/acu_ped.php">Traspasos acumulados</a></li>
											<li><a href="../pedidos/cos_suc.php">Costos por sucursal</a></li>
											<li><a href="../pedidos/env_dir.php">Envio directo</a></li>
											<li><a href="../pedidos/ped_aut.php">Pedido Automatico</a></li>
											<li><a href="../pedidos/general.php">Total Insumos Solicitados</a></li>
										</ul>
									</li>
								<?php } ?>
								<li class="dropdown"><a href="#">TRASPASOS<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										<li><a href="../traspasos/nuevo.php">Traspaso Nuevo</a></li>
										<li><a href="../traspasos/">Traspasos Realizados</a></li>
										<li><a href="../recepcion/">Recepcion de Traspasos</a></li>
									</ul>
								</li>
								<li class="dropdown"><a href="#">ELIMINACION <i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										<li><a href="../eliminacion/nuevo.php">Registro Nuevo</a></li>
										<li><a href="../eliminacion/">Eliminacion Registrada</a></li>
									</ul>
								</li>
								<li class="dropdown"><a href="#">RECICLAJE <i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										<li><a href="../reciclaje/nuevo.php">Registro Nuevo</a></li>
										<li><a href="../reciclaje/">Reciclaje registrado</a></li>
									</ul>
								</li>
								<li class="dropdown"><a href="#">COMPRA<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										<li><a href="../compra/nuevo.php">Registro Nuevo</a></li>
										<?php if ($usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario'] == '74444' || $usuario['codigo_usuario'] == '1127' || $usuario['codigo_usuario'] == '0077GS' || $usuario['codigo_usuario'] == '7777' || $usuario['codigo_usuario'] == '1807' || $usuario['codigo_usuario'] == '2617' || $usuario['codigo_usuario'] == '1999') { ?>
											<li><a href="../report_mix_ventas_general/reporte_general_sucursal.php">Mix Ventas por Sucursal</a></li>
											<li><a href="../compra/">Compras Registradas</a></li>
										<?php } ?>
									</ul>
								</li>

								<?php if ($usuario['codigo_usuario'] == '0077GS' || $usuario['codigo_usuario'] == '74444' || $usuario['codigo_usuario'] == '7777' || $usuario['codigo_usuario'] == '1127' || $usuario['codigo_usuario'] == '2617' || $usuario['codigo_usuario'] == '1999') { ?>
									<li class="dropdown"><a href="#">COMPRA PRUEBA<i class="fa fa-angle-down"></i></a>
										<ul role="menu" class="sub-menu">
											<li><a href="../compra2/nuevo.php">Registro Nuevo</a></li>
											<li><a href="../compra2/">Compras Registradas</a></li>

										</ul>
									</li>
								<?php } ?>

								<?php if ($usuario['codigo_usuario'] == '0077GS' || $usuario['codigo_usuario'] == '7777' || $usuario['codigo_usuario'] == '6666' || $usuario['codigo_usuario'] == '1127' || $usuario['codigo_usuario'] == '2617' || $usuario['codigo_usuario'] == '1999') { ?>
									<li class="dropdown"><a href="#">RRHH<i class="fa fa-angle-down"></i></a>
										<ul role="menu" class="sub-menu">
											<li><a href="../control_asistencia/reporte_view.php">Reporte Control Asistencia</a></li>
											<li><a href="../registrar_mo/report_mo.php">Reporte M.O.</a></li>
										</ul>
									</li>
								<?php } ?>


								<li class="dropdown"><a href="#">INVENTARIO<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">

										<li><a href="../inventario2/nuevo.php">Registro Nuevo de Inventario</a></li>
										<li><a href="../inventario/index.php">Inventarios Registrado</a></li>
									</ul>
								</li>

								<!--<li class="dropdown"><a href="#">INSERTAR VENTAS<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                    <li><a href="../reg_ventas/nuevo.php">Nuevo</a></li>
				                <li><a href="../reg_ventas/listar.php">Listar</a></li>
						<li><a href="../transacciones/nuevo.php">Ingresar Transacciones</a></li>
						<li><a href="../transacciones/listar.php">Listar Transacciones</a></li>
					             </ul>
                                </li>-->

								<?php if ($usuario['codigo_usuario'] == '74444' || $usuario['codigo_usuario'] == '2304' || $usuario['codigo_usuario'] == '1127' || $usuario['codigo_usuario'] == '6666' || $usuario['codigo_usuario'] == '12345' || $usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario'] == '0077GS' || $usuario['codigo_usuario'] == '1002' || $usuario['codigo_usuario'] == '0713' || $usuario['codigo_usuario'] == '1807' || $usuario['codigo_usuario'] == '7777' || $usuario['codigo_usuario'] == '2617' || $usuario['codigo_usuario'] == '1999') { ?>

									<li class="dropdown"><a href="#">PRODUCTO<i class="fa fa-angle-down"></i></a>
										<ul role="menu" class="sub-menu">
											<li><a href="../producto/nuevo.php">Registro Nuevo</a></li>
											<li><a href="../producto/listar.php">Productos Pegistrados</a></li>
											<li><a href="../inv_ideal/lis_sucur.php">Asignar Stock Ideal</a></li>
											<li><a href="../producto/asignarproveedor.php">Asignar Proveedor</a></li>

										</ul>
									</li>
								<?php } ?>
								<?php
								if (
									$usuario['codigo_usuario'] == '0077GS' ||
									$usuario['codigo_usuario'] == '74444' ||
									$usuario['codigo_usuario'] == '1531' || $usuario['codigo_usuario'] == '2304' || $usuario['codigo_usuario'] == '7777' || $usuario['codigo_usuario'] == '12345' || $usuario['codigo_usuario'] == '2617' || $usuario['codigo_usuario'] == '1999'
								) { ?>

									<li class="dropdown"><a href="#">REPORTES<i class="fa fa-angle-down"></i></a>
										<ul role="menu" class="sub-menu">

											<li><a href="../reporte/reporte_ventas_rf.php">Ventas Diarias - General</a></li>
											<li><a href="../reporte/delivery.php">Reporte Delivery por sucursal</a></li>
											<li><a href="../reporte/rv_promedio_mes.php">Promedio - Ventas Sucursal</a></li>
											<li><a href="../gastos_energia/reporte_consumoelectrico_rf.php">Consumo Electrico</a></li>
											<li><a href="../reporte/reporte_eliminacion_rf.php">Eliminaciones Diarias - General</a></li>
											<li><a href="../gastos_energia/reporte.php">Reporte consumo electrico</a></li>
											<li><a href="../reporte/valorizadosuc.php">Inventario Valorizado Sucursales</a></li>
											<li><a href="../report_mix_ventas_general/reporte.php">Mix Ventas General</a></li>
											<li><a href="../reporte/reporte_produccion_sucursal.php">Reporte Produccion Sucursal</a></li>
											<li><a href="../report_mix_ventas_general/reporte_general_sucursal.php">Mix Ventas por Sucursal</a></li>
											<li><a href="../reporte/valorizado.php">Inventario Valorizado</a></li>
											<li><a href="../asser_report/sales_report.php">Total Ventas Por Sucursal</a></li>
											<li><a href="../parte_produccion/reporte_general.php">Reporte General Parte de Produccion</a></li>
											<!--<li><a href="../reporte/reg_ventas.php">Ventas Por Sucursal</a></li>-->
											<li><a href="../reporte/transacciones.php">Transacciones Por Hora General</a></li>
											<li><a href="../reporte/transacciones_sucursal.php">Transacciones Horas Por Sucursal</a></li>
											<li><a href="../reporte/inventario.php">Ajuste de Inventario</a></li>

											<li><a href="../reporte/usuario.php">Usuarios registrados</a></li>
											<li><a href="../reporte/proveedores.php">Proveedores registrado</a></li>
											<!--<li><a href="../reporte/compras.php">Compras</a></li>-->
											<!--<li><a href="../reporte/traspasos.php">Traspasos</a></li>-->
											<li><a href="../reporte/pedido_e_r.php">Pedidos Eliminacion, resiclaje</a></li>
											<li><a href="../reporte/reciclaje.php">Reciclaje</a></li>
											<li><a href="../reporte/eliminacion.php">Eliminacion</a></li>
											<li><a href="../almacen/listari.php">Listar Inventario de Insumos</a></li>
											<li><a href="../almacen/listarp.php">Listar Inventario de Produccion</a></li>
											<li><a href="../reporte/reporte_llegada_produccion.php">Reporte Llegada produccion</a></li>

										</ul>
									</li>
								<?php } ?>
								<?php
								if ($usuario['codigo_usuario'] == '0077GS' || $usuario['codigo_usuario'] == '74444' || $usuario['codigo_usuario'] == '1807' || $usuario['codigo_usuario'] == '7777' || $usuario['codigo_usuario'] == '1127' || $usuario['codigo_usuario'] == '2617' || $usuario['codigo_usuario'] == '1999') { ?>
									<li class="dropdown"><a href="#">VENTAS SUCURSALES<i class="fa fa-angle-down"></i></a>
										<ul role="menu" class="sub-menu">
											<!--<li><a href="../report_ventas/ventas_iva.php">Libro de Ventas</a></li>-->
											<li><a href="../report_ventas/ventas_iva_fiscal.php">Libro de Ventas Nuevo Formato</a></li>
											<li><a href="../report_ventas/ventas_iva2.php">control de ventas anuladas </a></li>
											<li><a href="../report_ventas/verifica_codigo.php">Verifica Codigo</a></li>
											<li><a href="../dosificacion/nuevo.php">Registro de Dosificacion</a></li>
											<!--<li><a href="../report_ventas/ven_cat_suc.php">Ventas por Sucursales Categorias</a></li>-->
											<!--<li><a href="../report_ventas/ventas_sucursales.php">ventas_sucursales</a></li>-->
											<li><a href="../asser_report/sales_fiscal_report.php">Ventas Fiscales</a></li>
										</ul>
									</li>
								<?php } ?>

								<?php
								if ($usuario['codigo_usuario'] == '0077GS' || $usuario['codigo_usuario'] == '2617' || $usuario['codigo_usuario'] == '1999' || $usuario['codigo_usuario'] == '7777' || $usuario['codigo_usuario'] == '1127') { ?>

									<li class="dropdown"><a href="#">REPORTES GERENCIA<i class="fa fa-angle-down"></i></a>
										<ul role="menu" class="sub-menu">

											<li><a href="../reporte/reporte_ventas_rf.php">Ventas Diarias - General</a></li>
											<li><a href="../report_mix_ventas_general/reporte.php">Mix Ventas General</a></li>
											<li><a href="../report_mix_ventas_general/reporte_mix_sucursales.php">Mix Ventas por Sucursal</a></li>
											<li><a href="../asser_report/sales_fiscal_report.php">Ventas Fiscales</a></li>
											<li><a href="../asser_report/sales_report.php">Total Ventas Por Sucursal</a></li>
											<li><a href="../reporte/produccion_comparativa.php">Produccion Comparativa General</a></li>
											<li><a href="../reporte/produccion_consolidada.php">Produccion Consolidada Por Sucursal</a></li>
											<!-- /report_mix_ventas_general/reporte_mix_sucursales.php -->
										</ul>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div><!-- container -->
				</div>
			</div>
		</div>
		<!--/header-bottom-->
	</header>
	<!--/header-->
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.scrollUp.min.js"></script>
	<script src="../js/price-range.js"></script>
	<script src="../js/jquery.prettyPhoto.js"></script>
	<script src="../js/main.js"></script>
	<script src="../data/alert/alertify.min.js"></script>
</body>

</html>