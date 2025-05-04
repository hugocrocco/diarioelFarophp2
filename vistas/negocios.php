<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Forzar sesión como lector si no hay sesión activa
if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = [
        'id' => 'visitante',
        'nombre' => 'Lector automático',
        'tipo' => 'lector'
    ];
}

require_once __DIR__ . '/../controladores/ArticuloController.php';

$articuloController = new ArticuloController();
$articulos = $articuloController->obtenerArticulosPorCategoria('negocio');

// ✅ Ordenar por fecha descendente y desempatar por ID
usort($articulos, function ($a, $b) {
    $fechaA = strtotime($a->getFecha() ?? '1970-01-01');
    $fechaB = strtotime($b->getFecha() ?? '1970-01-01');

    if ($fechaA === $fechaB) {
        return strcmp($b->getId(), $a->getId());
    }

    return $fechaB - $fechaA;
});

include 'partials/header.php';
?>

<section class="section">
  <div class="container">
    <h1 class="title">Negocios</h1>

    <?php if (count($articulos) > 0): ?>
      <?php foreach ($articulos as $articulo): ?>
        <div class="box">
          <!-- Título y contenido -->
          <h3 class="title is-4"><?php echo htmlspecialchars($articulo->getTitulo()); ?></h3>
          <p><?php echo nl2br(htmlspecialchars($articulo->getContenido())); ?></p>

          <!-- Mostrar archivo adjunto si existe -->
          <?php if ($articulo->getArchivoAdjunto()): ?>
            <?php
              $archivo = $articulo->getArchivoAdjunto();
              $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
            ?>

            <div style="text-align: center; margin-top: 15px;">
              <?php if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'avif', 'webp', 'heic'])): ?>
                <figure style="max-width: 600px; margin: auto;">
                  <img src="/uploads/<?php echo htmlspecialchars($archivo); ?>" alt="Imagen del artículo" style="width: 100%; height: auto; border-radius: 8px;">
                </figure>

              <?php elseif (in_array($extension, ['mp3', 'wav', 'ogg'])): ?>
                <audio controls style="width: 90%; max-width: 600px; margin: 15px auto; display: block;">
                  <source src="/uploads/<?php echo htmlspecialchars($archivo); ?>" type="audio/<?php echo $extension; ?>">
                  Tu navegador no soporta el elemento de audio.
                </audio>

              <?php elseif (in_array($extension, ['mp4', 'webm', 'ogv'])): ?>
                <video controls style="width: 90%; max-width: 600px; margin: 15px auto; display: block; border-radius: 8px;">
                  <source src="/uploads/<?php echo htmlspecialchars($archivo); ?>" type="video/<?php echo $extension; ?>">
                  Tu navegador no soporta el elemento de video.
                </video>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <!-- Información adicional -->
          <p style="margin-top: 10px;">
            <strong>Fecha:</strong> <?php echo htmlspecialchars($articulo->getFecha()); ?> |
            <strong>Autor:</strong> <?php echo htmlspecialchars($articulo->getAutor()); ?>
          </p>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="notification is-warning">
        No hay artículos de negocios disponibles.
      </div>
    <?php endif; ?>
  </div>
</section>

<?php include 'partials/footer.php'; ?>