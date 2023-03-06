<?php
include_once "../../configuracion.php";
$data = data_submitted();
$obj = new abmUsuario();
$respuesta = $obj->modificacion($data);
if ($respuesta){
    $session = new Session();
    $session->cerrar();
}
echo json_encode($respuesta);
?>