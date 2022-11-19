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
            "idproducto" => $elem->getIdMenu(),
            "pronombre" => $elem->getProNombre(),
            "prodetalle" => $elem->getProDetalle(),
            "procantstock" => $elem->getProCantStock()
        ];
        array_push($arreglo_salida,$nuevoElem);
    }
    $respuesta['respuesta'] = 'sexo';
} else {
    $respuesta['respuesta'] = 'mondongo';
}
//verEstructura($arreglo_salida);

echo json_encode($retorno);

