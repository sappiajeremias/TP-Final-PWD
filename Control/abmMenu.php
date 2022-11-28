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
        $menu = null;
        if (

            array_key_exists('idmenu', $param) &&
            array_key_exists('menombre', $param) &&
            array_key_exists('medescripcion', $param) &&
            array_key_exists('idpadre', $param) &&
            array_key_exists('medeshabilitado', $param)
        ) {

            $menu = new menu();
            $menuPadre = new menu();

            if ($param['idpadre'] !== null || $param['idpadre'] !== "") {
                $menuPadre->setID($param['idpadre']);
                $menuPadre->cargar();
            }

            $menu->setear($param['idmenu'], $param['menombre'], $param['medescripcion'], $menuPadre, $param['medeshabilitado']);
        } elseif (
            array_key_exists('menombre', $param) &&
            array_key_exists('medescripcion', $param) &&
            array_key_exists('idpadre', $param)
        ) {


            $menu = new menu();
            $menuPadre = new menu();
            $menuPadre->setID($param['idpadre']);
            $menuPadre->cargar();
            $menu->setearSinID($param['menombre'], $param['medescripcion'], $menuPadre, null);
        } else {


            $menu = new menu();
            $menu->setearSinPadre($param['menombre'], $param['medescripcion']);
        }
        return $menu;
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
        // $param['idrol'] =null;
        $objMenu = $this->cargarObjeto($param);
        // verEstructura($Objrol);
        if (array_key_exists('idpadre', $param)) {
            if ($objMenu != null and $objMenu->insertar()) {
                $resp = true;
            }
        } else {
            if ($objMenu != null and $objMenu->insertarDos()) {
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
            if ($objMenu != null and $objMenu->modificar()) {
                $resp = true;
            }
        }
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
        $objMenu = new menu();
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
}
