<?php
require '../../utiles/vendor/phpmailer/phpmailer/src/Exception.php';
require '../../utiles/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../utiles/vendor/phpmailer/phpmailer/src/SMTP.php';
include_once "../../configuracion.php";
$data = data_submitted();
$objCE = new abmCompraEstado();

$resp = $objCE->modificarEstado($data);

if($resp){
    enviarMail($data);
}

echo json_encode($resp);
?>