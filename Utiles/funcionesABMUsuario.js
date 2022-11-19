/* AGREGAR */

$(document).on('click', '.agregar', function () {
    var row = $(this).closest('tr').find(".form-control");
   

    var nombre = row[1].value;
    var mail = row[2].value;
    var rol = row[3].options[row[3].selectedIndex].value;

    arreglo = {
        'usnombre': nombre,
        'usmail': mail,
        'rol': rol,
        'uspass': null
    };

    bootbox.prompt({ 
        size: "small",
        inputType: "password",
        title: "Ingrese una contraseña",
        callback: function(result){ 
                arreglo['uspass'] = result;
        }
    });
    
    var verificador = true;

    $.each(arreglo, function (index, value) {
       
        if (value === ''){
           verificador = false;
        }
    });

    if (verificador){
        
        agregar(arreglo);
    } else {
        // ALERT LIBRERIA
        bootbox.alert({
            message: "No puedes dejar campos vacios!",
            size: 'small',
            closeButton: false,
        });
    }
    
});

function agregar(array){
    $.ajax({
        type: "POST",
        url: './accion/altaUsuario.php',
        data: array,
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if(response.respuesta){
                location.reload();
            } else {
                bootbox.alert({
                    message: "Respuesta: "+response.respuesta,
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
}


/* EDITAR */

$(document).on('click', '.editar', function () { //MUESTRA EL FORMULARIO Y PRECARGA LOS DATOS
    document.getElementById('editarUsuario').classList.remove('d-none');
    var fila = $(this).closest('tr');
    var idusuario = fila[0].children[0].innerHTML;
    var usnombre = fila[0].children[1].innerHTML;
    var usmail = fila[0].children[2].innerHTML;
    var usdeshabilitado = fila[0].children[3].innerHTML;

    var form = document.getElementById('editarU');
    
    var inputs = form.getElementsByTagName('input');

    document.getElementById('idusuario').innerHTML = idusuario;

    inputs[0].value = idusuario;
    inputs[1].value = usnombre;
    inputs[2].value = usmail;
    inputs[3].value = usdeshabilitado;
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
        );*/
        
        $.ajax({
            type: "POST",
            url: './accion/editarUsuario.php',
            data: $(this).serialize(),
            success: function (response) {
                var response = jQuery.parseJSON(response);
                if(response.respuesta){
                    location.reload();
                } else {
                    console.log(response.respuesta);
                }
            }
        });
    });
});


/* ELIMINAR */


$(document).on('click', '.eliminar', function() {

    var fila = $(this).closest('tr');
    var idusuario = fila[0].children[0].innerHTML;
    var usnombre = fila[0].children[1].innerHTML;

    // CARTEL LIBRERIA
    bootbox.confirm({
        title: "Eliminar usuario?",
        closeButton: false,
        message: "Estas seguro que quieres eliminar a "+usnombre+" con ID:"+idusuario,
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
            if(result){
                eliminar(idusuario);
            }
        }
    });
});

function eliminar(idusuario){

    $.ajax({
        type: "POST",
        url: './accion/eliminarUsuario.php',
        data: {idusuario:idusuario},
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if(response.respuesta){
                location.reload();
            } else {
                console.log(response.respuesta);
            }
        }
    });
};