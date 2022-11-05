<?php

class compraEstadoTipo extends BaseDatos
{
    //ver los diferentes estados de la compra y sus posibles contextos de cambio
    //hacer la extensión con la BD

    private $idcompraestadotipo;
    private $cetdescripcion; //TIMESTAMP
    private $cetdetalle;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idcompraestadotipo="";
        $this->cetdescripcion="";
        $this->cetdetalle="";
        $this->mensajeOperacion="";
    }

    public function setear($idcompraestadotipo, $cetdescripcion, $cetdetalle)
    {
        $this->setID($idcompraestadotipo);
        $this->setCetdescripcion($cetdescripcion);
        $this->setCetdetalle($cetdetalle);
    }

    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar()
    {
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM compraestadotipo WHERE idcompraestadotipo = ".$this->getID();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res>-1) {
                if ($res>0) {
                    $row = $base->Registro();
                    
                    $this->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                }
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->listar: ".$base->getError());
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
        $sql="INSERT INTO compraestadotipo(idcompraestadotipo, cetdescripcion, cetdetalle) 
            VALUES('"
            .$this->getID()."', '"
            .$this->getCetdescripcion()."', '"
            .$this->getCetdetalle()."'
        );";
        if ($base->Iniciar()) {
            if ($esteid = $base->Ejecutar($sql)) {
                // Si se usa ID autoincrement, descomentar lo siguiente:
                //$this->setID($esteid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE compraestadotipo 
        SET cetdescripcion='".$this->getCetdescripcion()
        ."', cetdetalle='".$this->getCetdetalle()
        ."' WHERE idcompraestadotipo='".$this->getID()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM compraestadotipo WHERE idcompraestadotipo=".$this->getID();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro="")
    {
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM compraestadotipo ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res>-1) {
            if ($res>0) {
                while ($row = $base->Registro()) {
                    $obj= new compraEstadoTipo();
                    
                    $obj->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->listar: ".$base->getError());
        }

        return $arreglo;
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

    /**
     * Get the value of cetdetalle
     */ 
    public function getCetdetalle()
    {
        return $this->cetdetalle;
    }

    /**
     * Set the value of cetdetalle
     *
     * @return  self
     */ 
    public function setCetdetalle($cetdetalle)
    {
        $this->cetdetalle = $cetdetalle;

        return $this;
    }

    /**
     * Get the value of cetdescripcion
     */ 
    public function getCetdescripcion()
    {
        return $this->cetdescripcion;
    }

    /**
     * Set the value of cetdescripcion
     *
     * @return  self
     */ 
    public function setCetdescripcion($cetdescripcion)
    {
        $this->cetdescripcion = $cetdescripcion;

        return $this;
    }

    /**
     * Get the value of idcompraestadotipo
     */ 
    public function getID()
    {
        return $this->idcompraestadotipo;
    }

    /**
     * Set the value of idcompraestadotipo
     *
     * @return  self
     */ 
    public function setID($idcompraestadotipo)
    {
        $this->idcompraestadotipo = $idcompraestadotipo;

        return $this;
    }
}