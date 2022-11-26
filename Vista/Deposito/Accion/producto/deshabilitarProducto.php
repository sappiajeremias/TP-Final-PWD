<?php
include_once "../../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
if (!empty($data)) {
    $obj = new abmProducto();
    $objPro = $obj->buscar(['idproducto' => $data['idproducto']]);

    $fecha = null;
    if ($data['accion'] == "deshabilitar") {
        $fecha = date('Y-m-d H:i:s');
    }
    $objPro[0]->setProDeshabilitado($fecha);
    $respuesta = $objPro[0]->modificar();

    if (!$respuesta) {
        $mensajeError = "No se pudo deshabilitar al producto";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)) {

    $retorno['mensajeError'] = $mensajeError;
}
echo json_encode($retorno);
