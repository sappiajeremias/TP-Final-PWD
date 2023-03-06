<?php
include_once "../../configuracion.php";
$data = data_submitted();
$objControl = new abmUsuario();

echo json_encode($objControl->listarUsuarios($data));
?>