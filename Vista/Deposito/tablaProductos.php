<?php
$Titulo = "Tabla Productos";
include_once '../Estructura/cabecera.php';
if ($_SESSION['rolactivodescripcion']<> 'deposito') {
    $mensaje="No tiene permiso de deposito para acceder a este sitio.";
    echo "<script> window.location.href='../Home/index.php?mensaje=".urlencode($mensaje)."'</script>";
} else {
    $objItems = new abmProducto();
    $listaProds = $objItems->buscar(null);
    $combo = '<select class="form-select"  id="idproducto"  name="idproducto" label="Producto:" labelPosition="top">
    <option selected>Producto</option>';
    foreach ($listaProds as $obj) {
        $combo .='<option value="'.$obj->getID().'">'.$obj->getProNombre().'>'.$obj->getProDetalle().'>'.$obj->getProCantStock().'</option>';
    }
    $combo .='</select>';
    ?>
<table id="dgProductos" title="Listado de productos" class="easyui-datagrid tablaDepo" style="width:1296px;height:500px;"
    url="./Accion/listarProductos.php" toolbar="#toolbar" pagination="true"rownumbers="true" fitColumns="true" singleSelect="true">
            <thead>
            <tr>
            <th field="idproducto" width="50">ID Producto</th>
            <th field="pronombre" width="50">Nombre</th>
            <th field="prodetalle" width="50">Detalle</th>
            <th field="procantstock" width="50">Stock</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($listaProds as $objProd) {
                        ?>
                    <tr>
                        <td><?php echo $objProd->getID() ?></td>
                        <td><?php echo $objProd->getProNombre() ?></td>
                        <td><?php echo $objProd->getProDetalle() ?></td>
                        <td><?php echo $objProd->getProCantStock() ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            </table>
            <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton botonDepo" iconCls="icon-add" plain="true" onclick="nuevoProducto()">Nuevo producto</a>
            <a href="javascript:void(0)" class="easyui-linkbutton botonDepo" iconCls="icon-edit" plain="true" onclick="editarProducto()">Editar producto</a>
            <a href="javascript:void(0)" class="easyui-linkbutton botonDepo" iconCls="icon-remove" plain="true" onclick="eliminarProducto()">Eliminar producto</a>
            </div>
            
        <div id="dlgProductos" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
            <form id="fmProductos" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Informacion del producto</h3>
            <div style="margin-bottom:10px">       
            <input name="pronombre" id="pronombre"  class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
            <input  name="prodetalle" id="prodetalle"  class="easyui-textbox" required="true" label="Detalle:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
            <input  name="procantstock" id="procantstock"  class="easyui-textbox" required="true" label="Stock:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                       
            </div>
            </form>
            <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton botonDepo" iconCls="icon-ok" onclick='save()' style="width:90px">Aceptar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton botonDepo" iconCls="icon-cancel" onclick="javascript:$('#dlgProductos').dialog('close')" style="width:90px">Cancelar</a>
            </div>
        </div>

<!--<div class="container">
    <table id="dg" title="Administrador de usuarios" class="table table-hover" style="width:700px; margin-top: 3rem;"
    url="accion/listarUsuarios.php">
        <thead>
            <tr>
                <th field="idproducto" width="50">ID Producto</th>
                <th field="pronombre" width="50">Nombre</th>
                <th field="prodetalle" width="50">Detalle</th>
                <th field="procantstock" width="50">Stock</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
    <div id="toolbar">
        <button class="btn btn-outline-success" onclick="nuevoProducto()" data-bs-toggle="modal" data-bs-target="#modalAgregar"><i class="fa-solid fa-plus" ></i> Nuevo Usuario</button>
        <button class="btn btn-outline-warning" onclick="editarUsuario()"><i class="fa-solid fa-pen-to-square" data-bs-toggle="modal" data-bs-target="#modalAgregar"></i> Editar Usuario</button>
        <button class="btn btn-outline-danger" onclick="eliminarUsuario()"><i class="fa-solid fa-trash"></i> Baja Usuario</button>
    </div>
</div>        


<div class="modal fade" id="modalAgregar" aria-labelledby="modalAgregarLabel" aria-hidden="true" open>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarLabel">Informacion del producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            
            <div style="margin-bottom:10px">       
            <input name="pronombre" id="pronombre"  class="easyui-textbox" required="true" label="Nombre:">
            </div>
            <div style="margin-bottom:10px">
            <input  name="prodetalle" id="prodetalle"  class="easyui-textbox" required="true" label="Detalle:">
            </div>
            <div style="margin-bottom:10px">
            <input  name="procantstock" id="procantstock"  class="easyui-textbox" required="true" label="Stock:">
            </div>
            <div style="margin-bottom:10px">
                 <div id="modal-footer">
                <a href="javascript:void(0)" class="btn btn-outline-success" iconCls="icon-ok" onclick='save()' style="width:90px">Aceptar</a>
                <a href="javascript:void(0)" class="btn btn-outline-danger" iconCls="icon-cancel"data-bs-dismiss="modal" style="width:90px">Cancelar</a>
            </div>      
            </div>
        </form>
            
      </div>
      
    </div>
  </div>
</div>


</html>-->
<?php
}
?>
<?php include_once '../Estructura/pie.php'; ?>