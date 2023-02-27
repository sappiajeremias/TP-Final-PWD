<?php
require '../../../../utiles/vendor/phpmailer/phpmailer/src/Exception.php';
require '../../../../utiles/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../../utiles/vendor/phpmailer/phpmailer/src/SMTP.php';
include_once "../../../../configuracion.php";
$data = data_submitted();
$objC= new abmCompra();
$resp=$objC->ejecutarCompraCarrito();
if($resp['respuesta']){
    $respuestaCorreo = enviarMail(['idcompra'=>$resp['idcompra'], 'idcompraestadotipo'=>1]);
}
echo json_encode($respuestaCorreo);

?>
 


