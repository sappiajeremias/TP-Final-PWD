<?php

class abmMenu
{

    public function abm($datos)
    {
        $resp = false;
        if ($datos['action'] == 'eliminar') {
            if ($this->baja($datos)) {
                $resp = true;
            }
        }
        if ($datos['action'] == 'modificar') {
            if ($this->modificacion($datos)) {
                $resp = true;
            }
        }
        if ($datos['action'] == 'alta') {
            if ($this->alta($datos)) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto
     * @param array $param
     * @return menu
     */
    private function cargarObjeto($param)
    {

        $obj = null;

        if (array_key_exists('menombre', $param) and array_key_exists('medescripcion', $param)) {

            $obj = new menu();
            $objMenu = null;
            $deshabilitado = NULL;
            if (array_key_exists('idpadre', $param) && $param['idpadre'] != 'null') {

                $objMenu = new menu();
                $objMenu->setID($param['idpadre']);
                $objMenu->cargar();
            }

            if (array_key_exists('medeshabilitado', $param)) {
                $deshabilitado = $param['medeshabilitado'];
            }
            $obj->setear($param['idmenu'], $param['menombre'], $param['medescripcion'], $objMenu, $deshabilitado);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return menu
     */
    private function cargarObjetoConClave($param)
    {
        $menu = null;
        if (isset($param['idmenu'])) {
            $menu = new menu();
            $menu->setear($param['idmenu'], null, null, null, null);
        }
        return $menu;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idmenu'])) {

            $resp = true;
        }
        return $resp;
    }

    /**
     *
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $param['idmenu'] = null;
        $objMenu = $this->cargarObjeto($param);

        if (array_key_exists('idpadre', $param) || array_key_exists('idrol', $param)) {
            if ($objMenu != null and $objMenu->insertar()) {
                if (array_key_exists('idrol', $param) && $param['idrol'] != "") {
                    $resp = $this->darAlta($param);
                }
                $resp = true;
            }
        }
        return $resp;
    }



    /**
     * permite eliminar un objeto
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objMenu = $this->cargarObjetoConClave($param);
            if ($objMenu != null and $objMenu->eliminar()) {
                $resp = true;
            }
        }

        return $resp;
    }

    public function deshabilitarMenu($datos)
    {
        $resp = false;
        if (!empty($datos)) {
            $objMenu = $this->buscar(['idmenu' => $datos['idmenu']]);
            $fecha = null;
            if (isset($datos['accion']) && $datos['accion'] == 'deshabilitar') {
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $fecha = date('Y-m-d H:i:s');
            }


            $objMenu[0]->setMeDeshabilitado($fecha);
            if ($objMenu[0]->modificar()) {
                $resp = true;
            }
        }

        return $resp;
    }


    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objMenu = $this->cargarObjeto($param);
            if ($objMenu != null and $objMenu->modificar() || $this->ModificarRelacion($param)) {
                /*   if(array_key_exists('idrol',$param))
                {$this->ModificarRelacion($param);}  */
                $resp = true;
            }
        }
        return $resp;
    }

    private function ModificarRelacion($param)
    {
        $abmMenuRol = new abmMenuRol();
        $objMenuRolantes = $abmMenuRol->buscar(['idmenu' => $param['idmenu']]);
        $dataMR = [
            'idmenu' => $objMenuRolantes[0]->getObjMenu()->getID(),
            'idrol' => $objMenuRolantes[0]->getObjRol()->getID()
        ];
        $abmMenuRol->baja($dataMR);
        $resp = $abmMenuRol->alta(['idmenu' => $param['idmenu'], 'idrol' => $param['idrol']]);
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> null) {
            if (isset($param['idmenu'])) {
                $where .= " and idmenu ='" . $param['idmenu'] . "'";
            }
            if (isset($param['menombre'])) {
                $where .= " and menombre ='" . $param['menombre'] . "'";
            }
            if (isset($param['medescripcion'])) {
                $where .= " and medescripcion ='" . $param['medescripcion'] . "'";
            }
            if (isset($param['idpadre'])) {
                $where .= " and idpadre ='" . $param['idpadre'] . "'";
            }
            if (isset($param['medeshabilitado'])) {
                $where .= " and medeshabilitado ='" . $param['medeshabilitado'] . "'";
            }
        }

