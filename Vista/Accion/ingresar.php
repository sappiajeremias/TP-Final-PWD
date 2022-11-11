<?php

include_once '../Estructura/cabecera.php';

$data = data_submitted();
$psw =  md5($data['uspass']);


if (!(isset($_SESSION['usnombre'])) && (compararPsw($data['usnombre'], $psw))) {
    $sesion = new Session();
    $respuesta = $sesion->iniciar($data['usnombre'],$psw);
}

if ($respuesta) {
    $sesion->setearRolActivo();
    $mensaje = "Se inició sesión exitosamente!";
    header('Location:../Home/index.php?mensaje='.urlencode($mensaje));
} else {
    $mensaje = "Algo salió mal en el inicio de sesión :(";
    header('Location:../Home/index.php?mensaje='.urlencode($mensaje));
}
