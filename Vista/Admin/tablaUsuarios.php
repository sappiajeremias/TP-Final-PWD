<?php
$Titulo = "Tabla Usuarios";
include_once '../Estructura/cabecera.php';
if($_SESSION['rolactivodescripcion']<> 'admin'){
    $mensaje="No tiene permiso de administrador para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";
}
// Gestionar los usuarios, añadir usuarios, modificar usuarios (roles) y eliminarlos

echo "Tabla Usuarios";
?>

<?php include_once '../Estructura/pie.php'; ?>