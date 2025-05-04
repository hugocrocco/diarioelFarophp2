<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Solo admins pueden eliminar
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: /vistas/inicio.php');
    exit();
}

// Verificar si llegó el ID
if (isset($_POST['id'])) {
    require_once __DIR__ . '/../controladores/ArticuloController.php';

    $articuloController = new ArticuloController();
    $id = $_POST['id'];

    $articuloController->eliminarArticulo($id);

    // Redirigir después de eliminar
    header('Location: /vistas/inicio.php');
    exit();
} else {
    echo "ID no proporcionado.";
}
?>