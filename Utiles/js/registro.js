
/*################################# FORMULARIO DE REGISTRO #################################*/
$('#registro').submit(function (e) {

    var inputs = $('#registro :input');

    if (inputs[1].value != "" || inputs[2].value != "" || inputs[3].value != "") {
    var uspass = inputs[3].value;
    var pass = hex_md5(uspass);

    arreglo = {
        usmail: inputs[1].value,
        usnombre: inputs[2].value,
        uspass: pass,
        usdeshabilitado: null,
    }

    e.preventDefault();
    e.stopImmediatePropagation();

    $.ajax({
        type: "POST",
        url: '../Acciones/login/registro.php',
        data: arreglo,
        success: function (response){
            console.log(response);
            var response = jQuery.parseJSON(response);
            // SI EL REGISTRO ES EXITOSO TE REDIRIGE AL FORMULARIO DE INICIO DE SESIÓN
            if (response) {
                var dialog = bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner me-2"></i>Registrando ...</div>',
                    closeButton: false
                });
                dialog.init(function () {
                    setTimeout(function () {
                        window.location.href = "./login.php";
                    }, 1000);
                });
            } else {
                bootbox.alert({
                    message: "No se pudo concretar el registro. Puede ser que los datos ingresados ya pertenezcan a un usuario del sistema.",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });

    }else{
        bootbox.alert({
            message: "Debe completar todos los campos.",
            size: "small",
            closeButton: false,
          });
    }
    
});