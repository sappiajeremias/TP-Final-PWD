<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$objCE = new abmCompraEstado();
$list = $objCE->buscar(['idcompraestado' => $data['idcompraestado']]);

foreach ($list as $elem) { //RECORREMOS CADA COMPRA ESTADO
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $idCET = $elem->getObjCompraEstadoTipo()->getID(); //OBTENEMOS EL ID DEL TIPO DE ESTADO
    $fechaIni = $elem->getCeFechaIni(); //FECHA INICIO
    $fechaFin = date('Y-m-d H:i:s'); //FECHA FIN
    $arregloResp = cambiarEstado($data, $idCET, $fechaIni, $fechaFin, $objCE);
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
