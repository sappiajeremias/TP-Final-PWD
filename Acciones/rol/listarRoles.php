<?php
include_once "../../configuracion.php";
$data = data_submitted();
$objControl = new abmRol();

echo json_encode($objControl->listarRoles($data));
?>