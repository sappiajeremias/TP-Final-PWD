<?php

include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
$objCI = new abmCompraItem();
$listaCI = $objCI->buscar(['idcompra' => $data['idcompra']]);
if (count($listaCI) > 0) {
    foreach ($listaCI as $compraItem) {
        $objCI->baja(['idcompraitem' => $compraItem->getID()]);
    }
    $respuesta = true;
} else {
    $mensajeError = "No se pudo vaciar el carrito";
}


$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)) {

    $retorno['mensajeError'] = $mensajeError;
}
echo json_encode($retorno);
