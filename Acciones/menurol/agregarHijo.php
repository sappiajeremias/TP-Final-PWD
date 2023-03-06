<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$obj = new abmMenu();
echo json_encode($obj->alta($data));
?>
