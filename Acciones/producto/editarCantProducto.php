<?php
include_once "../../configuracion.php";
$data = data_submitted();
$respuesta=false;
$objCI = new abmCompraItem();

echo json_encode($objCI->modificacion($data));

?>