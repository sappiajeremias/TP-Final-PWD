<?php

class Session{

    public function __construct(){
        if(!session_start()){
            return false;
        }else{
            return true;
        }
    }

    public function iniciar($nombreUsuario,$pswUsuario,$usDeshabilitado){
        $resp=false;
        $objAbmUsuario= new abmUsuario();
        $param= array('usnombre'=> $nombreUsuario, 'uspass'=> $pswUsuario, 'usdeshabilitado'=> $usDeshabilitado);
        $listaUsuario=$objAbmUsuario->buscar($param);
        if(!empty($listaUsuario)){
            $_SESSION['usnombre']=$nombreUsuario;
            $_SESSION['uspass']=$pswUsuario;
            $_SESSION['usdeshabilitado']=$usDeshabilitado;
            $resp=true;
        }
        return $resp;
    }

    public function activa(){

        if ( php_sapi_name() !== 'cli' ) {

            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                //compara la version de php para ver si se puede usar el metodo session_status()
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
    
            } else {
                //si la version es menor se fija comparando el id de la session actual, para ver si esta seteada.
    
                return session_id() === '' ? false : true;
            }
        }
    
        return false;
    }

    public function validar(){
        $resp=false;
        if($this->activa() && isset($_SESSION['idusuario'])){
            $objAbmUsuario= new abmUsuario();
            $listaUsuario=$objAbmUsuario->buscar($_SESSION);
            if(!empty($listaUsuario)){
                $resp=true;
            }
        }
        return $resp;
    }



    public function getUsuario(){
        $user=null;
        //Verifico que la sesión este activa y también que sea válida
        if($this->activa() && $this->validar()){
            $objAbmUsuario= new AbmUsuario();
            //ver lo de mandar $_SESSION
            $param= array('usnombre'=> $_SESSION['usnombre'], 'uspass'=> $_SESSION['uspass'], 'usdeshabilitado'=> $_SESSION['usdeshabilitado']);
            $listaUsuario= $objAbmUsuario->buscar($param);
            $user=$listaUsuario[0];
        }
        return $user;
    }

    public function getRol(){
        $rol=null;
        $user= $this->getUsuario();
        if($user!=null){
            //Primero busco la instancia de UsuarioRol
            $objAbmUsuarioRol= new AbmUsuarioRol();
            //Creo el parametro con el id del usuario
            $parametroUser=array('idusuario'=>$user->getIdUsuario());
            $listaUsuarioRol= $objAbmUsuarioRol->buscar($parametroUser);
            //Ahora busco el rol
            $objAbmRol= new AbmRol();
            //Creo el parametro con el id del rol
            $parametroRol= array ('idrol' => $listaUsuarioRol[0]->getObjRol()->getIdRol());
            $listaRol= $objAbmRol->buscar($parametroRol);
            $rol=$listaRol[0];
        }
        return $rol;
    }

    public function cerrar(){
        //Primero me fijo si esta activa la session
        if($this->activa()){
            //elimino sus datos
            unset($_SESSION['usnombre']);
            unset($_SESSION['uspass']);
            unset($_SESSION['usdeshabilitado']);
            //destruyo la session
            session_destroy();
        }
    }


}
