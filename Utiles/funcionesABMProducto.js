
//FUNCIONES DEL ACCION-DEPOSITO


var url;
function nuevoProducto() {
    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Producto');
    $('#fm').form('clear');
    url = '../Deposito/Accion/altaProd.php';
}
function editarProducto() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Producto');
        $('#fm').form('load', row);
        url = '../Deposito/Accion/editarProd.php?idproducto=' + row.idproducto;
    }
}
function saveProd() {
    //alert(" Accion");
    $('#fm').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (result) {

            var result = eval('(' + result + ')');


            if (!result.respuesta) {
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
            } else {

                $('#dlg').dialog('close');        // close the dialog
                $('#dg').datagrid('reload');    // reload 
            }
        }
    });
}
function eliminarProducto() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirm', 'Seguro que desea eliminar el menu?', function (r) {
            if (r) {
                $.post('../Deposito/Accion/eliminarProducto.php?idproducto=' + row.idproducto, { idproducto: row.id },
                    function (result) {

                        if (result.respuesta) {

                            $('#dg').datagrid('reload');    // reload the  data
                        } else {
                            $.messager.show({    // show error message
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        }
                    }, 'json');
            }
        });
    }
}