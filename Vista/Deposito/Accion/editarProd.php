<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
if (isset($data['idproducto'])){
    $obj = new abmProducto();
    $respuesta = $obj->modificacion($data);
    if (!$respuesta){
        $sms_error = " La modificacion no pudo concretarse";
    }
    
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$sms_error;
    
}
echo json_encode($retorno);
?>