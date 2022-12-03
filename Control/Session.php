<?php

class Session
{
    public function __construct()
    {
        if (!session_start()) {
            return false;
        } else {
            return true;
        }
    }

    public function iniciar($nombreUsuario, $pswUsuario)
    {
        $resp = false;
        if ($this->activa() && $this->validar($nombreUsuario, $pswUsuario)) {
            $_SESSION['usnombre'] = $nombreUsuario;
            $user = $this->getUsuario();
            $_SESSION['idusuario'] = $user->getID();
            $_SESSION['usmail'] = $user->getUsMail();
            $_SESSION['usdeshabilitado'] = $user->getUsDeshabilitado();

            $resp = true;
        }

        if ($resp) {
            $this->setearRolActivo();
        }

        return $resp;
    }

    public function setearRolActivo()
    {
        $rolesUs = $this->getRoles(); // TRAEMOS EL ARREGLO DE OBJETOS

        if (count($rolesUs) > 0) {
            $i = 0;
            $verificador = false;
            do {
                if ($rolesUs[$i]->getRolDescripcion() == "admin") {
                    $_SESSION['rolactivodescripcion'] = 'admin';
                    $idRol = $this->buscarIdRol('admin');
                    $_SESSION['rolactivoid'] = $idRol;
                    $verificador = true;
                } elseif ($rolesUs[$i]->getRolDescripcion() == "deposito") {
                    $_SESSION['rolactivodescripcion'] = 'deposito';
                    $idRol = $this->buscarIdRol('deposito');
                    $_SESSION['rolactivoid'] = $idRol;
                    $verificador = true;
                } elseif ($rolesUs[$i]->getRolDescripcion() == "cliente") {
                    $_SESSION['rolactivodescripcion'] = 'cliente';
                    $idRol = $this->buscarIdRol('cliente');
                    $_SESSION['rolactivoid'] = $idRol;
                    $verificador = true;
                }
                $i++;
            } while (!$verificador);
        } else {
            $_SESSION['rolactivodescripcion'] = null;
            $_SESSION['rolactivoid'] = null;
        }
    }

    public function buscarIdRol($param)
    {
        $retorno = null;
        $roles = $this->getRoles();
        foreach ($roles as $rol) {
            if ($rol->getRolDescripcion() === $param) {
                $retorno = $rol->getID();
            }
        }

        return $retorno;
    }

    public function activa()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                //compara la version de php para ver si se puede usar el metodo session_status()
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                //si la version es menor se fija comparando el id de la session actual, para ver si esta seteada.

