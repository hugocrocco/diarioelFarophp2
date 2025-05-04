const formularioUsuario = document.getElementById('formulario-usuario');

formularioUsuario.addEventListener('submit', function(event) {
  event.preventDefault();

  const nombre = document.getElementById('nombre-usuario').value.trim();
  const email = document.getElementById('email-usuario').value.trim();
  const tipo = document.getElementById('tipo-usuario').value;

  if (!nombre || !email || !tipo) {
    alert("Completa todos los campos.");
    return;
  }

  const nuevoUsuario = { nombre, email, tipo };

  let usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
  usuarios.push(nuevoUsuario);
  localStorage.setItem('usuarios', JSON.stringify(usuarios));

  alert("Usuario creado correctamente ✅");
  formularioUsuario.reset();
});