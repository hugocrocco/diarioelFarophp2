<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Solo admins pueden eliminar
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: /vistas/inicio.php');
    exit();
}

if (isset($_POST['index'])) {
    $ruta = __DIR__ . '/../data/contactos.json';
    $contactos = [];

    if (file_exists($ruta)) {
        $contactos = json_decode(file_get_contents($ruta), true) ?? [];
    }

    $index = (int) $_POST['index'];

    if (isset($contactos[$index])) {
        array_splice($contactos, $index, 1); // eliminar el mensaje
        file_put_contents($ruta, json_encode($contactos, JSON_PRETTY_PRINT));
    }
}

header('Location: /vistas/verContactos.php');
exit();
?>