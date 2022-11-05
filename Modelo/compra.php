<?php

class compra extends BaseDatos
{
    //ver los diferentes estados de la compra y sus posibles contextos de cambio
    //hacer la extensión con la BD

    private $idcompra;
    private $cofecha; //TIMESTAMP
    private $idusuario;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idcompra="";
        $this->cofecha=null;
        $this->idusuario=new usuario();
        $this->mensajeOperacion="";
    }

    public function setear($idcompra, $cofecha, $idusuario)
    {
        $this->setID($idcompra);
        $this->setCofecha($cofecha);
        $this->setIdusuario($idusuario);
    }

    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar()
    {
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM compra WHERE idcompra = ".$this->getID();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res>-1) {
                if ($res>0) {
                    $row = $base->Registro();
                    $objUsuario= new usuario();
                    $objUsuario->setIdusuario($row['idusuario']);
                    $objUsuario->cargar();
                    $this->setear($row['idcompra'], $row['cofecha'], $objUsuario);
                }
            }
        } else {
            $this->setMensajeOperacion("compra->listar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        //Fecha ini poner fecha actual
        //Setear fecha fin cuando el admin apruebe la compra (fecha)
        $resp = false;
        $base=new BaseDatos();
        // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
        $sql="INSERT INTO compra(cofecha, idusuario) 
            VALUES('"
            .$this->getCofecha()."', '"
            .$this->getIdusuario()->getIdusuario()."'
        );";
        if ($base->Iniciar()) {
            if ($esteid = $base->Ejecutar($sql)) {
                // Si se usa ID autoincrement, descomentar lo siguiente:
                $this->setID($esteid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("compra->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE compra 
        SET cofecha='".$this->getCofecha()
        ."', idusuario='".$this->getIdusuario()->getIdusuario()
        ."' WHERE idcompra='".$this->getID()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compra->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM compra WHERE idcompra=".$this->getID();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("compra->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compra->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro="")
    {
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM compra ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res>-1) {
            if ($res>0) {
                while ($row = $base->Registro()) {
                    $obj= new compra();
                    $objUsuario = new usuario();
                    $objUsuario->setIdusuario($row['idusuario']);
                    $objUsuario->cargar();
                    $obj->setear($row['idcompra'], $row['cofecha'], $objUsuario);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("compra->listar: ".$base->getError());
        }

        return $arreglo;
    }



    /**
     * Get the value of idcompra
     */
    public function getID()
    {
        return $this->idcompra;
    }

    /**
     * Set the value of idcompra
     *
     * @return  self
     */
    public function setID($idcompra)
    {
        $this->idcompra = $idcompra;

        return $this;
    }

    /**
     * Get the value of cofecha
     */
    public function getCofecha()
    {
        return $this->cofecha;
    }

    /**
     * Set the value of cofecha
     *
     * @return  self
     */
    public function setCofecha($cofecha)
    {
        $this->cofecha = $cofecha;

        return $this;
    }

    /**
     * Get the value of idusuario
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Set the value of idusuario
     *
     * @return  self
     */
    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Get the value of mensajeoperacion
     */
    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    /**
     * Set the value of mensajeoperacion
     *
     * @return  self
     */
    public function setMensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;

        return $this;
    }
}
