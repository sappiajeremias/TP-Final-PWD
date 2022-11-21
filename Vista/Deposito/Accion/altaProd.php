<?php 
include_once "../../../configuracion.php";
$data = data_submitted();

$respuesta = false;
if (isset($data['pronombre'])){
        $obj = new abmProducto();
        $respuesta = $obj->altaSinID($data);
        
        if (!$respuesta){
            $sms_error = " La accion de crear no pudo concretarse";
            
        }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$sms_error;
   
}
 echo json_encode($retorno);
?>