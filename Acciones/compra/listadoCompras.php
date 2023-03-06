<?php
include_once "../../configuracion.php";
$abmUsuario= new abmUsuario();
$session = new Session();
$idUsuario=$session->getIDUsuarioLogueado();
echo json_encode($abmUsuario->listarCompras($idUsuario));
?>
