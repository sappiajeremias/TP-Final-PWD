<?php
include_once '../Estructura/cabecera.php';

$data = data_submitted();
$sesion = new Session();
$respuesta = $sesion->iniciar($data['usnombre'], $data['uspass']);


if ($respuesta){
    header("Location:../Home/index.php");
} else {
    header("Location:../Home/index.php?mensaje=true");
}
?>