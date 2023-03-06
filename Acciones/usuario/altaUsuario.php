<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$obj = new abmUsuario();

 echo json_encode($obj->crearUsuario($data));


