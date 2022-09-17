<?php
//require "conexion.php";
require_once '../config/conexion.inc.php';
class Consulta{
    private $_db;
    private  $lista_usuarios;

   /* public function __construct(){
        $this->_db = new Conexion();
    }*/

    public function buscar(){
        
        //$this->_db->conectar();

        //$consulta = $this->_db->cnx->prepare("SELECT * FROM usuario");
     $consulta=$db->GetRow("select * from venta where sucursal_id='$sucur' and idturno='$idturno' and nro='$nro'");
       // $consulta->execute();
        $c=0;
        foreach($consulta as $row){
            $lista_ventas[$c] =$row;
            $c=$c+1;
        }

      //  $this->_db->desconectar();
        return $lista_ventas;

    }

}