<?php

include_once "../../configuracion.php";
$data = data_submitted();
$objCE = new abmCompraEstado();

echo json_encode($objCE->modificarEstado($data));
?>