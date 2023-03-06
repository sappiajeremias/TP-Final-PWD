<?php
include_once "../../configuracion.php";
$datos = data_submitted();
$abmUsuario = new abmUsuario();

echo json_encode($abmUsuario->crearUsuario($datos));
?>