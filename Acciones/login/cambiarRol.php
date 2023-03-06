<?php
include_once "../../configuracion.php";
$data = data_submitted();
$sesion = new Session();

echo json_encode($sesion->cambiarRol($data));
?>