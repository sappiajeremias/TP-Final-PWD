<?php
include_once "../../../../configuracion.php";
$data = data_submitted();
$obj = new abmProducto();
echo json_encode($obj->baja($data));
?>