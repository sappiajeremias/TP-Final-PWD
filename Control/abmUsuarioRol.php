<?php

class abmUsuarioRol
{


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden 
     * con los nombres de las variables instancias del objeto
     * @param array $param
     * @return usuariorol
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (
            array_key_exists('idusuario', $param) &&
            array_key_exists('idrol', $param)
        ) {
            $obj = new usuarioRol();
            $objUs = new usuario();
            $objRol = new rol();
            $objUs->setID($param['idusuario']);
            $objUs->cargar();
            $objRol->setIdRol($param['idrol']);
            $objRol->cargar();
            $obj->setear($objUs, $objRol);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden 
     * con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return usuariorol
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idusuariorol'])) {
            $obj = new usuarioRol();
            $objUs = new usuario();
            $objRol = new rol();
            $objUs->setID($param['idusuario']);
            $objUs->cargar();
            $objRol->setIdRol($param['idrol']);
            $objRol->cargar();
            $obj->setear($objUs, $objRol);
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
        if (isset($param['idusuariorol']))
            $resp = true;
        return $resp;
    }

    /**
     * 
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $Objusuariorol = $this->cargarObjeto($param);
        if ($Objusuariorol != null and $Objusuariorol->insertar()) {
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
            $Objusuariorol = $this->cargarObjetoConClave($param);
            if ($Objusuariorol != null and $Objusuariorol->eliminar()) {
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
        // echo "<i>**Realizando la modificación**</i>"; var_dump($param);
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $Objusuariorol = $this->cargarObjeto($param);
            if ($Objusuariorol != null and $Objusuariorol->modificar()) {
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
        if ($param <> NULL) {
            if (isset($param['idusuario']))
                $where .= " and idusuario ='" . $param['idusuario'] . "'";
            if (isset($param['idrol']))
                $where .= " and idrol ='" . $param['idrol'] . "'";
        }
        $objUR = new usuarioRol();
        $arreglo = $objUR->listar($where);
        return $arreglo;
    }
}
