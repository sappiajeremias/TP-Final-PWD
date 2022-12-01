/*################################# CARGAR MENU #################################*/
$(window).on("load", function () {
    cargarMenu();
});

function cargarMenu() {
    $.ajax({
        type: "POST",
        url: '../Estructura/accion/menus.php',
        data: null,
        success: function (response) {
            //console.log(response);
            var response = jQuery.parseJSON(response);
            if (typeof (response.menuSinLogin) != "undefined" && response.menuSinLogin !== null) {
                armarMenuSinLogin(response.menuSinLogin);
            } else {
                armarMenuLogin(response.menuPermisos, response.menuCambioRoles, response.menuDatosUsActivo);
            }
        }
    });
}

function armarMenuSinLogin(listaSinUs){
    $('#sinLogin').empty();
    $('#sinLogin').append(listaSinUs);
}

function armarMenuLogin(listaPermisos, listaCambios, listaUsuario){
    $('#listaPermisos').empty();
    $('#listaCambioRol').empty();
    $('#listaUs').empty();
    $('#listaPermisos').append(listaPermisos);
    $('#listaCambioRol').append(listaCambios);
    $('#listaUs').append(listaUsuario);
}

$(document).on('click', '.cambiarRol', function () {

    var descripcion = $(this).text();

    $.ajax({
        type: "POST",
        url: '../../Control/controlCambiarRol.php',
        data: {nuevorol: descripcion.toLowerCase()},
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if (response.respuesta) {
                window.location.href="../Home/index.php";
            } else {
                // CARTEL SI LOS DATOS NO SE ENVIARON
                if (typeof (response.mensajeErrorRol) != "undefined" && response.mensajeErrorRol !== null) {
                    bootbox.alert({
                        message: "" + response.mensajeErrorRol,
                        size: 'small',
                        closeButton: false,
                    });
                }
                // CARTEL SI EL USUARIO NO EXISTE
                if (typeof (response.mensajeRolYaActivo) != "undefined" && response.mensajeRolYaActivo !== null) {
                    bootbox.alert({
                        message: "" + response.mensajeRolYaActivo,
                        size: 'small',
                        closeButton: false,
                    });
                }
            }
        }
    });
});
