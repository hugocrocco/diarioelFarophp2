<?php

class Articulo {
    private $id;
    private $titulo;
    private $contenido;
    private $categoria; // noticia, deporte, negocio
    private $autor;
    private $fecha;
    private $archivoAdjunto; // NUEVO

    public function __construct($id, $titulo, $contenido, $categoria, $autor, $fecha, $archivoAdjunto = null) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->contenido = $contenido;
        $this->categoria = $categoria;
        $this->autor = $autor;
        $this->fecha = $fecha;
        $this->archivoAdjunto = $archivoAdjunto; // opcional
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getContenido() {
        return $this->contenido;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getAutor() {
        return $this->autor;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getArchivoAdjunto() { // NUEVO
        return $this->archivoAdjunto;
    }

    // Setters
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setContenido($contenido) {
        $this->contenido = $contenido;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function setAutor($autor) {
        $this->autor = $autor;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setArchivoAdjunto($archivoAdjunto) { // NUEVO
        $this->archivoAdjunto = $archivoAdjunto;
    }
}

?>