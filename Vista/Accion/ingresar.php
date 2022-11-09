<?php
include_once '../Estructura/cabecera.php';

$data = data_submitted();
$sesion = new Session();
$respuesta = $sesion->iniciar($data['usnombre'], $data['uspass']);
if ($respuesta){
    $mensaje = "Se inició sesión exitosamente!";
    header('Location:../Home/index.php?mensaje='.urlencode($mensaje));
} else {
    $mensaje = "Algo salió mal en el inicio de sesión :(";
    header('Location:../Home/index.php?mensaje='.urlencode($mensaje));
}
?>