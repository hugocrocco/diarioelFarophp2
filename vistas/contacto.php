<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'partials/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';

    if (!empty($nombre) && !empty($correo) && !empty($mensaje)) {
        $contacto = [
            'nombre' => htmlspecialchars($nombre),
            'correo' => htmlspecialchars($correo),
            'mensaje' => htmlspecialchars($mensaje),
            'fecha' => date('Y-m-d H:i:s')
        ];

        $ruta = __DIR__ . '/../data/contactos.json';
        $contactos = [];

        if (file_exists($ruta)) {
            $contactos = json_decode(file_get_contents($ruta), true) ?? [];
        }

        $contactos[] = $contacto;
        file_put_contents($ruta, json_encode($contactos, JSON_PRETTY_PRINT));

        $exito = "¡Mensaje enviado exitosamente!";
    } else {
        $error = "Por favor completa todos los campos.";
    }
}
?>

<section class="section">
  <div class="container">
    <h1 class="title">Contacto</h1>

    <?php if (isset($exito)): ?>
      <div class="notification is-success">
        <?php echo $exito; ?>
      </div>
    <?php elseif (isset($error)): ?>
      <div class="notification is-danger">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
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
        <label class="label">Mensaje</label>
        <div class="control">
          <textarea class="textarea" name="mensaje" required></textarea>
        </div>
      </div>

      <div class="field">
        <div class="control">
          <button class="button is-link" type="submit">Enviar</button>
        </div>
      </div>
    </form>
  </div>
</section>

<?php include 'partials/footer.php'; ?>