        $objMenu = new menu();
        $arreglo = $objMenu->listar($where);
        return $arreglo;
    }


    public function ObtenerMenu($param = "")
    {
        $where = " true ";
        if ($param != "") {

            if (isset($param['idrol'])) {
                $where .= " and idrol = '" . $param['idrol'] . "'";
            }
            if (isset($param['idmenu'])) {
                $where .= " and idmenu = '" . $param['idmenu'] . "'";
            }
        }
        $objMenu = new menuRol();
        $arreglo = $objMenu->listar($where);

        return $arreglo;
    }

    public function tieneHijos($idPadre)
    {
        $idArreglo = ['idpadre' => $idPadre];
        $arreglo = $this->buscar($idArreglo);
        $retorno = null;
        if (count($arreglo) <> 0) {
            $retorno = $arreglo;
        }
        return $retorno;
    }

    public function darAlta($param)
    {
        $arrRes = [];
        $respuesta = false;
        $abmRol = new abmRol();
        $abmMenu = new abmMenu();
        $abmMenuRol = new abmMenuRol();
        $listaRol = $abmRol->buscar($param);
        $listaMenu = $abmMenu->buscar($param);


        $respuesta = $abmMenuRol->alta(['idrol' => $listaRol[0]->getID(), 'idmenu' => $listaMenu[0]->getID()]);
        if (!$respuesta) {
            $arrRes['mensajeError'] = "No se pudo crear el MenuRol";
        }
        $arrRes['respuesta'] = $respuesta;

        return $arrRes;
    }

    public function listarMenu($datos)
    {
        $arreglo = [];
        $list = $this->ObtenerMenu($datos);
        if (count($list) > 0) {
            foreach ($list as $elem) {
                $objMenu = $elem->getObjMenu();
                $objRol = $elem->getObjRol();
                $arrayHijoMenu = $this->tieneHijos($objMenu->getID());
                if (!empty($arrayHijoMenu)) {
                    $arregloHM = $this->listarMenu($arrayHijoMenu);
                }

                $nuevoElem = [
                    "idmenu" => $elem->getID(),
                    "menombre" => $elem->getProNombre(),
                    "medescripcion" => $elem->getProDetalle(),
                    "mehijo" => $arregloHM,
                    "idrol" => $objRol()->getID() . " " . $objRol->getDescripcion(),
                    "medeshabilitado" => $elem->getMeDeshabilitado()
                ];
                array_push($arreglo, $nuevoElem);
            }
        }

        return $arreglo;
    }

    public function armarMenu()
    {
        $sesion = new Session();
        $menuFinal = [];
        if ($sesion->sesionActiva()) {
            $permisos = [];
            $rol = null;

            $roles = $sesion->getRoles();
            if (count($roles) > 0) {
                $arregloRolActual = $sesion->getRolActivo();
                $objMR = $this->ObtenerMenu(['idrol' => $arregloRolActual['id']]); //Obtenemos el rol actual para armar el menu
                $rol = strtoupper($arregloRolActual['rol']);
                foreach ($objMR as $actualMR) {
                    $permisoActual = $this->listarPermisos($actualMR->getObjMenu());
                    array_push($permisos, $permisoActual);
                }
            }


            $arregloRolesUser = $sesion->getRoles(); //Obtenemos sus roles, si es que tiene
            $roles = $this->listarRoles($arregloRolesUser);

            $menuFinal['permisos'] = $permisos;
            $menuFinal['roles'] = $roles;
            $menuFinal['usuario'] = ['nombre' => $sesion->getNombreUsuarioLogueado(), 'rol' => $rol];
        }

        return $menuFinal; //En caso de que no haya sesión activa el retorno quedará vacio, menu.js se encarga de armar la interfaz
    }

    public function listarPermisos($menu)
    {
        $hijos = [];
        $arrayHijos = $this->tieneHijos($menu->getID());

        if (!empty($arrayHijos)) {
            foreach ($arrayHijos as $hijoActual) {

                $nietos = [];
                $arrayNietos = $this->tieneHijos($hijoActual->getID());

                if (!empty($arrayNietos)) {
                    foreach ($arrayNietos as $nietoActual) {
                        $nieto = $this->listarPermisos($nietoActual);
                        array_push($nietos, $nieto);
                    }
                }

                $newHijo = [
                    'menombre' => $hijoActual->getMeNombre(),
                    'medescripcion' => $hijoActual->getMeDescripcion(),
                    'hijos' => $nietos
                ];

                array_push($hijos, $newHijo);
            }
        }

        $newPapa = [
            'menombre' => $menu->getMeNombre(),
            'medescripcion' => $menu->getMeDescripcion(),
            'hijos' => $hijos
        ];

        return $newPapa;
    }

    public function listarRoles($roles)
    {
        $arregloRoles = [];

        if (count($roles) > 1) { //Si tiene más de un rol
            foreach ($roles as $rol) {
                $newItem = [
                    'rol' => strtoupper($rol->getRolDescripcion())
                ];

                array_push($arregloRoles, $newItem);
            }
        } elseif (count($roles) === 1) { //Si tiene un solo rol
            $newItem = [
                'rol' => strtoupper($roles[0]->getRolDescripcion())
            ];

            array_push($arregloRoles, $newItem);
        }

        return $arregloRoles;
    }
}
