<?php
include_once '../../configuracion.php';
$data = data_submitted();
$sesion = new Session();
$sesion->iniciar($data['usnombre'], $data['uspass']);
header("Location:../Home/index.php");
?>