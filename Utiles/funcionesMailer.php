<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Funcion encargada del envio del mail, recibe como parametro un arreglo con el id de la compra y el id de compraestadotipo
function enviarMail ($data) {
    $user = buscarUsuario($data['idcompra']);
    $bodyMail = devolverBody($data);
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPDebug = 0;

        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'autos.phpmailer@gmail.com';
        $mail->Password = 'pcilpoomhtuyoeel';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('Autos.phpmailer@gmail.com', 'Administrador');
        $mail->addAddress($user['usmail'], $user['usname']);
        //$mail->addCC('lunalaureanoluna@gmail.com');lacasadelasplantasnqn@gmail.com

        $mail->isHTML(true);
        $mail->Subject = 'Estado de tu pedido';

        $mail->Body = $bodyMail;

        $mail->send();
        $exito = true;
    } catch (Exception $e) {
        $exito = false;
    }
    return $exito;
}

// Funcion que se encarga de buscar los datos del usuario necesarios con el idcompra
function buscarUsuario($idcompra){
    $objCompra = new abmCompra();
    $objC = $objCompra->buscar(['idcompra' => $idcompra]);
   
    $objUsuario = $objC[0]->getObjUsuario();
    return (['usmail'=>$objUsuario->getUsMail(), 'usname'=>$objUsuario->getUsNombre()]);
}

