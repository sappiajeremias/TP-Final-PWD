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