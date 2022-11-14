<?php
include_once '../../configuracion.php';

$respuesta = false;
$data = data_submitted();

if (!empty($data)) {
//Se fija si hay datos ingresados
    $psw =  md5($data['uspass']);
    if (!(isset($_SESSION['usnombre'])) && (compararPsw($data['usnombre'], $psw))) {
        $sesion = new Session();
        $respuesta = $sesion->iniciar($data['usnombre'], $psw);
    }

    if ($respuesta) {
        $sesion->setearRolActivo();
        $mensaje = "Se inició sesión exitosamente!";
    } else {
        $mensaje = "Algo salió mal en el inicio de sesión :(";
    }
} else {
    //Si no hay datos ingresados muestra el cartel y redirecciona
    $mensaje = "Datos de usuario y contraseña no recibidos";
}
echo "<script> window.location.href='../Home/index.php?mensaje=" . urlencode($mensaje) . "'</script>";
