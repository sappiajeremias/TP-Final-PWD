
/*################################# FORMULARIO DE REGISTRO #################################*/
$('#registro').submit(function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
        type: "POST",
        url: './accion/registro.php',
        data: $(this).serialize(),
        success: function (response) {
            console.log(response)
            var response = jQuery.parseJSON(response);
            console.log(response.respuesta);
            // SI EL REGISTRO ES EXITOSO TE REDIRIGE AL FORMULARIO DE INICIO DE SESIÓN
            if (response.respuesta) {
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Registrando ...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        window.location.href = "login.php";
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
                // CARTEL SI EL CORREO YA EXISTE
                if (typeof (response.mensajeUsMail) != "undefined" && response.mensajeUsMail !== null) {
                    bootbox.alert({
                        message: "" + response.mensajeUsMail,
                        size: 'small',
                        closeButton: false,
                    });
                }
                // CARTEL SI EL NOMBRE DE USUARIO YA EXISTE
                if (typeof (response.mensajeUsName) != "undefined" && response.mensajeUsName !== null) {
                    bootbox.alert({
                        message: "" + response.mensajeUsName,
                        size: 'small',
                        closeButton: false,
                    });
                }
                // CARTEL SI ALGO SALIÓ MAL SETEANDO EL ROL
                if (typeof (response.mensajeRol) != "undefined" && response.mensajeRol !== null) {
                    bootbox.alert({
                        message: "" + response.mensajeRol,
                        size: 'small',
                        closeButton: false,
                    });
                }
                // CARTEL SI ALGO SALIÓ MAL EN EL REGISTRO
                if (typeof (response.mensajeRegistro) != "undefined" && response.mensajeRegistro !== null) {
                    bootbox.alert({
                        message: "" + response.mensajeRegistro,
                        size: 'small',
                        closeButton: false,
                    });
                }
            }
        }
    });
});