<?php
include_once '../../../configuracion.php';
$sesion = new Session();

echo json_encode($sesion->traerMenu());