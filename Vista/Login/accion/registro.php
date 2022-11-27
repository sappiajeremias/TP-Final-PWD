<?php
include_once '../../../configuracion.php';

$datos = data_submitted();

if (!empty($datos)) {
    $abmUsuario = new abmUsuario();

    $datos['uspass'] = md5($datos['uspass']); //CIFRAMOS LA CONTRASEÑA

    $listUser = $abmUsuario->buscar(null);

    $verficador = true;
    foreach ($listUser as $userActual) { //RECORREMOS LOS USUARIOS
        if ($userActual->getUsMail() == $datos['usmail']) { //SI EL EMAIL YA EXISTE
            $mensajeUsMail = "El correo ingresado ya está en uso";
            $verficador = false;
        } else if ($userActual->getUsNombre() == $datos['usnombre']) { //SI EL NOMBRE DE USUARIO YA EXISTE
            $mensajeUsName = "El nombre de usuario ingresado ya está en uso";
            $verficador = false;
        }
    }

    if ($verficador) {
        if ($datos['usnombre'] !== null && $abmUsuario->alta($datos)) {
            $objUser = $abmUsuario->buscar(['usnombre' => $datos['usnombre']]);
            $parametro = ['idusuario' => $objUser[0]->getID(), 'idrol' => 3];
            $altaRol = $abmUsuario->alta_rol($parametro);

            if (!$altaRol) {
                $mensajeRol = "Hubo un error al crear el usuarioRol";
            }

        } else {
            $mensajeRegistro = "Algo salió mal en el registro";
        }
    }
} else {
    $mensajeDatos = "Datos no recibidos";
}

$retorno['respuesta'] = true;

// AGREGAMOS MENSAJE DE ERRORES SI HUBIERON
if (isset($mensajeDatos)) {
    $retorno['mensajeDatos'] = $mensajeDatos;
}
if (isset($mensajeUsMail)) {
    $retorno['mensajeUsMail'] = $mensajeUsMail;
}
if (isset($mensajeUsName)) {
    $retorno['mensajeUsName'] = $mensajeUsName;
}
if (isset($mensajeRol)) {
    $retorno['mensajeRol'] = $mensajeRol;
}
if (isset($mensajeRegistro)) {
    $retorno['mensajeRegistro'] = $mensajeRegistro;
}
if (count($retorno) > 1) {
    $retorno['respuesta'] = false;
}

echo json_encode($retorno);
