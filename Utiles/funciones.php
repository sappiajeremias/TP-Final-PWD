<?php
// SI O SI REQUIERE EL AUTOLOAD DE PHPAUTH
//require __DIR__.'/../utiles\PHPAuth\vendor\autoload.php';
include_once('../Modelo/conector/BaseDatos.php');
$BASEDATOS = new BaseDatos();
// CREAMOS UNA INSTANCIA DE LA CLASE PHPAUTH PARA UTILIZAR SUS MÉTODOS EN EL ABM POSTERIORMENTE


function data_submitted()
{
    // Función auxiliar para tomar los datos recibidos sin importar el método usado
    $_AAux= array();
    if (!empty($_POST)) {
        $_AAux =$_POST;
    } elseif (!empty($_GET)) {
        $_AAux =$_GET;
    }
    if (count($_AAux)) {
        foreach ($_AAux as $indice => $valor) {
            if ($valor=="") {
                $_AAux[$indice] = 'null';
            }
        }
    }
    return $_AAux;
}

spl_autoload_register(function ($clase) {
    $directorys = array(
        $GLOBALS['ROOT'].'Modelo/',
        $GLOBALS['ROOT'].'Control/',
    );
    foreach ($directorys as $directory) {
        if (file_exists($directory.$clase.'.php')) {
            require_once($directory.$clase.'.php');
            return;
        }
    }
});


