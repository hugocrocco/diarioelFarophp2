<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Solo admins pueden agregar
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: /vistas/inicio.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../controladores/UsuarioController.php';

    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $password = $_POST['password'] ?? '';
    $tipo = $_POST['tipo'] ?? 'lector';

    if (!empty($nombre) && !empty($correo) && !empty($password)) {
        $usuarioController = new UsuarioController();
        $usuarioController->registrarUsuario($nombre, $correo, $password, $tipo);
    }
}

header('Location: /vistas/gestionarUsuarios.php');
exit();
?>