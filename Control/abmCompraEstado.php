<?php

class abmCompraEstado
{
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto
     * @param array $param
     * @return compra
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idcompraestado', $param) &&
            array_key_exists('objcompra', $param)&&
            array_key_exists('objcompraestadotipo', $param)&&
            array_key_exists('cefechaini', $param) &&
            array_key_exists('cefechafin', $param)
        ) {
            $objcompraestadotipo = new compraEstadoTipo();
            $objcompra = new compra();

            $objcompra->setID($param['objcompra']);
            $objcompraestadotipo->setID($param['objcompraestadotipo']);

            $objcompra->cargar();
            $objcompraestadotipo->cargar();

            $obj = new compraEstado();
            $obj->setear($param['idcompraestado'],$objcompra, $objcompraestadotipo, $param['cefechaini'], $param['cefechafin']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return compraEstado
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idcompraestado'])) {
            $obj = new compraEstado();
            $obj->setear($param['idcompraestado'], null, null,null,null);
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
        if (isset($param['idcompraestado'])) {
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
        $objcompraestado = $this->cargarObjeto($param);
        // verEstructura($Objrol);
        if ($objcompraestado!=null and $objcompraestado->insertar()) {
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
            $objcompraestado = $this->cargarObjetoConClave($param);
            if ($objcompraestado!=null and $objcompraestado->eliminar()) {
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
            $objcompraestado = $this->cargarObjeto($param);
            if ($objcompraestado!=null and $objcompraestado->modificar()) {
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
            if (isset($param['idcompraestado'])) {
                $where.=" and idcompraestado ='".$param['idcompraestado']."'";
            }
            if (isset($param['objcompra'])) {
                $where.=" and idcompra ='".$param['objcompra']."'";
            }
            if (isset($param['objcompraestadotipo'])) {
                $where.=" and idcompraestadotipo ='".$param['objcompraestadotipo']."'";
            }
            if (isset($param['cefechaini'])) {
                $where.=" and cefechaini ='".$param['cefechaini']."'";
            }
            if (isset($param['cefechafin'])) {
                $where.=" and cefechafin ='".$param['cefechafin']."'";
            }
        }
        $arreglo = compraEstado::listar($where);
        return $arreglo;
    }
}
