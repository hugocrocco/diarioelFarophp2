<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Solo admins pueden ver esta página
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: /vistas/inicio.php');
    exit();
}

include 'partials/header.php';

// Leer mensajes guardados
$ruta = __DIR__ . '/../data/contactos.json';
$contactos = [];

if (file_exists($ruta)) {
    $contactos = json_decode(file_get_contents($ruta), true) ?? [];
}
?>

<section class="section">
  <div class="container">
    <h1 class="title">Mensajes de Contacto</h1>

    <?php if (count($contactos) > 0): ?>
      <?php foreach ($contactos as $index => $contacto): ?>
        <div class="box">
          <p><strong>Nombre:</strong> <?php echo htmlspecialchars($contacto['nombre']); ?></p>
          <p><strong>Correo:</strong> <?php echo htmlspecialchars($contacto['correo']); ?></p>
          <p><strong>Mensaje:</strong> <?php echo nl2br(htmlspecialchars($contacto['mensaje'])); ?></p>
          <p><strong>Fecha:</strong> <?php echo htmlspecialchars($contacto['fecha']); ?></p>

          <form action="/vistas/eliminarContacto.php" method="POST" style="margin-top: 10px;">
            <input type="hidden" name="index" value="<?php echo $index; ?>">
            <button type="submit" class="button is-danger is-small" onclick="return confirm('¿Estás seguro de eliminar este mensaje?')">
               Eliminar
            </button>
          </form>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="notification is-warning">
        No hay mensajes de contacto disponibles.
      </div>
    <?php endif; ?>

  </div>
</section>

<?php include 'partials/footer.php'; ?>