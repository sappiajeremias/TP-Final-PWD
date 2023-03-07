/*################################# CARGAR USUARIOS #################################*/
$(window).on("load", function () {
    cargarUsuarios();
});

function cargarUsuarios() {
    $.ajax({
        type: "POST",
        url: '../Acciones/usuario/listarUsuarios.php',
        data: null,
        success: function (response) {
            //console.log(response)
            var arreglo = [];
            $.each($.parseJSON(response), function (index, value) {
                
                    arreglo.push(value);
                
            });
            armarTabla(arreglo);
        }
    });
}

function armarTabla(arreglo) {
    // VACIAMOS LA TABLA
    $('#tablaUsuarios > tbody').empty();
    // LISTAMOS LOS USUARIOS

    $.each(arreglo, function (index, usuario) {

        if (usuario.usdeshabilitado == null || usuario.usdeshabilitado == "0000-00-00 00:00:00"){
            var boton = '<a href="#" class="deshabilitar me-2"><button class="btn btn-outline-secondary"><i class="fa-solid fa-ban me-2"></i>Deshabilitar</button></a>';
        } else {
            var boton = '<a href="#" class="habilitar me-2"><button class="btn btn-outline-success"><i class="fa-solid fa-square-check me-2"></i>Habilitar</button></a>';
        }

        $('#tablaUsuarios > tbody:last-child').append('<tr><td>' + usuario.idusuario + '</td><td>' + usuario.usnombre + '</td><td>' + usuario.usmail + '</td><td>' + usuario.usdeshabilitado + '</td><td>' + usuario.roles + '</td><td><a href="#" class="eliminarRol"><button class="btn btn-outline-danger"><i class="fa-solid fa-book-skull me-2"></i>Quitar Rol</button></a><a href="#" class="agregarRol"><button class="btn btn-outline-warning"><i class="fa-solid fa-book-medical me-2"></i>Agregar Rol</button></a>'+boton+'</td>');
    });
}

/*################################# AGREGAR USUARIO #################################*/
$(document).on('click', '.agregar', function () {
    //Tomamos la fila del ingreso de los datos
    var row = $(this).closest('tr').find(".form-control");

    //Tomamos cada dato de esa fila
    var nombre = row[1].value;
    var mail = row[2].value;
    var rol = row[4].value;

    arregloVerificador = {
        'nombre': nombre,
        'mail': mail,
        'rol': rol,
    };

    var verificador = true;

    $.each(arregloVerificador, function (index, value) {
        if (value === '') {
            verificador = false;
        }
    });


    if (verificador) {
        bootbox.prompt({
            //Creamos el cartel para ingresarle una contraseña al usuario y la ciframos
            size: "small",
            closeButton: false,
            inputType: "password",
            title: "Ingrese una contraseña",
            callback: function (result) {
                if (result != '') {
                    result = hex_md5(result).toString();
                    arreglo = {
                        'usnombre': nombre,
                        'usmail': mail,
                        'idrol': rol,
                        'uspass': result,
                        'usdeshabilitado': null
                    };
                    agregar(arreglo);
                } else {
                    // ALERT LIBRERIA
                    bootbox.alert({
                        message: "Debes ingresar una contraseña válida!",
                        size: 'small',
                        closeButton: false,
                    });
                }
            }
        });
    } else {
        // ALERT LIBRERIA
        bootbox.alert({
            message: "No puedes dejar campos vacios!",
            size: 'small',
            closeButton: false,
        });
    }

});

