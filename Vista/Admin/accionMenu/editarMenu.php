<?php

include_once('../../../configuracion.php');

$data = data_submitted();

if (isset ($data['idmenu'])){

    $objAbmMenu = new abmMenu();

    /* $objMenu = $objAbmMenu->buscar(['idmenu'=>$data['idmenu']]); */

    $arraOBJ =[
        'idmenu'=>$data['idmenu'],
        'menombre'=>$data['menombre'],
        'medescripcion'=>$data['medescripcion'],
        'medeshabilitado'=>$data['medeshabilitado'],
        'idpadre'=>$data['idpadre']
    ];

    $respuesta = $objAbmMenu->modificacion($arraOBJ);
    if (!$respuesta) {
        $sms_error = " La modificacion no pudo concretarse";
    }

   
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {

    $retorno['errorMsg'] = $sms_error;
}
 echo json_encode($retorno);

?>