                return session_id() === '' ? false : true;
            }
        }

        return false;
    }

    public function sesionActiva()
    {
        $resp = false;
        if ($this->getNombreUsuarioLogueado() <> null) {
            $resp = true;
        }
        return $resp;
    }

    public function validar($usNombre, $usPsw)
    {
        //Viene por parametro el nombre de usuario y la contraseña encriptada
        $resp = false;
        if ($this->activa()) {
            $objAbmUsuario = new abmUsuario();
            $param = array("usnombre" => $usNombre, 'uspass' => $usPsw);
            $listaUsuario = $objAbmUsuario->buscar($param);
            if (!empty($listaUsuario)) {
                $resp = true;
            }
        }
        return $resp;
    }


    private function getUsuario()
    {
        //Método privado para no devolver el usuario fuera de la clase Session
        $user = null;
        if ($this->activa() && isset($_SESSION['usnombre'])) {
            $objAbmUsuario = new AbmUsuario();
            $param['usnombre'] = $_SESSION['usnombre'];
            $listaUsuario = $objAbmUsuario->buscar($param);
            $user = $listaUsuario[0];
        }
        return $user;
    }

    public function obtenerDeshabilitado($fecha)
    {
        $retorno = false;
        if ($fecha === null || $fecha === '0000-00-00 00:00:00') {
            $retorno = true;
        }
        return $retorno;
    }

    public function getRoles()
    {
        //Devuelve un arreglo con los objetos rol del user
        $roles = [];
        $user = $this->getUsuario();
        if ($user != null) {
            //Primero busco la instancia de UsuarioRol
            $objAbmUsuarioRol = new AbmUsuarioRol();
            //Creo el parametro con el id del usuario
            $parametroUser = array('idusuario' => $user->getID());
            $listaUsuarioRol = $objAbmUsuarioRol->buscar($parametroUser);
            foreach ($listaUsuarioRol as $tupla) {
                array_push($roles, $tupla->getObjRol());
            }
        }
        return $roles;
    }

    public function getNombreUsuarioLogueado()
    {
        //retorna el nombre del usuario logueado
        $nombreUsuario = null;
        if (isset($_SESSION['usnombre'])) {
            $nombreUsuario = $_SESSION['usnombre'];
        }
        return $nombreUsuario;
    }

    public function getIDUsuarioLogueado()
    {
        //retorna el id del usuario logueado
        $nombreUsuario = null;
        if (isset($_SESSION['idusuario'])) {
            $nombreUsuario = $_SESSION['idusuario'];
        }
        return $nombreUsuario;
    }

    public function getMailUsuarioLogueado()
    {
        //retorna el mail del usuario logueado
        $nombreUsuario = null;
        if (isset($_SESSION['usmail'])) {
            $nombreUsuario = $_SESSION['usmail'];
        }
        return $nombreUsuario;
    }

    public function esAdmin()
    {
        // Retorna true si el usuario activo tiene permiso de administrador
        $resp = false;
        if ($_SESSION['rolactivodescripcion'] <> 'admin') {
            $resp = true;
        }
        return $resp;
    }

    public function esDeposito()
    {
        // Retorna true si el usuario activo tiene permiso de depósito
        $resp = false;
        if ($_SESSION['rolactivodescripcion'] <> 'deposito') {
            $resp = true;
        }
        return $resp;
    }


    public function esCliente()
    {
        // Retorna true si el usuario activo tiene permiso de cliente
        $resp = false;
        if ($_SESSION['rolactivodescripcion'] <> 'cliente') {
            $resp = true;
        }
        return $resp;
    }

    public function getRolActivo()
    {
        $resp = [];
        if (isset($_SESSION['rolactivodescripcion']) && isset($_SESSION['rolactivoid'])) {
            $resp = [
                'rol' => $_SESSION['rolactivodescripcion'],
                'id' => $_SESSION['rolactivoid']
            ];
        }
        return $resp;
    }


    public function cerrar()
    {
        //Primero me fijo si esta activa la session
        if ($this->activa()) {
            //elimino sus datos
            unset($_SESSION['idusuario']);
            unset($_SESSION['usnombre']);
            unset($_SESSION['usmail']);
            unset($_SESSION['usdeshabilitado']);
            unset($_SESSION['rolactivodescripcion']);
            unset($_SESSION['rolactivoid']);
            //destruyo la session
            session_destroy();
        }
    }

    public function setIdRolActivo($param)
    {
        $_SESSION['rolactivoid'] = $param;
    }

    public function setDescripcionRolActivo($param)
    {
        $_SESSION['rolactivodescripcion'] = $param;
    }


    public function verificarPermiso($param)
    {
        $user = $this->getUsuario();
        if ($this->obtenerDeshabilitado($user->getUsDeshabilitado())) {
            $listaRoles = $this->getRoles();
            $respuesta = false;
            foreach ($listaRoles as $rolAct) {
                $objMR = new abmMenuRol();
                $listaMR = $objMR->buscar(['idrol' => $rolAct->getID()]);

                foreach ($listaMR as $padre) {
                    $objHijo = new abmMenu();
                    $listaHijos = $objHijo->buscar(['idpadre' => $padre->getObjMenu()->getID()]);
                    foreach ($listaHijos as $hijo) {
                        if ($hijo->getMeDescripcion() == $param) {
                            $respuesta = true;
                        }
                    }
                }
            }
        }

        return $respuesta;
    }

    public function cambiarRol($datos)
    {
        $resp = false;
        $rolActivo = $this->getRolActivo();

        if ($rolActivo['rol'] <> $datos['nuevorol']) { // SI EL ROL ES DISTINTO AL YA SETEADO HACEMOS EL CAMBIO
            $idRol = $this->buscarIdRol($datos['nuevorol']);
            $this->setIdRolActivo($idRol);
            $this->setDescripcionRolActivo($datos['nuevorol']);
            $resp = true;
        }

        return $resp;
    }
}
