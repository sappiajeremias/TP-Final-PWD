<?php
include_once "../../../../configuracion.php";
$data = data_submitted();
$objCE = new abmCompraEstado();
$list = $objCE->buscar(['idcompraestado' => $data['idcompraestado']]);

foreach ($list as $elem) { //RECORREMOS CADA COMPRA ESTADO

    $idCET = $elem->getObjCompraEstadoTipo()->getID(); //OBTENEMOS EL ID DEL TIPO DE ESTADO
    $fechaIni = $elem->getCeFechaIni(); //FECHA INICIO
    $fechaFin = date('Y-m-d H:i:s'); //FECHA FIN

    if ($data['idcompraestadotipo'] == 2) { // SI EL ESTADOTIPO ES ACEPTADA, HAY QUE VERIFICAR SI SE PUEDE CAMBIAR EL STOCK
        $objCI = new abmCompraItem();
        $verificado = verficarStock($data['idcompra'], $objCI); // VERIFICA SI HAY STOCK SUFICIENTE
        if ($verificado) { // SI HAY MODIFICAMOS LA CANTIDAD DE LOS PRODUCTOS Y FINALMENTE SETEAMOS EL NUEVO COMPRAESTADO
            $objCI->modificarCantidad($data['idcompra']);
            $arregloResp = cambiarEstado($data, $idCET, $fechaIni, $fechaFin, $objCE);
        } else {
            $mensajeModStock = "No se puede modificar el stock";
        }
    } else { // SI NO ES ESTADOTIPO ACEPTADA SIMPLEMENTE CAMBIAMOS DE ESTADO
        $arregloResp = cambiarEstado($data, $idCET, $fechaIni, $fechaFin, $objCE);
    }
}

$retorno['respuesta'] = true;

// AGREGAMOS MENSAJE DE ERRORES SI HUBIERON
if (isset($mensajeModStock)) {
    $retorno['mensajeStock'] = $mensajeModStock;
}
if (isset($arregloResp['mensajeAlta'])) {
    $retorno['mensajeAlta'] = $arregloResp['mensajeAlta'];
}
if (isset($arregloResp['mensajeModCE'])) {
    $retorno['mensajeModCE'] = $arregloResp['mensajeModCE'];
}
if (count($retorno)>1) {
    $retorno['respuesta'] = false;
}

echo json_encode($retorno);

function verficarStock($idcompra, $objCI)
{
    $list = $objCI->buscar(['idcompra' => $idcompra]); // ARREGLO DE OBJETOS COMPRAITEM
    $verficador = true; // INDICARÁ SI SE PUDIERON MODIFICAR EL STOCK DE TODOS LOS PRODUCTOS
    foreach ($list as $CIactual) {
        if (!($CIactual->getObjProducto()->getProCantStock() >= $CIactual->getCiCantidad())) { // SI NOOOO HAY STOCK PARA RESTAR
            $verficador = false; //NEGAMOS
        }
    }

    return $verficador;
}


function cambiarEstado($data, $idCET, $fechaIni, $fechaFin, $objCE)
{
    $arregloResp = [];

    // PRIMERO ACTUALIZAMOS EL ANTIGUO ESTADO, SETEAMOS SU FECHA FIN
    $arregloModCompra = [
        'idcompraestado' => $data['idcompraestado'],
        'idcompra' => $data['idcompra'],
        'idcompraestadotipo' => $idCET,
        'cefechaini' => $fechaIni,
        'cefechafin' => $fechaFin,
    ];

    // MODIFICAMOS
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
            $mensajeAlta = "No se pudo dar de alta el nuevo compraestado";
            $arregloResp['mensajeAlta'] = $mensajeAlta;
        }
    } else {
        $mensajeModCE = "No se pudo modificar el antiguo compraestado";
        $arregloResp['mensajeModCE'] = $mensajeModCE;
    }

    return $arregloResp;
}
