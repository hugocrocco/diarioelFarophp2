<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Si el usuario ya está logueado, enviarlo al inicio
if (isset($_SESSION['usuario'])) {
    header('Location: /vistas/inicio.php');
    exit();
}

// Procesar el login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../controladores/UsuarioController.php';

    $correo = $_POST['correo'] ?? '';
    $password = $_POST['password'] ?? '';

    $usuarioController = new UsuarioController();
    $usuario = $usuarioController->login($correo, $password);

    if ($usuario) {
        $_SESSION['usuario'] = [
            'id' => $usuario->getId(),
            'nombre' => $usuario->getNombre(),
            'tipo' => $usuario->getTipo()
        ];
        header('Location: /vistas/inicio.php');
        exit();
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<?php include 'partials/header.php'; ?>

<section class="section">
  <div class="container">
    <h1 class="title">Iniciar Sesión</h1>

    <?php if (isset($error)): ?>
      <div class="notification is-danger">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
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
        <div class="control">
          <button class="button is-link" type="submit">Ingresar</button>
        </div>
      </div>
    </form>
  </div>
</section>

<?php include 'partials/footer.php'; ?>