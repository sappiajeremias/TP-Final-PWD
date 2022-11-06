<?php
include_once('./Estructura/cabecera.php');

$data = data_submitted();

login($sesion, $data);

?>