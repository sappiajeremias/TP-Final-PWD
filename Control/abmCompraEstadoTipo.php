<?php

class abmCompraEstadoTipo
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
     * @return compraEstadoTipo
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idcompraestadotipo', $param) &&
            array_key_exists('cetdescripcion', $param)&&
            array_key_exists('cetdetalle', $param)
        ) {
            $obj = new compraEstadoTipo();
            $obj->setear($param['idcompraestadotipo'], $param['cetdescripcion'], $param['cetdetalle']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return compraEstadoTipo
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idcompraestadotipo'])) {
            $obj = new compra();
            $obj->setear($param['idcompraestadotipo'], null, null);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idcompraestadotipo'])) {
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
        $objcompra = $this->cargarObjeto($param);
        // verEstructura($Objrol);
        if ($objcompra!=null and $objcompra->insertar()) {
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
            $objcompra = $this->cargarObjetoConClave($param);
            if ($objcompra!=null and $objcompra->eliminar()) {
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
            $objcompra = $this->cargarObjeto($param);
            if ($objcompra!=null and $objcompra->modificar()) {
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
            if (isset($param['idcompraestadotipo'])) {
                $where.=" and idcompraestadotipo ='".$param['idcompraestadotipo']."'";
            }
            if (isset($param['cetdescripcion'])) {
                $where.=" and cetdescripcion ='".$param['cetdescripcion']."'";
            }
            if (isset($param['cetdetalle'])) {
                $where.=" and cetdetalle ='".$param['cetdetalle']."'";
            }
        }
        $objCET = new compraEstadoTipo();
        $arreglo = $objCET->listar($where);
        return $arreglo;
    }
    
}