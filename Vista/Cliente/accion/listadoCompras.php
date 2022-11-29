<?php
include_once "../../../configuracion.php";
$data = data_submitted();

$respuesta = false;
$session = new Session();
$objItems = new abmCompra();
$listaCompras = $objItems->buscar(['idusuario' => $session->getIDUsuarioLogueado()]);
if (count($listaCompras) > 0) {
    $arreglo_salida =  [];
    foreach ($listaCompras as $elem) {
        $objCE = new abmCompraEstado;
        $listaCE = $objCE->buscar(['idcompra' => $elem->getID()]);
        //RECORREMOS EL LISTADO DE COMPRAS ESTADO
        foreach ($listaCE as $compraActual) {

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
