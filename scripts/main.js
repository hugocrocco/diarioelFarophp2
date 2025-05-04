// ==================== RELOJ EN VIVO ====================

function actualizarReloj() {
    const ahora = new Date();
    let horas = ahora.getHours().toString().padStart(2, '0');
    let minutos = ahora.getMinutes().toString().padStart(2, '0');
    let segundos = ahora.getSeconds().toString().padStart(2, '0');
    const horaActual = `${horas}:${minutos}:${segundos}`;
    
    const reloj = document.getElementById('reloj');
    if (reloj) {
      reloj.textContent = `Hora actual: ${horaActual}`;
    }
  }
  
  setInterval(actualizarReloj, 1000);
  actualizarReloj(); // Mostrarlo de inmediato
  
  // ==================== BOTÓN FLOTANTE "SUBIR" ====================
  
  const scrollTopBtn = document.getElementById("scrollTopBtn");
  
  if (scrollTopBtn) {
    window.addEventListener("scroll", () => {
      scrollTopBtn.style.display = window.scrollY > 200 ? "block" : "none";
    });
  
    scrollTopBtn.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }
  
  // ==================== CARGAR AVISOS DINÁMICOS ====================
  
  function cargarAviso() {
    fetch('json/noticias.json')
      .then(response => response.json())
      .then(data => {
        const avisos = data.avisos;
        const aleatorio = avisos[Math.floor(Math.random() * avisos.length)];
        const contenidoAviso = document.getElementById("contenido-aviso");
        if (contenidoAviso) {
          contenidoAviso.innerHTML = aleatorio;
        }
      })
      .catch(error => {
        console.error('Error al cargar el aviso:', error);
      });
  }
  
  document.addEventListener("DOMContentLoaded", () => {
    cargarAviso();
    setInterval(cargarAviso, 3000); // cada 3 segundos
  });
  
  // ==================== CERRAR AVISO ====================
  
  function cerrarAviso() {
    const aviso = document.getElementById('aviso');
    if (aviso) {
      aviso.style.display = 'none';
    }
  }