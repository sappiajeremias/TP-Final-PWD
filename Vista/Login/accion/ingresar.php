<?php

include_once '../../../configuracion.php';

$respuesta = false;
$data = data_submitted();

if (!empty($data)) {
    //Se fija si hay datos ingresados
    $sesion = new Session();
    $usuario = new abmUsuario();

    $psw =  md5($data['uspass']);
    $objUsuario = $usuario->buscar(['usnombre' => $data['usnombre'], 'uspass'=>$psw]);
    $objUsuario[0]->cargar();
    if ($objUsuario[0]->getUsDeshabilitado()===null ||$objUsuario[0]->getUsDeshabilitado()==='0000-00-00 00:00:00') {
        if (!$sesion->sesionActiva() && (compararPsw($data['usnombre'], $psw))) {
            $respuesta = $sesion->iniciar($data['usnombre'], $psw);
        }
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
echo "<script> window.location.href='../../Home/index.php?mensaje=" . urlencode($mensaje) . "'</script>";
