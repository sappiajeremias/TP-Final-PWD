<?php

class Session{

    public function __construct(){
        if(!session_start()){
            return false;
        }else{
            return true;
        }
    }

    public function iniciar($nombreUsuario,$pswUsuario){
        $resp=false;
        if($this->activa() && $this->validar($nombreUsuario,$pswUsuario)){
            $_SESSION['usnombre']=$nombreUsuario;
            $user=$this->getUsuario();
            $_SESSION['idusuario']=$user->getID();
            $_SESSION['usmail']=$user->getUsMail();
            $_SESSION['usdeshabilitado']=$user->getUsDeshabilitado();
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

    public function validar($usNombre, $usPsw){
        //Viene por parametro el nombre de usuario y la contraseña encriptada
        $resp=false;
        if($this->activa()){
            $objAbmUsuario= new abmUsuario();
            $param=array("usnombre"=>$usNombre, 'uspass'=>$usPsw);            $listaUsuario=$objAbmUsuario->buscar($param);
            if(!empty($listaUsuario)){
                $resp=true;
            }
        }
        return $resp;
    }



    private function getUsuario(){
        $user=null;
        if($this->activa() && isset($_SESSION['usnombre'])){
            $objAbmUsuario= new AbmUsuario();
            //ver lo de mandar $_SESSION
            $param['usnombre']= $_SESSION['usnombre'];
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
            unset($_SESSION['idusuario']);
            unset($_SESSION['usnombre']);
            unset($_SESSION['usmail']);
            unset($_SESSION['usdeshabilitado']);
            //destruyo la session
            session_destroy();
        }
    }


}
