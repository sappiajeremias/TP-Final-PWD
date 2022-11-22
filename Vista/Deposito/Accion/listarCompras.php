<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$obj = new abmCompra();
$respuesta=false;
$list = $obj->buscar($data);
if (count($list) > 0){
    $arreglo_salida =  [];
    $obj = new abmCompraEstado;
    foreach ($list as $elem){
        $estadosElem = $obj->buscar($elem->getID());

        $estadoDescripcion = null;

        // Obtenemos el último estado de la compra
        foreach($estadosElem as $estadoActual){
            if($estadoActual->getCeFechaFin() == null){
                $estadoDescripcion = $estadoActual->getObjCompraEstadoTipo()->getCetDescripcion();
            }
            $fechaFin = $estadoActual->getCeFechaFin();
        }
        
        $nuevoElem = [
            "idcompra" => $elem->getID(),
            "cofecha" => $elem->getCofecha(),
            "finfecha" =>$fechaFin,
            "usnombre" => $elem->getObjUsuario()->getUsNombre(),
            "estado" => $estadoDescripcion
        ];
        array_push($arreglo_salida,$nuevoElem);
    }
    $respuesta['respuesta'] = $arreglo_salida;
} else {
    $respuesta['respuesta'] = 'No hay Compras!';
}

echo json_encode($respuesta);
