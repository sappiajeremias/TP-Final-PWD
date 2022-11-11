<?php
$Titulo = "Tabla Menu Roles";
include_once '../Estructura/cabecera.php';

if($_SESSION['rolactivodescripcion']<> 'admin'){
    $mensaje="No tiene permiso de administrador para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";
}

// Relacionar cada menu con un rol, modificar la relacion menurol

echo "Tabla Menu Roles";
?>

<?php include_once '../Estructura/pie.php'; ?>