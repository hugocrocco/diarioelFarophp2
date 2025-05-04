<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Solo admin puede entrar
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: /vistas/inicio.php');
    exit();
}

require_once __DIR__ . '/../controladores/UsuarioController.php';

$usuarioController = new UsuarioController();
$usuarios = $usuarioController->obtenerTodosLosUsuarios();

include 'partials/header.php';
?>

<section class="section">
  <div class="container">
    <h1 class="title">Gestión de Usuarios</h1>

    <!-- Formulario para agregar usuario -->
    <div class="box">
      <h2 class="subtitle">Agregar Nuevo Usuario</h2>
      <form method="POST" action="/vistas/agregarUsuario.php">
        <div class="field">
          <label class="label">Nombre</label>
          <div class="control">
            <input class="input" type="text" name="nombre" required>
          </div>
        </div>

        <div class="field">
          <label class="label">Correo</label>
          <div class="control">
            <input class="input" type="email" name="correo" required>
          </div>
        </div>

        <div class="field">
          <label class="label">Contraseña</label>
          <div class="control">
            <input class="input" type="password" name="password" required>
          </div>
        </div>

        <div class="field">
          <label class="label">Tipo de Usuario</label>
          <div class="control">
            <div class="select">
              <select name="tipo" required>
                <option value="lector">Lector</option>
                <option value="admin">Administrador</option>
              </select>
            </div>
          </div>
        </div>

        <div class="field">
          <div class="control">
            <button class="button is-primary" type="submit">Agregar Usuario</button>
          </div>
        </div>
      </form>
    </div>

    <hr>

    <!-- Tabla de usuarios existentes -->
    <h2 class="subtitle">Usuarios Registrados</h2>
    <table class="table is-fullwidth is-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Tipo</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $usuario): ?>
          <tr>
            <td><?php echo htmlspecialchars($usuario->getId()); ?></td>
            <td><?php echo htmlspecialchars($usuario->getNombre()); ?></td>
            <td><?php echo htmlspecialchars($usuario->getCorreo()); ?></td>
            <td><?php echo htmlspecialchars($usuario->getTipo()); ?></td>
            <td>
              <?php if (!in_array(strtolower($usuario->getNombre()), ['administrador', 'lector usuario'])): ?>
                <form method="POST" action="/vistas/eliminarUsuario.php" style="display:inline;">
                  <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario->getId()); ?>">
                  <button class="button is-danger is-small" onclick="return confirm('¿Seguro de eliminar este usuario?')">Eliminar</button>
                </form>
              <?php else: ?>
                <span class="has-text-grey-light">Protegido</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
</section>

<?php include 'partials/footer.php'; ?>