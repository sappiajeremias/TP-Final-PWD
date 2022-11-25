<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$objCE = new abmCompraEstado;
$respuesta = false;
$session = new Session();
$objItems = new abmCompra();
$listaCompras = $objItems->buscar(['idusuario'=>$_SESSION['idusuario']]);


$listaCE = $objCE->buscar(['idcompra'=>$listaCompras[0]->getID()]);
if (count($listaCE) > 0) {
    $arreglo_salida =  [];

    //RECORREMOS EL LISTADO DE COMPRAS ESTADO
    foreach ($listaCE as $compraActual) {

        // SI NO ES UN CARRITO LO SUMAMOS AL ARREGLO
        if (!($compraActual->getObjCompraEstadoTipo()->getCetDescripcion() === "carrito")) {

            $nuevoElem = [
                "idcompra" => $compraActual->getObjCompra()->getID(),
                "cofecha" => $compraActual->getCeFechaIni(),
                "finfecha" => $compraActual->getCeFechaFin(),
                "usnombre" => $compraActual->getObjCompra()->getObjUsuario()->getUsNombre(),
                "estado" => $compraActual->getObjCompraEstadoTipo()->getCetDescripcion(),
                "idcompraestado" => $compraActual->getID()
            ];
            array_push($arreglo_salida, $nuevoElem);
        }
    }
    $respuesta['respuesta'] = $arreglo_salida;
} else {
    $respuesta['respuesta'] = 'No hay Compras!';
}

echo json_encode($respuesta);
