<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$data['files'] = $_FILES;
$obj = new abmProducto();
echo json_encode($obj->altaSinID($data));
?>