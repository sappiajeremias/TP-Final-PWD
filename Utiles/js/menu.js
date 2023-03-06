$.ajax({
    type: "POST",
    url: "../Acciones/login/accionMenu.php",
    data: null,
    success: function (response) {
        //console.log(response);
        var response = jQuery.parseJSON(response);
        if (Object.keys(response).length > 0) {
            armarPermisos(response.permisos);
            armarCambioRol(response.roles);
            armarDatosUsuario(response.usuario);
        } else {
            armarNoLogin();
        }
    }
});

function armarPermisos(menus) {
    var permisosCuerpo = "";

    menus.forEach(menuActual => {
        contadorHijos = 0;
        menuActual.hijos.forEach(hijo => {
            contadorHijos++;
        });

        if (contadorHijos > 0) { // Si tiene hijos
            cuerpoHijos = ""; //Aqui se almacenaran los hijos

            permisosCuerpo += "<!-- INICIO PERMISOS --><li class='nav-item dropdown'><a class='nav-link dropdown-toggle' href='#' data-bs-toggle='dropdown'>" + menuActual.menombre + "</a><ul class='dropdown-menu dropdown-menu-end'>"; //Armamos el ul
            

            cuerpoHijos += listarHijos(menuActual.hijos); //Traemos la lista de hijos, función recursiva

            permisosCuerpo += cuerpoHijos + "</ul></li><!-- FIN PERMISOS -->"; //Anidamos los hijos
        } else {
            permisosCuerpo += "<li class='nav-item active'><a class='nav-link' href=" + menuActual.medescripcion + ">" + menuActual.menombre + "</a></li>"; //Papá soltero
        }
    });

    $('#menu').append(permisosCuerpo);
}

function listarHijos(hijos) {
    var cuerpoHijos = "";

    hijos.forEach(hijoActual => {
        contadorNietos = 0;
        hijoActual.hijos.forEach(nieto => {
            contadorNietos++;
        });

        if (contadorNietos > 0) { //Si tiene nietos
            cuerpoNietos = ""; //Aqui se almacenaran los nietos

            cuerpoHijos += "<li><a class='dropdown-item' href='#'>" + hijoActual.menombre + " &raquo; </a><ul class='submenu submenu-left dropdown-menu'>"; //Armamos el ul
            

            cuerpoNietos += listarHijos(hijoActual.hijos); //Traemos la lista de los nietos

            cuerpoHijos += cuerpoNietos + "</ul></li>"; //Anidamos los nietos
        } else {
            cuerpoHijos += "<li><a class='dropdown-item' href=" + hijoActual.medescripcion + ">" + hijoActual.menombre + "</a></li>";//Hijo soltero
        }
    });

    return cuerpoHijos;
}

function armarCambioRol(roles) {
    cambioRolCuerpo = "";
    //console.log(roles);

    if (Object.keys(roles).length > 1) { //Si tiene más de un rol
        cambioRolCuerpo += "<!-- INICIO CAMBIOS ROL --><li class='nav-item dropdown'><a class='nav-link dropdown-toggle' href='#' data-bs-toggle='dropdown'>Cambiar Rol</a><ul class='dropdown-menu dropdown-menu-end'>";

        roles.forEach(rolActual => {
            //La clase cambiarRol es la que permite reemplazar el rol activo por uno nuevo
            cambioRolCuerpo += "<li><button class='cambiarRol dropdown-item'>" + rolActual.rol + "</button></li>";
        });

        cambioRolCuerpo += "</ul></li><!-- FIN CAMBIOS ROL -->"
    } else if (Object.keys(roles).length === 0){
        cambioRolCuerpo += "<li class='nav-item active'><a class='nav-link'>No tienes Permisos</a></li>"
    }

    $('#menu').append(cambioRolCuerpo);
}

function armarDatosUsuario(usuario) {
    usuarioCuerpo = "";
    usuarioCuerpo += "<!-- INICIO USUARIO ACTIVO DATOS --><li class='nav-item dropdown'><a class='nav-link dropdown-toggle' href='#' data-bs-toggle='dropdown'>" + usuario.nombre + "</a><ul class='dropdown-menu dropdown-menu-end'>";
    if(usuario.rol !== null){
        usuarioCuerpo += "<li><button class='dropdown-item'>Rol Activo: " + usuario.rol + "</button></li>";
    } else {
        usuarioCuerpo += "<li><button class='dropdown-item'>No tienes roles</button></li>";
    }
    usuarioCuerpo += "<li><a class='dropdown-item' href='../Acciones/login/cerrarSesion.php'><i class='fa-solid fa-power-off me-2'></i>Cerrar Sesión</a></li>";
    usuarioCuerpo += "</ul></li><!-- FIN MENÚ USUARIO LOGEADO -->";

    $('#menu').append(usuarioCuerpo);
}

function armarNoLogin(){
    noLoginCuerpo = "";
    noLoginCuerpo += "<!-- INICIO NO LOGIN --><li class='nav-item dropdown'><a class='nav-link dropdown-toggle' href='#' data-bs-toggle='dropdown'><i class='fa-solid fa-right-to-bracket'></i></a><ul class='dropdown-menu dropdown-menu-end'>";
    noLoginCuerpo += "<li><a class='dropdown-item' href='./login.php'>Iniciar Sesión</a></li>";
    noLoginCuerpo += "<hr class='dropdown-divider'>";
    noLoginCuerpo += "<li><a class='dropdown-item' href='./registro.php'>Registrarse</a></li>";
    noLoginCuerpo += "</ul></li><!-- FIN NO LOGIN -->";

    $('#menu').append(noLoginCuerpo);
}


// CAMBIAR ROL 
$(document).on('click', '.cambiarRol', function () {
    var descripcion = $(this).text();
    $.ajax({
        type: "POST",
        url: '../Acciones/login/cambiarRol.php',
        data: {nuevorol: descripcion.toLowerCase()},
        success: function (response) {
            var response = jQuery.parseJSON(response);
            if (response) {
                window.location.href="./index.php";
            } else {
                bootbox.alert({
                    message: "Actualmente se encuentra en el rol seleccionado.",
                    size: 'small',
                    closeButton: false,
                });
            }
        }
    });
});