<?php
require_once '../config/conexion.inc.php';
date_default_timezone_set('America/La_Paz');
session_start();
$usuario = $_POST['codigo_usuario'];
$sucursal_id = $_POST['sucursal_id'];
$date = date('Y-m-d');
$time = date('H:i:s');
$registroinsertado = $db->GetOne("SELECT * FROM `registro_ingreso` where fecha = '$date' and usuario_id = $usuario and sucursal_id = $sucursal_id");
$horasalida = $db->getOne("SELECT hora_salida FROM `registro_ingreso` where fecha = '$date' and usuario_id = $usuario and sucursal_id = $sucursal_id;");
/* $contadorregistros = $db->GetOne("SELECT count(*) FROM `registro_ingreso` where fecha = '$date' and usuario_id = $usuario and sucursal_id = $sucursal_id;"); */
$format = 'H:i:s';
$newdate = DateTime::createFromFormat($format, "00:00:00");
/* echo $horasalida;
if($horasalida=="00:00:00"){
    echo "false";
}else{
    echo "true";
} */
$redireccion = (int)($sucursal_id - 1);
if ($registroinsertado != null) {
    if ($horasalida != "00:00:00") {
        print "<script>alert(\"ERR! Ya registro su ingreso y salida\");window.location='registro$redireccion.php';</script>";
    } else {
        $insertar = $db->Execute(
            "
            update registro_ingreso
            set hora_salida = '$time'
            where fecha = '$date' and usuario_id = $usuario and sucursal_id = $sucursal_id"
        );
        if ($insertar != null) {
            print "<script>alert(\"Salida registrada exitosamente.\");window.location='registro$redireccion.php';</script>";
        } else {
            print "<script>alert(\"No se pudo Guardar.\");</script>";
        }
    }
} else {
    $insertar = $db->Execute("INSERT INTO registro_ingreso (id, usuario_id, sucursal_id, fecha, hora_entrada, hora_salida) 
    VALUES (NULL, $usuario, $sucursal_id, '$date', '$time', '')");
    if ($insertar != null) {
        print "<script>alert(\"Entrada registrada exitosamente.\");window.location='registro$redireccion.php';</script>";
    } else {
        print "<script>alert(\"No se pudo Guardar.\");</script>";
    }
}