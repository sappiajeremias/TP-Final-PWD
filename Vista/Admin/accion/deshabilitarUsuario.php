<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
if (!empty($data)) {
    $obj = new abmUsuario();
    $objUs = $obj->buscar(['idusuario' => $data['idusuario']]);

    $fecha = null;
    if ($data['accion'] == "deshabilitar") {
        $fecha = date('Y-m-d H:i:s');
    }
    $objUs[0]->setUsdeshabilitado($fecha);
    $respuesta = $objUs[0]->modificar();

    if (!$respuesta) {
        $mensajeError = "No se pudo deshabilitar al usuario";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)) {

    $retorno['mensajeError'] = $mensajeError;
}
echo json_encode($retorno);
