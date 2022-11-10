<?php
include_once "../../configuracion.php";

$datos = data_submitted();
$abmUsuario = new abmUsuario();
$resultado = $abmUsuario->alta($datos);
if ($resultado) {
    $parametro = ['usnombre'=>$datos['usnombre']];
    $objUsuario = $abmUsuario->buscar($parametro);
    $idObjUsuario = $objUsuario[0]->getID();

    $parametro = ['rodescripcion'=>'cliente'];
    $objAbmRol = new abmRol();
    $objRol = $objAbmRol->buscar($parametro);
    $idObjRol = $objRol[0]->getIdRol();

    $arregloIndices = ['idusuario' => $idObjUsuario, 'idrol' => $idObjRol];

    $abmUsuarioRol = new abmUsuarioRol();
    $respuesta = $abmUsuarioRol->alta($arregloIndices);

    if ($respuesta){
        $mensaje = "El usuarioRol fue creado con exito";
        header('Location:../Home/index.php?mensaje='.urlencode($mensaje));
    } else {
        $mensaje = "Hubo un error al crear el usuarioRol";
        header('Location:../Home/index.php?mensaje='.urlencode($mensaje));
    }
} else {
    $mensaje = "Algo salió mal en el registro";
    header('Location:../Home/index.php?mensaje='.urlencode($mensaje));
}
