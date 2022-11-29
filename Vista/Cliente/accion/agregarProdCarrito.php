<?php 
include_once "../../../configuracion.php";
$data = data_submitted();

$respuesta = false;
$objSession = new Session();
$abmUs = new abmUsuario();
$idUser = $objSession->getIDUsuarioLogueado();
$carrito = $abmUs->obtenerCarrito($idUser);

if ($carrito <> null) {
    //Si el carrito existe chequeo el stock del producto a agregar

    if (verificarStockProd($carrito, $data)) {
        //Si tiene stock lo agrego

        $respuesta = agregarProdCarrito($carrito, $data);

        if (!$respuesta) {
            $mensajeError = "No pudo añadirse el producto al carrito.";
        }
    }else{
        $mensajeError="Este producto no tiene mas stock!";
    }

} else {

    //si el carrito no existe lo creo 
    $carritoNuevo = crearCarrito($idUser);

    if ($carritoNuevo <> null) {
        //y agrego el producto

        $respuesta = agregarProdCarrito($carritoNuevo, $data);

        if (!$respuesta) {
            $mensajeError = "No pudo añadirse el producto al carrito.";
        }
    }else{
        $mensajeError = "No pudo crearse el carrito.";
    }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensajeError)){
    
    $retorno['errorMsg']=$mensajeError;
   
}
 echo json_encode($retorno);


//*************************  MÉTODOS  ***************************************//

function agregarProdCarrito($carrito, $data)
{
    //Agrega el producto con cantidad 1 si no existe
    //Si el producto existe, le suma 1 a su cantidad
    $respuesta = false;
    $abmCI = new abmCompraItem();
    $idCompra = $carrito->getID();
    $idProducto = $data['idproducto'];

    $listaCI = $abmCI->buscar(['idproducto' => $idProducto, 'idcompra' => $idCompra]);

    if (count($listaCI) > 0) {
        //Si el producto ya esta en el carrito solo lo seteo
        $objCI = $listaCI[0];
        $idCI = $objCI->getID();
        $cantidadCI = $objCI->getCiCantidad();
        $cantidadCI++;
        //print_r($paramCI);
        $respuesta = $abmCI->modificacion([
            'idcompraitem' => $idCI, 'idproducto' => $idProducto, 'idcompra' => $idCompra,
            'cicantidad' => $cantidadCI
        ]);

        if (!$respuesta) {
            echo "no se modifico";
        }
    } else {
        //Si no existe el producto en el carrito lo creo
        //Creo el indice idcompra con el id del carrito en $data para unir ese compraitem con el carrito
        $data['idcompra'] = $idCompra;
        $respuesta = $abmCI->altaSinID($data);
    }

    return $respuesta;
}



function crearCarrito($idUser){

    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $carrito=null;
    $abmCompra = new abmCompra();
    $respuesta=$abmCompra->altaSinID(['cofecha'=>date('Y-m-d H:i:s'),'idusuario'=>$idUser]);

    if($respuesta){
        //Si se creo el carrito creo el estadocompra
        $abmCE= new abmCompraEstado();
        //Busco las compras del usuario para hallar al carrito recien creado
        $listaC=$abmCompra->buscar(['idusuario'=>$idUser]);
        //El carrito va a estar siempre en la ultima posicion porque es el ultimo en ser creaedo
        $posCompra=count($listaC)-1;
        //Obtengo el id del carrito
        $idCompra=$listaC[$posCompra]->getID();

        $respuesta=$abmCE->altaSinID([
            'idcompra'=>$idCompra, 
            'idcompraestadotipo'=>5, 
            'cefechaini'=>date('Y-m-d H:i:s'),//ver lo de la hora actual
            'cefechafin'=>'0000-00-00 00:00:00'
        ]);

        if($respuesta){
            //si se creo el estado compra, devuelvo el carrito

            $carrito=$listaC[$posCompra];

        }
    }else{
        echo "No se creo el carrito";
    }
    return $carrito;
}




function verificarStockProd($carrito, $data){
    //Verifica que la cantidad de stock del producto sea mayor o igual a la nueva cicantidad

    $respuesta = false;
    $abmCI = new abmCompraItem();
    $idCompra = $carrito->getID();
    $listaCI = $abmCI->buscar(['idproducto' => $data['idproducto'],'idcompra' => $idCompra]);

    if (count($listaCI) > 0) { 
        //si existe el producto en el carrito chequeo con su cicantidad
        $objCI = $listaCI[0];
        $cantCI = ($objCI->getCiCantidad()) + 1;
        $objAbmProd = new abmProducto();
        $listaProd = $objAbmProd->buscar(['idproducto'=>$data['idproducto']]);
        if (count($listaProd) > 0) {

            $stockProd = $listaProd[0]->getProCantStock();
            if ($stockProd >= $cantCI) {

                $respuesta = true;
            }
        }

    } else { 
        //si no existe el producto en el carrito no tengo que chequear ningun stock
        $respuesta = true;

    }

    return $respuesta;

}


