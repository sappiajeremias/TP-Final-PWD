<?php
$Titulo = "Tabla Compras";
include_once '../Estructura/cabecera.php';

// Ver las compras generadas por los clientes
// Cambiar el estado de las compras
// EN CADA CAMBIO DE ESTADO SE LE DEBE NOTIFICAR AL USUARIO
// ACEPTADA (SE RESTA EL STOCK DE ESE CARRITO A TODOS LOS PRODUCTOS CORRESPONDIENTES)
// CANCELADA (RECHAZA EL CARRITO DEL CLIENTE, NO OCURRE NADA MAS ALLA DEL CAMBIO DE ESTADO DE LA COMPRA)
// ENVIADA (CAMBIO DE ESTADO)

echo "Tabla Compras";
?>

<?php include_once '../Estructura/pie.php'; ?>