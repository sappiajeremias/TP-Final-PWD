<?php

class rol extends BaseDatos
{

    private $idrol;
    private $rodescripcion;
    private $mensajeOperacion;

    public function __construct()
    {
        parent::__construct();
        $this->idrol = "";
        $this->rodescripcion = "";
        $this->mensajeOperacion = "";
    }

    public function setear($idRol, $rolDescripcion)
    {
        $this->setIdRol($idRol);
        $this->setRolDescripcion($rolDescripcion);
    }

    public function setearSinId( $rolDescripcion)
    {
        $this->setRolDescripcion($rolDescripcion);
    }

    //MÉTODOS PROPIOS DE LA CLASE

    public function cargar()
    {
        $resp = false;
        $sql = "SELECT * FROM rol WHERE idrol = " . $this->getID();
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $this->Registro();
                    $this->setear($row['idrol'], $row['rodescripcion']);
                }
            }
        } else {
            $this->setMensajeOperacion("rol->cargar: " . $this->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
        $sql = "INSERT INTO rol(rodescripcion) 
            VALUES('"
            . $this->getRolDescripcion() . "'
        );";
        if ($this->Iniciar()) {
            if ($esteid = $this->Ejecutar($sql)) {
                // Si se usa ID autoincrement, descomentar lo siguiente:
                $this->setIdRol($esteid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("rol->insertar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->insertar: " . $this->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $sql = "UPDATE rol 
        SET rodescripcion='" . $this->getRolDescripcion() .
            "' WHERE idrol='" . $this->getID() . "'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("rol->modificar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->modificar: " . $this->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $sql = "DELETE FROM rol WHERE idrol=" . $this->getID();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("rol->eliminar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("rol->eliminar: " . $this->getError());
        }
        return $resp;
    }

    public function listar($parametro = "")
    {
        $arreglo = array();
        $sql = "SELECT * FROM rol ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $this->Registro()) {
                        $obj = new rol();
                        $obj->setear($row['idrol'], $row['rodescripcion']);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setMensajeOperacion("rol->listar: " . $this->getError());
            }
        }

        return $arreglo;
    }


    //MÉTODOS GET
    public function getID()
    {
        return $this->idrol;
    }

    public function getRolDescripcion()
    {
        return $this->rodescripcion;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    //MÉTODOS SET
    public function setIdRol($newIdRol)
    {
        $this->idrol = $newIdRol;
        return $this;
    }

    public function setRolDescripcion($newRolDescripcion)
    {
        $this->rodescripcion = $newRolDescripcion;
        return $this;
    }
    public function setMensajeOperacion($newMensajeOperacion)
    {
        $this->mensajeOperacion = $newMensajeOperacion;
        return $this;
    }
}
