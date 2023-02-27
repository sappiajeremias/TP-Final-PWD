// FORMULARIO DE INICIO DE SESIÓN
// --------------------------- INICIO VALIDACIONES ---------------------------
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form){
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

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
                        message: 'Formato ejemplo: ejemplo@gmail.com'
                    }
                }
            }
        },
    });
});

// FORMULARIO DE MODIFICAR PERFIL
$(document).ready(function() {
    $('#modificar').bootstrapValidator({
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
            uspass1: {
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
            uspass2: {
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
                        message: 'Formato ejemplo: ejemplo@gmail.com'
                    }
                }
            }
        },
    });
});
