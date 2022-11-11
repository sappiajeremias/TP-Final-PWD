<?php

include_once '../Estructura/cabecera.php';

$data = data_submitted();
$psw =  md5($data['uspass']);


if (!(isset($_SESSION['usnombre'])) && (compararPsw($data['usnombre'], $psw))) {
    $respuesta = $sesion->iniciar($data['usnombre'],$psw);
}

if ($respuesta) {
    $sesion->setearRolActivo();
    $mensaje = "Se inició sesión exitosamente!";
} else {
    $mensaje = "Algo salió mal en el inicio de sesión :(";
}

echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";