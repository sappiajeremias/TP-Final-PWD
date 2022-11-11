<?php
$Titulo = "Listado de Compras";
include_once '../Estructura/cabecera.php';
if($_SESSION['rolactivodescripcion']<> 'cliente'){
    $mensaje="No tiene permiso de cliente para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";
}
// Ver las compras y sus estados Y NADA MAS NO PUEDE TOCAR NADA

echo "Listado compras";
?>

<?php include_once '../Estructura/pie.php'; ?>