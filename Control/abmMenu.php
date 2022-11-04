<?php

class abmMenu
{
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto
     * @param array $param
     * @return menu
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idmenu', $param) &&
            array_key_exists('menombre', $param) &&
            array_key_exists('medescripcion', $param) &&
            array_key_exists('idpadre', $param) &&
            array_key_exists('medeshabilitado', $param)
        ) {
            $menu = new menu();
            $menu->setear($param['idmenu'], $param['menombre'], $param['medescripcion'], $param['idpadre'], $param['medeshabilitado']);
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
        if ($objMenu!=null and $objMenu->insertar()) {
            $resp = true;
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
            if ($objMenu!=null and $objMenu->eliminar()) {
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
        // echo "<i>**Realizando la modificación**</i>";

        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objMenu = $this->cargarObjeto($param);
            if ($objMenu!=null and $objMenu->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param<>null) {
            if (isset($param['idmenu'])) {
                $where.=" and idmenu ='".$param['idmenu']."'";
            }
            if (isset($param['menombre'])) {
                $where.=" and menombre ='".$param['menombre']."'";
            }
            if (isset($param['medescripcion'])) {
                $where.=" and medescripcion ='".$param['medescripcion']."'";
            }
            if (isset($param['idpadre'])) {
                $where.=" and idpadre ='".$param['idpadre']."'";
            }
            if (isset($param['medeshabilitado'])) {
                $where.=" and medeshabilitado ='".$param['medeshabilitado']."'";
            }
        }
        $arreglo = menu::listar($where);
        return $arreglo;
    }
}
