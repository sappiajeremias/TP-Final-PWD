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
            console.log(response.menuPermisos)
            armarMenu(response.menuPermisos, response.menuCambioRoles, response.menuDatosUsActivo);
        }
    });
}

function armarMenu(listaPermisos, listaCambios, listaUsuario){
    $('#listaPermisos').append(listaPermisos);
    $('#listaCambioRol').append(listaCambios);
    $('#listaUs').append(listaUsuario);
}