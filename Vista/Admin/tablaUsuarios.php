<?php
$Titulo = "Tabla Usuarios";
include_once '../Estructura/cabecera.php';
if($_SESSION['rolactivodescripcion']<> 'admin'){
    $mensaje="No tiene permiso de administrador para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";
}else{
    $objControl = new abmUsuario();
    $listaUsuarios = $objControl->buscar(null);
    $combo = '<select class="easyui-combobox"  id="idpadre"  name="idpadre" label="Submenu de?:" labelPosition="top" style="width:90%;">
    <option></option>';
    foreach ($listaUsuarios as $objUser){
        $combo .='<option value="'.$objUser->getID().'">'.$objUser->getUsNombre().'>'.$objUser->getUsMail().'</option>';
        }

    $combo .='</select>';
    ?>
    <table id="dg" title="Administrador de usuarios" class="" style="width:700px;height:250px"
    url="accion/listar_usuario.php" toolbar="#toolbar" pagination="true"rownumbers="true" fitColumns="true" singleSelect="true">
            <thead>
            <tr>
            <th field="idrol" width="50">ID</th>
            <th field="usnombre" width="50">Nombre</th>
            <th field="usmail" width="50">Descripci&oacute;n</th>
             <th field="usdeshabilitado" width="50">Deshabilitado</th>
            </tr>
            </thead>
            </table>
            <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevoUsuario()">Nuevo Usuario </a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editarUsuario()">Editar Usuario</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminarUsuario()">Baja Usuario</a>
            </div>
            
            <div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
            <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Usuario Informacion</h3>
            <div style="margin-bottom:10px">
            <input  name="idusuario" id="idusuario"  class="easyui-textbox" required="true" label="ID-Usuario:" style="width:100%">
            </div>
                      
            <input name="usnombre" id="usnombre"  class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
            <input  name="usmail" id="usmail"  class="easyui-textbox" required="true" label="Mail:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
            <?php 
                echo $combo;
            ?>
            </div>
              <div style="margin-bottom:10px">
            <input class="easyui-checkbox" name="medeshabilitado" value="medeshabilitado" label="Des-Habilitar:">
                </div>
            </form>
            </div>
            <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="guardarUsuario()" style="width:90px">Aceptar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
            </div>
<?php
}
// Gestionar los usuarios, añadir usuarios, modificar usuarios (roles) y eliminarlos

echo "Tabla Usuarios";
?>

<?php include_once '../Estructura/pie.php'; ?>