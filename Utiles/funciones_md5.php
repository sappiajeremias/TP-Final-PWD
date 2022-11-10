<?php


function compararPsw($nombre, $psw)
{
    $resul = false;
    $user = new abmUsuario();
    $arreglo = $user->buscar(['usnombre'=>$nombre]);

    if ($psw == $arreglo[0]->getUsPass()) {
        $resul = true;
    }
    return $resul;
}
