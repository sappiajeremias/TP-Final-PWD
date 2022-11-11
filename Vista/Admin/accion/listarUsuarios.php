<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$objControl = new abmUsuario();
$list = $objControl->buscar($data);
$arreglo_salida =  array();
foreach ($list as $elem ){
    
    $nuevoElem['idusuario'] = $elem->getIdMenu();
    $nuevoElem['usnombre']=$elem->getUsNombre();
    $nuevoElem['usmail']=$elem->getUsMail();
    $nuevoElem['usdeshabilitado']=$elem->getUsDeshabilitado();
    array_push($arreglo_salida,$nuevoElem);
    
}
//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida);

?>