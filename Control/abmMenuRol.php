<?php

class abmMenuRol
{

    public function abm($datos){
        $resp=false;
        if($datos['action']== 'eliminar'){
            if($this->baja($datos)){
                $resp=true;
            }
        }
        if($datos['action']== 'modificar'){
            if($this->modificacion($datos)){
                $resp=true;
            }
        }
        if($datos['action']== 'alta'){
            if($this->alta($datos)){
                $resp=true;
            }
        }
        return $resp;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto
     * @param array $param
     * @return menuRol
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idmenu', $param) &&
            array_key_exists('idrol', $param)
        ) {
            $objMenuRol = new menuRol();
            $menu= new menu();
            $rol= new rol();

            $menu->setID($param['idmenu']);
            $menu->cargar();
            $rol->setIdRol($param['idrol']);
            $rol->cargar();

            $objMenuRol->setear($menu, $rol);
        }
        return $objMenuRol;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return menuRol
     */
    private function cargarObjetoConClave($param)
    {
        $menu = null;
        if (isset($param['idmenu']) && isset($param['idrol']) ) {
            $objMenuRol = new menuRol();
            $menu= new menu();
            $rol= new rol();

            $menu->setID($param['idmenu']);
            $menu->cargar();
            $rol->setIdRol($param['idrol']);
            $rol->cargar();

            $objMenuRol->setear($menu, $rol);
        }
        return $objMenuRol;
        
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
     * @return object
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param<>null) {
            if (isset($param['idmenu'])) {
                $where.=" and idmenu ='".$param['idmenu']."'";
            }
            if (isset($param['idrol'])) {
                $where.=" and idrol ='".$param['idrol']."'";
            }
        }
        $objMenuRol = new menuRol();
        $arreglo = $objMenuRol->listar($where);
        return $arreglo;
    }

}