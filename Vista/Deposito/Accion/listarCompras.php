<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$objC = new abmCompra();
$respuesta=false;
$listaCompras = $objC->buscar($data);
if (count($listaCompras) > 0){
    $arreglo_salida =  [];
    $objCE = new abmCompraEstado;

    //RECORREMOS EL LISTADO DE COMPRAS
    foreach ($listaCompras as $compraActual){
        //BUSCAMOS LOS ESTADOS POR LA COMPRA ACTUAL
        $estadosElem = $objCE->buscar(["idcompra" => $compraActual->getID()]);
        $estadoDescripcion = null;

        // OBTENEMOS EL ÚLTIMO ESTADO DE LA COMPRA Y EL ID DE COMPRAESTADO
        foreach($estadosElem as $estadoActual){
            $fechaFin = $estadoActual->getCeFechaFin();
            if($fechaFin == null || $fechaFin == ""){
                $estadoDescripcion = $estadoActual->getObjCompraEstadoTipo()->getCetDescripcion();
                $idEstadoActual = $estadoActual->getID();
            }
        }
        
        $nuevoElem = [
            "idcompra" => $compraActual->getID(),
            "cofecha" => $compraActual->getCofecha(),
            "finfecha" =>$fechaFin,
            "usnombre" => $compraActual->getObjUsuario()->getUsNombre(),
            "estado" => $estadoDescripcion,
            "idcompraestado" => $idEstadoActual
        ];
        array_push($arreglo_salida,$nuevoElem);
    }
    $respuesta['respuesta'] = $arreglo_salida;
} else {
    $respuesta['respuesta'] = 'No hay Compras!';
}

echo json_encode($respuesta);
