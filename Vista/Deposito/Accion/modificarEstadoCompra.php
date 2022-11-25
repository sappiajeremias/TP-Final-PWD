<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$objCE = new abmCompraEstado();
$list = $objCE->buscar(['idcompraestado' => $data['idcompraestado']]);
$respuesta = false;

foreach ($list as $elem) {

    $idCET = $elem->getObjCompraEstadoTipo()->getID();
    $fechaIni = $elem->getCeFechaIni();
    $fechaFin = date('Y-m-d H:i:s');

    if ($data['idcompraestadotipo'] == 2) { // SI LA COMPRA ESTADOTIPO ES ACEPTADA, HAY QUE CAMBIAR EL STOCK
        $objCI = new abmCompraItem();
        $verificado = verficarStock($data['idcompra'], $objCI); // VERIFICA SI HAY STOCK SUFICIENTE
        if ($verificado) {
            $objCI->modificarCantidad($data['idcompra']);
        } else {
            $mensajeModStock = "No se puede modificar el stock";
        }
    }

    // ACTUALIZO EL ANTIGUO ESTADO (SETEO SU FECHAFIN CON LA DE AHORA)
    $arregloModCompra = [
        'idcompraestado' => $data['idcompraestado'],
        'idcompra' => $data['idcompra'],
        'idcompraestadotipo' => $idCET,
        'cefechaini' => $fechaIni,
        'cefechafin' => $fechaFin,
    ];

    $resp = $objCE->modificacion($arregloModCompra);

    if ($resp) { // SI SE PUDO MODIFICAR EL ESTADO ANTERIOR, AGREGAMOS EL NUEVO

        $arregloNewCompra = [
            'idcompra' => $data['idcompra'],
            'idcompraestadotipo' => $data['idcompraestadotipo'],
            'cefechaini' => $fechaFin,
            'cefechafin' => null,
        ];
        $respuesta = $objCE->altaSinID($arregloNewCompra);

        if (!$respuesta) {
            $mensajeError = "No se pudo dar de alta al compraestado";
        }
    } else {
        $mensajeModCE = "No se pudo modificar el Obj Compra Estado";
    }
}

function verficarStock($idcompra, $objCI)
{
    $list = $objCI->buscar($idcompra); // ARREGLO DE OBJETOS COMPRAITEM
    $verficador = true; // INDICARÁ SI SE PUDIERON MODIFICAR EL STOCK DE TODOS LOS PRODUCTOS
    foreach ($list as $CIactual) {
        if (!($CIactual->getObjProducto()->getProCantStock() >= $CIactual->getCiCantidad())) { // SI NOOOO HAY STOCK PARA RESTAR
            $verficador = false; //NEGAMOS
        }
    }

    return $verficador;
}

$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)) {
    echo $mensajeError;
    $retorno['mensajeError'] = $mensajeError;
}
if (isset($mensajeModStock)) {
    echo $mensajeModStock;
    $retorno['mensajeStock'] = $mensajeModStock;
}
if (isset($mensajeModCE)) {
    echo $mensajeModCE;
    $retorno['mensajeModCE'] = $mensajeModCE;
}

echo json_encode($retorno);
