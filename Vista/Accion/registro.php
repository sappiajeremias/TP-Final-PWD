<?php
include_once "../../configuracion.php";

$datos = data_submitted();
$abmUsuario = new abmUsuario();
$resultado = $abmUsuario->alta($datos);

if ($resultado) {
    $mensaje = "El registro fue exitoso!";
    header('Location:../Home/index.php?mensaje='.urlencode($mensaje));
} else {
    $mensaje = "Algo salió mal en el registro";
    header('Location:../Home/index.php?mensaje='.urlencode($mensaje));
}
