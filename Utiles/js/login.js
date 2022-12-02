/*################################# FORMULARIO DE INICIO SESIÓN #################################*/
$('#login').submit(function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
        type: "POST",
        url: './accion/ingresar.php',
        data: $(this).serialize(),
        success: function (response) {
            var response = jQuery.parseJSON(response);
            console.log(response);
            // SI SE PUDO INICAR SESIÓN O NO, REDIRIGIMOS HACIA INDEX CON UN MENSAJE
            if (response.respuesta) {
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Iniciando...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        window.location.href = "../Home/index.php?mensaje=Sesión iniciada correctamente!";
                    }, 750);
                });
            } else {
                bootbox.alert({
                    message: "No se pudo iniciar Sesión",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
});