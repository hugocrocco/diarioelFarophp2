<?php
// Activar errores visibles (extra por si .htaccess no los muestra)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Intentar cargar el controlador y vista manualmente
require_once __DIR__ . '/controladores/ArticuloController.php';

$controller = new ArticuloController();
$articulos = $controller->obtenerTodosLosArticulos();

echo "<h1>Conexión y carga de artículos exitosa ✅</h1>";
echo "<ul>";
foreach ($articulos as $a) {
    echo "<li>" . htmlspecialchars($a->getTitulo()) . "</li>";
}
echo "</ul>";