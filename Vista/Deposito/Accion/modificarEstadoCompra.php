<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$objCE = new abmCompraEstado();
$obj = $objCE->buscar(['idcompraestado' => $data['idcompraestado']]);
$respuesta = false;

foreach ($obj as $elem) {
    
    $idCET = $elem->getObjCompraEstadoTipo()->getID();
    $fechaIni = $elem->getCeFechaIni();
    $fechaFin = date('Y-m-d H:i:s');

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
            'cefechafin' => 0,
        ];
        $respuesta = $objCE->altaSinID($arregloNewCompra);
        if (!$respuesta){
            $mensajeError = "No se pudo dar de alta al compraestado";
        }
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
    $retorno['mensajeError']=$mensajeError;
}

echo json_encode($retorno);
