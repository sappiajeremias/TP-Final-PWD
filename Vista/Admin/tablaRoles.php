<?php
$Titulo = "Tabla Roles";
include_once '../Estructura/cabecera.php';
if($_SESSION['rolactivodescripcion']<> 'admin'){
    $mensaje="No tiene permiso de administrador para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";
}

// Gestionar los rooles, añadir roles, eliminar roles

echo "Tabla Roles";
?>

<?php include_once '../Estructura/pie.php'; ?>