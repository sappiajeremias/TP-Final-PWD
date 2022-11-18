// FORMULARIO DE INICIO DE SESIÓN
$(document).ready(function() {
    $('#login').bootstrapValidator({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'fas fa-check',
            invalid: 'fas fa-times',
            validating: 'fas fa-refresh'
        },
        fields: {
            usnombre: {
                validators: {
                    notEmpty: {
                        message: 'Debe ingresar un nombre para su usuario'
                    },
                    stringLength: {
                        min: 3,
                        message: 'Debe tener al menos 3 caracteres'
                    }
                }
            },
            uspass: {
                validators: {
                    notEmpty: {
                        message: 'Debe ingresar su contraseña. '
                    },
                    stringLength: {
                        min: 8,
                        message: 'La contraseña tener un mínimo de 8 caracteres'
                    },
                }
            }
        },
    });
});

// FORMULARIO DE REGISTRO
$(document).ready(function() {
    $('#registro').bootstrapValidator({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'fas fa-check',
            invalid: 'fas fa-times',
            validating: 'fas fa-refresh'
        },
        fields: {
            usnombre: {
                validators: {
                    notEmpty: {
                        message: 'Debe ingresar un nombre para su usuario'
                    },
                    stringLength: {
                        min: 3,
                        message: 'Debe tener al menos 3 caracteres'
                    }
                }
            },
            uspass: {
                validators: {
                    notEmpty: {
                        message: 'Debe ingresar una contraseña'
                    },
                    stringLength: {
                        min: 8,
                        message: 'Debe tener al menos 8 caracteres'
                    }
                }
            },
            usmail: {
                validators: {
                    notEmpty: {
                        message: 'Debe ingresar un correo'
                    },
                    regexp: {
                        regexp: /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/,
                        message: 'Ejemplo: ejemplo@gmail.com'
                    }
                }
            }
        },
    });
});

// FORMULARIO MODIFICAR PRODUCTO

$(document).ready(function() {
    $('#editarP').bootstrapValidator({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'fas fa-check',
            invalid: 'fas fa-times',
            validating: 'fas fa-refresh'
        },
        fields: {
            pronombre: {
                validators: {
                    notEmpty: {
                        message: 'Debe ingresar un nombre para el producto'
                    }
                }
            },
            prodetalle: {
                validators: {
                    notEmpty: {
                        message: 'Debe ingresar una descripción detallada. '
                    }
                }
            },
            procantstock: {
                validators: {
                    notEmpty: {
                        message: 'Debe ingresar el stock. '
                    }
                }
            }
        }
    });
});



//
//  ⢀⡴⠑⡄⠀⠀⠀⠀⠀⠀⠀⣀⣀⣤⣤⣤⣀⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀ 
//  ⠸⡇⠀⠿⡀⠀⠀⠀⣀⡴⢿⣿⣿⣿⣿⣿⣿⣿⣷⣦⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀ 
//  ⠀⠀⠀⠀⠑⢄⣠⠾⠁⣀⣄⡈⠙⣿⣿⣿⣿⣿⣿⣿⣿⣆⠀⠀⠀⠀⠀⠀⠀⠀ 
//  ⠀⠀⠀⠀⢀⡀⠁⠀⠀⠈⠙⠛⠂⠈⣿⣿⣿⣿⣿⠿⡿⢿⣆⠀⠀⠀⠀⠀⠀⠀ 
//  ⠀⠀⠀⢀⡾⣁⣀⠀⠴⠂⠙⣗⡀⠀⢻⣿⣿⠭⢤⣴⣦⣤⣹⠀⠀⠀⢀⢴⣶⣆ 
//  ⠀⠀⢀⣾⣿⣿⣿⣷⣮⣽⣾⣿⣥⣴⣿⣿⡿⢂⠔⢚⡿⢿⣿⣦⣴⣾⠁⠸⣼⡿ 
//  ⠀⢀⡞⠁⠙⠻⠿⠟⠉⠀⠛⢹⣿⣿⣿⣿⣿⣌⢤⣼⣿⣾⣿⡟⠉⠀⠀⠀⠀⠀ 
//  ⠀⣾⣷⣶⠇⠀⠀⣤⣄⣀⡀⠈⠻⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇⠀⠀⠀⠀⠀⠀ 
//  ⠀⠉⠈⠉⠀⠀⢦⡈⢻⣿⣿⣿⣶⣶⣶⣶⣤⣽⡹⣿⣿⣿⣿⡇⠀⠀⠀⠀⠀⠀ 
//  ⠀⠀⠀⠀⠀⠀⠀⠉⠲⣽⡻⢿⣿⣿⣿⣿⣿⣿⣷⣜⣿⣿⣿⡇⠀⠀⠀⠀⠀⠀ 
//  ⠀⠀⠀⠀⠀⠀⠀⠀⢸⣿⣿⣷⣶⣮⣭⣽⣿⣿⣿⣿⣿⣿⣿⠀⠀⠀⠀⠀⠀⠀ 
//  ⠀⠀⠀⠀⠀⠀⣀⣀⣈⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠇⠀⠀⠀⠀⠀⠀⠀ 
//  ⠀⠀⠀⠀⠀⠀⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠃⠀⠀⠀⠀⠀⠀⠀⠀ 
//  ⠀⠀⠀⠀⠀⠀⠀⠹⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠟⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀ 
//  ⠀⠀⠀⠀⠀⠀⠀⠀⠀⠉⠛⠻⠿⠿⠿⠿⠛⠉
//