<?php
include_once '../../../configuracion.php';
$respuesta = false;
$data = data_submitted();
$sesion = new Session();

if (!$sesion->sesionActiva()){
    $respuesta = $sesion->iniciar($data['usnombre'], $data['uspass']);
}

echo json_encode($respuesta);
?>