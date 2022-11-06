<?php

class Session{

    public function __construct(){
        session_start();
    }

    public function iniciar($nombreUsuario,$password){
        $_SESSION['usnombre']=$nombreUsuario;
        $_SESSION['uspass']=$password;
    }

    public function validar(){
        //Verifica si existe el usuario y password guardados en $_SESSION
        $resp=false;
        $objAbmUsuario= new AbmUsuario();
        //Le mando por parámetro la variable $_SESSION ya que ahi estan los datos guardados de la sesión iniciada
        $listaUsuario=$objAbmUsuario->buscar($_SESSION);
        if(!empty($listaUsuario)){
            //$objRol = $objAbmUsuario->DarRol(['idusuario'=>$listaUsuario[0]->getIdusuario()]);
            $resp=true;
        }
        return $resp;
    }

    public function activa(){
        //Verifica si la sesión está activa
        $resp=false;
        if(session_status() === PHP_SESSION_ACTIVE){
            $resp=true;
        }
        return $resp;
    }

    public function getUsuario(){
        $user=null;
        //Verifico que la sesión este activa y también que sea válida
        if($this->activa() && $this->validar()){
            $objAbmUsuario= new AbmUsuario();
            $listaUsuario= $objAbmUsuario->buscar($_SESSION);
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
            //destruyo la session
            session_destroy();
        }
    }


}
?>