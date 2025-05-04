<?php

class Usuario {
    private $id;
    private $nombre;
    private $correo;
    private $password;
    private $tipo; // Puede ser 'admin' o 'lector'

    public function __construct($id, $nombre, $correo, $password, $tipo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->password = $password;
        $this->tipo = $tipo;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getTipo() {
        return $this->tipo;
    }

    // Setters
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
}

?>