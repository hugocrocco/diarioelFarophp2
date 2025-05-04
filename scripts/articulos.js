const usuarioActivo = JSON.parse(localStorage.getItem('usuarioActivo'));

// Mostrar el formulario solo si es admin
if (usuarioActivo && usuarioActivo.tipo === "admin") {
  document.getElementById('seccion-formulario').style.display = "block";
}

// Cargar artículos guardados
let articulos = JSON.parse(localStorage.getItem('articulos')) || [];

function mostrarArticulos() {
  document.getElementById('seccion-noticias').innerHTML = "";
  document.getElementById('seccion-deportes').innerHTML = "";
  document.getElementById('seccion-negocios').innerHTML = "";
  document.getElementById('articulo-destacado').innerHTML = "";

  articulos.forEach((articulo, index) => {
    const nuevo = document.createElement('div');
    nuevo.classList.add('column', 'is-half');
    nuevo.innerHTML = `
      <div class="box">
        <h3 class="title is-5">${articulo.titulo}</h3>
        <p>${articulo.contenido}</p>
        <span class="tag is-info" style="margin-top: 10px;">${articulo.seccion}</span>
      </div>
    `;

    if (articulo.seccion === "noticias") {
      document.getElementById('seccion-noticias').appendChild(nuevo);
    } else if (articulo.seccion === "deportes") {
      document.getElementById('seccion-deportes').appendChild(nuevo);
    } else if (articulo.seccion === "negocios") {
      document.getElementById('seccion-negocios').appendChild(nuevo);
    }

    if (index === articulos.length - 1) {
      const destacado = document.createElement('div');
      destacado.classList.add('box');
      destacado.innerHTML = `
        <h3 class="title is-4">${articulo.titulo}</h3>
        <p>${articulo.contenido}</p>
        <span class="tag is-primary" style="margin-top: 10px;">${articulo.seccion}</span>
      `;
      document.getElementById('articulo-destacado').appendChild(destacado);
    }
  });
}

mostrarArticulos();

// Agregar nuevos artículos si es admin
const formularioArticulo = document.getElementById('formulario-articulo');

if (formularioArticulo) {
  formularioArticulo.addEventListener('submit', function(event) {
    event.preventDefault();

    const titulo = document.getElementById('titulo').value;
    const contenido = document.getElementById('contenido').value;
    const seccion = document.getElementById('seccion').value;

    const nuevoArticulo = { titulo, contenido, seccion };
    articulos.push(nuevoArticulo);

    localStorage.setItem('articulos', JSON.stringify(articulos));
    mostrarArticulos();
    formularioArticulo.reset();
  });
}