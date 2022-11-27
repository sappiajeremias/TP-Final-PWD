//ENVIA LOS DATOS
$('#login').submit(function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
        type: "POST",
        url: './accion/ingresar.php',
        data: $(this).serialize(),
        success: function (response) {
            var response = jQuery.parseJSON(response);
            console.log(response.respuesta);
            // SI SE PUDO INICAR SESIÓN O NO, REDIRIGIMOS HACIA INDEX CON UN MENSAJE
            if (response.respuesta) {
                console.log("hola");
                // CARTEL LIBRERIA, ESPERA 1,5 SEG Y LUEGO HACE EL RELOAD
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Iniciando...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        window.location.href = "../Home/index.php?mensaje=Sesión iniciada correctamente!";
                    }, 1000);
                });
            } else {
                // CARTEL SI LOS DATOS NO SE ENVIARON
                if (typeof (response.mensajeDatos) != "undefined" && response.mensajeDatos !== null) {
                    bootbox.alert({
                        message: "" + response.mensajeDatos,
                        size: 'small',
                        closeButton: false,
                    });
                }
                // CARTEL SI EL USUARIO NO EXISTE
                if (typeof (response.mensajeUsExist) != "undefined" && response.mensajeUsExist !== null) {
                    bootbox.alert({
                        message: "" + response.mensajeUsExist,
                        size: 'small',
                        closeButton: false,
                    });
                }
                // CARTEL SI EL USUARIO ESTA DESHABILITADO
                if (typeof (response.mensajeUsDes) != "undefined" && response.mensajeUsDes !== null) {
                    bootbox.alert({
                        message: "" + response.mensajeUsDes,
                        size: 'small',
                        closeButton: false,
                    });
                }
                // CARTEL SI LA CONTRASEÑA FUE INCORRECTA
                if (typeof (response.mensajePass) != "undefined" && response.mensajePass !== null) {
                    bootbox.alert({
                        message: "" + response.mensajePass,
                        size: 'small',
                        closeButton: false,
                    });
                }
            }
        }
    });
});