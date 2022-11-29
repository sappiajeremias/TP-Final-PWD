<?php
include_once "../../../configuracion.php";
$data = data_submitted();

$respuesta = false;
$objSession = new Session();
$objAbmUsuario = new abmUsuario();
$idUserLogueado = $objSession->getIDUsuarioLogueado();
$carrito = $objAbmUsuario->obtenerCarrito($idUserLogueado);

$respuesta = iniciarCompra($carrito);

if ($respuesta) {

    $respuesta = true;

} else {

    $mensajeError = "No pudo iniciarse la compra.";
}

$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)) {

    $retorno['errorMsg'] = $mensajeError;
}
echo json_encode($retorno);



 function iniciarCompra($carrito){
    //modificar fechafin del carrito y crear nueva instancia de compraestado, con idcompraestadotipo =1, unido a la compra.

    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $abmCE= new abmCompraEstado();
    $idCompra=$carrito->getID();
    
    //Creo el objeto compraestado con idcompraestadotipo 1
    $respuesta=$abmCE->altaSinID([
        'idcompra'=>$idCompra,
        'idcompraestadotipo'=>1,
        'cefechaini'=>date('Y-m-d H:i:s'),
        'cefechafin'=>'0000-00-00 00:00:00'
    ]);

    if ($respuesta) {
        //Si se creo busco el carrito
        $listaCE = $abmCE->buscar([
            'idcompra'=>$idCompra,
            'idcompraestadotipo'=>5,
            'cefechafin'=>'0000-00-00 00:00:00'
        ]);

        if (count($listaCE) > 0) {
            //Seteo su parametro de fecha fin
            $idCE = $listaCE[0]->getID();
            $respuesta = $abmCE->modificacion([
                'idcompraestado' => $idCE,
                'idcompra'=>$idCompra,
                'idcompraestadotipo'=>5,
                'cefechaini'=>$listaCE[0]->getCeFechaIni(),
                'cefechafin' => date('Y-m-d H:i:s')
            ]);
        }
        
    }

    return $respuesta;

 }

