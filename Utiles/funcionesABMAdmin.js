//FUNCIONES DEL ACCION-ADMINISTRADOR
//Acciones en USUARIO
function nuevoUsuario() {
    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Usuario');
    $('#fm').form('clear');
    url = '../Vista/Admin/accion/altaUsuario.php';
}

function editarUsuario() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Usuario');
        $('#fm').form('load', row);
        url = '../Vista/Admin/accion/editarUsuario.php?idusuario=' + row.idusuario;
    }
}

function guardarUsuario() {
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

function eliminarUsuario() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirm', 'Seguro que desea eliminar el Usuario?', function (r) {
            if (r) {
                $.post('../Vista/Admin/accion/altaUsuario.php?idusuario=' + row.idusuario, { idusuario: row.id },
                    function (result) {
                        alert("Volvio Servidor");
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

//Acciones en ROL
function nuevoRol() {
    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Rol');
    $('#fm').form('clear');
    url = '../Vista/Admin/accion/altaRol.php';
}

function editarRol() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Rol');
        $('#fm').form('load', row);
        url = '../Vista/Admin/accion/editarRol.php?accion=mod&idrol=' + row.idrol;
    }
}

function guardarRol() {
    //alert(" Accion");
    $('#fm').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (result) {
            var result = eval('(' + result + ')');

            alert("Volvio Servidor");
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

function eliminarRol() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirm', 'Seguro que desea eliminar el Rol?', function (r) {
            if (r) {
                $.post('../Vista/Admin/accion/altaRol.php?idrol=' + row.idrol, { idrol: row.id },
                    function (result) {
                        alert("Volvio Servidor");
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


