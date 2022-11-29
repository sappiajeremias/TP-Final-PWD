<?php

include_once '../../../configuracion.php';

$respuesta = false;
$data = data_submitted();

if (!empty($data)) {
    $sesion = new Session();
    $usuario = new abmUsuario();

    $psw =  md5($data['uspass']); // CIFRAMOS LA CONTRASEÑA RECIBIDA

    $objUsuario = $usuario->buscar(['usnombre' => $data['usnombre']]); //BUSCAMOS AL USUARIO

    if ($objUsuario <> null) { // SI LO ENCUENTRA

        $objUsuario[0]->cargar(); //LO CARGAMOS

        if ($objUsuario[0]->getUsDeshabilitado() === null || $objUsuario[0]->getUsDeshabilitado() === '0000-00-00 00:00:00') { //VERIFICAMOS SI EL USUARIO ESTA HABILITADO

            if (!$sesion->sesionActiva() && (compararPsw($data['usnombre'], $psw))) { //VERIFICAMOS QUE LA CONTRASEÑA HAYA SIDO INGRESADA CORRECTAMENTE
                $respuesta = $sesion->iniciar($data['usnombre'], $psw); //INICAMOS SESIÓN
            } else {
                $mensajePass = "Usuario o contraseña incorrecta!";
            }
        } else {
            $mensajeUsDes = "Usuario Deshabilitado!";
        }

        if ($respuesta) {
            $sesion->setearRolActivo();
        } else {
            $mensajeSesion = "Algo salió mal en el inicio de sesión :(";
        }
    } else {
        $mensajeUsExist = "El usuario no existe";
    }
} else {
    $mensajeDatos = "Datos de usuario y contraseña no recibidos";
}


$retorno['respuesta'] = true;

// AGREGAMOS MENSAJE DE ERRORES SI HUBIERON
if (isset($mensajeDatos)) {
    $retorno['mensajeDatos'] = $mensajeDatos;
}
if (isset($mensajePass)) {
    $retorno['mensajePass'] = $mensajePass;
}
if (isset($mensajeUsDes)) {
    $retorno['mensajeUsDes'] = $mensajeUsDes;
}
if (isset($mensajeSesion)) {
    $retorno['mensajeSesion'] = $mensajeSesion;
}
if (isset($mensajeUsExist)) {
    $retorno['mensajeUsExist'] = $mensajeUsExist;
}
if (count($retorno) > 1) {
    $retorno['respuesta'] = false;
}


echo json_encode($retorno);
