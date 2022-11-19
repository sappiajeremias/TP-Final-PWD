/* AGREGAR */

$(document).on('click', '.agregar', function () {
    var row = $(this).closest('tr').find("input");

    var nombre = row[1].value;
    var detalle = row[2].value;
    var stock = row[3].value;

    arreglo = {
        'pronombre': nombre,
        'prodetalle': detalle,
        'procantstock': stock
    };

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
        url: './accion/altaProd.php',
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
    document.getElementById('editarProducto').classList.remove('d-none');
    var fila = $(this).closest('tr');
    var idproducto = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;
    var prodetalle = fila[0].children[2].innerHTML;
    var procantstock = fila[0].children[3].innerHTML;

    var form = document.getElementById('editarP');
    
    var inputs = form.getElementsByTagName('input');

    document.getElementById('idproducto').innerHTML = idproducto;

    inputs[0].value = idproducto;
    inputs[1].value = pronombre;
    inputs[2].value = prodetalle;
    inputs[3].value = procantstock;
});

//CIERRA EL FORMULARIO
$(document).on('click', '#cancelar', function () {
    document.getElementById('editarProducto').classList.add('d-none');
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
            url: './accion/editarProd.php',
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
    var idproducto = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;

    // CARTEL LIBRERIA
    bootbox.confirm({
        title: "Eliminar Producto?",
        closeButton: false,
        message: "Estas seguro que quieres eliminar a "+pronombre+" con ID:"+idproducto,
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
                eliminar(idproducto);
            }
        }
    });
});

function eliminar(idproducto){

    $.ajax({
        type: "POST",
        url: './accion/eliminarProducto.php',
        data: {idproducto:idproducto},
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