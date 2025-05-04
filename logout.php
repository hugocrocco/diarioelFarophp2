<?php
// Iniciar sesión si aún no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Destruir la sesión
session_destroy();

// Redirigir al formulario de login
header('Location: /vistas/login.php');
exit();
?>