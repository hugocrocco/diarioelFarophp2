<?php

require_once __DIR__ . '/../modelos/Articulo.php';

class ArticuloController {

    private $articulos = [];

    public function __construct() {
        $this->cargarArticulos();
    }

    public function eliminarArticulo($id) {
        $this->articulos = array_filter($this->articulos, function($articulo) use ($id) {
            return $articulo->getId() !== $id;
        });
        $this->guardarArticulos();
    }

    private function cargarArticulos() {
        $ruta = __DIR__ . '/../data/articulos.json';
        if (file_exists($ruta)) {
            $json = file_get_contents($ruta);
            $arrayArticulos = json_decode($json, true);

            if ($arrayArticulos) {
                foreach ($arrayArticulos as $articuloData) {
                    $articulo = new Articulo(
                        $articuloData['id'],
                        $articuloData['titulo'],
                        $articuloData['contenido'],
                        $articuloData['categoria'],
                        $articuloData['autor'],
                        $articuloData['fecha'],
                        $articuloData['archivoAdjunto'] ?? null // <- NUEVO
                    );
                    $this->articulos[] = $articulo;
                }
            }
        }
    }

    private function guardarArticulos() {
        $ruta = __DIR__ . '/../data/articulos.json';
        $arrayArticulos = [];

        foreach ($this->articulos as $articulo) {
            $arrayArticulos[] = [
                'id' => $articulo->getId(),
                'titulo' => $articulo->getTitulo(),
                'contenido' => $articulo->getContenido(),
                'categoria' => $articulo->getCategoria(),
                'autor' => $articulo->getAutor(),
                'fecha' => $articulo->getFecha(),
                'archivoAdjunto' => $articulo->getArchivoAdjunto() // <- NUEVO
            ];
        }

        file_put_contents($ruta, json_encode($arrayArticulos, JSON_PRETTY_PRINT));
    }

    public function agregarArticulo($titulo, $contenido, $categoria, $autor, $archivoAdjunto = null) {
        $id = uniqid();
        $fecha = date('Y-m-d');
        $nuevoArticulo = new Articulo($id, $titulo, $contenido, $categoria, $autor, $fecha, $archivoAdjunto);
        $this->articulos[] = $nuevoArticulo;
        $this->guardarArticulos();
        return $nuevoArticulo;
    }

    public function obtenerArticulosPorCategoria($categoria) {
        $articulosFiltrados = [];

        foreach ($this->articulos as $articulo) {
            if ($articulo->getCategoria() === $categoria) {
                $articulosFiltrados[] = $articulo;
            }
        }

        return $articulosFiltrados;
    }

    public function obtenerTodosLosArticulos() {
        return $this->articulos;
    }
}

?>