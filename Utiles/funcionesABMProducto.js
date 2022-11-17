//FUNCIONES DEL ACCION-DEPOSITO


var url;

function nuevoProducto() {
    $('#dlgProductos').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Producto');
    $('#fmProductos').form('clear');
    url = '../Deposito/Accion/altaProd.php';
}

function editarProducto() {
    var row = $('#dgProductos').datagrid('getSelected');
    if (row) {
        $('#dlgProductos').dialog('open').dialog('center').dialog('setTitle', 'Editar Producto');
        $('#fmProductos').form('load', row);
        url = '../Deposito/Accion/editarProd.php?idproducto=' + row.idproducto;
    }
}

function save() {
    //alert(" Accion");
    $('#fmProductos').form('submit', {
        url: url,
        onSubmit: function() {
            return $(this).form('validate');
        },
        success: function(result) {

            var result = eval('(' + result + ')');


            if (!result.respuesta) {
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
            } else {

                $('#dlgProductos').dialog('close'); // close the dialog
                $('#dgProductos').datagrid('reload', true); // reload 
            }
        }
    });
}

function eliminarProducto() {
    var row = $('#dgProductos').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirm', 'Seguro que desea eliminar el menu?', function(r) {
            if (r) {
                $.post('../Deposito/Accion/eliminarProducto.php?idproducto=' + row.idproducto, { idproducto: row.id },
                    function(result) {

                        if (result.respuesta) {

                            $('#dgProductos').datagrid('reload'); // reload the  data
                        } else {
                            $.messager.show({ // show error message
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        }
                    }, 'json');
            }
        });
    }
}