<?php
include_once "../../../configuracion.php";
$data = data_submitted();

$session = new Session();
$objItems = new abmCompra();
$listaCompras = $objItems->buscar(['idusuario'=>$session->getIDUsuarioLogueado()]);
$objAbmCI = new abmCompraItem();

$abmUser= new abmUsuario();
$carrito= $abmUser->obtenerCarrito($session->getIDUsuarioLogueado());

if ($carrito <> null) {
    $objCI= new abmCompraItem();
    $arreglo_salida = [];
    $eltosCarrito = $objAbmCI->buscar(['idcompra'=> $carrito->getID()]);

    //Recorremos los compraItem del carrito
    foreach ($eltosCarrito as $compraItem) {
            $cant=$compraItem->getCiCantidad();
            $precio=$compraItem->getObjProducto()->getPrecio();
            $nuevoElem = [
                "idcompraitem" => $compraItem->getID(),
                "idproducto"=> $compraItem->getObjProducto()->getID(),
                "idcompra"=> $compraItem->getObjCompra()->getID(),
                "imagen"=>$compraItem->getObjProducto()->getImagen(),
                "detalle"=>$compraItem->getObjProducto()->getProDetalle(),
                "pronombre" => $compraItem->getObjProducto()->getProNombre(),
                "precio" => $precio,
                "cicantidad" => $cant,
                "procantstock"=>$compraItem->getObjProducto()->getProCantStock(),
                "subtotal" => ($cant*$precio)
            ];

            array_push($arreglo_salida, $nuevoElem);
        
    }
    $respuesta['respuesta'] = $arreglo_salida;
} else {
    $respuesta['respuesta'] = $carrito;
}

echo json_encode($respuesta);
