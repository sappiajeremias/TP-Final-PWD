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
    private function cargarObjeto($param){
        
        $obj = null;
           
        if(array_key_exists('menombre',$param) and array_key_exists('medescripcion',$param)){
            
            $obj = new menu();            
            $objMenu = null;
            if (array_key_exists('idpadre',$param) && $param['idpadre'] !=''){
                $objMenu = new menu();
                $objMenu->setID($param['idpadre']);
                $objMenu->cargar();
            }
            
            if(isset($param['medeshabilitado'])){
                $param['medeshabilitado']=null;
            }else{
                $param['medeshabilitado']= date("Y-m-d H:i:s");
            } 
            $obj->setear($param['idmenu'],$param['menombre'],$param['medescripcion'],$objMenu,$param['medeshabilitado']); 
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
        $param['idmenu'] =null;
        $objMenu = $this->cargarObjeto($param);
        
        if ($objMenu != null and $objMenu->insertar()) {
            $resp = $this->darAlta($param) ;
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

    public function bajaHabilitacion($param)
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
                if(array_key_exists('idrol',$param)){$this->ModificarRelacion($param);}    
                $resp = true;
            }
        }
        return $resp;
    }

    private function ModificarRelacion($param){
        $abmMenuRol = new abmMenuRol();
        $resp = $abmMenuRol->modificacion(['idmenu'=>$param['idmenu'],'idrol'=>$param['idrol']]);
        return $resp;
    }

    public function ModificarHablilitacion($param)
    {
        $bool = false;
        $arrayObjMenu = $this->buscar($param);
        
        if ($arrayObjMenu[0]->getMeDeshabilitado() == '0000-00-00 00:00:00') {
            $arrayObjMenu[0]->setMeDeshabilitado(date('Y-m-d H:i:s'));
        } else {
            $arrayObjMenu[0]->setMeDeshabilitado(NULL);
        }
        if ($arrayObjMenu[0]->modificar()) {
            $bool = true;
        }
        return $bool;
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
        ;
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
}
