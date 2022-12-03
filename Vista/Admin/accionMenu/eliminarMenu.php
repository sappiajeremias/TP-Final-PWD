<?php
include_once('../../../configuracion.php');

$data = data_submitted();
$respuesta['respuesta'] = false;

if (isset($data['idmenu'])){
    $objMenu_abm = new abmMenu();
    //$objMenu = $objMenu_abm->buscar($data);
    if ($objMenu_abm->bajaHabilitacion($data)){
        $respuesta['respuesta']= true;
    }
    echo json_encode($respuesta);

    
    
 /*    $arregloOBJ= 
    [
        'idmenu'=>$objMenu[0]->getID(),
        'menombre'=>$objMenu[0]->getMeNombre(),
        'medescripcion'=>$objMenu[0]->getMeDescripcion(),
        'idpadre'=>($objMenu[0]->getObjMenuPadre()->getID() !== $objMenu[0]->getID() ? $objMenu[0]->getObjMenuPadre()->getID(): 'null'),
        'medeshabilitado'=> $fecha
    ];
 */
    /* if($objMenu_abm->modificacion($data)){
        $respuesta['respuesta']= true;
    } */
    

}


?>