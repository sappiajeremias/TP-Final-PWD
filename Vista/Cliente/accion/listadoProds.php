<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$obj = new abmCompraItem();
$respuesta=false;
$list = $obj->buscar($data);
if (count($list) > 0){
    $arreglo_salida =  [];
    foreach ($list as $elem){
        
        $nuevoElem = [
            "pronombre" => $elem->getObjProducto()->getProNombre(),
            "prodetalle" => $elem->getObjProducto()->getProDetalle(),
            "precio" => $elem->getObjProducto()->getPrecio(),
            "procantstock" => $elem->getCicantidad(),
            "imagen" => $elem->getObjProducto()->getImagen()
        ];
        array_push($arreglo_salida,$nuevoElem);
    }
    $respuesta['respuesta'] = $arreglo_salida;
} else {
    $respuesta['respuesta'] = 'No hay productos!';
}

echo json_encode($respuesta);