function agregar(arreglo) {
    $.ajax({
        //Llamamos al metodo que agrega al usuario e indicamos al administrador si tuvo exito o no
        type: "POST",
        url: '../Acciones/usuario/altaUsuario.php',
        data: arreglo,
        success: function (response) {
            //console.log(response);
            var response = jQuery.parseJSON(response);
            if (response) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Agregando Usuario...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarUsuarios();
                        bootbox.hideAll();
                    }, 1500);
                });
            } else {
                bootbox.alert({
                    message: "No se pudo agregar el usuario!",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
}


/*################################# AGREGAR ROL #################################*/
$(document).on('click', '.agregarRol', function () { //MUESTRA EL FORMULARIO Y PRECARGA LOS DATOS
    var fila = $(this).closest('tr');
    var idusuario = fila[0].children[0].innerHTML;

    $.ajax({
        //Llamamos al metodo que agrega al usuario e indicamos al administrador si tuvo exito o no
        type: "POST",
        url: '../Acciones/usuario/listaRolesUsuario.php',
        data: null,
        success: function (response) {
            //console.log(response);
            var response = jQuery.parseJSON(response);
            bootbox.prompt({
                title: 'Agregar roles a ID: ' + idusuario,
                closeButton: false,
                buttons: {
                    cancel: {
                        className: 'btn btn-outline-danger',
                        label: '<i class="fa fa-times"></i> Cancelar'
                    },
                    confirm: {
                        className: 'btn btn-outline-success',
                        label: '<i class="fa fa-check"></i> Confirmar'
                    }
                },
                //El input que va a indicar al administrador las opciones de roles disponibles
                inputType: 'select',
                inputOptions: response,
                //Guardamos la opcion elegida y la enviamos a la funcion
                callback: function (result) {
                    let arreglo = { 'idusuario': idusuario, 'idrol': result };
                    editarAgregar(arreglo);
                }
            });
        }
    });
});

//CIERRA EL FORMULARIO
$(document).on('click', '#cancelar', function () {
    document.getElementById('editarUsuario').classList.add('d-none');
});

function editarAgregar(arreglo) {
    $.ajax({
        type: "POST",
        url: '../Acciones/usuario/editarUsuario.php',
        data: arreglo,
        success: function (response) {
            //console.log(response);
            var response = jQuery.parseJSON(response);
            if (response) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Agregando Nuevo Rol a Usuario...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarUsuarios();
                        bootbox.hideAll();
                    }, 1500);
                });
            } else {
                bootbox.alert({
                    message: "Respuesta: " + response,
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
};

/*################################# ELIMINAR ROL #################################*/
$(document).on('click', '.eliminarRol', function () {
    var fila = $(this).closest('tr');
    var idusuario = fila[0].children[0].innerHTML;

    $.ajax({
        //Llamamos al metodo que agrega al usuario e indicamos al administrador si tuvo exito o no
        type: "POST",
        url: '../Acciones/usuario/listaRolesUsuario.php',
        data: {idusuario: idusuario},
        success: function (response) {
            //console.log(response);
            var response = jQuery.parseJSON(response);
            bootbox.prompt({
                title: 'Agregar roles a ID: ' + idusuario,
                closeButton: false,
                buttons: {
                    cancel: {
                        className: 'btn btn-outline-danger',
                        label: '<i class="fa fa-times"></i> Cancelar'
                    },
                    confirm: {
                        className: 'btn btn-outline-success',
                        label: '<i class="fa fa-check"></i> Confirmar'
                    }
                },
                //El input que va a indicar al administrador las opciones de roles disponibles
                inputType: 'select',
                inputOptions: response,
                //Guardamos la opcion elegida y la enviamos a la funcion
                callback: function (result) {
                    let arreglo = { 'idusuario': idusuario, 'idrol': result };
                    editarEliminar(arreglo);
                }
            });
        }
    });
});

//CIERRA EL FORMULARIO
$(document).on('click', '#cancelar', function () {
    document.getElementById('editarUsuario').classList.add('d-none');
});


function editarEliminar(arreglo) {

    $.ajax({
        type: "POST",
        url: '../Acciones/usuario/editarUsuarioEliminar.php',
        data: arreglo,
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if (response) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Sacándole Rol a Usuario...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarUsuarios();
                        bootbox.hideAll();
                    }, 1500);
                });
            } else {
                bootbox.alert({
                    message: "Respuesta: " + response,
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
};

/*################################# DESHABILITAR USUARIO #################################*/

$(document).on('click', '.deshabilitar', function () {

    var fila = $(this).closest('tr');
    
    var idusuario = fila[0].children[0].innerHTML;
    var usnombre = fila[0].children[1].innerHTML;
    
    // CARTEL LIBRERIA
    bootbox.confirm({
        closeButton: false,
        title: "DESHABILITAR USUARIO?",
        message: "Estas seguro que quieres DESHABILITAR a <b>" + usnombre + "</b> con ID:<b>" + idusuario + "</b>",
        buttons: {
            cancel: {
                className: 'btn btn-outline-danger',
                label: '<i class="fa fa-times"></i> Cancelar'
            },
            confirm: {
                className: 'btn btn-outline-secondary',
                label: '<i class="fa-solid fa-ban"></i> Deshabilitar'
            }
        },
        //Llamamos a la funcion deshabilitar con el id del usuario apuntado
        callback: function (result) {
            if (result) {
                deshabilitar(idusuario);
            }
        }
    });
});

function deshabilitar(idusuario) {
    $.ajax({
        type: "POST",
        //Llamamos a la funcion deshabilitarUsuario con el arreglo del id del usuario con la accion a tomar.
        url: '../Acciones/usuario/deshabilitarUsuario.php',
        data: { idusuario: idusuario, accion: 'deshabilitar'},
        success: function (response) {
            //console.log(response)
            var response = jQuery.parseJSON(response);
            if (response) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Deshabilitando Usuario...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarUsuarios();
                        bootbox.hideAll();
                    }, 1500);
                });
            } else {
                // ALERT LIBRERIA
                bootbox.alert({
                    message: "No se pudo deshabilitar el usuario!",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
};

/*################################# HABILITAR USUARIO #################################*/

$(document).on('click', '.habilitar', function () {

    var fila = $(this).closest('tr');
    
    var idusuario = fila[0].children[0].innerHTML;
    var usnombre = fila[0].children[1].innerHTML;

    // CARTEL LIBRERIA
    bootbox.confirm({
        title: "HABILITAR USUARIO?",
        closeButton: false,
        message: "Estas seguro que quieres HABILITAR a <b>" + usnombre + "</b> con ID: <b>" + idusuario+'</b>',
        buttons: {
            cancel: {
                className: 'btn btn-outline-danger',
                label: '<i class="fa fa-times"></i> Cancelar'
            },
            confirm: {
                className: 'btn btn-outline-success',
                label: '<i class="fa-solid fa-square-check"></i> Habilitar'
            }
        },
        callback: function (result) {
            if (result) {
                habilitar(idusuario);
            }
        }
    });
});

function habilitar(idusuario) {

    $.ajax({
        type: "POST",
        //Llamamos a la funcion habilitarUsuario con el arreglo del id del usuario con la accion a tomar.
        url: '../Acciones/usuario/deshabilitarUsuario.php',
        data: {idusuario: idusuario, accion: 'habilitar'},
        success: function (response) {
            //console.log(response);
            var response = jQuery.parseJSON(response);
            if (response) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Habilitando Usuario...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        cargarUsuarios();
                        bootbox.hideAll();
                    }, 1500);
                });
            } else {
                // ALERT LIBRERIA
                bootbox.alert({
                    message: "No se pudo habilitar el usuario!",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
};