<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diario El Faro</title>

  <!-- Estilos externos Bulma y FontAwesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Tu CSS personalizado -->
  <link rel="stylesheet" href="/css/estilos.css">
</head>

<body>

<!-- Botón Cerrar sesión (solo si hay sesión activa y no estamos en login.php) -->
<?php
$currentPage = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if (isset($_SESSION['usuario']) && $currentPage !== 'login.php'):
?>
  <a href="/logout.php" class="button is-danger" style="position: fixed; top: 15px; right: 15px; z-index: 2000; font-weight: bold;">
    Cerrar sesión
  </a>
<?php endif; ?>

<!-- Navbar principal -->
<nav class="navbar is-info" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="/vistas/inicio.php">
      <img src="/imagenes/logoinicio.png" width="28" height="28">
      <strong style="margin-left: 8px;">Diario El Faro</strong>
    </a>

    <!-- Botón hamburguesa para móviles -->
    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="menuPrincipal">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="menuPrincipal" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="/vistas/inicio.php">Inicio</a>
      <a class="navbar-item" href="/vistas/noticias.php">Noticias</a>
      <a class="navbar-item" href="/vistas/deportes.php">Deportes</a>
      <a class="navbar-item" href="/vistas/negocios.php">Negocios</a>

      <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['tipo'] === 'admin'): ?>
        <a class="navbar-item" href="/vistas/agregarArticulo.php">Agregar Artículo</a>
        <a class="navbar-item" href="/vistas/gestionarUsuarios.php">Gestionar Usuarios</a> <!-- corregido -->
        <a class="navbar-item" href="/vistas/verContactos.php">Ver Contactos</a>
      <?php endif; ?>
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <?php if (!isset($_SESSION['usuario'])): ?>
            <a class="button is-primary" href="/vistas/login.php">
              <strong>Login</strong>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Reloj con fecha -->
<div id="relojFecha" style="text-align: center; font-size: 1.2em; margin: 10px 0; font-family: monospace;"></div>

<!-- Script para activar menú hamburguesa -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const $navbarBurgers = Array.from(document.querySelectorAll('.navbar-burger'));
  if ($navbarBurgers.length > 0) {
    $navbarBurgers.forEach(el => {
      el.addEventListener('click', () => {
        const target = el.dataset.target;
        const $target = document.getElementById(target);
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');
      });
    });
  }
});
</script>

<!-- Script para el reloj -->
<script src="/scripts/reloj.js"></script>

</body>
</html>