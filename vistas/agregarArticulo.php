<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: /vistas/login.php');
    exit();
}

// Verificar que el usuario sea admin
if ($_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: /vistas/inicio.php');
    exit();
}

require_once __DIR__ . '/../controladores/ArticuloController.php';

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $contenido = $_POST['contenido'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $archivoAdjunto = null;

    // Procesar el archivo adjunto si se subió
    if (isset($_FILES['archivoAdjunto']) && $_FILES['archivoAdjunto']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = uniqid() . "_" . basename($_FILES['archivoAdjunto']['name']);
        $rutaDestino = __DIR__ . '/../uploads/' . $nombreArchivo;

        if (!is_dir(__DIR__ . '/../uploads/')) {
            mkdir(__DIR__ . '/../uploads/', 0777, true);
        }

        if (move_uploaded_file($_FILES['archivoAdjunto']['tmp_name'], $rutaDestino)) {
            $archivoAdjunto = $nombreArchivo;
        }
    }

    if (!empty($titulo) && !empty($contenido) && !empty($categoria)) {
        $articuloController = new ArticuloController();
        $articuloController->agregarArticulo(
            $titulo,
            $contenido,
            $categoria,
            $_SESSION['usuario']['nombre'], // Autor
            $archivoAdjunto // Archivo adjunto
        );

        header('Location: /vistas/inicio.php');
        exit();
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}

include 'partials/header.php';
?>

<section class="section">
  <div class="container">
    <h1 class="title">Agregar Nuevo Artículo</h1>

    <?php if (isset($error)): ?>
      <div class="notification is-danger">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
      <div class="field">
        <label class="label">Título</label>
        <div class="control">
          <input class="input" type="text" name="titulo" required>
        </div>
      </div>

      <div class="field">
        <label class="label">Contenido</label>
        <div class="control">
          <textarea class="textarea" name="contenido" rows="5" required></textarea>
        </div>
      </div>

      <div class="field">
        <label class="label">Categoría</label>
        <div class="control">
          <div class="select">
            <select name="categoria" required>
              <option value="">Seleccione una categoría</option>
              <option value="noticia">Noticia</option>
              <option value="deporte">Deporte</option>
              <option value="negocio">Negocio</option>
            </select>
          </div>
        </div>
      </div>

      <div class="field">
        <label class="label">Archivo adjunto (opcional)</label>
        <div class="control">
          <input class="input" type="file" name="archivoAdjunto" accept="image/*,audio/*,video/*">
        </div>
      </div>

      <div class="field">
        <div class="control">
          <button class="button is-primary" type="submit">Agregar Artículo</button>
        </div>
      </div>
    </form>
  </div>
</section>

<?php include 'partials/footer.php'; ?>