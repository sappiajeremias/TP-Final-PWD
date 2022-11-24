/*################################# AGREGAR USUARIO #################################*/

$(document).on('click', '.agregar', function () {
    
    var row = $(this).closest('tr').find(".form-control");


    var nombre = row[1].value;
    var mail = row[2].value;
    var rol = row[3].value;

    var verificador = true;
console.log(rol);
    

    if (verificador) {
        bootbox.prompt({
            size: "small",
            closeButton: false,
            inputType: "password",
            title: "Ingrese una contraseña",
            callback: function (result) {
                if (result != '') {
                    arreglo = {
                        'usnombre': nombre,
                        'usmail': mail,
                        'idrol': rol,
                        'uspass': result,
                        'usdeshabilitado': null
                    };
                    console.log(arreglo);
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
    console.log(arreglo);
    $.ajax({
        
        type: "POST",
        url: './accion/altaUsuario.php',
        data: arreglo,
        success: function (response) {
            console.log(response);
            var response = jQuery.parseJSON(response);
            if (response.respuesta) {
                location.reload();
            } else {
                bootbox.alert({
                    message: "Respuesta: " + response.respuesta,
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
}


/*################################# AGREGAR ROL #################################*/

$(document).on('click', '.editarAgregar', function () { //MUESTRA EL FORMULARIO Y PRECARGA LOS DATOS
    var fila = $(this).closest('tr');
    var idusuario = fila[0].children[0].innerHTML;
    bootbox.prompt({
        title: 'Agregar roles a ID: '+ idusuario,
        inputType: 'select',
        inputOptions: [
            {
                text: 'Admin',
                value: 1
            },
            {
                text: 'Deposito',
                value: 2
            },
            {
                text: 'Cliente',
                value: 3
            }
        ],
        callback: function (result) {
            let arreglo = {'idusuario': idusuario, 'idrol': result};
            editarAgregar(arreglo);
        }
    });
});

//CIERRA EL FORMULARIO
$(document).on('click', '#cancelar', function () {
    document.getElementById('editarUsuario').classList.add('d-none');
});

//ENVIA LOS DATOS
$(document).ready(function () {
    
    $('form').submit(function (e) {
        e.preventDefault();

        /*$.post("./accion/editarProd.php",{ data: $(this).serialize() },
            function(response) {
                var response = jQuery.parseJSON(response);
                console.log(response.respuesta);
            }
        );*/});});
function editarAgregar(arreglo){
        $.ajax({
            type: "POST",
            url: './accion/editarUsuario.php',
            data: arreglo,
            success: function (response) {
                
                var response = jQuery.parseJSON(response);
                if (response.respuesta) {
                    location.reload();
                } else {
                    console.log(response.respuesta);
                }
            }
        });
    };

    /*################################# ELIMINAR ROL #################################*/

$(document).on('click', '.editarEliminar', function () { //MUESTRA EL FORMULARIO Y PRECARGA LOS DATOS
    var fila = $(this).closest('tr');
    var idusuario = fila[0].children[0].innerHTML;
    bootbox.prompt({
        title: 'Eliminar roles a ID: '+ idusuario,
        inputType: 'select',
        inputOptions: [
            {
                text: 'Admin',
                value: 1
            },
            {
                text: 'Deposito',
                value: 2
            },
            {
                text: 'Cliente',
                value: 3
            }
        ],
        callback: function (result) {
            let arreglo = {'idusuario': idusuario, 'idrol': result};
            editarEliminar(arreglo);
        }
    });
});

//CIERRA EL FORMULARIO
$(document).on('click', '#cancelar', function () {
    document.getElementById('editarUsuario').classList.add('d-none');
});

//ENVIA LOS DATOS
$(document).ready(function () {
    
    $('form').submit(function (e) {
        e.preventDefault();

        /*$.post("./accion/editarProd.php",{ data: $(this).serialize() },
            function(response) {
                var response = jQuery.parseJSON(response);
                console.log(response.respuesta);
            }
        );*/});});
function editarEliminar(arreglo){

        $.ajax({
            type: "POST",
            url: './accion/editarUsuarioEliminar.php',
            data: arreglo,
            success: function (response) {
                var response = jQuery.parseJSON(response);
                
                if (response.respuesta) {
                    location.reload();
                } else {
                    console.log(response.respuesta);
                }
            }
        });
    };



/*################################# ELIMINAR USUARIO #################################*/


$(document).on('click', '.eliminar', function () {

    var fila = $(this).closest('tr');
    var idusuario = fila[0].children[0].innerHTML;
    var usnombre = fila[0].children[1].innerHTML;

    // CARTEL LIBRERIA
    bootbox.confirm({
        title: "Eliminar usuario?",
        closeButton: false,
        message: "Estas seguro que quieres eliminar a " + usnombre + " con ID:" + idusuario,
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
        callback: function (result) {
            if (result) {
                eliminar(idusuario);
            }
        }
    });
});

function eliminar(idusuario) {

    $.ajax({
        type: "POST",
        url: './accion/eliminarUsuario.php',
        data: { idusuario: idusuario },
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if (response.respuesta) {
                location.reload();
            } else {
                console.log(response.respuesta);
            }
        }
    });
};