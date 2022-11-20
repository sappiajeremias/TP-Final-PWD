
/*################################# VER PRODUCTOS #################################*/

$(document).on('click', '.verProductos', function () {

    var fila = $(this).closest('tr');
    var idproducto = fila[0].children[0].innerHTML;
    var pronombre = fila[0].children[1].innerHTML;


    $.ajax({
        type: "POST",
        url: './accion/listarProdComprar.php',
        data: { idproducto: idproducto },
        success: function (response) {
            console.log(response);
        }
    });
   
});

function eliminar(idproducto) {

    $.ajax({
        type: "POST",
        url: './accion/eliminarProducto.php',
        data: { idproducto: idproducto },
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if (response.respuesta) {
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Borrando Producto...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                });
            } else {
                console.log(response.respuesta);
            }
        }
    });
};
