
$(document).on('click', '.eliminar', function() {

    var fila = $(this).closest('tr');
    var idproducto = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;

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
                eliminar(fila);
            }
        }
    });
});

function eliminar(fila){
    
    var idproducto = fila[0].children[0].innerHTML;

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