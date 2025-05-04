<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: /vistas/login.php');
    exit();
}

// Validar que sea admin
if ($_SESSION['usuario']['tipo'] !== 'admin') {
    // Si no es admin, redirigir a inicio
    header('Location: inicio.php');
    exit();
}

require_once __DIR__ . '/../controladores/UsuarioController.php';

// Cargar todos los usuarios
$usuarioController = new UsuarioController();

// Recordemos: UsuarioController tiene una propiedad privada $usuarios, no un método público.
// Necesitamos agregar un método público para obtenerlos:

$usuarios = $usuarioController->obtenerTodosLosUsuarios(); // Este método lo vamos a agregar abajo

include 'partials/header.php';
?>

<section class="section">
  <div class="container">
    <h1 class="title">Gestión de Usuarios</h1>

    <?php if (count($usuarios) > 0): ?>
      <table class="table is-fullwidth is-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Tipo</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($usuarios as $usuario): ?>
            <tr>
              <td><?php echo htmlspecialchars($usuario->getId()); ?></td>
              <td><?php echo htmlspecialchars($usuario->getNombre()); ?></td>
              <td><?php echo htmlspecialchars($usuario->getCorreo()); ?></td>
              <td><?php echo htmlspecialchars($usuario->getTipo()); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="notification is-warning">
        No hay usuarios registrados.
      </div>
    <?php endif; ?>

  </div>
</section>

<?php include 'partials/footer.php'; ?>