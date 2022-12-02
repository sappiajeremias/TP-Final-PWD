<?php
include_once '../../../configuracion.php';
$respuesta = false;
$data = data_submitted();
$sesion = new Session();

if (!$sesion->sesionActiva()){
    $respuesta = $sesion->iniciar($data['usnombre'], $data['uspass']);
}

if ($respuesta) {
    $rolesUs = $sesion->getRoles();
    if (count($rolesUs) > 0) {
        $sesion->setearRolActivo();
    }
}

echo json_encode($respuesta);
