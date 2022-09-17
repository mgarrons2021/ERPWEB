<?php

$maximo = $_POST["maximo"];

for($i = 1; $i <= 2; $i++ ){

    ${"nro".$i} = $_POST["nro".$i];
    ${"fecha".$i} = $_POST["fecha".$i];
    ${"total".$i} = $_POST["total".$i];
    ${"deuda".$i} = $_POST["deuda".$i];
    ${"nombre".$i} = $_POST["nombre".$i];
    ${"proveedor".$i} = $_POST["proveedor".$i];
    ${"pagar".$i} = $_POST["pagar".$i];



}

?>