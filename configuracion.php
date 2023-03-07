<?php

/////////////////////////////////////
///////// CONFIGURACIÓN APP /////////
/////////////////////////////////////

$GLOBALS['ROOT'] = $_SERVER['DOCUMENT_ROOT'];

// INCLUSIÓN FUNCIONES
include_once 'Utiles/funciones.php';
include_once 'Utiles/funcionesMailer.php';
include 'Utiles/vendor/phpmailer/phpmailer/src/Exception.php';
include 'Utiles/vendor/phpmailer/phpmailer/src/PHPMailer.php';
include 'Utiles/vendor/phpmailer/phpmailer/src/SMTP.php';

// MODIFICAR SEGÚN TENGAS EL PROYECTO GUARDADO LOCALMENTE
$PROYECTO = 'TP-Final-PWD';

// ALMACENA EL DIRECTORIO DEL PROYECTO
$ROOT = $_SERVER['DOCUMENT_ROOT']."/$PROYECTO/";

$GLOBALS['IMGS'] = $ROOT . "Vista/img/"; //NOMBRAR CARPETA GALERIA O PROFESIONALES SEGÚN CORRESPONDA

?>