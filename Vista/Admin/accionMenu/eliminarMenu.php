<?php
include_once('../../../configuracion.php');

$data = data_submitted();
$respuesta['respuesta'] = false;

if (isset($data['idmenu'])){
    $objMenu_abm = new abmMenu();
    $objMenu = $objMenu_abm->buscar($data);
    $fecha = date('Y-m-d');
   
    
    
    $arregloOBJ= 
    [
        'idmenu'=>$objMenu[0]->getID(),
        'menombre'=>$objMenu[0]->getMeNombre(),
        'medescripcion'=>$objMenu[0]->getMeDescripcion(),
        'idpadre'=>($objMenu[0]->getObjMenuPadre()->getID() !== $objMenu[0]->getID() ? $objMenu[0]->getObjMenuPadre()->getID(): 'null'),
        'medeshabilitado'=> $fecha
    ];

    if($objMenu_abm->modificacion($arregloOBJ)){
        $respuesta['respuesta']= true;
    }
    

}

echo json_encode($respuesta);

?>