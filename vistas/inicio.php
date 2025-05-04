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
$articulos = $articuloController->obtenerTodosLosArticulos();

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

    <!-- ✅ BANNER DE AVISOS -->
    <div id="bannerAvisos" class="notification is-info has-text-centered" style="font-size: 1.1em; font-weight: bold;">
      Cargando avisos...
    </div>

    <h1 class="title">Bienvenido a Diario El Faro</h1>
    <h2 class="subtitle">Resumen de artículos</h2>

    <?php if (count($articulos) > 0): ?>
      <?php foreach ($articulos as $articulo): ?>
        <div class="box">
          <h3 class="title is-4"><?php echo htmlspecialchars($articulo->getTitulo()); ?></h3>

          <?php if ($articulo->getArchivoAdjunto()): ?>
            <figure style="max-width: 600px; margin: auto;">
              <img src="/uploads/<?php echo htmlspecialchars($articulo->getArchivoAdjunto()); ?>" alt="Imagen del artículo" style="width: 100%; height: auto; border-radius: 8px;">
            </figure>
          <?php endif; ?>

          <p>
            <?php
              $primerParrafo = explode("\n", $articulo->getContenido())[0];
              echo nl2br(htmlspecialchars($primerParrafo));
            ?>
          </p>

          <!-- ✅ Botón Leer más redirige según categoría -->
          <?php
            $categoria = strtolower($articulo->getCategoria());
            $archivoSeccion = match ($categoria) {
              'noticia' => 'noticias.php',
              'deporte' => 'deportes.php',
              'negocio' => 'negocios.php',
              default => null
            };
          ?>

          <?php if ($archivoSeccion): ?>
            <a href="<?php echo $archivoSeccion; ?>?id=<?php echo $articulo->getId(); ?>" class="button is-link is-small" style="margin-top: 10px;">Leer más</a>
          <?php else: ?>
            <span class="tag is-warning">Categoría desconocida</span>
          <?php endif; ?>

          <!-- Botón Eliminar solo para administradores -->
          <?php if ($_SESSION['usuario']['tipo'] === 'admin'): ?>
            <form action="eliminarArticulo.php" method="POST" style="margin-top: 10px;">
              <input type="hidden" name="id" value="<?php echo htmlspecialchars($articulo->getId()); ?>">
              <button type="submit" class="button is-danger is-small" onclick="return confirm('¿Estás seguro de eliminar este artículo?')">
                Eliminar
              </button>
            </form>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="notification is-warning">No hay artículos disponibles.</div>
    <?php endif; ?>
  </div>
</section>

<?php include 'partials/footer.php'; ?>

<!-- ✅ SCRIPT DEL BANNER -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const banner = document.getElementById('bannerAvisos');

  fetch('/data/noticias.json')
    .then(response => response.json())
    .then(data => {
      if (data.avisos && data.avisos.length > 0) {
        let index = 0;
        banner.textContent = data.avisos[index];

        setInterval(() => {
          index = (index + 1) % data.avisos.length;
          banner.textContent = data.avisos[index];
        }, 5000);
      } else {
        banner.textContent = "No hay avisos disponibles.";
      }
    })
    .catch(error => {
      console.error('Error cargando avisos:', error);
      banner.textContent = "Error cargando avisos.";
    });
});
</script>