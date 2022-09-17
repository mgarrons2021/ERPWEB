<?php
require_once 'pear/adodb/adodb.inc.php';
require_once 'pear/smarty/libs/Smarty.class.php';
date_default_timezone_set('America/La_Paz');
$db=ADONewConnection('mysqli');
$db->PConnect('localhost','root','','donesco_erpwebdonesco');
$smarty=new Smarty;
//$db->set_charset("SET NAMES 'utf8'");
?>