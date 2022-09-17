<?php
require_once 'conexion.inc.php';
//$_usuario = $_POST['user'];
$_codigo_usuario = $_POST['codusuario'];
$idsucursal = $_POST['idsucursal'];
//$sql2= $db->GetAll("select idusuario from usuario where codigo_usuario='$_codigo_usuario'");
$sql = $db->Execute("update usuario set sucursal_id='$idsucursal' where codigo_usuario='$_codigo_usuario'");
$usuario = $db->GetRow("SELECT u.estado as estado, r.nombre as nombrerol, u.idusuario as idusuario, u.nombre   as nombreusuario, r.nombre as nombrerol, u.sucursal_id, s.nombre as nombresucursal, u.codigo_usuario
      from rol r, usuario u , sucursal s
      where u.estado = 'activo' and
      u.sucursal_id = s.idsucursal and
      u.rol_id= r.idrol and
      u.codigo_usuario = '$_codigo_usuario'");
if($idsucursal=='1'){
  if ($usuario['codigo_usuario']=='7777'||$usuario['codigo_usuario']=='74444'||$usuario['codigo_usuario']=='6909'||$usuario['codigo_usuario']=='7029'||$usuario['codigo_usuario']=='2304'||$usuario['codigo_usuario']=='12345'||$usuario['codigo_usuario']=='1127'||$_codigo_usuario=='1531'||$_codigo_usuario=='0077GS'||$_codigo_usuario=='0713'||$_codigo_usuario=='1002'||$usuario['codigo_usuario']=='1807'||$usuario['codigo_usuario']=='2617'||$usuario['codigo_usuario']=='1999'){
      if($usuario){      
                  session_start();
                  $_SESSION['usuario']=$usuario;
                  $dato=$_SESSION['usuario'];
                  header("location: ../sesion/admin.php");
                  }
      else{ 
       print "<script>alert(\"Usuario Incorrecto\");window.location='../index.php';</script>";
          }
     }else{
      print "<script>alert(\"No tiene acceso a Bodega Principal\");window.location='../index.php';</script>";
         }
}else{
  if ($_codigo_usuario!='daniel123'){
      if($usuario){
                  session_start();
                  $_SESSION['usuario']=$usuario;
                  $dato=$_SESSION['usuario'];
                  header("location: ../sesion/admin.php");
                  }
      else{
       print "<script>alert(\"Usuario Incorrecto\");window.location='../index.php';</script>";
         }
        }else{
          print "<script>alert(\"No tiene acceso \");window.location='../index.php';</script>";
             }

}
?>