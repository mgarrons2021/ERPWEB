<?php
$servidor = 'localhost';
$usuario = 'donesco_erpwebdonesco';
$password = 'unDuNM619!';
$basededatos = 'donesco_erpwebdonesco';
$db = mysqli_connect($servidor, $usuario, $password, $basededatos);          
mysqli_query($db, "SET NAMES 'utf8'");    

?>