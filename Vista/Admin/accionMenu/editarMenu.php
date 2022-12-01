<?php

include_once('../../../configuracion.php');

$data = data_submitted();

if (isset($data['idrol']) && isset($data['idmenu'])) {

    $objMenuRol = new abmMenuRol();

    $busqueda = $objMenuRol->buscar(['idmenu'=>$data['idmenu']]);

    $idRol = $busqueda[0]->getObjRol()->getID();

    $bajaMR = $objMenuRol->baja(['idmenu'=>$data['idmenu'], 'idrol'=>$idRol]);

    if ($bajaMR){
        $altaMR = $objMenuRol->alta(['idmenu'=>$data['idmenu'], 'idrol'=>$data['idrol']]);
    } else {
        $altaMR = false;
    }

    if ($altaMR) {
        $arraOBJ = [
            'idmenu' => $data['idmenu'],
            'menombre' => $data['menombre'],
            'medescripcion' => $data['medescripcion'],
            'medeshabilitado' => $data['medeshabilitado'],
            'idpadre' => $data['idpadre']
        ];

        $objAbmMenu = new abmMenu();
        $respuesta = $objAbmMenu->modificacion($arraOBJ);
        if (!$respuesta) {
            $sms_error = " La modificacion no pudo concretarse";
        }
    } else {
        $sms_error = "La relacion con rol no pudo concretarse.";
    }
} else {
    $sms_error = "No llegaron datos";
}




$retorno['respuesta'] = $respuesta;
if (isset($sms_error)) {
    $retorno['errorMsg'] = $sms_error;
}

echo json_encode($retorno);
