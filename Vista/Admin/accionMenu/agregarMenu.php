<?php
include_once('../../../configuracion.php');

$datos = data_submitted();
$arreglo['respuesta'] = false;

if (isset($datos['menombre']) && isset($datos['medescripcion'])) {
  $obj_menu_abm = new abmMenu();
  $array_obj_ABMmenu = $obj_menu_abm->buscar(['medescripcion'=>$datos['medescripcion']]);
  $objPadre= $obj_menu_abm->buscar(['idpadre'=>$datos['idpadre']]);

  
  if (empty($array_obj_ABMmenu) && !empty($objPadre)) {
    if ($obj_menu_abm->alta($datos)) {
      $arreglo=darAlta($datos);
    }else{
      $arreglo['mensajeError']="No se pudo dar de alta :(";
    }
  }else{
    $arreglo['mensajeError']="Descripcion del menu existente.";
  }
}

echo json_encode($arreglo);

function darAlta($datos){
  $arrRes=[];
  $respuesta=false;
  $abmRol = new abmRol();
  $abmMenu = new abmMenu();
  $abmMenuRol = new abmMenuRol();
  $listaRol=$abmRol->buscar($datos['idrol']);
  $listaMenu=$abmMenu->buscar($datos['menombre']);

  $respuesta=$abmMenuRol->alta(['idrol'=>$listaRol[0]->getID(), 'idmenu'=>$listaMenu[0]->getID()]);
  if(!$respuesta){
    $arrRes['mensajeError']="No se pudo crear el MenuRol";
  }
  $arrRes['respuesta']=$respuesta;

  return $arrRes;
}

