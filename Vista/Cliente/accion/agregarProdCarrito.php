<?php 
include_once "../../../configuracion.php";
$data = data_submitted();

$respuesta = false;
$objSession = new Session();
$objAbmCompraEstado = new abmCompraEstado();
$objAbmUsuario = new abmUsuario();
$idUserLogueado = $objSession->getIDUsuarioLogueado();
$carrito = $objAbmUsuario->obtenerCarrito($idUserLogueado);
if ($carrito <> null) {
    //si el carrito existe agrego el producto
    $respuesta = verificarStockProd($carrito, $data);
    if ($respuesta) {
        $respuesta = agregarProductoCarrito($carrito, $data);
        if (!$respuesta) {
            $mensajeError = "No pudo añadirse el producto al carrito.";
        }
    }else{
        $mensajeError="Este producto no tiene mas stock!";
    }
} else {//si el carrito no existe lo creo
    echo "HOLA";
    $carritoNuevo = crearCarrito($idUserLogueado);
    if ($carritoNuevo <> null) {
        //y agrego el producto
        $respuesta = agregarProductoCarrito($carritoNuevo, $data);
        if (!$respuesta) {
            $mensajeError = "No pudo añadirse el producto al carrito.";
        }
    }else{
        $mensajeError = "No crearse el carrito.";
    }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
    
    $retorno['errorMsg']=$mensajeError;
   
}

echo json_encode($retorno);

function agregarProductoCarrito($objCompraCarrito, $data)
{
    //Agrega el producto con cantidad 1 si no existe
    //Si el producto existe, le suma 1 a su cantidad
    $respuesta=false;
    $objAbmCompraItem = new abmCompraItem();
    $idCompra = $objCompraCarrito->getID();
    $param = array(
        'idproducto' => $data['idproducto'],
        'idcompra' => $idCompra
    );
    $listaCompraItem = $objAbmCompraItem->buscar($param);
    if (count($listaCompraItem) > 0) { //si existe el producto ya en el carrito solo lo seteo
        $objCompraItem = $listaCompraItem[0];
        $idCI = $objCompraItem->getID();
        $cantidadCI = $objCompraItem->getCiCantidad();
        $nuevaCantCI = $cantidadCI + 1;
        $paramCI = array(
            'idcompraitem' => $idCI,
            'idproducto' => $data['idproducto'],
            'idcompra' => $idCompra,
            'cicantidad' => $nuevaCantCI
        );
        //print_r($paramCI);
        $respuesta=$objAbmCompraItem->modificacion($paramCI);
        if(!$respuesta){
            echo "no se modifico";
        }
    }else{//si no lo creo y lo uno con el carrito
        $data['idcompra'] = $idCompra;
        $respuesta = $objAbmCompraItem->altaSinID($data);
    }
    return $respuesta;
}

 function crearCarrito($idUser){
    $carrito=null;
    $objAbmCompra = new abmCompra();
    $param= array(
        'cofecha'=>date('Y-m-d H:i:s'),
        'idusuario'=>$idUser
    );
    $respuesta=$objAbmCompra->altaSinID($param);
    if(!$respuesta){
        echo "no se creo el carrito";
    }
    if($respuesta){//si se creo el carrito creo el estadocompra
        $paramIDUsuario['idusuario']=$idUser;
        $objAbmCompraEstado= new abmCompraEstado();
        $listaCompras=$objAbmCompra->buscar($paramIDUsuario);
        $posCompra=count($listaCompras)-1;//la ultima compra que cree es el carrito
        $idCompra=$listaCompras[$posCompra]->getID();
        $paramCompraEstado= array(
            'idcompra'=>$idCompra, 
            'idcompraestadotipo'=>5, 
            'cefechaini'=>date('Y-m-d H:i:s'),//ver lo de la hora actual
            'cefechafin'=>'0000-00-00 00:00:00');// ver el null
        $respuesta=$objAbmCompraEstado->altaSinID($paramCompraEstado);
        if($respuesta){//si se creo el estado compra, devuelvo el carrito
            $carrito=$listaCompras[$posCompra];
        }
    }
    return $carrito;
 }

function verificarStockProd($objCompraCarrito, $data)
{//Verifica que la cantidad de stock del producto sea mayor o igual a la nueva cicantidad
    $respuesta = false;
    $objAbmCompraItem = new abmCompraItem();
    $idCompra = $objCompraCarrito->getID();
    $param = array(
        'idproducto' => $data['idproducto'],
        'idcompra' => $idCompra
    );
    $listaCompraItem = $objAbmCompraItem->buscar($param);
    if (count($listaCompraItem) > 0) { //si existe el producto en el carrito chequeo con su cicantidad
        $objCompraItem = $listaCompraItem[0];
        $nuevaCantCI = $objCompraItem->getCiCantidad() + 1;
        $objAbmProd = new abmProducto();
        $param['idproducto'] = $data['idproducto'];
        $listaProd = $objAbmProd->buscar($param);
        if (count($listaProd)) {
            $cantStockProd = $listaProd[0]->getProCantStock();
            if ($cantStockProd >= $nuevaCantCI) {
                $respuesta = true;
            }
        }
    } else { //si no existe el producto en el carrito no tengo que chequear ningun stock
        $respuesta = true;
    }
    return $respuesta;
}


