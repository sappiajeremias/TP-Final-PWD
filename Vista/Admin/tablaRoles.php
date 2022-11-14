<?php
// Gestionar los rooles, añadir roles, eliminar roles
$Titulo = "Tabla Roles";
include_once '../Estructura/cabecera.php';
if($_SESSION['rolactivodescripcion']<> 'admin'){
    $mensaje="No tiene permiso de administrador para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";
}else{
    $objControl = new abmRol();
    $listaRoles = $objControl->buscar(null);
    $combo = '<select class="easyui-combobox"  id="idrol"  name="idrol" label="Rol:" labelPosition="top" style="width:90%;">
    <option></option>';
    foreach ($listaRoles as $objRol){
        $combo .='<option value="'.$objRol->getID().'">'.$objRol->getRolDescripcion().'</option>';
        }

    $combo .='</select>';
    ?>
    <table id="dg" title="Administrador de roles" class="easyui-datagrid" style="width:700px;height:250px"
    url="accion/listarRoles.php" toolbar="#toolbar" pagination="true"rownumbers="true" fitColumns="true" singleSelect="true">
            <thead>
            <tr>
            <th field="idrol" width="50">ID</th>
            <th field="rodescripcion" width="50">Nombre</th>
            </tr>
            </thead>
            </table>
            <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevoRol()">Nuevo Rol </a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editarRol()">Editar Rol</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminarRol()">Baja Rol</a>
            </div>
            
            <div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
            <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Usuario Informacion</h3>
            <div style="margin-bottom:10px">
            <input  name="idrol" id="idrol"  class="easyui-textbox" required="true" label="ID-Rol:" style="width:100%">
            </div>       
            <input name="rodescripcion" id="rodescripcion"  class="easyui-textbox" required="true" label="Rol-Descripcion:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
            <?php 
                echo $combo;
            ?>
            </div>
            <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="guardarRol()" style="width:90px">Aceptar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
            </div>
<?php

}

?>

<?php include_once '../Estructura/pie.php'; ?>