<?php
/*
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta=false;
$obj = new abmCompraItem();
$respuesta = $obj->modificacion($data);
if (!$respuesta){
        $mensajeError = "No se pudo eliminar al producto";
}


$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
   
    $retorno['mensajeError']=$mensajeError;

}
    echo json_encode($retorno);
*/

    
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = true;
$obj = new abmCompraItem();
$objProducto = new abmProducto();
$listaProd = $objProducto->buscar(['idproducto' => $datos['idproducto']]);
if (count($listaProd)>0) {
    $cantStockPro = $listaProd[0]->getProCantStock();
    if ($datos['cicantidad'] > $cantStockPro) {
        $mensajeError = "El stock de este producto es " . $cantStockPro . ".Proba ingresando un valor valido";
        $respuesta = false;
    } else if ($datos['cicantidad'] < 1) {
        $mensajeError = "El valor minimo de un producto es 1. Ingresa un valor mayor o igual a 1.";
        $respuesta = false;
    } else {
        $respuesta = $obj->modificacion($data);
        if (!$respuesta) {
            $mensajeError = "No se pudo modificar la cantidad del producto";
            $respuesta = false;
        }
    }
} else {
    $mensajeError = "No se pudo modificar la cantidad del producto";
    $respuesta = false;
}
$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)) {
    $retorno['mensajeError'] = $mensajeError;
}
echo json_encode($retorno); 
?>