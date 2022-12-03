<?php

class abmUsuario
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
            } elseif (array_key_exists('idusuario', $param)) {
                $obj->setear(
                    $param['idusuario'],
                    $param['usnombre'],
                    $param['uspass'],
                    $param['usmail'],
                    null
                );
            } else {
                $obj->setear(
                    null,
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
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto
     * @param array $param
     * @return usuario
     */
    private function cargarObjetoSinID($param)
    {
        $obj = null;
        if (
            array_key_exists('usnombre', $param) &&
            array_key_exists('uspass', $param) &&
            array_key_exists('usmail', $param) &&
            array_key_exists('usdeshabilitado', $param)
        ) {
            $obj = new usuario();
            $obj->setearSinID($param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']);
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
        $Objusuario = $this->cargarObjeto($param);
        if ($Objusuario != null and $Objusuario->insertar()) {
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

        $objUsuario = $this->cargarObjetoSinID($param);
        if ($objUsuario != null and $objUsuario->insertar()) {
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
            $objUsuario = $this->cargarObjetoConClave($param);
            if ($objUsuario != null and $objUsuario->eliminar()) {
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



    public function DarRol($param = "")
    {
        $where = " true ";
        if ($param != "") {
            if (isset($param['idusuario'])) {
                $where .= " and idusuario = '" . $param['idusuario'] . "'";
            }
            if (isset($param['idrol'])) {
                $where .= " and idrol = '" . $param['idrol'] . "'";
            }
        }
        $objUR = new usuarioRol();
        $arreglo = $objUR->listar($where);
        return $arreglo;
    }

    public function alta_rol($param)
    {
        $resp = false;
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $elObjtTabla = new usuarioRol();
            $elObjtTabla->setearConClave($param);
            $resp = $elObjtTabla->insertar();
        }

        return $resp;
    }

    public function obtenerCarrito($idUsuario)
    { //parametro es $sesion->getIDUsuarioLogueado()
        //Devuelve los compraItem del carrito.
        $encontrado = false;
        $objCompra = new abmCompra();
        $compraEncontrada = null;
        $listaCompras = $objCompra->buscar(['idusuario' => $idUsuario]);
        if (count($listaCompras) > 0) { //CHEQUEO QUE TENGA COMPRAS
            foreach ($listaCompras as $compraActual) {
                $objCompraEstado = new abmCompraEstado();
                $listaCompraEstados = $objCompraEstado->buscar(['idcompra' => $compraActual->getID()]);

                foreach ($listaCompraEstados as $elem) {
                    if ($elem->getObjCompraEstadoTipo()->getID() == 5 && ($elem->getCeFechaFin() == '0000-00-00 00:00:00' || $elem->getCeFechaFin() == null)) {
                        $compraEncontrada = $elem->getObjCompra();
                    }
                }
            }
        }
        return $compraEncontrada;
    }


    public function listarUsuarios($datos)
    {
        $arregloUsuarios = [];
        $listaUsuarios = $this->buscar($datos);
        if ($listaUsuarios > 0) {
            foreach ($listaUsuarios as $elem) {
                $objUR = new abmUsuarioRol();
                $rolesUs = $objUR->buscar(['idusuario' => $elem->getID()]);
                $roles = '';

                foreach ($rolesUs as $rolActual) {
                    switch ($rolActual->getObjRol()->getRolDescripcion()) {
                        case 'admin':
                            $roles .= 'admin ';
                            break;
                        case 'deposito':
                            $roles .= 'deposito ';
                            break;
                        case 'cliente':
                            $roles .= 'cliente';
                            break;
                    }
                }

                $nuevoElem = [
                    'idusuario' => $elem->getID(),
                    'usnombre' => $elem->getUsNombre(),
                    'usmail' => $elem->getUsMail(),
                    'usdeshabilitado' => $elem->getUsDeshabilitado(),
                    'roles' => $roles
                ];

                array_push($arregloUsuarios, $nuevoElem);
            }

            return $arregloUsuarios;
        }
    }

    public function habilitarUsuario($data)
    {
        $respuesta = false;
        if (!empty($data)) {
            $objUs = $this->buscar(['idusuario' => $data['idusuario']]);
            $fecha = null;
            if ($data['accion'] == "deshabilitar") {
                $fecha = date('Y-m-d H:i:s');
            }
            $objUs[0]->setUsdeshabilitado($fecha);
            $respuesta = $objUs[0]->modificar();
        }
        return $respuesta;
    }

    public function crearUsuario($data)
    {
        $respuesta = false;
        if (!$this->usuarioExiste($data['usnombre'], $data['usmail'])) {

            if ($this->altaSinID($data)) {
                $objUs = $this->buscar(['usnombre' => $data['usnombre'], 'usmail' => $data['usmail']]);
                $objUR = new abmUsuarioRol();
                if (isset($data['idrol'])) {
                    $respuesta = $objUR->alta(['idrol' => $data['idrol'], 'idusuario' => $objUs[0]->getID()]);
                } else {
                    $respuesta = $objUR->alta(['idrol' => 3, 'idusuario' => $objUs[0]->getID()]);
                }
            }
        }
        return $respuesta;
    }

    public function usuarioExiste($usname, $usmail)
    {
        $respuesta = false;
        $list = $this->buscar(null);
        foreach ($list as $usActual) {
            if (($usActual->getUsNombre() == $usname) || ($usActual->getUsMail() == $usmail)) {
                $respuesta = true;
            }
        }
        return $respuesta;
    }

    public function listarCompras($idUsuario)
    {
        $objItems = new abmCompra();
        $arreglo_salida =  [];
        $listaCompras = $objItems->buscar(['idusuario' => $idUsuario]);
        if (count($listaCompras) > 0) {
        
            foreach ($listaCompras as $elem) {
                $objCE = new abmCompraEstado;
                $listaCE = $objCE->buscar(['idcompra' => $elem->getID()]);
                //RECORREMOS EL LISTADO DE COMPRAS ESTADO
                foreach ($listaCE as $compraActual) {
                    //SI ES CARRITO NO LO MOSTRAMOS
                    if (!($compraActual->getObjCompraEstadoTipo()->getCetDescripcion() === "carrito")) {
                        $nuevoElem = [
                            "idcompra" => $compraActual->getObjCompra()->getID(),
                            "cofecha" => $compraActual->getCeFechaIni(),
                            "finfecha" => $compraActual->getCeFechaFin(),
                            "usnombre" => $compraActual->getObjCompra()->getObjUsuario()->getUsNombre(),
                            "estado" => $compraActual->getObjCompraEstadoTipo()->getCetDescripcion(),
                            "idcompraestado" => $compraActual->getID()
                        ];
                        array_push($arreglo_salida, $nuevoElem);
                    }
                }
            }
        
        } 
        return $arreglo_salida;
    }
}
