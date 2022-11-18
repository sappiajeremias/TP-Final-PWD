$(window).on("load", function () {
    $.ajax({
        type: "POST",
        url: './accion/listarProductos.php',
        data: null,
        success: function (response) {
            console.log('hola')
            var response = jQuery.parseJSON(response);
            console.log(typeof response)
            console.log(response.respuesta)
        }
    });
})