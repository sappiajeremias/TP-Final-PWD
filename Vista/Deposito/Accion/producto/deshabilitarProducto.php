<?php
include_once "../../../../configuracion.php";
$data = data_submitted();
$respuesta=false;
if (!empty($data)){
    $obj = new abmProducto();

    $fecha = date('Y-m-d H:i:s');

    $objPro = $obj->buscar(['idproducto'=>$data['idproducto']]);

    if (!$respuesta){
        $mensajeError = "No se pudo deshabilitar al producto";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
   
    $retorno['mensajeError']=$mensajeError;

}
echo json_encode($retorno);
?>