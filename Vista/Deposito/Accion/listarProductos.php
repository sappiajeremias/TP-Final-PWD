<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$obj = new abmProducto();
$respuesta=false;
$list = $obj->buscar($data);
if (count($list) > 0){
    $arreglo_salida =  [];
    foreach ($list as $elem){
        
        $nuevoElem = [
            "idproducto" => $elem->getID(),
            "pronombre" => $elem->getProNombre(),
            "prodetalle" => $elem->getProDetalle(),
            "procantstock" => $elem->getProCantStock()
        ];
        array_push($arreglo_salida,$nuevoElem);
    }
    $respuesta['respuesta'] = $arreglo_salida;
} else {
    $respuesta['respuesta'] = 'No hay productos!';
}
//verEstructura($arreglo_salida);

echo json_encode($respuesta);

