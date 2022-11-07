<?php

class compraEstadoTipo extends BaseDatos
{
    //ver los diferentes estados de la compra y sus posibles contextos de cambio
    //hacer la extensión con la BD

    private $idcompraestadotipo;
    private $cetdescripcion; 
    private $cetdetalle;
    private $mensajeoperacion;

    public function __construct()
    {
        parent::__construct();
        $this->idcompraestadotipo="";
        $this->cetdescripcion="";
        $this->cetdetalle="";
        $this->mensajeoperacion="";
    }

    public function setear($idcompraestadotipo, $cetdescripcion, $cetdetalle)
    {
        $this->setID($idcompraestadotipo);
        $this->setCetDescripcion($cetdescripcion);
        $this->setCetDetalle($cetdetalle);
    }

    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar()
    {
        $resp = false;
        
        $sql="SELECT * FROM compraestadotipo WHERE idcompraestadotipo = ".$this->getID();
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res>-1) {
                if ($res>0) {
                    $row = $this->Registro();
                    
                    $this->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                }
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->listar: ".$this->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        //Fecha ini poner fecha actual
        //Setear fecha fin cuando el admin apruebe la compra (fecha)
        $resp = false;
        
        // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
        $sql="INSERT INTO compraestadotipo(idcompraestadotipo, cetdescripcion, cetdetalle) 
            VALUES('"
            .$this->getID()."', '"
            .$this->getCetdescripcion()."', '"
            .$this->getCetdetalle()."'
        );";
        if ($this->Iniciar()) {
            if ($esteid = $this->Ejecutar($sql)) {
                // Si se usa ID autoincrement, descomentar lo siguiente:
                //$this->setID($esteid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->insertar: ".$this->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->insertar: ".$this->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        
        $sql="UPDATE compraestadotipo 
        SET cetdescripcion='".$this->getCetDescripcion()
        ."', cetdetalle='".$this->getCetDetalle()
        ."' WHERE idcompraestadotipo='".$this->getID()."'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->modificar: ".$this->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->modificar: ".$this->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        
        $sql="DELETE FROM compraestadotipo WHERE idcompraestadotipo=".$this->getID();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->eliminar: ".$this->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->eliminar: ".$this->getError());
        }
        return $resp;
    }

    public function listar($parametro="")
    {
        $arreglo = array();
        
        $sql="SELECT * FROM compraestadotipo ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $this->Ejecutar($sql);
        if ($res>-1) {
            if ($res>0) {
                while ($row = $this->Registro()) {
                    $obj= new compraEstadoTipo();
                    
                    $obj->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->listar: ".$this->getError());
        }

        return $arreglo;
    }

    /**
     * Get the value of mensajeoperacion
     */ 
    public function getMensajeOperacion()
    {
        return $this->mensajeoperacion;
    }

    /**
     * Set the value of mensajeoperacion
     *
     * @return  self
     */ 
    public function setMensajeOperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;

        return $this;
    }

    /**
     * Get the value of cetdetalle
     */ 
    public function getCetDetalle()
    {
        return $this->cetdetalle;
    }

    /**
     * Set the value of cetdetalle
     *
     * @return  self
     */ 
    public function setCetDetalle($cetdetalle)
    {
        $this->cetdetalle = $cetdetalle;

        return $this;
    }

    /**
     * Get the value of cetdescripcion
     */ 
    public function getCetDescripcion()
    {
        return $this->cetdescripcion;
    }

    /**
     * Set the value of cetdescripcion
     *
     * @return  self
     */ 
    public function setCetDescripcion($cetdescripcion)
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