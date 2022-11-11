<?php
$Titulo = "Tabla Productos";
include_once '../Estructura/cabecera.php';
if($_SESSION['rolactivodescripcion']<> 'deposito'){
    $mensaje="No tiene permiso de deposito para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";
}
// Generar nuevos productos, modificar los productos y eliminar los productos
// Modificar el stock de cada producto (input donde ingrese el stock total)

echo "Tabla Productos";
?>

<?php include_once '../Estructura/pie.php'; ?>