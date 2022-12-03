<?php

include_once('../../../configuracion.php');

$data = data_submitted();
$respuesta=false;
if (isset($data['idmenu'])) {
    $objMenu = new abmMenu();
   if ($objMenu->modificacion($data) ){
        $respuesta=true;
    }
} else {
    $sms_error = "No llegaron datos";
}




$retorno['respuesta'] = $respuesta;
if (isset($sms_error)) {
    $retorno['errorMsg'] = $sms_error;
}

echo json_encode($retorno);
