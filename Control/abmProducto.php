<?php

class abmProducto
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
     * @return menu
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idproducto', $param) &&
            array_key_exists('pronombre', $param) &&
            array_key_exists('prodetalle', $param) &&
            array_key_exists('procantstock', $param)
        ) {
            $obj = new producto();
            $obj->setear($param['idproducto'], $param['pronombre'], $param['prodetalle'], $param['procantstock']);
        }
        return $obj;
        
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto
     * @param array $param
     * @return menu
     */
    private function cargarObjetoSinID($param)
    {
        $obj = null;
        if (
            array_key_exists('pronombre', $param) &&
            array_key_exists('prodetalle', $param) &&
            array_key_exists('procantstock', $param)
        ) {
            $obj = new producto();
            $obj->setearSinID($param['pronombre'], $param['prodetalle'], $param['procantstock']);
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
        $producto = null;
        if (isset($param['idproducto'])) {
            $producto = new producto();
            $producto->setear($param['idproducto'], null, null, null, null);
        }
        return $producto;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idproducto'])) {
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
       
        $objProducto = $this->cargarObjeto($param);
        if ($objProducto!=null and $objProducto->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     *
     * @param array $param
     */
    public function altaSinID($param)
    {
        $resp = false;
       
        $objProducto = $this->cargarObjetoSinID($param);
        if ($objProducto!=null and $objProducto->insertar()) {
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
            $objProducto = $this->cargarObjetoConClave($param);
            if ($objProducto!=null and $objProducto->eliminar()) {
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
            $objProducto = $this->cargarObjeto($param);
            if ($objProducto!=null and $objProducto->modificar()) {
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
            if (isset($param['idproducto'])) {
                $where.=" and idproducto ='".$param['idproducto']."'";
            }
            if (isset($param['pronombre'])) {
                $where.=" and pronombre ='".$param['pronombre']."'";
            }
            if (isset($param['prodetalle'])) {
                $where.=" and prodetalle ='".$param['prodetalle']."'";
            }
            if (isset($param['procantstock'])) {
                $where.=" and procantstock ='".$param['procantstock']."'";
            }
        }

        $objProducto = new producto();
        $arreglo = $objProducto->listar($where);
        return $arreglo;
    }

    public function buscarConStock(){
        $arreglo = [];
        $objProducto = new producto();
        $arreglo = $objProducto->listar('procantstock > 0');
        return $arreglo;
    }
}