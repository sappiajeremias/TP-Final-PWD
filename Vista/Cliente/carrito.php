<?php
$Titulo = "Carrito";
include_once '../Estructura/cabecera.php';
if($_SESSION['rolactivodescripcion']<> 'cliente'){
    $mensaje="No tiene permiso de cliente para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";
}
// GESTIONAR SU CARRITO, ELIMINAR EL ITEM PRODUCTO DEL ARREGLO O MODIFICAR SU CANTIDAD
// ENVIAR SOLITUD DE COMPRA = SE LIMPIA EL CARRITO

echo "Carrito";
?>

<?php include_once '../Estructura/pie.php'; ?>