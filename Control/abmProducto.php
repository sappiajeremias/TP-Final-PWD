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
        
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden
     * con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return menu
     */
    private function cargarObjetoConClave($param)
    {
       
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        
    }

    /**
     *
     * @param array $param
     */
    public function alta($param)
    {
       
    }

    /**
     * permite eliminar un objeto
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        
    }

    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        // echo "<i>**Realizando la modificación**</i>";

        
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param)
    {
       
    }
}