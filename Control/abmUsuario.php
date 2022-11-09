<?php

class abmUsuario
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
     * @return usuario
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (
            //array_key_exists('idusuario',$param) && <-- Probar con esto comentado, según ejemplo foro
            array_key_exists('usnombre', $param) &&
            array_key_exists('uspass', $param) &&
            array_key_exists('usmail', $param)
        ) {
            $obj = new usuario();
            // Pequeña corrección para poder asignar usdeshabilitado si se manda desde el método baja():
            if (array_key_exists('usdeshabilitado', $param)) {
                $obj->setear(
                    $param['idusuario'],
                    $param['usnombre'],
                    $param['uspass'],
                    $param['usmail'],
                    $param['usdeshabilitado']
                );
            } else {
                $obj->setear(
                    $param['idusuario'],
                    $param['usnombre'],
                    $param['uspass'],
                    $param['usmail'],
                    null
                );
            }
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return usuario
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idusuario'])) {
            $obj = new usuario();
            $obj->setear($param['idusuario'], null, null, null, null);
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
        if (isset($param['idusuario'])) {
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
        // $param['idusuario'] =null;
        $Objusuario = $this->cargarObjeto($param);
        // verEstructura($Objusuario);
        if ($Objusuario != null and $Objusuario->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * permite realizar borrado lógico (marcar como deshabilitado)
     * Solamente toma los datos de la BD y le asigna una fecha actual a usdehsabilitado
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            // Me lo compliqué pero funciona: Busca el usuario, carga los valores en arreglo $param
            // y luego modifica el usuario con la fecha actual de usdeshabilitado
            $usuario = $this->buscar($param);
            $param['usnombre'] = $usuario[0]->getusnombre();
            $param['uspass'] = $usuario[0]->getuspass();
            $param['usmail'] = $usuario[0]->getusmail();
            $param['usdeshabilitado'] = date("Y-m-d H:i:s");
            //echo "<br>Fecha y hora: " . $param['usdeshabilitado'];
            $Objusuario = $this->cargarObjeto($param);
            if ($Objusuario != null and $Objusuario->modificar()) {
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
        echo "<i>**Realizando la modificación**</i>";
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $Objusuario = $this->cargarObjeto($param);
            if ($Objusuario != null and $Objusuario->modificar()) {
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
    public function buscar($param = "")
    {
        $where = " true ";
        if ($param != "") {
            if (isset($param['idusuario'])) {
                $where .= " and idusuario ='" . $param['idusuario'] . "'";
            }
            if (isset($param['usnombre'])) {
                $where .= " and usnombre ='" . $param['usnombre'] . "'";
            }
            if (isset($param['uspass'])) {
                $where .= " and uspass ='" . $param['uspass'] . "'";
            }
            if (isset($param['usmail'])) {
                $where .= " and usmail ='" . $param['usmail'] . "'";
            }
            if (isset($param['usdeshabilitado'])) {
                $where .= " and usdeshabilitado ='" . $param['usdeshabilitado'] . "'";
            }
        }
        $objU = new usuario();
        $arreglo = $objU->listar($where);
        return $arreglo;
    }

    

    public function DarRol($param ="")
    {
        $where = " true ";
        if($param!=""){
            if(isset($param['idusuario'])){
                $where .= " and idusuario = '". $param['idusuario']. "'";
            }
            if(isset($param['idrol'])){
                $where .= " and idrol = '".$param['idrol']."'";
            }
        }
        $objUR = new usuarioRol();
        $arreglo = $objUR->listar($where);
        return $arreglo;

    }
}
