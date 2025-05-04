<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = [
        'id' => 'visitante',
        'nombre' => 'Lector automático',
        'tipo' => 'lector'
    ];
}

require_once __DIR__ . '/../controladores/ArticuloController.php';

if (!isset($_GET['id'])) {
    die('ID de artículo no proporcionado.');
}

$articuloController = new ArticuloController();
$articulo = $articuloController->obtenerArticuloPorId($_GET['id']);

if (!$articulo) {
    die('Artículo no encontrado.');
}

include 'partials/header.php';
?>

<section class="section">
  <div class="container">
    <h1 class="title"><?php echo htmlspecialchars($articulo->getTitulo()); ?></h1>
    <p><strong>Autor:</strong> <?php echo htmlspecialchars($articulo->getAutor()); ?> | <strong>Fecha:</strong> <?php echo $articulo->getFecha(); ?></p>

    <?php if ($articulo->getArchivoAdjunto()): ?>
      <figure style="max-width: 600px; margin: auto;">
        <img src="/uploads/<?php echo htmlspecialchars($articulo->getArchivoAdjunto()); ?>" alt="Imagen del artículo" style="width: 100%; height: auto; border-radius: 8px;">
      </figure>
    <?php endif; ?>

    <div class="content" style="margin-top: 20px;">
      <?php echo nl2br(htmlspecialchars($articulo->getContenido())); ?>
    </div>

    <a href="inicio.php" class="button is-link is-light" style="margin-top: 20px;">⬅ Volver</a>
  </div>
</section>

<?php include 'partials/footer.php'; ?>