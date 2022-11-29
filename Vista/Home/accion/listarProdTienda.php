<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$arreglo_salida=[];
$abmProducto = new abmProducto();
$listaProductos = $abmProducto->buscarConStock();

if (count($listaProductos)>0) {
    foreach ($listaProductos as $producto) {
        //Para cada producto me fijo que no este deshabilitado
        if($producto->getProDeshabilitado()==null || $producto->getProDeshabilitado()=='0000-00-00 00:00:00'){
            $nuevoElem = [
                "idproducto" => $producto->getID(),
                "pronombre"=> $producto->getProNombre(),
                "prodetalle"=> $producto->getProDetalle(),
                "procantstock"=>$producto->getProCantStock(),
                "precio"=>$producto->getPrecio()
            ];

            array_push($arreglo_salida, $nuevoElem);

        }  
        
    }
    $respuesta['respuesta'] = $arreglo_salida;
} else {
    $respuesta['respuesta'] = $listaProductos;
}

echo json_encode($respuesta);
