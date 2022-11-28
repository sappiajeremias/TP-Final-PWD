<?php

include_once '../configuracion.php';

$data = data_submitted();

$idNuevoRol = $data['nuevorol'];

$sesion = new Session();
$rolActivo = $sesion->getRolActivo();
$idRolBuscar = $sesion->buscarIdRol($idNuevoRol); // VERIFICAMOS SI EL ID ENVIADO COINCIDE CON ALGÚN ROL EXISTENTE

if($idRolBuscar<>null){ // SI EXISTE EL ROL
    if($rolActivo['id']<>$idRolBuscar){ // SI EL ROL ES DISTINTO AL YA SETEADO HACEMOS EL CAMBIO
        $sesion->setIdRolActivo($idRolBuscar); // SETEAMOS EL NUEVO ID ROL
        switch($idRolBuscar){ // SETEAMOS LA DESCRIPCION DEL NUEVO ROL
            case '1':
                $sesion->setDescripcionRolActivo('admin');
                $rolMensaje = "ADMIN";
                break;
            case '2':
                $sesion->setDescripcionRolActivo('deposito');
                $rolMensaje = "DEPOSITO";
                break;
            case '3':
                $sesion->setDescripcionRolActivo('cliente');
                $rolMensaje = "CLIENTE";
                break;
        }
    } else {
        $mensajeRolYaActivo = "Usted ya tiene activo el rol: ".strtoupper($rolActivo['rol']);
    }
} else {
    $mensajeErrorRol = "No se pudo actualizar el rol!";
}

$retorno['respuesta'] = true;

// AGREGAMOS MENSAJE DE ERRORES SI HUBIERON
if (isset($mensajeRolYaActivo)) {
    $retorno['mensajeRolYaActivo'] = $mensajeRolYaActivo;
}
if (isset($mensajeErrorRol)) {
    $retorno['mensajeErrorRol'] = $mensajeErrorRol;
}
if (count($retorno) > 1) {
    $retorno['respuesta'] = false;
}

echo json_encode($retorno);