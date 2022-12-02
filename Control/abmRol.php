<?php

class abmRol
{
    public function abm($datos)
    {
        $resp=false;
        if ($datos['action']== 'eliminar') {
            if ($this->baja($datos)) {
                $resp=true;
            }
        }
        if ($datos['action']== 'modificar') {
            if ($this->modificacion($datos)) {
                $resp=true;
            }
        }
        if ($datos['action']== 'alta') {
            if ($this->alta($datos)) {
                $resp=true;
            }
        }
        return $resp;
    }


/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden
 * con los nombres de las variables instancias del objeto
 * @param array $param
 * @return rol
 */
private function cargarObjeto($param)
{
    $obj = null;

    if (array_key_exists('idrol', $param) &&
        array_key_exists('rodescripcion', $param)
    ) {
        $obj = new rol();
        $obj->setear($param['idrol'], $param['rodescripcion']);
    }
    return $obj;
}

private function cargarObjetoSinId($param)
{
    $obj = null;

    if (
        array_key_exists('rodescripcion', $param)
    ) {
        $obj = new rol();
        $obj->setearSinId($param['rodescripcion']);
    }
    return $obj;
}


/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden
 * con los nombres de las variables instancias del objeto que son claves
 * @param array $param
 * @return rol
 */
private function cargarObjetoConClave($param)
{
    $obj = null;
    if (isset($param['idrol'])) {
        $obj = new rol();
        $obj->setear($param['idrol'], null);
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
    if (isset($param['idrol'])) {
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
    $Objrol = $this->cargarObjeto($param);

    // verEstructura($Objrol);
    if ($Objrol!=null and $Objrol->insertar()) {
        $resp = true;
    }
    return $resp;
}

public function altaSinId($param)
{
    $resp = false;
    // $param['idrol'] =null;
    $Objrol = $this->cargarObjetoSinId($param);

    // verEstructura($Objrol);
    if ($Objrol!=null and $Objrol->insertar()) {
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
        $Objrol = $this->cargarObjetoConClave($param);
        if ($Objrol!=null and $Objrol->eliminar()) {
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
        $Objrol = $this->cargarObjeto($param);
        if ($Objrol!=null and $Objrol->modificar()) {
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
        if (isset($param['idrol'])) {
            $where.=" and idrol ='".$param['idrol']."'";
        }
        if (isset($param['roldescripcion'])) {
            $where.=" and rodescripcion ='".$param['roldescripcion']."'";
        }
    }

    $Objrol = new rol();

    $arreglo = $Objrol->listar($where);

    return $arreglo;
}

public function listarRoles($data)
{
    $listaRoles = $this->buscar($data);
    $arregloRoles =  array();
    foreach ($listaRoles as $elem) {
        $nuevoElem['idrol'] = $elem->getID();
        $nuevoElem['rodescripcion'] = $elem->getRolDescripcion();
        array_push($arregloRoles, $nuevoElem);
    }
    return $arregloRoles;
}
}
