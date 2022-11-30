<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$arreglo_salida=[];
$abmSession = new Session();
$abmProducto = new abmProducto();
$listaProductos = $abmProducto->buscarConStock();
$rolActivo = $abmSession->getRolActivo();

if (count($listaProductos)>0) {
    foreach ($listaProductos as $producto) {
        //Para cada producto me fijo que no este deshabilitado
        if($producto->getProDeshabilitado()==null || $producto->getProDeshabilitado()=='0000-00-00 00:00:00'){
            $nuevoElem = [
                "idproducto" => $producto->getID(),
                "imagen"=> $producto->getImagen(),
                "pronombre"=> $producto->getProNombre(),
                "prodetalle"=> $producto->getProDetalle(),
                "procantstock"=>$producto->getProCantStock(),
                "precio"=>$producto->getPrecio(),
                "prodeshabilitado"=>$producto->getProDeshabilitado(),
                "rol"=>null
            ];

            if(isset($rolActivo['rol'])){
                $nuevoElem['rol']=$rolActivo['rol'];
            }

            array_push($arreglo_salida, $nuevoElem);

        }  
        
    }
    $respuesta['respuesta'] = $arreglo_salida;
} else {
    $respuesta['respuesta'] = $listaProductos;
}

echo json_encode($respuesta);