//Funcion que se encarga de crear el cuerpo del mail en base al estado de la compra
function devolverBody($data){
    switch($data['idcompraestadotipo']){
        case 1: {
            $body = "<!DOCTYPE html>
            <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='./FontAwesomeKit.js'></script>
                    <!-- CSS only -->
                    <style>
                                    .bodyCont{
                                        
                                        width: 1200px; margin: 0 auto; height: 571px;
                                    }
                                    *{
                                        text-align: center;
                                    }
                                   
                                    .containerFull{
                                        margin-top: 25px;
                                        background-color: #F5EFE6;;
                                        
                                        border: solid 2px;
                                        padding: 0%;
                                        
                                    }
                                    .containerRedes{
                                        margin: 0 auto;
                                        width: 75%;
                                        margin-top: 1rem;
                                        border-top: solid 1px black;
                                    }
                                    
                                    .nav{
                                        width: 75%;
                                        height: 75px;
                                        border-radius: 5px;
                                        margin: 0 auto;
                                        margin-top: 1.5rem;
                                        background-color: rgba( 120,194,173);
                                        padding: 1rem;  
                                        box-shadow: 5px 5px 15px 5px #000000;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
                                    .h3{
                                        font-size:25px;
                                        font-weight:normal;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
                                    .h3.subtitle{
                                        font-size: 20px;
                                    }
                                    .h3.subtitleRedes{
                                        font-size: 20px;
                                        margin: 0 auto;
                                        margin-top: 1rem;
                                    }
                                    .h4{
                                        font-size:15px;
                                        font-weight:normal;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
                                    /*CSS BUTTON*/
                                    .hvr-overline-from-center {
                                        margin-top: 1rem;
                                        background-color: #b4eeeb;
                                        border-color: transparent;
                                        border-radius: 10px;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                        display: inline-block;
                                        width: 150px;
                                        height: 45px;margin-bottom: 2rem;
                                        vertical-align: middle;
                                        -webkit-transform: perspective(1px) translateZ(0);
                                        transform: perspective(1px) translateZ(0);
                                        box-shadow: 0 0 1px rgba(0, 0, 0, 0);
                                        position: relative;
                                        overflow: hidden;
                                        }
                                        .hvr-overline-from-center:before {
                                        content: '';
                                        position: absolute;
                                        z-index: -1;
                                        left: 51%;
                                        right: 51%;
                                        top: 0;
                                        background: rgb(28, 199, 148);
                                        height: 4px;
                                        -webkit-transition-property: left, right;
                                        transition-property: left, right;
                                        -webkit-transition-duration: 0.3s;
                                        transition-duration: 0.3s;
                                        -webkit-transition-timing-function: ease-out;
                                        transition-timing-function: ease-out;
                                        }
                                        .hvr-overline-from-center:hover:before, .hvr-overline-from-center:focus:before, .hvr-overline-from-center:active:before {
                                        left: 0;
                                        right: 0;
                                        }
                                    /*CSS BUTTON*/
                                    
                                    .namebrand *{
                                        color:#F5EFE6;
                                        padding: 5px;
                                    }
                                </style>
                    <title>Mail Confirm</title>
                </head>
            
                <body class='bodyCont'>
                    <div class='containerFull'>
                        <div class='nav'>
                            <div class='namebrand'>
                                <h2><i class='fa-solid fa-seedling'></i>La casa de las plantas<i class='fa-solid fa-seedling'></i></h2>
                            </div>
                            
                        </div>
                        <div class='containerText'><h1 class='h1'>Pedido recibido!</h1>
                            <h3 class='h3'>Hemos recibido correctamente tu pedido!</h3>
                            <h3 class='h3 subtitle'>El ID de tu pedido es: {$data['idcompra']}</h3>
                            <h3 class='h3 subtitle'>Estamos esperando la confirmación del pago,
                                que puede demorar hasta 48hs hábiles.</h3>
                            <br/>
                                <h4 class='h4'>Luego de esto te informaremos sobre como sigue
                                    el pedido!</h4>
                            </div>
                            <div class='containerRedes'>
                                <h3 class='h3 subtitleRedes'>Estado de tu pedido!</h3>
                                <a
                                    href='http://localhost/TP-Final-PWD/Vista/Cliente/listaCompras.php'
                                    target='_blank'><button class='hvr-overline-from-center'>Click
                                        aquí!</button></a>
                            </div>
                        </div>
                    </body>
                </html>";
        }
        break;
        case 2: {
            $body = "<!DOCTYPE html>
            <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='./FontAwesomeKit.js'></script>
                    <!-- CSS only -->
                    <style>
                                     .bodyCont{
                                        
                                        width: 1200px; margin: 0 auto; height: 571px;
                                    }
                                    *{
                                        text-align: center;
                                    }
                                   
                                    .containerFull{
                                        margin-top: 25px;
                                        background-color: #F5EFE6;;
                                        
                                        border: solid 2px;
                                        padding: 0%;
                                        
                                    }
                                    .containerRedes{
                                        margin: 0 auto;
                                        width: 75%;
                                        margin-top: 1rem;
                                        border-top: solid 1px black;
                                    }
                                    
                                    .nav{
                                        width: 75%;
                                        height: 75px;
                                        border-radius: 5px;
                                        margin: 0 auto;
                                        margin-top: 1.5rem;
                                        background-color: #BFACE2;
                                        padding: 1rem;  
                                        box-shadow: 5px 5px 15px 5px #000000;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
                                    .h3{
                                        font-size:25px;
                                        font-weight:normal;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
                                    .h3.subtitle{
                                        font-size: 20px;
                                    }
                                    .h3.subtitleRedes{
                                        font-size: 20px;
                                        margin: 0 auto;
                                        margin-top: 1rem;
                                    }
                                    .h4{
                                        font-size:15px;
                                        font-weight:normal;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
                                    /*CSS BUTTON*/
                                    .hvr-overline-from-center {
                                        margin-top: 1rem;
                                        background-color: #BFACE2;
                                        border-color: transparent;
                                        border-radius: 10px;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                        display: inline-block;
                                        width: 150px;
                                        height: 45px;margin-bottom: 2rem;
                                        vertical-align: middle;
                                        -webkit-transform: perspective(1px) translateZ(0);
                                        transform: perspective(1px) translateZ(0);
                                        box-shadow: 0 0 1px rgba(0, 0, 0, 0);
                                        position: relative;
                                        overflow: hidden;
                                        }
                                        .hvr-overline-from-center:before {
                                        content: '';
                                        position: absolute;
                                        z-index: -1;
                                        left: 51%;
                                        right: 51%;
                                        top: 0;
                                        background: rgb(28, 199, 148);
                                        height: 4px;
                                        -webkit-transition-property: left, right;
                                        transition-property: left, right;
                                        -webkit-transition-duration: 0.3s;
                                        transition-duration: 0.3s;
                                        -webkit-transition-timing-function: ease-out;
                                        transition-timing-function: ease-out;
                                        }
                                        .hvr-overline-from-center:hover:before, .hvr-overline-from-center:focus:before, .hvr-overline-from-center:active:before {
                                        left: 0;
                                        right: 0;
                                        }
                                    /*CSS BUTTON*/
                                    
                                    .namebrand *{
                                        color:#F5EFE6;
                                        padding: 5px;
                                    }
                                </style>
                    <title>Mail Confirm</title>
                </head>
            
                <body class='bodyCont'>
                    <div class='containerFull'>
                        <div class='nav'>
                            <div class='namebrand'>
                                <h2><i class='fa-solid fa-seedling'></i>La casa de las plantas<i class='fa-solid fa-seedling'></i></h2>
                            </div>
                            
                        </div>
                        <div class='containerText'><h1 class='h1'>Pedido aceptado!</h1>
                            <h3 class='h3'>Ya hemos confirmado tu pedido!</h3>
                            <h3 class='h3 subtitle'>El ID para seguir tu compra es: {$data['idcompra']}</h3>
                            <h3 class='h3 subtitle'>La preparación de los pedidos puede tomar hasta 48hs hábiles.</h3>
                            <br/>
                            
                            <h4 class='h4'>Te informaremos por este medio su envío!</h3>
                            </div>
                            <div class='containerRedes'>
                                <h3 class='h3 subtitleRedes'>Estado de tu compra!</h3>
                                <a  href='http://localhost/TP-Final-PWD/Vista/Cliente/listaCompras.php' target='_blank'><button class='hvr-overline-from-center' >Click aquí!</button></a>
                            </div>
                        </div>
                    </body>
                </html>";
        }
        break;
        case 3: { 
            $body = "<!DOCTYPE html>
            <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='./FontAwesomeKit.js'></script>
                    <!-- CSS only -->
            
                    <style>
                                     .bodyCont{
                                        
                                        width: 1200px; margin: 0 auto; height: 571px;
                                    }
                                    *{
                                        text-align: center;
                                    }
                                   
                                    .containerFull{
                                        margin-top: 25px;
                                        background-color: #F5EFE6;;
                                        
                                        border: solid 2px;
                                        padding: 0%;
                                        
                                    }
                                    .containerRedes{
                                        margin: 0 auto;
                                        width: 75%;
                                        margin-top: 1rem;
                                        border-top: solid 1px black;
                                    }
                                    
                                    .nav{
                                        width: 75%;
                                        height: 75px;
                                        border-radius: 5px;
                                        margin: 0 auto;
                                        margin-top: 1.5rem;
                                        background-color: #93C6E7;
                                        padding: 1rem;  
                                        box-shadow: 5px 5px 15px 5px #000000;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
                                    .h3{
                                        font-size:25px;
                                        font-weight:normal;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
                                    .h3.subtitle{
                                        font-size: 20px;
                                    }
                                    .h3.subtitleRedes{
                                        font-size: 20px;
                                        margin: 0 auto;
                                        margin-top: 1rem;
                                    }
                                    .h4{
                                        font-size:15px;
                                        font-weight:normal;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
                                    /*CSS BUTTON*/
                                    .hvr-overline-from-center {
                                        margin-top: 1rem;
                                        background-color: #93C6E7;
                                        border-color: transparent;
                                        border-radius: 10px;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                        display: inline-block;
                                        width: 150px;
                                        height: 45px;margin-bottom: 2rem;
                                        vertical-align: middle;
                                        -webkit-transform: perspective(1px) translateZ(0);
                                        transform: perspective(1px) translateZ(0);
                                        box-shadow: 0 0 1px rgba(0, 0, 0, 0);
                                        position: relative;
                                        overflow: hidden;
                                        }
                                        .hvr-overline-from-center:before {
                                        content: '';
                                        position: absolute;
                                        z-index: -1;
                                        left: 51%;
                                        right: 51%;
                                        top: 0;
                                        background: rgb(28, 199, 148);
                                        height: 4px;
                                        -webkit-transition-property: left, right;
                                        transition-property: left, right;
                                        -webkit-transition-duration: 0.3s;
                                        transition-duration: 0.3s;
                                        -webkit-transition-timing-function: ease-out;
                                        transition-timing-function: ease-out;
                                        }
                                        .hvr-overline-from-center:hover:before, .hvr-overline-from-center:focus:before, .hvr-overline-from-center:active:before {
                                        left: 0;
                                        right: 0;
                                        }
                                    /*CSS BUTTON*/
                                    
                                    .namebrand *{
                                        color:#F5EFE6;
                                        padding: 5px;
                                    }
                                </style>
                    <title>Mail Confirm</title>
                </head>
            
                <body class='bodyCont'>
                    <div class='containerFull'>
                        <div class='nav'>
                            <div class='namebrand'>
                                <h2><i class='fa-solid fa-seedling'></i>La casa de las plantas<i class='fa-solid fa-seedling'></i></h2>
                            </div>
                            
                        </div>
                        <div class='containerText'><h1 class='h1'>Pedido enviado!</h1>
                            <h3 class='h3'>Ya hemos realizado el envío de tu pedido con ID:
                            {$data['idcompra']}.</h3>
                            <h3 class='h3 subtitle'>La empresa encargada del envío se
                                contactará para enviarte los datos del mismo.</h3>
                            <h3 class='h3 subtitle'>Ante cualquier golpe o extravío debes
                                contactarte con la misma compañia.</h3>
                            <br/>
            
                                <h4 class='h4'>Te estaremos esperando nuevamente, gracias!</h4>
                            </div>
                            <div class='containerRedes'>
                                <h3 class='h3 subtitleRedes'>Volvé a comprar con nosotros!</h3>
                                <a
                                    href='http://localhost/TP-Final-PWD/Vista/Home/productos.php'
                                    target='_blank'><button class='hvr-overline-from-center'>Click
                                        aquí!</button></a>
                            </div>
                        </div>
                    </body>
                </html>";
        }
        break;
        case 4: {
            $body = "<!DOCTYPE html>
            <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='./FontAwesomeKit.js'></script>
                    <!-- CSS only -->
                    <style>
                        .bodyCont{
                           
                           width: 1200px; margin: 0 auto; height: 571px;
                       }
                       *{
                           text-align: center;
                       }
                      
                       .containerFull{
                           margin-top: 25px;
                           background-color: #F5EFE6;;
                           
                           border: solid 2px;
                           padding: 0%;
                           
                       }
                       .containerRedes{
                           margin: 0 auto;
                           width: 75%;
                           margin-top: 1rem;
                           border-top: solid 1px black;
                       }
                       
                       .nav{
                           width: 75%;
                           height: 75px;
                           border-radius: 5px;
                           margin: 0 auto;
                           margin-top: 1.5rem;
                           background-color: rgba( 243,150,154);
                           padding: 1rem;  
                           box-shadow: 5px 5px 15px 5px #000000;
                           font-family: Verdana, Geneva, Tahoma, sans-serif;
                       }
                       .h3{
                           font-size:25px;
                           font-weight:normal;
                           font-family: Verdana, Geneva, Tahoma, sans-serif;
                       }
                       .h3.subtitle{
                           font-size: 20px;
                       }
                       .h3.subtitleRedes{
                           font-size: 20px;
                           margin: 0 auto;
                           margin-top: 1rem;
                       }
                       .h4{
                           font-size:15px;
                           font-weight:normal;
                           font-family: Verdana, Geneva, Tahoma, sans-serif;
                       }
                       /*CSS BUTTON*/
                       .hvr-overline-from-center {
                           margin-top: 1rem;
                           background-color: #b4eeeb;
                           border-color: transparent;
                           border-radius: 10px;
                           font-family: Verdana, Geneva, Tahoma, sans-serif;
                           display: inline-block;
                           width: 150px;
                           height: 45px;margin-bottom: 2rem;
                           vertical-align: middle;
                           -webkit-transform: perspective(1px) translateZ(0);
                           transform: perspective(1px) translateZ(0);
                           box-shadow: 0 0 1px rgba(0, 0, 0, 0);
                           position: relative;
                           overflow: hidden;
                           }
                           .hvr-overline-from-center:before {
                           content: '';
                           position: absolute;
                           z-index: -1;
                           left: 51%;
                           right: 51%;
                           top: 0;
                           background: rgb(28, 199, 148);
                           height: 4px;
                           -webkit-transition-property: left, right;
                           transition-property: left, right;
                           -webkit-transition-duration: 0.3s;
                           transition-duration: 0.3s;
                           -webkit-transition-timing-function: ease-out;
                           transition-timing-function: ease-out;
                           }
                           .hvr-overline-from-center:hover:before, .hvr-overline-from-center:focus:before, .hvr-overline-from-center:active:before {
                           left: 0;
                           right: 0;
                           }
                       /*CSS BUTTON*/
                       
                       .namebrand *{
                           color:#F5EFE6;
                           padding: 5px;
                       }
                   </style>
                    <title>Mail Confirm</title>
                </head>
            
                <body class='bodyCont'>
                    <div class='containerFull'>
                        <div class='nav'>
                            <div class='namebrand'>
                                <h2><i class='fa-solid fa-seedling'></i>La casa de las plantas<i class='fa-solid fa-seedling'></i></h2>
                            </div>
                            
                        </div>
                        <div class='containerText'><h1 class='h1'>Pedido cancelado</h1>
                            <h3 class='h3'>Lamentamos informarte que tu pedido fue cancelado.</h3>
                            <h3 class='h3 subtitle'>Por razones ajenas a nosotros, debemos cancelar el envío de tu pedido.</h3>
                            <h3 class='h3 subtitle'>El dinero de la compra sera reintegrado automáticamente.</h3>
                            <br/>
                            
                            <h4 class='h4'>No dudes en contactarnos ante cualquier duda con el reintegro!</h4>
                            </div>
                            <div class='containerRedes'>
                                <h3 class='h3 subtitleRedes'>Volvé a comprar con nosotros!</h3>
                                <a  href='http://localhost/TP-Final-PWD/Vista/Home/productos.php' target='_blank'><button class='hvr-overline-from-center' >Click aquí!</button></a>
                            </div>
                        </div>
                    </body>
                </html>";
        }
        break;
        default: {
            $body = '';
        }
        break;
    }
    return $body;
}