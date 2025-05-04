<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Solo admins pueden eliminar
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: /vistas/inicio.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    require_once __DIR__ . '/../controladores/UsuarioController.php';

    $usuarioController = new UsuarioController();
    $usuarioController->eliminarUsuario($_POST['id']);

    // Guardar un mensaje de éxito en sesión
    $_SESSION['mensaje_exito'] = "Usuario eliminado exitosamente.";
}

// Redirigir de nuevo a gestionar usuarios
header('Location: /vistas/gestionarUsuarios.php');
exit();
?>