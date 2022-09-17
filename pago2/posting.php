<?php

require_once '../config/conexion.inc.php';
$fechahoy = date('Y-m-d h:i:s');
$banco = $_POST["banco"];
$nro_cuenta = $_POST["nro_cuenta"];
$tipo_pago = $_POST["tipo_pago"];
$nro_comprobante = $_POST["nro_comprobante"];
$nro_cheque = $_POST["nro_cheque"];
$maximo = $_POST["maximo"]+1;
$texto = "";
for($i = 1; $i <= $maximo; $i++ ){
    if(isset($_POST["seleccionar".$i])){
    ${"nro".$i} = $_POST["nro".$i];
    ${"fecha".$i} = $_POST["fecha".$i];
    ${"total".$i} = $_POST["total".$i];
    ${"deuda".$i} = $_POST["deuda".$i];
    ${"nombre".$i} = $_POST["nombre".$i];
    ${"proveedor".$i} = $_POST["proveedor".$i];
    ${"pagar".$i} = $_POST["pagar".$i];
    ${"deudas".$i} = (float)($_POST["deuda".$i] - $_POST["pagar".$i]);
    ${"deudat".$i} = number_format(${"deudas".$i},2);
    $texto = $texto ."k". $_POST["nro".$i];
    $ultimo =$db-> GetOne("SELECT tipo_pago FROM `pago` where compra_id = ${"nro".$i}");
    $nro_factura = $db-> GetOne("SELECT nro_factura FROM `pago` where compra_id = ${"nro".$i}");
    $nro_recibo = $db-> GetOne("SELECT nro_recibo FROM `pago` where compra_id = ${"nro".$i}");
    $emite_factura = $db-> GetOne("SELECT emite_factura FROM `pago` where compra_id = ${"nro".$i}");
    $recibo = $db-> GetOne("SELECT recibo FROM `pago` where compra_id = ${"nro".$i}");
    $nit = $db-> GetOne("SELECT nit FROM `pago` where compra_id = ${"nro".$i}");
    $nro_autorizacion = $db-> GetOne("SELECT nro_autorizacion FROM `pago` where compra_id = ${"nro".$i}");
    $codigo_control = $db-> GetOne("SELECT cod_control FROM `pago` where compra_id = ${"nro".$i}");
    $fecha_vencimiento = $db-> GetOne("SELECT fecha_vencimiento FROM `pago` where compra_id = ${"nro".$i}");
    if($ultimo === 'value'){
        $datos=$db -> Execute("UPDATE pago SET fecha = '$fechahoy', monto = ${"pagar".$i}, deuda = '${"deudat".$i}', banco = '$banco', nro_cuenta = '$nro_cuenta', nro_comprobante = '$nro_comprobante', nro_cheque = '$nro_cheque', tipo_pago='$tipo_pago' WHERE compra_id = ${"nro".$i}");
        $update_compra = $db->Execute("UPDATE compra c SET c.deuda = '${"deudas".$i}' WHERE  c.nro = ${"nro".$i}");
        $verify_estado = $db->Execute("SELECT * FROM compra WHERE nro = ${"nro".$i}");
        foreach($verify_estado as $r){
            $deuda = $r['deuda'];
        }
        if($deuda == 0){
            $update_estado_compra = $db->Execute("UPDATE compra c SET c.estado = 'Pagada' WHERE c.nro = ${"nro".$i}");
        }
    }else{
        $datos=$db -> Execute("INSERT INTO pago(compra_id, fecha, monto,tipo_pago,deuda,emite_factura,recibo,
            nro_recibo,nro_factura,nit, fecha_vencimiento,banco,nro_cuenta, nro_comprobante, nro_cheque,nro_autorizacion, 
            cod_control) 
            VALUES(${"nro".$i}, '$fechahoy', '${"pagar".$i}', '$tipo_pago', ${"deuda".$i}-${"pagar".$i}, '$emite_factura', 
            '$recibo', $nro_recibo,$nro_factura,$nit, '$fecha_vencimiento', '$banco', $nro_cuenta, $nro_comprobante, $nro_cheque,
            $nro_autorizacion, '$codigo_control')");   
        $update_compra = $db->Execute("UPDATE compra c SET c.deuda = '${"deudas".$i}' WHERE  c.nro = ${"nro".$i}");
        $verify_estado = $db->Execute("SELECT * FROM compra WHERE nro = ${"nro".$i}");
        foreach($verify_estado as $r){
            $deuda = $r['deuda'];
        }
        if($deuda == 0){
            $update_estado_compra = $db->Execute("UPDATE compra c SET c.estado = 'Pagada' WHERE c.nro = ${"nro".$i}");
        }  
        }   
$sacardatos = $db->GetOne( "SELECT * FROM `pago` WHERE compra_id =  ${"nro".$i}");
$query_compra = $db->Execute("SELECT c.deuda FROM compra c WHERE c.nro = ${"nro".$i}"); 
$nro_compra = ${"nro".$i};
foreach ($query_compra as $r) {
    $deuda = number_format($r['deuda'], 2);
    
}
$deudas = $db->Execute("SELECT p.*, c.estado, c.total FROM pago p INNER JOIN compra c ON  c.nro = p.compra_id  WHERE p.compra_id = $nro_compra   ORDER BY p.id_pago DESC");   }
}

echo "<script>
window.location = 'posting2.php?nro=$texto';
</script>";