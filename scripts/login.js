const formularioLogin = document.getElementById('formulario-login');
const selectUsuarios = document.getElementById('usuario-login');
const mensajeLogin = document.getElementById('mensaje-login');

// Cargar usuarios
function cargarUsuarios() {
  const usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
  selectUsuarios.innerHTML = '<option value="">Selecciona tu usuario...</option>';
  usuarios.forEach((usuario, index) => {
    const option = document.createElement('option');
    option.value = index;
    option.textContent = `${usuario.nombre} (${usuario.tipo})`;
    selectUsuarios.appendChild(option);
  });
}

document.addEventListener('DOMContentLoaded', cargarUsuarios);

// Hacer login
formularioLogin.addEventListener('submit', function(event) {
  event.preventDefault();

  const indice = selectUsuarios.value;
  if (indice === "") {
    alert("Selecciona un usuario para ingresar.");
    return;
  }

  const usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
  const usuarioActivo = usuarios[indice];

  localStorage.setItem('usuarioActivo', JSON.stringify(usuarioActivo));

  mensajeLogin.innerHTML = `<p class="has-text-success">¡Bienvenido, <strong>${usuarioActivo.nombre}</strong>! Rol: <strong>${usuarioActivo.tipo.toUpperCase()}</strong></p>`;

  setTimeout(() => {
    window.location.href = "inicio.php";
  }, 2000);
});