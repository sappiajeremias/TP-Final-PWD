<?php
include_once "../../configuracion.php";
$data = data_submitted();
$obj = new abmCompraItem();
 
echo json_encode($obj->baja($data));

?>