<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$objControl = new abmUsuario();
$listaUsuarios = $objControl->buscar($data);

if ($listaUsuarios > 0) {
    $arregloUsuarios = [];
    foreach ($listaUsuarios as $elem) {
        $objUR = new abmUsuarioRol();
        $rolesUs = $objUR->buscar(['idusuario'=>$elem->getID()]);
        $roles = '';

        foreach ($rolesUs as $rolActual) {
            switch ($rolActual->getObjRol()->getRolDescripcion()) {
                case 'admin':
                    $roles .= 'admin ';
                    break;
                case 'deposito':
                    $roles .= 'deposito ';
                    break;
                case 'cliente':
                    $roles .= 'cliente';
                    break;
            }
        }

        $nuevoElem = [
            'idusuario' => $elem->getID(),
            'usnombre' => $elem->getUsNombre(),
            'usmail' => $elem->getUsMail(),
            'usdeshabilitado' => $elem->getUsDeshabilitado(),
            'roles' => $roles
        ];

        array_push($arregloUsuarios, $nuevoElem);
    }
    $respuesta['respuesta'] = $arregloUsuarios;
} else {
    $respuesta['respuesta'] = 'No hay usuarios!';
}
//verEstructura($arregloUsuarios);
echo json_encode($respuesta);
