<?php
include_once "../../../configuracion.php";
$data = data_submitted();

$respuesta = false;
$objSession = new Session();
$objAbmCompraEstado = new abmCompraEstado();
$objAbmUsuario = new abmUsuario();
$idUserLogueado = $objSession->getIDUsuarioLogueado();
$carrito = $objAbmUsuario->obtenerCarrito($idUserLogueado);
//si el carrito existe agrego el producto
$respuesta = iniciarCompra($carrito);
if ($respuesta) {
    //actualizarStockProd($carrito);
    $respuesta = true;
} else {
    $mensajeError = "No pudo iniciarse la compra, stock insuficiente de algunos productos.";
}

$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)) {

    $retorno['errorMsg'] = $mensajeError;
}
echo json_encode($retorno);

 function iniciarCompra($carrito){
    //modificar fechafin del carrito y crear nueva instancia de compraestado, con idcompraestadotipo =1, unido a la compra.
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $objAbmCompraEstado= new abmCompraEstado();
    $idCompra=$carrito->getID();
    $paramCompra= array(
        'idcompra'=>$idCompra,
        'idcompraestadotipo'=>1,
        'cefechaini'=>date('Y-m-d H:i:s'),
        'cefechafin'=>'0000-00-00 00:00:00'
    );

    $respuesta=$objAbmCompraEstado->altaSinID($paramCompra);
    
    if ($respuesta) {
        $param= array(
            'idcompra'=>$idCompra,
            'idcompraestadotipo'=>5,
            'cefechafin'=>null
        );
        $listaCompraEstado = $objAbmCompraEstado->buscar($param);
        if (count($listaCompraEstado) > 0) {
            $idCompraEstado = $listaCompraEstado[0]->getID();
            $paramEdicion = array(
                'idcompraestado' => $idCompraEstado,
                'idcompra'=>$idCompra,
                'idcompraestadotipo'=>5,
                'cefechaini'=>$listaCompraEstado[0]->getCeFechaIni(),
                'cefechafin' => date('Y-m-d H:i:s')
            );
            $respuesta = $objAbmCompraEstado->modificacion($paramEdicion);
        }
        
    }
    return $respuesta;
 }


