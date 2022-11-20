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
            "objproducto" => $elem->getObjProducto(),
            "procantstock" => $elem->getCicantidad()
        ];
        array_push($arreglo_salida,$nuevoElem);
    }
    $respuesta['respuesta'] = $arreglo_salida;
} else {
    $respuesta['respuesta'] = 'No hay productos!';
}

echo json_encode($respuesta);

