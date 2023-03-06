<?php
include_once "../../configuracion.php";
$obj = new abmMenu();
echo json_encode($obj->armarMenu());
?>