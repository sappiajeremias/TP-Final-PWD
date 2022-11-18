<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$obj = new abmProducto();
$list = $obj->buscar($data);
$arreglo_salida =  false;
foreach ($list as $elem){
    
    $nuevoElem['idproducto'] = $elem->getIdMenu();
    $nuevoElem["pronombre"]=$elem->getProNombre();
    $nuevoElem["prodetalle"]=$elem->getProDetalle();
    $nuevoElem["procantstock"]=$elem->getProCantStock();

    array_push($arreglo_salida,$nuevoElem);
}
//verEstructura($arreglo_salida);
echo json_encode(false);
?>