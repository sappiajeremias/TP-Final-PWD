<?php

/////////////////////////////////////
///////// CONFIGURACIÓN APP /////////
/////////////////////////////////////

$GLOBALS['ROOT'] = $_SERVER['DOCUMENT_ROOT'];

// INCLUSIÓN FUNCIONES
include_once 'Utiles/funciones.php';
include_once 'Utiles/funcion_log.php';
include_once 'Utiles/funciones_md5.php';

// MODIFICAR SEGÚN TENGAS EL PROYECTO GUARDADO LOCALMENTE
$PROYECTO = 'TP-Final-PWD';

// ALMACENA EL DIRECTORIO DEL PROYECTO
$ROOT = $_SERVER['DOCUMENT_ROOT']."/$PROYECTO/";

?>